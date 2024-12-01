<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesSeeder extends Seeder
{
    public function run()
    {
        DB::table('favorites')->insert([
            ['users_id' => 1, 'movies_id' => 1],
            ['users_id' => 2, 'movies_id' => 2],
        ]);
    }
}
