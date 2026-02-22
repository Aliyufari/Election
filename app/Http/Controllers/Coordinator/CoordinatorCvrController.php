<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\Pu;
use App\Models\Cvr;
use App\Models\Lga;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\Role;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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

        $user = auth()->user();

        $cvrs = $this
            ->scopedCvrs($user)
            ->paginate(10);

        $states = State::with('zones', 'lgas', 'wards', 'pus')->get();

        $coordinator = $user;

        return view('coordinator.cvr.index', compact('cvrs', 'states', 'coordinator'));
    }

    private function scopedCvrs(User $user)
    {
        return Cvr::with('pu.ward.lga.zone.state')
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

        // Ensure the PU is within the coordinator's scope
        $this->authorizePuScope(auth()->user(), $request->pu_id);

        $cvr = Cvr::create([
            'unique_id'  => $request->unique_id,
            'type'       => $request->type,
            'pu_id'      => $request->pu_id,
            'status'     => $request->status,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'CVR created successfully',
            'data'    => $cvr->load('pu.ward'),
        ]);
    }

    /* ===================== UPDATE CVR ===================== */

    public function update(Request $request, Cvr $cvr)
    {
        $this->authorize('update', $cvr);

        $validator = Validator::make($request->all(), [
            'unique_id' => ['required', 'string', 'max:100', "unique:cvrs,unique_id,{$cvr->id}"],
            'type'      => ['required', 'string'],
            'pu_id'     => ['required', 'exists:pus,id'],
            'status'    => ['required', 'in:pending,approved,rejected'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ensure the PU is within the coordinator's scope
        $this->authorizePuScope(auth()->user(), $request->pu_id);

        $cvr->update([
            'unique_id' => $request->unique_id,
            'type'      => $request->type,
            'pu_id'     => $request->pu_id,
            'status'    => $request->status,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'CVR updated successfully',
            'data'    => $cvr->load('pu.ward'),
        ]);
    }

    /* ===================== DELETE CVR ===================== */

    public function destroy(Cvr $cvr)
    {
        $this->authorize('delete', $cvr);

        $cvr->delete();

        return response()->json([
            'status'  => true,
            'message' => 'CVR deleted successfully',
        ]);
    }

    /* ===================== CVR LOGINS LIST ===================== */

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

        $users  = User::with(['role', 'state', 'zone', 'lga', 'ward']);
        $states = State::query();
        $zones  = Zone::query();
        $lgas   = Lga::query();
        $wards  = Ward::query();
        $pus    = Pu::query();

        if ($user->isStateCoordinator()) {
            $users->where('state_id', $user->state_id)
                ->whereHas('role', fn($q) => $q->whereIn('name', [
                    'zonal_coordinator',
                    'lga_coordinator',
                    'ward_coordinator',
                ]));

            $states->where('id', $user->state_id);
            $zones->where('state_id', $user->state_id);
            $lgas->where('state_id', $user->state_id);
            $wards->where('state_id', $user->state_id);
            $pus->where('state_id', $user->state_id);
        } elseif ($user->isZonalCoordinator()) {
            $users->where('zone_id', $user->zone_id)
                ->whereHas('role', fn($q) => $q->whereIn('name', [
                    'lga_coordinator',
                    'ward_coordinator',
                ]));

            $zones->where('id', $user->zone_id);
            $lgas->where('zone_id', $user->zone_id);
            $wards->where('zone_id', $user->zone_id);
            $pus->where('zone_id', $user->zone_id);
        } elseif ($user->isLgaCoordinator()) {
            $users->where('lga_id', $user->lga_id)
                ->whereHas('role', fn($q) => $q->where('name', 'ward_coordinator'));

            $lgas->where('id', $user->lga_id);
            $wards->where('lga_id', $user->lga_id);
            $pus->where('lga_id', $user->lga_id);
        } elseif ($user->isWardCoordinator()) {
            // Ward coordinators cannot create any logins
            abort(403, 'You are not authorized to manage logins.');
        }

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

    /* ===================== STORE LOGIN ===================== */

    public function storeLogin(StoreUserRequest $request)
    {
        $authUser = auth()->user();

        // Ward coordinators cannot create logins
        abort_if($authUser->isWardCoordinator(), 403, 'You are not authorized to create logins.');

        $this->authorizeRoleAssignment($authUser, $request->role_id);
        $this->authorizeLocationScope($authUser, $request);

        $data             = $request->validated();
        $data['password'] = bcrypt($data['password']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('assets/img/users', 'public');
        }

        User::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Login created successfully',
        ]);
    }

    /* ===================== UPDATE LOGIN ===================== */

    public function updateLogin(UpdateUserRequest $request, User $user)
    {
        $authUser = auth()->user();

        // Ward coordinators cannot update logins
        abort_if($authUser->isWardCoordinator(), 403, 'You are not authorized to update logins.');

        $this->authorizeUserAccess($authUser, $user);
        $this->authorizeRoleAssignment($authUser, $request->role_id);
        $this->authorizeLocationScope($authUser, $request);

        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')
                ->store('assets/img/users', 'public');
        }

        $user->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Login updated successfully',
        ]);
    }

    /* ===================== DELETE LOGIN ===================== */

    public function deleteLogin(User $user)
    {
        $authUser = auth()->user();

        // Ward coordinators cannot delete logins
        abort_if($authUser->isWardCoordinator(), 403, 'You are not authorized to delete logins.');

        // Cannot delete yourself
        abort_if(
            $user->id === $authUser->id,
            403,
            'You cannot delete your own account.'
        );

        $this->authorizeUserAccess($authUser, $user);

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Login deleted successfully',
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

        // Ensure ward is within the coordinator's scope
        $user = auth()->user();
        $ward = Ward::with('pus')->findOrFail($request->ward_id);

        abort_unless($this->wardInScope($user, $ward), 403, 'This ward is outside your scope.');

        $pus = $ward->pus;

        if ($pus->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No PUs found.']);
        }

        for ($i = 0; $i < $request->count; $i++) {
            Cvr::create([
                'pu_id'     => $pus->random()->id,
                'user_id'   => $user->id,
                'type'      => 'Registration',
                'status'    => 'pending',
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

        $user = auth()->user();
        $pu   = Pu::findOrFail($request->pu_id);

        // Ensure PU is within the coordinator's scope
        $this->authorizePuScope($user, $pu->id);

        for ($i = 0; $i < $request->count; $i++) {
            Cvr::create([
                'pu_id'     => $pu->id,
                'user_id'   => $user->id,
                'type'      => 'Registration',
                'status'    => 'pending',
                'unique_id' => Cvr::generateUniqueId(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'CVRs added successfully']);
    }

    /* ===================== PRIVATE SECURITY HELPERS ===================== */

    /**
     * Ensure the auth user is allowed to assign the given role.
     */
    private function authorizeRoleAssignment(User $authUser, int $roleId): void
    {
        $role = Role::findOrFail($roleId);

        $allowed = match (true) {
            $authUser->isStateCoordinator() => ['zonal_coordinator', 'lga_coordinator', 'ward_coordinator'],
            $authUser->isZonalCoordinator() => ['lga_coordinator', 'ward_coordinator'],
            $authUser->isLgaCoordinator()   => ['ward_coordinator'],
            default                         => [],
        };

        abort_unless(
            in_array($role->name, $allowed),
            403,
            'You are not authorized to assign this role.'
        );
    }

    /**
     * Ensure all location IDs in the request fall within the auth user's jurisdiction.
     */
    private function authorizeLocationScope(User $authUser, Request $request): void
    {
        if ($authUser->isStateCoordinator()) {

            abort_if(
                $request->state_id && $request->state_id != $authUser->state_id,
                403,
                'You can only assign users within your state.'
            );

            if ($request->zone_id) {
                $zone = Zone::findOrFail($request->zone_id);
                abort_unless($zone->state_id == $authUser->state_id, 403, 'Zone is outside your state.');
            }

            if ($request->lga_id) {
                $lga = Lga::findOrFail($request->lga_id);
                abort_unless($lga->state_id == $authUser->state_id, 403, 'LGA is outside your state.');
            }

            if ($request->ward_id) {
                $ward = Ward::findOrFail($request->ward_id);
                abort_unless($ward->state_id == $authUser->state_id, 403, 'Ward is outside your state.');
            }
        } elseif ($authUser->isZonalCoordinator()) {

            abort_if(
                $request->zone_id && $request->zone_id != $authUser->zone_id,
                403,
                'You can only assign users within your zone.'
            );

            if ($request->lga_id) {
                $lga = Lga::findOrFail($request->lga_id);
                abort_unless($lga->zone_id == $authUser->zone_id, 403, 'LGA is outside your zone.');
            }

            if ($request->ward_id) {
                $ward = Ward::findOrFail($request->ward_id);
                abort_unless($ward->zone_id == $authUser->zone_id, 403, 'Ward is outside your zone.');
            }
        } elseif ($authUser->isLgaCoordinator()) {

            abort_if(
                $request->lga_id && $request->lga_id != $authUser->lga_id,
                403,
                'You can only assign users within your LGA.'
            );

            if ($request->ward_id) {
                $ward = Ward::findOrFail($request->ward_id);
                abort_unless($ward->lga_id == $authUser->lga_id, 403, 'Ward is outside your LGA.');
            }
        }
    }

    /**
     * Ensure the auth user has jurisdiction over the target user.
     */
    private function authorizeUserAccess(User $authUser, User $targetUser): void
    {
        $authorized = match (true) {
            $authUser->isStateCoordinator() => $targetUser->state_id == $authUser->state_id
                && in_array($targetUser->role->name, ['zonal_coordinator', 'lga_coordinator', 'ward_coordinator']),

            $authUser->isZonalCoordinator() => $targetUser->zone_id == $authUser->zone_id
                && in_array($targetUser->role->name, ['lga_coordinator', 'ward_coordinator']),

            $authUser->isLgaCoordinator()   => $targetUser->lga_id == $authUser->lga_id
                && $targetUser->role->name === 'ward_coordinator',

            default => false,
        };

        abort_unless($authorized, 403, 'You are not authorized to manage this user.');
    }

    /**
     * Ensure the given PU is within the auth user's scope.
     */
    private function authorizePuScope(User $user, int $puId): void
    {
        $pu = Pu::findOrFail($puId);

        $inScope = match (true) {
            $user->isStateCoordinator() => $pu->state_id == $user->state_id,
            $user->isZonalCoordinator() => $pu->zone_id  == $user->zone_id,
            $user->isLgaCoordinator()   => $pu->lga_id   == $user->lga_id,
            $user->isWardCoordinator()  => $pu->ward_id  == $user->ward_id,
            default                     => false,
        };

        abort_unless($inScope, 403, 'This polling unit is outside your scope.');
    }

    /**
     * Check if a ward is within the auth user's scope.
     */
    private function wardInScope(User $user, Ward $ward): bool
    {
        return match (true) {
            $user->isStateCoordinator() => $ward->state_id == $user->state_id,
            $user->isZonalCoordinator() => $ward->zone_id  == $user->zone_id,
            $user->isLgaCoordinator()   => $ward->lga_id   == $user->lga_id,
            $user->isWardCoordinator()  => $ward->id       == $user->ward_id,
            default                     => false,
        };
    }
}
