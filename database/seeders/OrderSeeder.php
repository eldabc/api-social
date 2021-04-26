<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order_distri = Order::create([
            'city'  => 'City Test Distribuidor',
            'delivery_address'  => 'Delibery Address Distribuidor',
            'name'  => 'Nombre Distribuidor',
            'phone'  => '55555555',
            'email'  => 'c_repsex@info.com',
            'total_order'  => 100,
            'status_id'  => 2,
            'user_id'  => 3,
            'distr_id'  => null,
        ]);

            OrderDetails::create([
                'price'  => 1000,
                'quantity'  => 100,
                'plan_id'  => 1,
                'order_id'  => $order_distri->id,
            ]);
            OrderDetails::create([
                'price'  => 2000,
                'quantity'  => 200,
                'plan_id'  => 2,
                'order_id'  => $order_distri->id,
            ]);

        $order_client = Order::create([
            'city'  => 'City Test Cliente',
            'delivery_address'  => 'Delibery Address Cliente',
            'name'  => 'Nombre Cliente',
            'phone'  => '55555555',
            'email'  => 'c_repsex@info.com',
            'total_order'  => 200,
            'status_id'  => 2,
            'user_id'  => 2,
            'distr_id'  => 2,
        ]);

            OrderDetails::create([
                'price'  => 3000,
                'quantity'  => 300,
                'plan_id'  => 1,
                'order_id'  => $order_client->id,
            ]);
            OrderDetails::create([
                'price'  => 2000,
                'quantity'  => 200,
                'plan_id'  => 2,
                'order_id'  => $order_client->id,
            ]);
    }
}
