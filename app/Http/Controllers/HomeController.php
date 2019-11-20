<?php

namespace App\Http\Controllers;

use App\Session;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sessions = Session::where('user_id', auth()->id())->get();
        return view('home', ["sessions" => $sessions]);
    }
}
