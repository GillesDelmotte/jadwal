<?php

use App\Teacher;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::create([
            'name' => 'Dominique Vilain',
            'email' => 'dominique.vilain@outlook.be'
        ]);
        Teacher::create([
            'name' => 'Myriam Dupond',
            'email' => 'myriam.dupond@outlook.be'
        ]);
    }
}
