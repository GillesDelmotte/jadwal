<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {

        if ($request->type === 'form') {

            $request->validate([
                'name' => 'required',
                'email' => 'required'
            ]);

            $session = $request->session()->get('session');
            $newTeacher = Teacher::where('email', '=', $request->email)->first();

            if (!$newTeacher) {
                $newTeacher = new Teacher();
                $newTeacher->name = $request->name;
                $newTeacher->email = $request->email;
                $newTeacher->save();
            }

            Session::find($session->id)->teachers()->attach($newTeacher->id);
        }

        if ($request->type === 'csv') {

            $session = $request->session()->get('session');

            $toto = fopen($request->file, 'r');

            $row = 1;
            $arr = [];

            while (($data = fgetcsv($toto, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $arr[] = $data[$c];
                }
            }
            fclose($toto);

            $objects = [];
            $keys = [];
            for ($i = 0; $i < count($arr); $i++) {
                $val = explode(";", $arr[$i]);
                if ($i == 0) {
                    for ($j = 0; $j < count($val); $j++) {
                        $keys[] = strtolower($val[$j]);
                    }
                } else {
                    $objects[] = [];
                    for ($j = 0; $j < count($val); $j++) {
                        $objects[$i - 1][$keys[$j]] = $val[$j];
                    }
                }
            }


            foreach ($objects as $object) {
                $newTeacher = Teacher::where('email', '=', $object['email'])->first();

                if (!$newTeacher) {
                    $newTeacher = new Teacher();
                    $newTeacher->name = $object['nom'];
                    $newTeacher->email = $object['email'];
                    $newTeacher->save();
                }

                Session::find($session->id)->teachers()->attach($newTeacher->id);
            }
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
}
