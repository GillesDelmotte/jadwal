<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\sendFirstEmail;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

            $lastSession->load('teachers.teacher');

            foreach ($lastSession->teachers as $teacher) {
                $sessionTeacher = new SessionTeacher();
                $sessionTeacher->session_id = $session->id;
                $sessionTeacher->teacher_id = $teacher->teacher_id;
                $sessionTeacher->save();
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


        $session->load('teachers.teacher.modals');
        $request->session()->put('session', $session);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }

    public function sendEmails(Request $request)
    {

        $session = $request->session()->get('session');
        $user = User::findOrFail($session->user_id);

        foreach ($session->teachers as $teacher) {
            $updateTeacher = $teacher->teacher;

            $updateTeacher->token = time() . '$' . $session->id;
            $updateTeacher->save();

            dispatch(new SendEmailJob($session, $updateTeacher, $user))->delay(Carbon::now()->addSeconds(5));
        }

        return redirect('/home');
    }


    public function fillModals(Request $request, $token)
    {
        $tokenParts = explode('$', $token);
        $session_id = $tokenParts[count($tokenParts) - 1];
        $teacher = Teacher::where('token', '=', $token)->firstOrFail();
        $session = Session::findOrFail($session_id);

        $request->session()->put('session', $session);

        return view('sessions.fillModals', ['session' => $session, 'teacher' => $teacher]);
    }
}
