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

    public function index(Ward $ward)
    {
        return view('admin.wards.index', [
            'wards' => $ward->latest()->paginate(10),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'pus' => Pu::latest()->get(),
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

    public function create()
    {
        return view('admin.wards.create', [
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
            'name' => ['required', 'min:3', Rule::unique('wards', 'name')],
            'state_id' => ['required'],
            'zone_id' => ['required'],
            'lga_id' => ['required'],
            'description' => [],
        ]);

        Ward::create($data);

        return redirect('/admin/wards')->with('success', 'Ward created successfully!');
    }

    public function show(Ward $ward)
    {
        return response()->json([
            'ward' => $ward->load('pus')
        ]);
    }

    public function edit(Ward $ward)
    {
        return view('admin.wards.edit', [
            'ward' => $ward,
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function update(Request $request, Ward $ward)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'state' => ['required'],
            'zone' => ['required'],
            'lga' => ['required'],
            'description' => ['required', 'min:24'],
        ]);

        $ward->update($data);

        return redirect('/admin/wards')->with('success', 'Ward updated successfully!');
    }

    public function destroy(Ward $ward)
    {
        $ward->delete();

        return redirect('/admin/wards')->with('success', 'Ward deleted successfully!');
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
