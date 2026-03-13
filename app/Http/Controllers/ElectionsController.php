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

    public function index()
    {
        $elections = Election::latest()->paginate(20);

        return view('admin.elections.index', [
            'elections' => $elections,
            'states' => State::with(['zones.lgas.wards.pus'])->latest()->get(),
            'sn' => 1,
        ]);
    }

    public function show(Election $election)
    {
        return response()->json(['election' => $election]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::unique('elections', 'type')],
            'date' => ['required', 'date'],
        ]);

        Election::create($data);

        return response()->json(['status' => true, 'message' => 'Election created successfully.']);
    }

    public function update(Request $request, Election $election)
    {
        $data = $request->validate([
            'type' => ['required', Rule::unique('elections', 'type')->ignore($election->id)],
            'date' => ['required', 'date'],
        ]);

        $election->update($data);

        return response()->json(['status' => true, 'message' => 'Election updated successfully.']);
    }

    public function destroy(Election $election)
    {
        $election->delete();

        return response()->json(['status' => true, 'message' => 'Election deleted successfully.']);
    }
}
