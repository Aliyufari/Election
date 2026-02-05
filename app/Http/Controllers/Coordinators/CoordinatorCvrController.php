<?php

namespace App\Http\Controllers\Coordinators;

use App\Models\Pu;
use App\Models\Cvr;
use App\Models\Lga;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;

class CoordinatorCvrController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Cvr::class, 'cvr');
    }

    /* ===================== CVR LIST ===================== */

    public function index()
    {
        $this->authorize('viewAny', Cvr::class);

        $cvrs = $this
            ->scopedCvrs(auth()->user())
            ->paginate(10);

        $states = State::with('zones', 'lgas', 'wards', 'pus', 'users')
            ->paginate(10);

        return view('coordinators.cvr.index', compact('cvrs', 'states'));
    }

    private function scopedCvrs(User $user)
    {
        return Cvr::with('pu')
            ->when(
                $user->isStateCoordinator(),
                fn($q) =>
                $q->whereHas('pu', fn($q) => $q->where('state_id', $user->state_id))
            )
            ->when(
                $user->isZonalCoordinator(),
                fn($q) =>
                $q->whereHas('pu', fn($q) => $q->where('zone_id', $user->zone_id))
            )
            ->when(
                $user->isLgaCoordinator(),
                fn($q) =>
                $q->whereHas('pu', fn($q) => $q->where('lga_id', $user->lga_id))
            )
            ->when(
                $user->isWardCoordinator(),
                fn($q) =>
                $q->whereHas('pu', fn($q) => $q->where('ward_id', $user->ward_id))
            );
    }

    /* ===================== CREATE CVR ===================== */

    public function store(Request $request)
    {
        $this->authorize('create', Cvr::class);

        $validator = Validator::make($request->all(), [
            'unique_id' => ['required', 'string', 'max:100', 'unique:cvrs,unique_id'],
            'type'      => ['required', 'string'],
            'pu_id'     => ['required', 'exists:pus,id'],
            'status'    => ['required', 'in:pending,approved,rejected'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
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

    /* ===================== STATE ===================== */

    public function states()
    {
        $this->authorize('viewAny', Cvr::class);

        return view('coordinators.cvr.states', [
            'states' => State::with('zones', 'lgas', 'wards', 'pus', 'users')->paginate(10),
            'sn' => 1,
        ]);
    }

    /* ===================== ZONES ===================== */

    /* ===================== ZONES ===================== */
    public function zones(State $state)
    {
        $this->authorize('viewAny', Cvr::class);

        $user = auth()->user();

        $zones = $state->zones()->with(['lgas.wards.pus.cvrs'])->get()->map(function ($zone) use ($user) {
            // Filter CVRs in nested PUs according to policy
            $zone->lgas->each(function ($lga) use ($user) {
                $lga->wards->each(function ($ward) use ($user) {
                    $ward->pus->each(function ($pu) use ($user) {
                        $pu->cvrs = $pu->cvrs->filter(fn($cvr) => $user->can('view', $cvr));
                    });
                });
            });

            // Count filtered CVRs
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

        return view('coordinators.cvr.zones', [
            'state' => $state,
            'zones' => $zones,
            'stateCvrCount' => $zones->sum('cvr_count'),
        ]);
    }

    /* ===================== LGAs ===================== */
    public function lgas(State $state, Zone $zone)
    {
        $this->authorize('viewAny', Cvr::class);

        $user = auth()->user();

        $lgas = $zone->lgas()
            ->with('wards.pus.cvrs')
            ->get()
            ->map(function ($lga) use ($user) {
                $lga->wards->each(function ($ward) use ($user) {
                    $ward->pus->each(function ($pu) use ($user) {
                        $pu->cvrs = $pu->cvrs->filter(fn($cvr) => $user->can('view', $cvr));
                    });
                });

                $lga->cvr_count = $lga->wards
                    ->pluck('pus')
                    ->flatten()
                    ->pluck('cvrs')
                    ->flatten()
                    ->count();

                return $lga;
            });

        return view('coordinators.cvr.lgas', [
            'zone' => $zone,
            'lgas' => $lgas,
            'zoneCvrCount' => $lgas->sum('cvr_count'),
        ]);
    }

    /* ===================== WARDS ===================== */
    public function wards(State $state, Zone $zone, Lga $lga)
    {
        $this->authorize('viewAny', Cvr::class);

        $user = auth()->user();

        $wards = $lga->wards()
            ->with('pus.cvrs')
            ->get()
            ->map(function ($ward) use ($user) {
                $ward->pus->each(function ($pu) use ($user) {
                    $pu->cvrs = $pu->cvrs->filter(fn($cvr) => $user->can('view', $cvr));
                });

                $ward->cvr_count = $ward->pus
                    ->pluck('cvrs')
                    ->flatten()
                    ->count();

                return $ward;
            });

        return view('coordinators.cvr.wards', [
            'lga' => $lga,
            'wards' => $wards,
            'lgaCvrCount' => $wards->sum('cvr_count'),
        ]);
    }

    /* ===================== PUs ===================== */
    public function pus(State $state, Zone $zone, Lga $lga, Ward $ward)
    {
        $this->authorize('viewAny', Cvr::class);

        $user = auth()->user();

        $pus = $ward->pus()
            ->with('cvrs')
            ->get()
            ->map(function ($pu) use ($user) {
                $pu->cvrs = $pu->cvrs->filter(fn($cvr) => $user->can('view', $cvr));
                $pu->cvr_count = $pu->cvrs->count();
                return $pu;
            });

        return view('coordinators.cvr.pus', [
            'ward' => $ward,
            'pus' => $pus,
            'wardCvrCount' => $pus->sum('cvr_count'),
        ]);
    }

    /* ===================== BULK UPDATE (WARD) ===================== */

    public function updateWardCvr(Request $request)
    {
        $this->authorize('create', Cvr::class);

        $request->validate([
            'ward_id' => 'required|exists:wards,id',
            'count'   => 'required|integer|min:1',
        ]);

        $ward = Ward::with('pus')->findOrFail($request->ward_id);
        $pus  = $ward->pus;

        if ($pus->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No PUs found.']);
        }

        $userId = auth()->id();

        for ($i = 0; $i < $request->count; $i++) {
            Cvr::create([
                'pu_id' => $pus->random()->id,
                'user_id' => $userId,
                'type' => 'Registration',
                'status' => 'pending',
                'unique_id' => Cvr::generateUniqueId(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'CVRs updated successfully']);
    }

    /* ===================== BULK UPDATE (PU) ===================== */

    public function updatePuCvr(Request $request)
    {
        $this->authorize('create', Cvr::class);

        $request->validate([
            'pu_id' => 'required|exists:pus,id',
            'count' => 'required|integer|min:1',
        ]);

        $pu = Pu::findOrFail($request->pu_id);
        $userId = auth()->id();

        for ($i = 0; $i < $request->count; $i++) {
            Cvr::create([
                'pu_id' => $pu->id,
                'user_id' => $userId,
                'type' => 'Registration',
                'status' => 'pending',
                'unique_id' => Cvr::generateUniqueId(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'CVRs added successfully']);
    }
}
