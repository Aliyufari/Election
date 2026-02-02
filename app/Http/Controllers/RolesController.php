<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        return response()->json([
            'roles' => Role::withoutSuper()->get()
        ]);
    }
}
