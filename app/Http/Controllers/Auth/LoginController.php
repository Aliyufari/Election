<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        if(auth()->attempt($credentials))
        {
           $request->session()->regenerate();

           return redirect()
                  ->intended('/')
                  ->with(['success' => 'Logged in Successfully!']);
        }

        return redirect('/login')
               ->withErrors(['username' => 'Invalid Username / Password'])
               ->onlyInput('username'); 
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully!');
    } 
}
