<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('payments')->insert([
            [
                'payment_method' => 'Credit Card',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'payment_method' => 'Pay on Delivery',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'payment_method' => 'Banking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
