<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudiosSeeder extends Seeder
{
    public function run()
    {
        DB::table('studios')->insert([
            ['name' => 'Warner Bros'],
            ['name' => 'Disney'],
            ['name' => 'Universal'],
        ]);
    }
}
