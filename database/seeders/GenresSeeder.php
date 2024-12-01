<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresSeeder extends Seeder
{
    public function run()
    {
        DB::table('genres')->insert([
            ['name' => 'Action'],
            ['name' => 'Drama'],
            ['name' => 'Comedy'],
            ['name' => 'Horror'],
        ]);
    }
}
