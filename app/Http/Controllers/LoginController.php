<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller

{
    function login() {
        $data1 = DB::connection('mysql')->table('users')->get();
        dd($data1);
    }
}
