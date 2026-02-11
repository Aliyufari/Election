<?php

namespace App\Http\Controllers\Coordinator;

use App\Models\Lga;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CoordinatorLgaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user->lga_id) {
            return response()->json([
                'lgas' => [],
            ]);
        }

        $lgas = Lga::with(['state', 'users', 'wards', 'pus', 'zone'])
            ->where('id', $user->lga_id)
            ->get();

        return response()->json([
            'lgas' => $lgas,
        ]);
    }


    public function show(Lga $lga)
    {
        $user = Auth::user();

        if ($lga->state_id !== $user->state_id) {
            return response()->json([
                'lga' => null,
            ]);
        }

        $lga->load(['state', 'users', 'wards', 'pus', 'zone']);

        return response()->json([
            'lga' => $lga
        ]);
    }
}
