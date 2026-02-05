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

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        return view('admin.users.index', [
            'users' => $user->latest()->paginate(10),
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
            'sn' => 1,
        ]);
    }

    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user,
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function create(State $state)
    {
        return view('admin.users.create', [
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:50', Rule::unique('users', 'username')],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'gender'   => ['required', 'in:male,female'],
            'phone'    => ['required', 'string', 'max:20'],
            'image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'role_id'  => ['required', 'exists:roles,id'],
            'state_id' => ['required', 'exists:states,id'],
            'zone_id'  => ['required', 'exists:zones,id'],
            'lga_id'   => ['required', 'exists:lgas,id'],
            'ward_id'  => ['required', 'exists:wards,id'],
            'pu_id'    => ['required', 'exists:pus,id'],
            'password' => ['required', 'min:8'],
        ]);

        $credentials['password'] = bcrypt($credentials['password']);

        if ($request->hasFile('image')) {
            $credentials['image'] = $request->file('image')->store('assets/img/users', 'public');
        }

        $user = User::create($credentials);

        if ($request->ajax()) {
            return response()->json([
                'status'  => true,
                'message' => 'User created successfully',
                'data'    => $user->load('role'),
            ]);
        }

        return redirect('/admin/users')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $credentials = $request->validate([
            'name' => ['required', 'min:3'],
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
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
        if ($request->hasFile('image')) {
            $credentials['image'] = $request->file('image')->store('assets/img/users', 'public');
        }

        $user->update($credentials);

        return redirect('/admin/users')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/admin/users')->with('warning', 'User deleted successfully!');
    }

    public function profile(User $user)
    {
        return view('admin.users.profile', [
            'user' => $user,
            'states' => State::latest()->get(),
            'zones' => Zone::latest()->get(),
            'lgas' => Lga::latest()->get(),
            'wards' => Ward::latest()->get(),
            'pus' => Pu::latest()->get(),
        ]);
    }

    public function updateProfile(Request $request, User $user)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'email'],
            'gender' => ['required'],
            'image' => ['required', 'mimes:jpg,png,jpeg'],
            'company' => ['required'],
            'job' => ['required'],
            'country' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'facebook' => ['required'],
            'twitter' => ['required'],
            'instagram' => ['required'],
            'youtube' => ['required'],
            'description' => ['required'],
        ]);

        //Image Upload
        if ($request->hasFile('image')) {
            $credentials['image'] = $request->file('image')->store('assets/img/users', 'public');
        }

        if ($user->update($credentials)) {
            return redirect('/admin/profile')->with('success', 'Profile updated Successfully!');
        }
    }

    public function updatePassword(Request $request, User $user)
    {
        $passwords = $request->validate([
            'password' => ['required'],
            'newpassword' => ['required'],
            'renewpassword' => ['required', 'same:newpassword'],
        ]);


        if (auth()->attempt(['username' => $user->username, 'password' => $passwords['password']])) {
            $password = bcrypt($passwords['newpassword']);

            $user->update(['password' => $password]);

            return redirect('/admin/profile')->with('success', 'Password updated Successfully!');
        }


        return redirect('/admin/profile')
            ->withErrors(['password' => 'Current Password Incorrect'])
            ->onlyInput('password');
    }
}
