<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoordinatorStateController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user->state_id) {
            return response()->json([
                'states' => [],
            ]);
        }

        $states = State::with(['lgas', 'users', 'wards', 'pus', 'zones'])
            ->where('id', $user->state_id)
            ->get();

        return response()->json([
            'states' => $states,
        ]);
    }


    public function show(State $state)
    {
        $user = Auth::user();

        if ($state->id != $user->state_id) {
            return response()->json([
                'state' => null,
            ]);
        }

        $state->load(['lgas', 'users', 'wards', 'pus', 'zones']);

        return response()->json([
            'state' => $state
        ]);
    }
}
