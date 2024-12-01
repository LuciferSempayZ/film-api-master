<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgeRatingSeeder extends Seeder
{
    public function run()
    {
        DB::table('age_rating')->insert([
            ['age' => 6],
            ['age' => 12],
            ['age' => 16],
            ['age' => 18],
        ]);
    }
}
