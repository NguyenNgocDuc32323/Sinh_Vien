<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'user_id' => 1,
                'order_id' => 1,
                'code' => 'TRANS2024001',
                'amount' => 100.00,
                'payment_method' => 'Credit Card',
                'status' => 'Pending',
                'description' => 'First transaction',
                'admin_check' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
