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

class ElectionsController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index(Election $election)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('elections.index', [
                'elections' => $election->latest()->paginate(10),
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]);
        }   
    }

    public function show(Election $election)
    {   
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
           return view('elections.show', [
                'election' => $election,
                'states' => State::latest()->get(),
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
           ]);  
        } 
    }

    public function create()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            $elections = [
                'Presidential election',
                'Governorship election',
                'Senatorial election',
                'House of Representatives election',
                'House of Assemby election',
                'Chairmanship',
                'Councillor'
            ];

            return view('elections.create', [
                'election_list' => $elections,
                'elections' => Election::latest()->get(),
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
            'type' => ['required', Rule::unique('elections', 'type')],
            'date' => ['required'],
        ]);

        Election::create($data);

        return redirect('/admin/elections')->with('success', 'Election created successfully!');
    }

    public function edit(Election $election)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
           $elections = [
                'Presidential election',
                'Governorship election',
                'Senatorial election',
                'House of Representatives election',
                'House of Assemby election',
                'Chairmanship',
                'Councillor'
            ];

            return view('elections.edit', [
                'election' => $election,
                'elections' => Election::latest()->get(),
                'election_list' => $elections,
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);   
        }
    }

    public function update(Request $request, Election $election)
    {
        $data = $request->validate([
            'type' => ['required'],
            'date' => ['required'],
        ]);

        $election->update($data);

        return redirect('/admin/elections')->with('success', 'Election updated successfully!');
    }

    public function destroy(Election $election)
    {
        $election->delete();

        return redirect('/admin/elections')->with('success', 'Election deleted successfully!');
    }
}
