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
use Illuminate\Support\Facades\Validator;

class CvrController extends Controller
{
    public function index()
    {
        $states = State::with('zones', 'lgas', 'wards', 'pus', 'users')->paginate(10);
        return view('admin.cvr.index', [
            'cvrs' => Cvr::with('pu')->paginate(10),
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
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'CVR created successfully',
            'data'    => $cvr->load('pu.ward'),
        ]);
    }

    public function states()
    {
        $states = State::with('zones', 'lgas', 'wards', 'pus', 'users')->paginate(10);

        return view('admin.cvr.states', [
            'states' => $states,
            // 'zones' => Zone::latest()->get(),
            // 'lgas' => Lga::latest()->get(),
            // 'wards' => Ward::latest()->get(),
            // 'pus' => Pu::latest()->get(),
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

    public function voters()
    {
        return view('admin.cvr.voters', [
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
            'sn' => 1,
        ]);
    }

    public function logins()
    {

        return view('admin.cvr.logins', [
            'users' => User::with('role')
                ->whereHas('role', function ($query) {
                    $query->whereIn('name', [
                        'state_coodinator',
                        'lga_coodinator'
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
}
