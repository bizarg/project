<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::all();
        $domains->load('ip', 'ns1', 'ns2', 'ip.country', 'build');

//        dd($domains[0]);


        return view('home', compact('domains'));
    }
}
