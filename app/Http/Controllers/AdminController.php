<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajax(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table($dependent . 's')
            ->where($select, $value)
            ->get();

        if ($dependent == 'lga' || $dependent == 'pu') {
            $dependent = strtoupper($dependent);
        } else {
            $dependent = ucfirst($dependent);
        }

        $output = '<option disabled selected>Choose ' . $dependent . '</option>';

        foreach ($data as $value) {
            $output .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }

        echo $output;
    }
}
