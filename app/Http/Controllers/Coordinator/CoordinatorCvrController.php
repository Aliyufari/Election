<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\Pu;
use App\Models\Cvr;
use App\Models\Lga;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        return view('coordinator.cvr.index', compact('cvrs', 'states'));
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

    public function logins()
    {
        $user = Auth::user();

        abort_unless(
            $user->hasAnyRole([
                'state_coordinator',
                'zonal_coordinator',
                'lga_coordinator',
                'ward_coordinator',
            ]),
            403
        );

        // ---------------------------------
        // Base users query (coordinator only)
        // ---------------------------------
        $users = User::with('role');

        // ---------------------------------
        // Base location queries
        // ---------------------------------
        $states = State::query();
        $zones  = Zone::query();
        $lgas   = Lga::query();
        $wards  = Ward::query();
        $pus    = Pu::query();

        // ---------------------------------
        // Role-based scoping
        // ---------------------------------
        if ($user->isStateCoordinator()) {

            $users->where('state_id', $user->state_id)
                ->whereHas(
                    'role',
                    fn($q) =>
                    $q->whereIn('name', [
                        'zonal_coordinator',
                        'lga_coordinator',
                        'ward_coordinator',
                    ])
                );

            $states->where('id', $user->state_id);
            $zones->where('state_id', $user->state_id);
            $lgas->where('state_id', $user->state_id);
            $wards->where('state_id', $user->state_id);
            $pus->where('state_id', $user->state_id);
        } elseif ($user->isZonalCoordinator()) {

            $users->where('zone_id', $user->zone_id)
                ->whereHas(
                    'role',
                    fn($q) =>
                    $q->whereIn('name', [
                        'lga_coordinator',
                        'ward_coordinator',
                    ])
                );

            $zones->where('id', $user->zone_id);
            $lgas->where('zone_id', $user->zone_id);
            $wards->where('zone_id', $user->zone_id);
            $pus->where('zone_id', $user->zone_id);
        } elseif ($user->isLgaCoordinator()) {

            $users->where('lga_id', $user->lga_id)
                ->whereHas(
                    'role',
                    fn($q) =>
                    $q->where('name', 'ward_coordinator')
                );

            $lgas->where('id', $user->lga_id);
            $wards->where('lga_id', $user->lga_id);
            $pus->where('lga_id', $user->lga_id);
        } elseif ($user->isWardCoordinator()) {

            $users->where('ward_id', $user->ward_id);

            $wards->where('id', $user->ward_id);
            $pus->where('ward_id', $user->ward_id);
        }

        // ---------------------------------
        // Return filtered results
        // ---------------------------------
        return view('coordinator.cvr.logins', [
            'users'  => $users->paginate(10),
            'states' => $states->latest()->get(),
            'zones'  => $zones->latest()->get(),
            'lgas'   => $lgas->latest()->get(),
            'wards'  => $wards->latest()->get(),
            'pus'    => $pus->latest()->get(),
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
