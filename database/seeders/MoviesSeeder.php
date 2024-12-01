<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        DB::table('movies')->insert([
            [
                'title' => 'Inception',
                'release_year' => 2010,
                'duration' => 148,
                'description' => 'A mind-bending thriller by Christopher Nolan.',
                'photo' => 'inception.jpg',
                'studio_id' => 1,
                'age_rating_id' => 3,
            ],
            [
                'title' => 'Avengers: Endgame',
                'release_year' => 2019,
                'duration' => 181,
                'description' => 'The epic conclusion to the Marvel saga.',
                'photo' => 'endgame.jpg',
                'studio_id' => 2,
                'age_rating_id' => 3,
            ],
        ]);
    }
}
