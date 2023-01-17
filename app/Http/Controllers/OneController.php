<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OneController extends Controller
{
    function createuser(){
        User::create([
            'name'=>'fsfs',
            'password'=>'dadad'
        ]);
    }
}
