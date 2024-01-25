<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Hash;
use Session;
use App\Models\User;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;
use Illuminate\Support\Facades\Auth;

class RatechsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(User $user)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('ratechs.index', [
                'users' => $user->latest()->paginate(10),
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]); 
        }  
    }

    public function show(User $user)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
           return view('ratechs.show', [
                'user' => $user,
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
           ]); 
        }  
    }

    public function create(State $state)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('ratechs.create', [
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);
        }  
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'min:3'],
            'username' => ['required', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required','min:8'],
            'gender' => ['required'],
            'phone' => ['required'],
            'image' => ['required', 'mimes:jpg,png,jpeg'],
            'role' => ['required'],
            'state_id' => ['required'],
            'zone_id' => ['required'],
            'lga_id' => ['required'],
            'ward_id' => ['required'],
            'pu_id' => ['required'],
        ]);

        //Hash Password
        $credentials['password'] = bcrypt($credentials['password']);

        //Image Upload
        if ($request->hasFile('image')) 
        {
            $credentials['image'] = $request->file('image')->store('assets/img/users', 'public');
        }

        User::create($credentials);

        return redirect('/admin/ratechs')->with('success', 'Ratech created successfully!');
    }

    public function edit(User $user)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
           return view('ratechs.edit', [
                'user' => $user,
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
           ]); 
        } 
    }

    public function update(Request $request, User $user)
    {
        $credentials = $request->validate([
            'name' => ['required', 'min:3'],
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required','min:8'],
            'gender' => ['required'],
            'phone' => ['required'],
            'image' => ['required', 'mimes:jpg,png,jpeg'],
            'role' => ['required'],
            'state_id' => ['required'],
            'zone_id' => ['required'],
            'lga_id' => ['required'],
            'ward_id' => ['required'],
            'pu_id' => ['required'],
        ]);

        //Hash Password
        $credentials['password'] = bcrypt($credentials['password']);

        //Image Upload
        if ($request->hasFile('image')) 
        {
            $credentials['image'] = $request->file('image')->store('assets/img/users', 'public');
        }

        $user->update($credentials);

        return redirect('/admin/ratechs')->with('success', 'Ratech updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/admin/ratechs')->with('warning', 'Ratech deleted successfully!');
    }
}
