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

    public function index(Pu $pu)
    {
        return view('admin.pus.index', [
            'pus' => $pu->latest()->paginate(10),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'sn' => 1,
        ]);
    }

    public function create()
    {
        return view('admin.pus.create', [
            'states' => State::latest()->get(),
            'elections' => Election::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => ['required', Rule::unique('pus', 'number')],
            'state_id' => ['required'],
            'zone_id' => ['required'],
            'lga_id' => ['required'],
            'ward_id' => ['required'],
        ]);

        Pu::create($data);

        return redirect('/admin/pus')->with('success', 'PU created successfully!');
    }

    public function show(Pu $pu) {}

    public function edit(Pu $pu)
    {
        return view('admin.pus.edit', [
            'pu' => $pu,
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function update(Request $request, Pu $pu)
    {
        $data = $request->validate([
            'number' => ['required'],
            'name' => ['required', 'min:3'],
            'state_id' => ['required'],
            'zone_id' => ['required'],
            'lga_id' => ['required'],
            'ward_id' => ['required'],
            'description' => ['required', 'min:24'],
        ]);

        $pu->update($data);

        return redirect('/admin/pus')->with('success', 'PU updated successfully!');
    }

    public function destroy(Pu $pu)
    {
        $pu->delete();

        return redirect('/admin/pus')->with('success', 'PU deleted successfully!');
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
