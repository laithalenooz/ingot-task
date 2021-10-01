<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
                'name'     => 'Admin',
                'email'    => 'admin@ingot.com',
                'image'    => 'user.png',
                'password' => bcrypt('password'),
                'phone'    => '00962777777777',
                'birthdate'=> '1999-11-11',
                'role'     => 1
        ]);

        DB::table('users')->insert([
            'name'     => 'User',
            'email'    => 'user@ingot.com',
            'image'    => 'user.png',
            'password' => bcrypt('password'),
            'phone'    => '00962777777777',
            'birthdate'=> '1999-11-11'
        ]);
    }
}
