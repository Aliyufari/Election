<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function create()
    {
        return view('admin.auth.register');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'min:3'],
            'username' => ['required', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8'],
        ]);

        //Hash Password
        $credentials['password'] = bcrypt($credentials['password']);


        User::create($credentials);

        return redirect('/login')->with('success', 'User created successfully!');
    }
}
