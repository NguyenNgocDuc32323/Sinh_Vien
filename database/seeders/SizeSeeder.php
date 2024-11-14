<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('sizes')->insert([
            [
                'name' => 'S',
                'ratio_price' => 0.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'M',
                'ratio_price' => 1.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'L',
                'ratio_price' => 1.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
