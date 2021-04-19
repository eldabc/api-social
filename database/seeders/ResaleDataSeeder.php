<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResaleData;

class ResaleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResaleData::create([
            'stock' => 100,
            'shipping_value' => 100,
            'delivery_time' => 1,
            'status' => 2,
            'unitary_price' => 100,
            'product_id' => 1,
            'user_id' => 3,
        ]);

        ResaleData::create([
            'stock' => 200,
            'shipping_value' => 200,
            'delivery_time' => 1,
            'status' => 2,
            'unitary_price' => 200,
            'product_id' => 2,
            'user_id' => 3,
        ]);
    }
}
