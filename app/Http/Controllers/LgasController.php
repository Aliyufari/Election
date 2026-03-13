<?php

namespace App\Http\Controllers;

use DB;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LgasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Lga $lga)
    {
        $lgas = Lga::with(['state', 'zone', 'wards', 'pus', 'users'])
            ->latest()
            ->paginate(20);

        return view('admin.lgas.index', [
            'lgas' => $lgas,
            'states' => State::with(['zones'])->latest()->get(),
            'sn' => 1,
        ]);
    }

    public function info(Lga $lga)
    {
        return view('admin.lgas.info', [
            'election' => request('name'),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lga' => $lga,
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'state_id'    => 'required|exists:states,id',
            'zone_id'     => 'required|exists:zones,id',
            'description' => 'nullable|string',
        ]);

        Lga::create($validated);

        return response()->json(['status' => true, 'message' => 'LGA created successfully.']);
    }

    public function show(Lga $lga)
    {
        return response()->json([
            'lga' => $lga->load(['state', 'zone', 'wards'])
        ]);
    }

    public function update(Request $request, Lga $lga)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'state_id'    => 'required|exists:states,id',
            'zone_id'     => 'required|exists:zones,id',
            'description' => 'nullable|string',
        ]);

        $lga->update($validated);

        return response()->json(['status' => true, 'message' => 'LGA updated successfully.']);
    }

    public function destroy(Lga $lga)
    {
        $lga->delete();

        return response()->json(['status' => true, 'message' => 'LGA deleted successfully.']);
    }
}
