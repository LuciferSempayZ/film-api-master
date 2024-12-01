<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieGenresSeeder extends Seeder
{
    public function run()
    {
        DB::table('movie_genres')->insert([
            ['movie_id' => 1, 'genre_id' => 1],
            ['movie_id' => 2, 'genre_id' => 2],
        ]);
    }
}
