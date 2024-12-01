<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['code' => 'admin', 'name' => 'Administrator'],
            ['code' => 'user', 'name' => 'User'],
            ['code' => 'moderator', 'name' => 'Moderator'],
        ]);
    }
}
