<?php

use App\SessionTeacher;
use Illuminate\Database\Seeder;

class SessionTeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SessionTeacher::create([
            'session_id' => 1,
            'teacher_id' => 1
        ]);

        SessionTeacher::create([
            'session_id' => 2,
            'teacher_id' => 1
        ]);

        SessionTeacher::create([
            'session_id' => 1,
            'teacher_id' => 2
        ]);

        SessionTeacher::create([
            'session_id' => 2,
            'teacher_id' => 2
        ]);
    }
}
