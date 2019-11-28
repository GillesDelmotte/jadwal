<?php

namespace App\Http\Controllers;

use App\Session;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $sessions = Session::where('user_id', auth()->id())->where('is_archive', '=', true)->get();
        return view('sessions.archive', ["sessions" => $sessions]);
    }
}
