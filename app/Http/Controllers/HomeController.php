<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Message;
use App\Models\Election;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = User::find(auth()->user()->id);
        $notifications = Message::where('user_id', $id)
                                ->where('author', 'admin')
                                ->where('is_read', false)
                                ->latest()->get();

       return view('dashboard', [
        'notifications' => $notifications,
        'messages' => Message::latest()->get(),
        'states' => State::latest()->get(),
        'zones' => Zone::latest()->get(),
        'lgas' => Lga::latest()->get(),
        'wards' => Ward::latest()->get(),
        'pus' => Pu::latest()->get(),
       ]);      
    }
}
