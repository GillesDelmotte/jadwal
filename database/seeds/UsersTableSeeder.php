<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Gilles Delmotte',
            'email' => 'gilles.delmotte@outlook.be',
            'password' => Hash::make('azerty'),
        ]);
    }
}
