<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('contact_replies')->insert([
            [
                'contact_id' => 1,
                'message' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
