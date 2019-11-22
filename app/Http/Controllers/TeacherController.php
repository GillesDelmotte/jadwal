<?php

namespace App\Http\Controllers;

use App\SessionTeacher;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
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
        $session = $request->session()->get('session');

        $session->load('teachers.teacher');

        return view('teachers.create', ['session' => $session]);
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
            'name' => 'required',
            'email' => 'required'
        ]);

        if ($request->type === 'form') {
            $session = $request->session()->get('session');
            $newTeacher = Teacher::where('email', '=', $request->email)->first();

            if (!$newTeacher) {
                $newTeacher = new Teacher();
                $newTeacher->name = $request->name;
                $newTeacher->email = $request->email;
                $newTeacher->save();
            }

            $sessionTeacher = new SessionTeacher();
            $sessionTeacher->teacher_id = $newTeacher->id;
            $sessionTeacher->session_id = $session->id;
            $sessionTeacher->save();
        }

        if ($request->type === 'csv') { }


        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(SessionTeacher $sessionTeacher, $id)
    {
        $sessionTeacher = SessionTeacher::findorfail($id);
        $sessionTeacher->delete();
        return back();
    }
}
