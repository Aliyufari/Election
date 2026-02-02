<?php

namespace App\Http\Controllers;

use DB;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LgasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Lga $lga)
    {

        return view('admin.lgas.index', [
            'lgas' => $lga->latest()->paginate(10),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
            'sn' => 1,
        ]);
    }

    public function info(Lga $lga)
    {
        return view('admin.lgas.info', [
            'election' => request('name'),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lga' => $lga,
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.lgas.create', [
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', Rule::unique('lgas', 'name')],
            'state_id' => ['required'],
            'zone_id' => ['required'],
            'description' => ['required', 'min:24'],
        ]);

        Lga::create($data);

        return redirect('/admin/lgas')->with('success', 'LGA created successfully!');
    }

    public function show(Lga $lga)
    {
        return response()->json([
            'lga' => $lga->load('wards')
        ]);
    }

    public function edit(Lga $lga)
    {

        return view('admin.lgas.edit', [
            'lga' => $lga,
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function update(Request $request, Lga $lga)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'state_id' => ['required'],
            'zone_id' => ['required'],
            'description' => ['required', 'min:24'],
        ]);

        $lga->update($data);

        return redirect('/admin/lgas')->with('success', 'LGA updated successfully!');
    }

    public function destroy(Lga $lga)
    {
        $lga->delete();

        return redirect('/admin/lgas')->with('success', 'LGA deleted successfully!');
    }
}
