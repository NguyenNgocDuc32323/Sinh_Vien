<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('contacts')->insert([
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'phone' => '1234567890',
                'title' => 'Support Request',
                'content' => 'I need assistance with my account.',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
