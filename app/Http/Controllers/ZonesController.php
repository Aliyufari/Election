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
    
    public function index(Zone $zone)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('zones.index', [
                'zone_state' => $zone,
                'zones' => $zone->latest()->paginate(10),
                'states' => State::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]);
        } 
    }

    public function info(Zone $zone)
    {
       return view('zones.info', [
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
       return view('zones.lgas', [
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
       return view('zones.list', [
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

    public function create()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('zones.create', [
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
            'name' => ['required', 'min:3', Rule::unique('zones', 'name')],
            'state_id' => ['required'],
            'description' => ['required', 'min:24'], 
        ]);

        Zone::create($data);

        return redirect('/admin/zones')->with('success', 'Zone created successfully!');
    }

    public function show(Zone $zone)
    {
        //
    }


    public function edit(Zone $zone)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('zones.edit', [
                'zone' => $zone,
                'states' => State::latest()->get(),
                'zones' => $zone->latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(), 
            ]);
        }
    }

    public function update(Request $request, Zone $zone)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'state_id' => ['required'],
            'description' => ['required', 'min:24'], 
        ]);

        $zone->update($data);

        return redirect('/admin/zones')->with('success', 'Zone updated successfully!');
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();

        return redirect('/admin/zones')->with('success', 'Zone deleted successfully!');
    }
}
