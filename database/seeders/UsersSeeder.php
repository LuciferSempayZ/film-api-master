<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'roles_id' => 1,
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'avatar' => null,
                'gender' => 'male',
            ],
            [
                'roles_id' => 2,
                'username' => 'user1',
                'email' => 'user1@example.com',
                'password' => Hash::make('password'),
                'avatar' => null,
                'gender' => 'female',
            ],
        ]);
    }
}
