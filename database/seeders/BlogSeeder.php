<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $blogs = [
            [
                'name' => 'Blog 1',
                'title' => 'Title 1',
                'content' => 'Content for Blog 1',
                'image' => 'https://via.placeholder.com/800x600.png?text=Image+1',
                'category_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blog 2',
                'title' => 'Title 2',
                'content' => 'Content for Blog 2',
                'image' => 'https://via.placeholder.com/800x600.png?text=Image+2',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blog 3',
                'title' => 'Title 3',
                'content' => 'Content for Blog 3',
                'image' => 'https://via.placeholder.com/800x600.png?text=Image+3',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blog 4',
                'title' => 'Title 4',
                'content' => 'Content for Blog 4',
                'image' => 'https://via.placeholder.com/800x600.png?text=Image+4',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blog 5',
                'title' => 'Title 5',
                'content' => 'Content for Blog 5',
                'image' => 'https://via.placeholder.com/800x600.png?text=Image+5',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blog 6',
                'title' => 'Title 6',
                'content' => 'Content for Blog 6',
                'image' => 'https://via.placeholder.com/800x600.png?text=Image+6',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blogs')->insert($blogs);
    }
}
