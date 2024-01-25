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

class ResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Result $result)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('results.index', [
                'results' => $result->latest()->paginate(10),
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'sn' => 1,
            ]);
        }
    }

    public function show(Result $result)
    { 
        return view('results.show', [
            'result' => $result,
            'results' => $result->latest()->paginate(10),
            'election' => request('name'),
            'elections' => Election::latest()->get(),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
        ]);
    }

    public function create()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('results.create', [
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
            'pu_id' => ['required'],
            'election_id' => ['required'],
            'image' => ['required', 'mimes:jpg,png,jpeg'],
        ]);

        //Image Upload
        if ($request->hasFile('image')) 
        {
            $data['image'] = $request->file('image')->store('assets/img/results', 'public');
        }


        Result::create($data);

        return redirect('/admin/results')->with('success', 'Result uploaded successfully!');
    }

    public function edit(Result $result)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('results.edit', [
                'result' => $result,
                'elections' => Election::latest()->get(),
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);
        }
    }

    public function update(Request $request, Result $result)
    {
        $data = $request->validate([
            'pu_id' => ['required'],
            'election_id' => ['required'],
            'image' => ['required', 'mimes:jpg,png,jpeg'],
        ]);

        //Image Upload
        if ($request->hasFile('image')) 
        {
            $data['image'] = $request->file('image')->store('assets/img/results', 'public');
        }


        $result->update($data);

        return redirect('/admin/results')->with('success', 'Result updated successfully!');
    }

     public function destroy(Result $result)
    {
        $result->delete();

        return redirect('/admin/results')->with('success', 'Result deleted successfully!');
    }
}
