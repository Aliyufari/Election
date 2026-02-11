<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\Pu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoordinatorPuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user->pu_id) {
            return response()->json([
                'pus' => [],
            ]);
        }

        $pus = Pu::with(['state', 'users', 'lga', 'ward', 'zone'])
            ->where('id', $user->pu_id)
            ->get();

        return response()->json([
            'pus' => $pus,
        ]);
    }


    public function show(Pu $pu)
    {
        $user = Auth::user();

        if ($pu->id !== $user->pu_id) {
            return response()->json([
                'pu' => null,
            ]);
        }

        $pu->load(['state', 'users', 'lga', 'ward', 'zone']);

        return response()->json([
            'pu' => $pu
        ]);
    }
}
