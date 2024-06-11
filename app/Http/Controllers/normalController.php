<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class normalController extends Controller
{
    //
    function normal(Request $request){
        $request->all();
    }
}
