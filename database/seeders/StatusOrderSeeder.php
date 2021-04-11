<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusOrder;

class StatusOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusOrder::create(['status'  => 'Entregado']);
        StatusOrder::create(['status'  => 'Pendiente']);
        StatusOrder::create(['status'  => 'Enviado']);
        StatusOrder::create(['status'  => 'En Proceso']);
    }
}
