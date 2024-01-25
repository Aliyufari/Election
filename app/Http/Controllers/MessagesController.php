<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Message;
use App\Models\Election;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;
use DB;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function index(Message $message)
    {   
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('messages.index', [
                'messages' => $message->latest()->paginate(10),
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
                'sn' => 1,
            ]);
        }   
    }

    public function show(Message $message)
    {   
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            $message->update(['is_read' => 1]);
            return view('messages.show', [
                'message' => $message,
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);
        }   
    }

    public function create()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('messages.create', [
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
        $data = $request->validate([
            'title' => ['required', 'min:10', 'max:24'],
            'body' => ['required', 'min:24'],
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['author'] = auth()->user()->role;

        Message::create($data);

        return redirect('/admin/messages')->with('success', 'Message created successfully!');
    }

    public function edit(Message $message)
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return abort('404');
        }
        else{
            return view('messages.edit', [
                'msg' => $message,
                'states' => State::latest()->get(),
                'zones' => Zone::latest()->get(),
                'lgas' => Lga::latest()->get(),
                'wards' => Ward::latest()->get(),
                'pus' => Pu::latest()->get(),
            ]);
        }  
    }

    public function update(Request $request, Message $message)
    {
        $data = $request->validate([
            'title' => ['required', 'min:10', 'max:24'],
            'body' => ['required', 'min:24'],
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['author'] = auth()->user()->role;

        $message->update($data);

        return redirect('/admin/messages')->with('success', 'Message updated successfully!');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect('/admin/messages')->with('success', 'Message deleted successfully!');
    }
}
