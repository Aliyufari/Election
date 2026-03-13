<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Lga;
use App\Models\Message;
use App\Models\Pu;
use App\Models\Result;
use App\Models\State;
use App\Models\Ward;
use App\Models\Zone;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $results = Result::with('pu', 'election')
            ->latest()
            ->paginate(20);

        return view('admin.results.index', [
            'results'   => $results,
            'elections' => Election::latest()->get(),
            'states'    => State::with(['zones.lgas.wards.pus'])->latest()->get(),
            'sn'        => 1,
        ]);
    }

    public function show(Result $result)
    {
        return view('admin.results.show', [
            'result' => $result->load(['pu.state', 'pu.zone', 'pu.lga', 'pu.ward', 'election']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pu_id'       => ['required', 'exists:pus,id'],
            'election_id' => ['required', 'exists:elections,id'],
            'image'       => ['required', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/img/results', 'public');
        }

        Result::create($data);

        return response()->json(['status' => true, 'message' => 'Result uploaded successfully.']);
    }

    public function update(Request $request, Result $result)
    {
        $data = $request->validate([
            'pu_id'       => ['required', 'exists:pus,id'],
            'election_id' => ['required', 'exists:elections,id'],
            'image'       => ['nullable', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($result->image) {
                Storage::disk('public')->delete($result->image);
            }
            $data['image'] = $request->file('image')->store('assets/img/results', 'public');
        } else {
            unset($data['image']); // keep existing image
        }

        $result->update($data);

        return response()->json(['status' => true, 'message' => 'Result updated successfully.']);
    }

    public function destroy(Result $result)
    {
        if ($result->image) {
            Storage::disk('public')->delete($result->image);
        }

        $result->delete();

        return response()->json(['status' => true, 'message' => 'Result deleted successfully.']);
    }
}
