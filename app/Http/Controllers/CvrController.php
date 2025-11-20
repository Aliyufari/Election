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
