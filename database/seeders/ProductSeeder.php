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
            "presentation" => 10,
            "stock" => 100,
            "img" => 'product.png',
            "status" => 1,
        ]);
        
        Plan::create([
            "price" => 6000,
            "quantity" => 100,
            "product_id" => $product->id,
        ]);

        $product_1 = Product::create([
            "name" => 'Product Test 1',
            "presentation" => 20,
            "stock" => 200,
            "img" => 'product_1.png',
            "status" => 1,
        ]);

        Plan::create([
            "price" => 7000,
            "quantity" => 200,
            "product_id" => $product_1->id,
        ]);

        $product_2 = Product::create([
            "name" => 'Product Test 2',
            "presentation" => 30,
            "stock" => 300,
            "img" => 'product_2.png',
            "status" => 1,
        ]);

        Plan::create([
            "price" => 8000,
            "quantity" => 300,
            "product_id" => $product_2->id,
        ]);
    }
}
