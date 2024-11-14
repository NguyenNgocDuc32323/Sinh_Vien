<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('labels')->insert([
            [
                'name' => 'Hot',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'New',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
