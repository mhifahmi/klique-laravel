<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        return view('dashboard.queue.index');
    }
}
