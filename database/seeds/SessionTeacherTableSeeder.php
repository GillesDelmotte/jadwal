<?php

use App\Session;
use App\SessionTeacher;
use Illuminate\Database\Seeder;

class SessionTeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Session::find(1)->teachers()->attach(1);
        Session::find(2)->teachers()->attach(1);
        Session::find(1)->teachers()->attach(2);
        Session::find(2)->teachers()->attach(2);
    }
}
