<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('rating')->insert([
            ['movies_id' => 1, 'review_text' => 'Amazing movie!', 'rating' => 9.5, 'users_id' => 1],
            ['movies_id' => 2, 'review_text' => 'Loved it!', 'rating' => 8.7, 'users_id' => 2],
        ]);
    }
}
