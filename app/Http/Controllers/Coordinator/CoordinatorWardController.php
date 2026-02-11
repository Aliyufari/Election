<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\Ward;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoordinatorWardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user->ward_id) {
            return response()->json([
                'wards' => [],
            ]);
        }

        $wards = Ward::with(['state', 'users', 'lga', 'pus', 'zone'])
            ->where('id', $user->ward_id)
            ->get();

        return response()->json([
            'wards' => $wards,
        ]);
    }


    public function show(Ward $ward)
    {
        $user = Auth::user();

        if ($ward->state_id !== $user->state_id) {
            return response()->json([
                'ward' => null,
            ]);
        }

        $ward->load(['state', 'users', 'lga', 'pus', 'zone']);

        return response()->json([
            'ward' => $ward
        ]);
    }
}
