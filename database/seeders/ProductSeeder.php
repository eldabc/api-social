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
            "presentation" => 60,
            "stock" => 200,
            "img" => 'product.png',
            "status" => 1,
            "shipping_value" => '',
            "delivery_time" => '',
        ]);
        
        Plan::create([
            "price" => 6000,
            "quantity" => 100,
            "product_id" => $product->id,
        ]);

        Plan::create([
            "price" => 7000,
            "quantity" => 200,
            "product_id" => $product->id,
        ]);
    }
}
