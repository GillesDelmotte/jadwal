<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacher;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $session->load('teachers');

        return view('teachers.create', ['session' => $session]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacher $request)
    {
        $session = $request->session()->get('session');
        //return $session;
        $newTeacher = Teacher::where('email', '=', $request->email)->first();

        if (!$newTeacher) {
            $newTeacher = new Teacher();
            $newTeacher->name = $request->name;
            $newTeacher->email = $request->email;
            $newTeacher->save();
        }

        $sessionFilter = $session->teachers->filter(function($teacher, $key) use ($newTeacher){
            return $teacher->email === $newTeacher->email;
        });


        if(!$sessionFilter->first()){
            Session::find($session->id)->teachers()->attach($newTeacher->id);
        }



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
    public function destroy(Request $request, $id)
    {
        $session = $request->session()->get('session');
        Session::find($session->id)->teachers()->detach($id);
        return back();
    }

    public function teachersAPI(){
        $teachers = Teacher::all();
        return $teachers;
    }

    public function storeTeacher(StoreTeacher $request){
        $session = $request->session()->get('session');
        //return $session;
        $newTeacher = Teacher::where('email', '=', $request->email)->first();


        if (!$newTeacher) {
            $newTeacher = new Teacher();
            $newTeacher->name = $request->name;
            $newTeacher->email = $request->email;
            $newTeacher->save();
            $newTeacher = Teacher::where('email', '=', $request->email)->first();
        }

        $sessionFilter = $session->teachers->filter(function($teacher, $key) use ($newTeacher){
            return $teacher->email === $newTeacher->email;
        });

        if(!$sessionFilter->first()){
            $lastInsertTeacher = Session::find($session->id)->teachers()->attach($newTeacher->id);
            $teachers = Teacher::all();
            return ['teachers' => $teachers, 'newTeacher' =>$newTeacher];

        }
        $teachers = Teacher::all();
        return ['teachers' => $teachers, 'newTeacher' => null];
    }
}
