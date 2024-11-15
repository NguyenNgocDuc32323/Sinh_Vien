<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'password' => Hash::make('password'),
            'role' => 'admin',
            'name' => 'Nguyễn Ngọc Đức',
            'email' => 'nguyenngocduc@gmail.com',
            'avatar' => 'images/Dashboard/student.webp',
            'phone' => '0123456789',
            'address' => '123 Main Street, Los Angeles, CA 90012, United States',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'name' => 'Đỗ Khắc Hưng',
            'email' => 'dokhachung@gmail.com',
            'avatar' => 'images/Dashboard/teacher.webp',
            'phone' => '0987654321',
            'address' => '456 Elm Street, Los Angeles, CA 90012, United States',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create([
            'password' => Hash::make('password'),
            'role' => 'student',
            'name' => 'Nguyễn Quang Trung',
            'email' => 'nguyenquangtrung@gmail.com',
            'avatar' => 'images/Dashboard/admin.png',
            'phone' => '0123456789',
            'address' => '789 Oak Street, Los Angeles, CA 90012, United States',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
