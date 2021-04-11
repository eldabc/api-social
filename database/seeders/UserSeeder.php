<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $user = User::create([
          'name'  => 'Admin Repsex',
          'phone'      => '12345678',
          'email'      => 'repsex@info.com',
          'email_verified_at' => now(),
          'delivery_address'  => 'Address Test',
          'city' => 'City Test',
          'total_purchase' => '100',
          'total_sale'     => '200',
          'password'       => bcrypt('12345678'),
          'remember_token' => null,
      ]);

      $user->assignRole(1);


    }
}
