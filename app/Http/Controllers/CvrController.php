<?php

namespace App\Http\Controllers;

use App\Models\Pu;
use App\Models\Cvr;
use App\Models\Lga;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Models\Voter;
use Illuminate\Support\Facades\Validator;

class CvrController extends Controller
{
    public function index()
    {
        $states = State::with('zones', 'lgas', 'wards', 'pus', 'users')->paginate(10);
        return view('admin.cvr.index', [
            'cvrs' => Cvr::with('pu', 'createdBy')->paginate(10),
            'states' => $states
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unique_id' => [
                'required',
                'string',
                'max:100',
                'unique:cvrs,unique_id'
            ],
            'type'   => ['required', 'string'],
            'pu_id'  => ['required', 'exists:pus,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $cvr = Cvr::create([
            'unique_id' => $request->unique_id,
            'type'      => $request->type,
            'pu_id'     => $request->pu_id,
            'status'    => $request->status,
            'user_id'   => auth()->id(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'CVR created successfully',
            'data'    => $cvr->load('pu.ward', 'createdBy'),
        ]);
    }

    public function states()
    {
        $states = State::with('zones', 'lgas', 'wards', 'pus', 'users')->paginate(10);

        return view('admin.cvr.states', [
            'states' => $states,
            'sn' => 1,
        ]);
    }

    public function zones(State $state)
    {
        $zones = $state->zones()->with(['lgas.wards.pus.cvrs'])->get()->map(function ($zone) {
            $zone->cvr_count = $zone->lgas
                ->pluck('wards')
                ->flatten()
                ->pluck('pus')
                ->flatten()
                ->pluck('cvrs')
                ->flatten()
                ->count();
            return $zone;
        });

        // Total CVRs in the state
        $stateCvrCount = $zones->sum('cvr_count');

        return view('admin.cvr.zones', [
            'state' => $state,
            'zones' => $zones,
            'stateCvrCount' => $stateCvrCount,
        ]);
    }

    public function lgas(State $state, Zone $zone)
    {
        $lgas = $zone->lgas()->with(['wards.pus.cvrs'])->get()->map(function ($lga) {
            $lga->cvr_count = $lga->wards
                ->pluck('pus')
                ->flatten()
                ->pluck('cvrs')
                ->flatten()
                ->count();
            return $lga;
        });

        // Total CVRs in the zone
        $zoneCvrCount = $lgas->sum('cvr_count');

        return view('admin.cvr.lgas', [
            'zone' => $zone,
            'lgas' => $lgas,
            'zoneCvrCount' => $zoneCvrCount,
        ]);
    }

    public function wards(State $state, Zone $zone, Lga $lga)
    {
        $wards = $lga->wards()->with('pus.cvrs')->get()->map(function ($ward) {
            $ward->cvr_count = $ward->pus
                ->pluck('cvrs')
                ->flatten()
                ->count();
            return $ward;
        });

        // Total CVRs in the LGA
        $lgaCvrCount = $wards->sum('cvr_count');

        return view('admin.cvr.wards', [
            'lga' => $lga,
            'wards' => $wards,
            'lgaCvrCount' => $lgaCvrCount,
        ]);
    }

    public function pus(State $state, Zone $zone, Lga $lga, Ward $ward)
    {
        $pus = $ward->pus()->with('cvrs')->get()->map(function ($pu) {
            $pu->cvr_count = $pu->cvrs->count();
            return $pu;
        });

        // Total CVRs in the ward
        $wardCvrCount = $pus->sum('cvr_count');

        return view('admin.cvr.pus', [
            'ward' => $ward,
            'pus' => $pus,
            'wardCvrCount' => $wardCvrCount,
        ]);
    }

    public function voters(Request $request)
    {
        $query = State::with('zones', 'lgas', 'wards.voters', 'pus', 'users')->latest();

        // Apply filters if request has parameters
        if ($request->state_id) {
            $query->where('id', $request->state_id);
        }

        $states = $query->get();

        // Filter wards if needed
        if ($request->ward_id) {
            foreach ($states as $state) {
                $state->wards = $state->wards->where('id', $request->ward_id)->values();
            }
        }

        // Calculate first and second phase totals
        $firstPhaseTotalVoters = 0;
        $secondPhaseTotalVoters = 0;

        foreach ($states as $state) {
            foreach ($state->wards as $ward) {
                foreach ($ward->voters as $voter) {
                    $firstPhaseTotalVoters += $voter->first_phase_figure ?? 0;
                    $secondPhaseTotalVoters += $voter->second_phase_figure ?? 0;
                }
            }
        }

        // If it's an AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'states' => $states,
                'first_phase_total' => $firstPhaseTotalVoters,
                'second_phase_total' => $secondPhaseTotalVoters,
            ]);
        }

        // Normal page load
        return view('admin.cvr.voters', compact(
            'states',
            'firstPhaseTotalVoters',
            'secondPhaseTotalVoters'
        ));
    }

    public function logins()
    {
        return view('admin.cvr.logins', [
            'users' => User::with('role')
                ->whereHas('role', function ($query) {
                    $query->whereIn('name', [
                        'state_coordinator',
                        'zonal_coordinator',
                        'lga_coordinator',
                        'ward_coordinator'
                    ]);
                })
                ->latest()
                ->paginate(10),

            'states' => State::latest()->get(),
            'zones'  => Zone::latest()->get(),
            'lgas'   => Lga::latest()->get(),
            'wards'  => Ward::latest()->get(),
            'pus'    => Pu::latest()->get(),
            'sn'     => 1,
        ]);
    }

    public function storeLogin(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        //Image Upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('assets/img/users', 'public');
        }

        User::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Login created successfully'
        ]);
    }

    public function updateWardCvr(Request $request)
    {
        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'count'   => 'required|integer|min:1',
        ]);

        $ward = Ward::with('pus')->findOrFail($request->ward_id);
        $pus = $ward->pus;

        if ($pus->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No PUs found in this ward.'
            ]);
        }

        $totalCvrToAdd = $request->count;
        $puCount = $pus->count();
        $userId = auth()->id();

        // If number of CVRs <= number of PUs, assign 1 each to random PUs
        if ($totalCvrToAdd <= $puCount) {
            $pusToUpdate = $pus->random($totalCvrToAdd);
            foreach ($pusToUpdate as $pu) {
                Cvr::create([
                    'pu_id' => $pu->id,
                    'user_id' => $userId,
                    'type' => 'Registration',
                    'status' => 'pending',
                    'unique_id' => Cvr::generateUniqueId(),
                ]);
            }
        } else {
            // Distribute CVRs equally among all PUs
            $cvrsPerPu = intdiv($totalCvrToAdd, $puCount);
            $remaining = $totalCvrToAdd % $puCount;

            foreach ($pus as $pu) {
                for ($i = 0; $i < $cvrsPerPu; $i++) {
                    Cvr::create([
                        'pu_id' => $pu->id,
                        'user_id' => $userId,
                        'type' => 'Registration',
                        'status' => 'pending',
                        'unique_id' => Cvr::generateUniqueId(),
                    ]);
                }
            }

            // Distribute remaining randomly
            if ($remaining > 0) {
                $pusToUpdate = $pus->random($remaining);
                foreach ($pusToUpdate as $pu) {
                    Cvr::create([
                        'pu_id' => $pu->id,
                        'user_id' => $userId,
                        'type' => 'Registration',
                        'status' => 'pending',
                        'unique_id' => Cvr::generateUniqueId(),
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'CVRs updated successfully.',
        ]);
    }

    public function updatePuCvr(Request $request)
    {
        $request->validate([
            'pu_id' => 'required|exists:pus,id',
            'count' => 'required|integer|min:1',
        ]);

        $pu = Pu::findOrFail($request->pu_id);
        $totalCvrToAdd = $request->count;
        $userId = auth()->id();

        for ($i = 0; $i < $totalCvrToAdd; $i++) {
            Cvr::create([
                'pu_id' => $pu->id,
                'user_id' => $userId,
                'type' => 'Registration',
                'status' => 'pending',
                'unique_id' => Cvr::generateUniqueId(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'CVRs added successfully.',
        ]);
    }

    public function updateFigure(Request $request)
    {
        $validated = $request->validate([
            'type'    => 'required|in:first_phase,second_phase',
            'value'   => 'required|integer|min:0',
            'ward_id' => 'required|exists:wards,id',
        ]);

        // Either get existing voter record for the ward or create it
        $voter = Voter::firstOrCreate(
            ['ward_id' => $validated['ward_id']],
            [
                'first_phase_figure'  => 0,
                'second_phase_figure' => 0,
            ]
        );

        // Decide which column to update
        if ($validated['type'] === 'first_phase') {
            $voter->update([
                'first_phase_figure' => $validated['value'],
            ]);
        } else {
            $voter->update([
                'second_phase_figure' => $validated['value'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'CVR figure updated successfully',
        ]);
    }

    public function filter(Request $request)
    {
        $query = State::with('zones', 'lgas', 'wards.voters', 'pus');

        if ($request->state_id) {
            $query->where('id', $request->state_id);
        }

        $states = $query->get();

        // Filter wards if ward_id is set
        if ($request->ward_id) {
            foreach ($states as $state) {
                $state->wards = $state->wards->where('id', $request->ward_id)->values();
            }
        }

        // Calculate total voters
        $totalVoters = 0;
        foreach ($states as $state) {
            foreach ($state->wards as $ward) {
                $totalVoters += $ward->voters->count();
            }
        }

        return response()->json([
            'states' => $states,
            'total_voters' => $totalVoters,
        ]);
    }
}
