<?php

namespace App\Http\Controllers;

use App\Models\Pu;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\State;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class WardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wards = Ward::with(['state', 'zone', 'lga', 'pus'])
            ->latest()
            ->paginate(20);
        return view('admin.wards.index', [
            'wards' => $wards,
            'states' => State::with(['zones.lgas'])
                ->latest()
                ->get(),
            'sn' => 1,
        ]);
    }

    public function info(Ward $ward)
    {
        return view('admin.wards.info', [
            'election' => request('name'),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'ward' => $ward,
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'min:3', Rule::unique('wards', 'name')],
            'state_id'    => ['required', 'exists:states,id'],
            'zone_id'     => ['required', 'exists:zones,id'],
            'lga_id'      => ['required', 'exists:lgas,id'],
            'description' => ['nullable', 'string'],
        ]);

        Ward::create($data);

        return response()->json(['status' => true, 'message' => 'Ward created successfully.']);
    }

    public function show(Ward $ward)
    {
        return response()->json([
            'ward' => $ward->load(['state', 'zone', 'lga'])
        ]);
    }

    public function update(Request $request, Ward $ward)
    {
        $data = $request->validate([
            'name'        => ['required', 'min:3', Rule::unique('wards', 'name')->ignore($ward->id)],
            'state_id'    => ['required', 'exists:states,id'],
            'zone_id'     => ['required', 'exists:zones,id'],
            'lga_id'      => ['required', 'exists:lgas,id'],
            'description' => ['nullable', 'string'],
        ]);

        $ward->update($data);

        return response()->json(['status' => true, 'message' => 'Ward updated successfully.']);
    }

    public function destroy(Ward $ward)
    {
        $ward->delete();

        return response()->json(['status' => true, 'message' => 'Ward deleted successfully.']);
    }

    public function accreditations(Request $request, Ward $ward)
    {
        $data = $request->validate([
            'accreditation' => ['required'],
        ]);


        $pus = DB::table('pus')->where('ward_id', $ward->id)->update($data);


        return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function registrations(Request $request, Ward $ward)
    {
        $data = $request->validate([
            'registration' => ['required'],
        ]);

        $pus = DB::table('pus')->where('ward_id', $ward->id)->update($data);


        return redirect()->back()->with('success', 'Updated successfully!');
    }
}
