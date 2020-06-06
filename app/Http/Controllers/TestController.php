<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TestController extends Controller
{
    public function index()
    {
        return view('welcome')->with('sessionDialog', new Collection([
            'type' => 'top-alert',
            'message' => 'initial dialog loaded'
        ]));
    }
}
