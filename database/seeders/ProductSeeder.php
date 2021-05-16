<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create([
            "name" => 'Product Test',
            "price" => 10,
            "description" => "Description test",
            "phone" => 1234567,
            "phone_ws" => 12345678,
            "user_id" => 1
        ]);

        $product_1 = Product::create([
            "name" => 'Product Test 1',
            "price" => 20,
            "description" => "Description test",
            "phone" => 1234567,
            "phone_ws" => 12345678,
            "user_id" => 2
        ]);


        $product_2 = Product::create([
            "name" => 'Product Test 2',
            "price" => 30,
            "description" => "Description test",
            "phone" => 1234567,
            "phone_ws" => 12345678,
            "user_id" => 2
        ]);

    }
}
