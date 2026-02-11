<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoordinatorRoleController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $roles = Role::query();

        abort_unless(
            $user->hasAnyRole([
                'state_coordinator',
                'zonal_coordinator',
                'lga_coordinator',
                'ward_coordinator',
            ]),
            403
        );

        if ($user->isStateCoordinator()) {
            $roles->whereIn('name', [
                'zonal_coordinator',
                'lga_coordinator',
                'ward_coordinator',
            ]);
        } elseif ($user->isZonalCoordinator()) {
            $roles->whereIn('name', [
                'lga_coordinator',
                'ward_coordinator',
            ]);
        } elseif ($user->isLgaCoordinator()) {

            $roles->where('name', 'ward_coordinator');
        } elseif ($user->isWardCoordinator()) {
            $roles->whereRaw('1 = 0');
        }

        return response()->json([
            'roles' => $roles->get(),
        ]);
    }
}
