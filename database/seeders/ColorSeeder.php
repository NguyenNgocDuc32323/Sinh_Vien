<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('colors')->insert([
            [
                'name' => 'White',
                'ratio_price' => 1.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blue',
                'ratio_price' => 1.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green',
                'ratio_price' => 1.1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
