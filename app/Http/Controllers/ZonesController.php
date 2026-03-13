<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Election;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;
use DB;

class ZonesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $zones = Zone::with(['state', 'lgas', 'wards', 'pus', 'users'])
            ->latest();



        if (request()->wantsJson()) {
            return response()->json(['zones' => $zones->get()]);
        }

        return view('admin.zones.index', [
            'zones' => $zones->paginate(10),
            'states' => State::latest()->get(),
            'sn' => 1,
        ]);
    }

    public function info(Zone $zone)
    {
        return view('admin.zones.info', [
            'election' => request('name'),
            'elections' => Election::latest()->get(),
            'states' => State::latest()->get(),
            'zone' => $zone,
            'zones' => $zone->latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function lgas(Zone $zone)
    {
        return view('admin.zones.lgas', [
            'election' => request('name'),
            'elections' => Election::latest()->get(),
            'states' => State::latest()->get(),
            'zone' => $zone,
            'zones' => $zone->latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function list(Zone $zone)
    {
        return view('admin.zones.list', [
            'election' => DB::table('elections')->where('type', 'Senatorial election')->value('type'),
            'elections' => Election::latest()->get(),
            'states' => State::latest()->get(),
            'zones' => $zone->latest()->get(),
            'zone_lgas' => DB::table('lgas')->where('state', 'Bauchi'),
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
            'description' => 'nullable|string',
        ]);

        Zone::create($validated);

        return response()->json(['status' => true, 'message' => 'Zone created successfully.']);
    }

    public function show(Zone $zone)
    {
        return response()->json([
            'zone' => $zone->load('state')
        ]);
    }

    public function update(Request $request, Zone $zone)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'state_id'    => 'required|exists:states,id',
            'description' => 'nullable|string',
        ]);

        $zone->update($validated);

        return response()->json(['status' => true, 'message' => 'Zone updated successfully.']);
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();

        return response()->json(['status' => true, 'message' => 'Zone deleted successfully.']);
    }
}
