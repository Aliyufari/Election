<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard', []);
    }

    public function coordinator()
    {
        return view('coordinator.dashboard', []);
    }
}
