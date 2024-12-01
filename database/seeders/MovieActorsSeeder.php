<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieActorsSeeder extends Seeder
{
    public function run()
    {
        DB::table('movie_actors')->insert([
            ['movie_id' => 1, 'actor_id' => 1],
            ['movie_id' => 2, 'actor_id' => 2],
        ]);
    }
}
