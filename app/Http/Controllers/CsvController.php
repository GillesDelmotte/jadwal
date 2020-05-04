<?php

namespace App\Http\Controllers;

use App\Session;
use App\Teacher;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function store(Request $request)
    {
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
                $newTeacher = Teacher::where('email', '=', $object['email'])->first();
            }

            $sessionFilter = $session->teachers->filter(function($teacher, $key) use ($newTeacher){
                return $teacher->email === $newTeacher->email;
            });
            if(!$sessionFilter->first()){
                Session::find($session->id)->teachers()->attach($newTeacher->id);
            }
        }

        return back();
    }
    public function index(){
        var_dump('ok'); die();
    }
}
