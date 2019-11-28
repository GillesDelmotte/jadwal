<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\sendFirstEmail;
use App\Modal;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session as PHPSession;


class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->from) {
            $sessions = Session::where('user_id', auth()->id())->get();

            $session = Session::find($request->from);
            return view('sessions.create', ['sessions' => $sessions, 'lastSession' => $session]);
        }
        $sessions = Session::where('user_id', auth()->id())->get();
        return view('sessions.create', ['sessions' => $sessions, 'lastSession' => '']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'content' => 'required'
        ]);

        $session = new Session();
        $session->title = $request->title;
        $session->user_id = auth()->id();

        $date = $request->date . ' ' .  '00:00';

        $session->date = new Carbon($date);
        $session->content = $request->content;

        $session->save();

        if ($request->lastSession) {
            $lastSession = Session::find($request->lastSession);

            $lastSession->load('teachers');

            foreach ($lastSession->teachers as $teacher) {
                Session::find($session->id)->teachers()->attach($teacher->id);
            }
        }


        $request->session()->put('session', $session);


        return redirect('/teachers/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session, Request $request)
    {
        $request->session()->put('session', $session);
        $session->load('teachers.modals');

        return view('sessions.show', ['session' => $session]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session $session)
    {
        $session->is_archive = true;
        $session->save();

        PHPSession::flash('success', 'votre session a bien été archivé');

        return Back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        $session->teachers()->detach();

        $session->delete();

        return Back();
    }

    public function sendEmails(Request $request)
    {

        $session = $request->session()->get('session');
        $user = User::findOrFail($session->user_id);

        $session->load('teachers');



        foreach ($session->teachers as $teacher) {

            $teacher->pivot->token = Str::random(32);
            $teacher->pivot->save();

            $token = $teacher->pivot->token;

            dispatch(new SendEmailJob($session, $teacher, $user, $token))->delay(Carbon::now()->addSeconds(5));
        }

        PHPSession::flash('success', 'vos emails ont bien été envoyés');

        return redirect('/home');
    }


    public function fillModals(Request $request, $token)
    {
        $participations = DB::table('session_teacher')->where('token', $token)->get();

        $teacher = Teacher::findOrFail($participations[0]->teacher_id);
        $session = Session::findOrFail($participations[0]->session_id);
        $modals = Modal::where('teacher_id', $teacher->id)->get();

        $request->session()->put('session', $session);

        if ($request->from) {
            $lastModal = Modal::findOrFail($request->from);
            return view('sessions.fillModals', ['session' => $session, 'teacher' => $teacher, 'modals' => $modals, 'lastModal' => $lastModal]);
        }

        return view('sessions.fillModals', ['session' => $session, 'teacher' => $teacher, 'modals' => $modals, 'lastModal' => '']);
    }
}
