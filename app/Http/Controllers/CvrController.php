<?php

namespace App\Http\Controllers;

use App\Models\Pu;
use App\Models\Lga;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use App\Models\State;

class CvrController extends Controller
{
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
            return abort('404');
        } else {
            return view('cvr.logins', [
                'users' => User::latest()->paginate(10),
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]);
        }
    }
}
