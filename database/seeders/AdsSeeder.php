<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Dữ liệu mẫu cho bảng ads
    $ads = [
        [
            'name' => 'Premium PET Bottles',
            'description' => 'Clear & Lightweight',
            'expired_at' => now()->addDays(30), // Expire 30 days from now
            'image' => 'images/Dashboard/collection_1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Eco-Friendly PET',
            'description' => 'Sustainable Choice',
            'expired_at' => now()->addDays(60), // Expire 60 days from now
            'image' => 'images/Dashboard/collection_2.webp',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Durable PC Bottles',
            'description' => 'Heat Resistant',
            'expired_at' => now()->addDays(30), // Expire 30 days from now
            'image' => 'images/Dashboard/collection_3.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'High-Quality PC',
            'description' => 'Long Lasting',
            'expired_at' => now()->addDays(60), // Expire 60 days from now
            'image' => 'images/Dashboard/collection_4.webp',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Flexible PP Bottles',
            'description' => 'BPA Free',
            'expired_at' => now()->addDays(30), // Expire 30 days from now
            'image' => 'images/Dashboard/collection_5.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Affordable PP',
            'description' => 'Safe & Reusable',
            'expired_at' => now()->addDays(60), // Expire 60 days from now
            'image' => 'images/Dashboard/collection_7.webp',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    // Insert dữ liệu vào bảng ads
    DB::table('ads')->insert($ads);
}


}
