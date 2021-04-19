<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $admin = User::create([
          'name'  => 'Admin Repsex',
          'phone'      => '12345678',
          'email'      => 'admin@repcex.com',
          'email_verified_at' => now(),
          'delivery_address'  => 'Address Test Admin',
          'city' => 'City Test',
          'total_transactions' => 0,
          'password'       => bcrypt('12345678'),
          'remember_token' => null,
      ])->syncRoles(['Administrador']);
    
      $client = User::create([
        'name'  => 'Client Repsex',
        'phone'      => '12345678',
        'email'      => 'client@repcex.com',
        'email_verified_at' => now(),
        'delivery_address'  => 'Address Test Client',
        'city' => 'City Test',
        'total_transactions' => 0,
        'password'       => bcrypt('12345678'),
        'remember_token' => null,
      ])->assignRole('Cliente');

      $distribuitor = User::create([
        'name'  => 'Distribuidor Repsex',
        'phone'      => '12345678',
        'email'      => 'distri@repcex.com',
        'email_verified_at' => now(),
        'delivery_address'  => 'Address Test Distribuidor',
        'city' => 'City Test',
        'total_transactions' => 0,
        'password'       => bcrypt('12345678'),
        'remember_token' => null,
      ])->assignRole('Distribuidor');
  

      $direct_sale = User::create([
        'name'  => 'Venta Directa',
        'phone'      => '12345678',
        'email'      => 'c_vt_repsex@info.com',
        'email_verified_at' => now(),
        'delivery_address'  => 'Address Cliente Venta Directa',
        'city' => 'City Venta Directa',
        'total_transactions' => 0,
        'password'       => bcrypt('12345678'),
        'remember_token' => null,
      ])->assignRole('Cliente');



    }
}
