<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('orders')->insert([
        [
            'code' => 'ORD123456',
            'user_id' => 1,
            'shipping_method' => 'Standard Shipping',
            'status' => 'Pending',
            'amount' => 200.00,
            'discount_amount' => 10.00,
            'shipping_amount' => 5.00,
            'description' => 'First order',
            'sub_total' => 205.00,
            'is_finished' => false,
            'completed_at' => null,
            'payment_id' => 1,
            'address' => 'Ha Noi',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
    }

}
