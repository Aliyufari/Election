<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Result;
use App\Models\Message;
use App\Models\Election;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;
use DB;

class PusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pus = Pu::with(['state', 'zone', 'lga', 'ward'])
            ->latest()
            ->paginate(20);
        return view('admin.pus.index', [
            'pus' => $pus,
            'states' => State::with(['zones.lgas.wards'])
                ->latest()
                ->get(),
            'sn' => 1,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number'      => ['required', Rule::unique('pus', 'number')],
            'name'        => ['required', 'min:3'],
            'state_id'    => ['required', 'exists:states,id'],
            'zone_id'     => ['required', 'exists:zones,id'],
            'lga_id'      => ['required', 'exists:lgas,id'],
            'ward_id'     => ['required', 'exists:wards,id'],
            'description' => ['nullable', 'string'],
        ]);

        Pu::create($data);

        return response()->json(['status' => true, 'message' => 'Polling unit created successfully.']);
    }

    public function show(Pu $pu)
    {
        return response()->json([
            'pu' => $pu->load(['state', 'zone', 'lga', 'ward'])
        ]);
    }

    public function update(Request $request, Pu $pu)
    {
        $data = $request->validate([
            'number'      => ['required', Rule::unique('pus', 'number')->ignore($pu->id)],
            'name'        => ['required', 'min:3'],
            'state_id'    => ['required', 'exists:states,id'],
            'zone_id'     => ['required', 'exists:zones,id'],
            'lga_id'      => ['required', 'exists:lgas,id'],
            'ward_id'     => ['required', 'exists:wards,id'],
            'description' => ['nullable', 'string'],
        ]);

        $pu->update($data);

        return response()->json(['status' => true, 'message' => 'Polling unit updated successfully.']);
    }

    public function destroy(Pu $pu)
    {
        $pu->delete();

        return response()->json(['status' => true, 'message' => 'Polling unit deleted successfully.']);
    }

    public function registrations(Request $request, Pu $pu)
    {
        $data = $request->validate([
            'registration' => ['required'],
        ]);

        $pu->update($data);

        return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function accreditations(Request $request, Pu $pu)
    {
        $data = $request->validate([
            'accreditation' => ['required'],
        ]);

        dd($pu);

        $pu->update($data);

        return redirect()
            ->back()
            ->with('success', 'Updated successfully!');
    }
}
