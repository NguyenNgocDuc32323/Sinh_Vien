<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $insertData = [
        // Reviews for product 1
        [
            'product_id' => 1,
            'user_id' => 1,
            'stars' => 4.5,
            'comment' => 'Great product! Highly recommend.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 1,
            'user_id' => 2,
            'stars' => 3.0,
            'comment' => 'It’s okay, but could be better.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 2
        [
            'product_id' => 2,
            'user_id' => 1,
            'stars' => 3.5,
            'comment' => 'Average product.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 2,
            'user_id' => 2,
            'stars' => 4.0,
            'comment' => 'Good quality.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 3
        [
            'product_id' => 3,
            'user_id' => 3,
            'stars' => 5.0,
            'comment' => 'Exceeded my expectations!',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 3,
            'user_id' => 4,
            'stars' => 4.0,
            'comment' => 'Good value for the price.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 4
        [
            'product_id' => 4,
            'user_id' => 4,
            'stars' => 4.0,
            'comment' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 4,
            'user_id' => 5,
            'stars' => 2.5,
            'comment' => 'Not as expected.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 5
        [
            'product_id' => 5,
            'user_id' => 5,
            'stars' => 4.5,
            'comment' => 'Excellent!',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 5,
            'user_id' => 1,
            'stars' => 3.5,
            'comment' => 'Decent product.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Add similar blocks for products 6 to 15
        // Reviews for product 6
        [
            'product_id' => 6,
            'user_id' => 1,
            'stars' => 4.0,
            'comment' => 'Satisfied with the purchase.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 6,
            'user_id' => 2,
            'stars' => 3.0,
            'comment' => 'Average experience.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 7
        [
            'product_id' => 7,
            'user_id' => 3,
            'stars' => 5.0,
            'comment' => 'Highly recommend!',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 7,
            'user_id' => 4,
            'stars' => 4.0,
            'comment' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 8
        [
            'product_id' => 8,
            'user_id' => 5,
            'stars' => 4.5,
            'comment' => 'Very good product.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 8,
            'user_id' => 1,
            'stars' => 3.5,
            'comment' => 'Could be better.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 9
        [
            'product_id' => 9,
            'user_id' => 2,
            'stars' => 4.0,
            'comment' => 'Happy with the product.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 9,
            'user_id' => 3,
            'stars' => 5.0,
            'comment' => 'Amazing!',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 10
        [
            'product_id' => 10,
            'user_id' => 4,
            'stars' => 3.0,
            'comment' => 'It’s okay.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 10,
            'user_id' => 5,
            'stars' => 2.5,
            'comment' => 'Could be improved.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 11
        [
            'product_id' => 11,
            'user_id' => 1,
            'stars' => 4.0,
            'comment' => 'Worth the price.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 11,
            'user_id' => 2,
            'stars' => 3.5,
            'comment' => 'Satisfactory.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 12
        [
            'product_id' => 12,
            'user_id' => 3,
            'stars' => 5.0,
            'comment' => 'Fantastic product!',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 12,
            'user_id' => 4,
            'stars' => 4.5,
            'comment' => 'Very good quality.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 13
        [
            'product_id' => 13,
            'user_id' => 5,
            'stars' => 3.0,
            'comment' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 13,
            'user_id' => 1,
            'stars' => 2.5,
            'comment' => 'Not satisfied.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 14
        [
            'product_id' => 14,
            'user_id' => 2,
            'stars' => 4.0,
            'comment' => 'Good product overall.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 14,
            'user_id' => 3,
            'stars' => 5.0,
            'comment' => 'Best purchase ever!',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Reviews for product 15
        [
            'product_id' => 15,
            'user_id' => 4,
            'stars' => 4.5,
            'comment' => 'Very satisfied.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'product_id' => 15,
            'user_id' => 5,
            'stars' => 3.0,
            'comment' => 'Average product.',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    // Insert reviews into the table
    DB::table('reviews')->insert($insertData);
}


}
