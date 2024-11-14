<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'PC',
                'description' => 'Description for category 1',
                'order_total' => 10,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PP',
                'description' => 'Description for category 2',
                'order_total' => 20,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PET',
                'description' => 'Description for category 3',
                'order_total' => 30,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
