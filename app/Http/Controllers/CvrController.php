<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Pu;
use App\Models\Lga;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\State;

class CvrController extends Controller
{
    public function states()
    {
        $states = State::with('zones', 'lgas', 'wards', 'pus', 'users')->paginate(10);

        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        } else {
            return view('cvr.states', [
                'states' => $states,
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]);
        }
    }

    public function zones(State $state)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            abort(404);
        }

        $zones = $state->zones()->with('state', 'lgas')->get();

        return view('cvr.zones', [
            'state' => $state,
            'zones' => $zones,
        ]);
    }

    public function lgas(State $state, Zone $zone)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            abort(404);
        }

        $lgas = $zone->lgas()->with('zone', 'wards')->get();

        return view('cvr.lgas', [
            'zone' => $zone,
            'lgas' => $lgas,
        ]);
    }

    public function wards(State $state, Zone $zone, Lga $lga)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            abort(404);
        }

        $wards = $lga->wards()->with('lga', 'pus')->get();

        return view('cvr.wards', [
            'lga' => $lga,
            'wards' => $wards,
        ]);
    }

    public function pus(State $state, Zone $zone, Lga $lga, Ward $ward)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            abort(404);
        }

        $pus = $ward->pus()->with('ward')->get();

        return view('cvr.pus', [
            'ward' => $ward,
            'pus' => $pus,
        ]);
    }

    public function voters()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        } else {
            return view('cvr.voters', [
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]);
        }
    }

    public function logins()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            abort(404);
        }

        return view('cvr.logins', [
            'users' => User::with('role')
                ->whereHas('role', function ($query) {
                    $query->whereIn('name', [
                        'state_coodinator',
                        'lga_coodinator'
                    ]);
                })
                ->latest()
                ->paginate(10),

            'states' => State::latest()->get(),
            'zones'  => Zone::latest()->get(),
            'lgas'   => Lga::latest()->get(),
            'wards'  => Ward::latest()->get(),
            'pus'    => Pu::latest()->get(),
            'sn'     => 1,
        ]);
    }

    public function storeLogin(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);

        //Image Upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('assets/img/users', 'public');
        }

        User::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Login created successfully'
        ]);
    }
}
