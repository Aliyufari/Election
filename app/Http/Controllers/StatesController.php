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

    public function index(State $state)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        } else {
            return view('states.index', [
                'states' => $state->paginate(10),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]);
        }
    }

    public function show(State $state)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        } else {
            return view('states.show', [
                'state' => $state,
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);
        }
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

        return view('states.info', [
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
        return view('states.zones', [
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

    public function create()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        } else {
            return view('states.create', [
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', Rule::unique('states', 'name')],
            'description' => ['required', 'min:24'],
        ]);

        State::create($data);

        return redirect('/admin/states')->with('success', 'State created successfully!');
    }

    public function edit(State $state)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        } else {
            return view('states.edit', [
                'state' => $state,
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);
        }
    }

    public function update(Request $request, State $state)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'description' => ['required', 'min:24'],
        ]);

        $state->update($data);

        return redirect('/admin/states')->with('success', 'State updated successfully!');
    }

    public function destroy(State $state)
    {
        $state->delete();

        return redirect('/admin/states')->with('success', 'State deleted successfully!');
    }
}
