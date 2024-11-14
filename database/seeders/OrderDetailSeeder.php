<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('order_details')->insert([
        [
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
            'price' => 99.99,
            'product_name' => 'Product 1',
            'product_image' => 'https://idea7.co.uk/wp-content/uploads/2021/02/placeholder-250x250-1.png',
            'color' => 'White',
            'size' => 'M',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
    ]);
    }

}
