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

class StatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $state = State::with(['lgas', 'users', 'wards', 'pus', 'zones'])
            ->latest()
            ->paginate(20);

        if (request()->expectsJson()) {
            return response()->json([
                'states' => $state,
            ]);
        }

        return view('admin.states.index', [
            'states' => $state,
            'sn'     => 1,
        ]);
    }

    public function list(State $state)
    {
        return view('admin.states.list', [
            'states' => $state->paginate(10),
            'sn' => 1,
        ]);
    }

    public function show(State $state)
    {
        $state->load(['lgas', 'users', 'wards', 'pus', 'zones']);

        return response()->json(['state' => $state]);
    }

    public function info(State $state)
    {
        $elections = [
            'Presidential election',
            'Governorship election',
            'Senatorial election',
            'House of Representatives election',
            'House of Assemby election',
            'Chairmanship',
            'Councillor'
        ];

        return view('admin.states.info', [
            'election_list' => $elections,
            'state' => $state,
            'states' => State::latest()->get(),
            'state_zones' => $state->zones(),
            'zones' => DB::table('zones')->where('state_id', $state->id)->get(),
            // 'zones' => Zone::with('state_id', $state->id)->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function zones(State $state)
    {
        return view('admin.states.zones', [
            'election' => request('name'),
            'elections' => Election::latest()->get(),
            'states' => State::latest()->get(),
            'state_zones' => DB::table('zones')->where('state_id', $state->id)->get(),
            'zones' => Zone::latest()->get(),
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
            'description' => 'nullable|string',
        ]);

        State::create($validated);

        return response()->json(['status' => true, 'message' => 'State created successfully.']);
    }

    public function update(Request $request, State $state)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $state->update($validated);

        return response()->json(['status' => true, 'message' => 'State updated successfully.']);
    }

    public function destroy(State $state)
    {
        $state->delete();

        return response()->json(['status' => true, 'message' => 'State deleted successfully.']);
    }
}
