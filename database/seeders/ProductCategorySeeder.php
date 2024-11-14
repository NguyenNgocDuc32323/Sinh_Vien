<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [1, 2, 3];
        $products = range(1, 15);
    $inserts = [];

    foreach ($categories as $category) {
        $assignedProducts = array_slice($products, 0, 5);
        foreach ($assignedProducts as $product) {
            $inserts[] = [
                'product_id' => $product,
                'category_id' => $category,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            }
                $products = array_slice($products, 5);
                }
            DB::table('product_category')->insert($inserts);
            }
    }
