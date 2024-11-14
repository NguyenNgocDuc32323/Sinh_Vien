<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'Nguyen Ngoc Duc',
                'email' => 'nguyenngocduc@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'avatar' => 'images/Dashboard/admin.png',
                'phone' => '0123456789',
                'address' => '123 Main Street, Los Angeles, CA 90012, United States',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'John Smith',
                'email' => 'john.smith@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'images/Admin/user.png',
                'phone' => '0987654321',
                'address' => '456 Elm Avenue, Brooklyn, NY 11201, United States',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Emily Johnson',
                'email' => 'emily.johnson@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'images/Admin/user.png',
                'phone' => '0123756789',
                'address' => '789 Oak Street, Houston, TX 77002, United States',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Michael Brown',
                'email' => 'michael.brown@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'images/Admin/user.png',
                'phone' => '0123856789',
                'address' => '101 Maple Drive, Chicago, IL 60611, United States',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Sophia Davis',
                'email' => 'sophia.davis@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'images/Admin/user.png',
                'phone' => '0124356789',
                'address' => '202 Pine Lane, Miami, FL 33130, United States',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
