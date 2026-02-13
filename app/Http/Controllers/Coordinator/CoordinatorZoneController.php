<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\Zone;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoordinatorZoneController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user->zone_id) {
            return response()->json([
                'zones' => [],
            ]);
        }

        $zones = Zone::with(['state', 'users', 'wards', 'pus', 'lgas'])
            ->where('id', $user->zone_id)
            ->get();

        return response()->json([
            'zones' => $zones,
        ]);
    }


    public function show(Zone $zone)
    {
        $user = Auth::user();

        if ($zone->state_id !== $user->state_id) {
            return response()->json([
                'zone' => null,
            ]);
        }

        $zone->load(['state', 'users', 'wards', 'pus', 'lgas']);

        return response()->json([
            'zone' => $zone
        ]);
    }
}
