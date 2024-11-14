<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Slider::create([
            'name' => 'Trường Đại học Kiến trúc Đà Nẵng',
            'images' => 'images/Dashboard/banner.jpg',
            'description' => 'Trường Đại học Kiến trúc Đà Nẵng, nơi đào tạo kiến thức, kỹ năng và định hướng tương lai cho sinh viên.'
        ]);

        Slider::create([
            'name' => 'Trường Đại học Kiến trúc Đà Nẵng',
            'images' => 'images/Dashboard/banner_2.jpg',
            'description' => 'Môi trường học tập năng động, sáng tạo và hiện đại tại Đại học Kiến trúc Đà Nẵng.'
        ]);

        Slider::create([
            'name' => 'Trường Đại học Kiến trúc Đà Nẵng',
            'images' => 'images/Dashboard/banner_3.jpg',
            'description' => 'Những giảng viên giàu kinh nghiệm và tâm huyết tại Đại học Kiến trúc Đà Nẵng.'
        ]);

        Slider::create([
            'name' => 'Trường Đại học Kiến trúc Đà Nẵng',
            'images' => 'images/Dashboard/banner_4.png',
            'description' => 'Trường Đại học Kiến trúc Đà Nẵng - Định hướng tương lai vững vàng cho các kiến trúc sư tương lai.'
        ]);
    }
}
