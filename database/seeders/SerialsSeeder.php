<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SerialsSeeder extends Seeder
{
    public function run()
    {
        DB::table('serials')->insert([
            ['movies_id' => 1, 'quantity' => 10],
            ['movies_id' => 2, 'quantity' => 22],
        ]);
    }
}
