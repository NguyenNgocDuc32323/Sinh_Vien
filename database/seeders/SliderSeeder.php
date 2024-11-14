<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('sliders')->insert([
            [
                'name' => 'Summer Sale',
                'images' => 'images/Dashboard/slide_1.webp',
                'description' => 'Big discounts for summer season!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'New Arrivals',
                'images' => 'images/Dashboard/slide_2.webp',
                'description' => 'Explore our latest products.',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
