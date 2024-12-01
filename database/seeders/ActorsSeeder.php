<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActorsSeeder extends Seeder
{
    public function run()
    {
        DB::table('actors')->insert([
            ['first_name' => 'Leonardo', 'last_name' => 'DiCaprio', 'birth_date' => '1974-11-11', 'biography' => 'Famous actor known for Titanic.', 'photo' => 'dicaprio.jpg'],
            ['first_name' => 'Robert', 'last_name' => 'Downey Jr.', 'birth_date' => '1965-04-04', 'biography' => 'Iron Man actor.', 'photo' => 'downey.jpg'],
        ]);
    }
}
