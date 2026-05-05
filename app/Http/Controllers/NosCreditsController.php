<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NosCreditsController extends Controller
{
    public function index()
    {
        return view('nos-credits');
    }
}
