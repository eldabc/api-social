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
          'name'  => 'Admin Publiguarne',
          'phone'      => '12345678',
          'email'      => 'admin@publiguarne.com',
          'email_verified_at' => now(),
          'accept_terms' => true,
          'password'       => bcrypt('12345678'),
          'remember_token' => null,
      ])->syncRoles(['Administrador']);
    
      $client = User::create([
        'name'  => 'Oficina Virtual Publiguarne',
        'phone'      => '12345678',
        'email'      => 'oficina@publiguarne.com',
        'email_verified_at' => now(),
        'accept_terms' => true,
        'password'       => bcrypt('12345678'),
        'remember_token' => null,
      ])->assignRole('Oficina');

      $distribuitor = User::create([
        'name'  => 'Personal Publiguarne',
        'phone'      => '12345678',
        'email'      => 'personal@publiguarne.com',
        'email_verified_at' => now(),
        'accept_terms' => true,
        'password'       => bcrypt('12345678'),
        'remember_token' => null,
      ])->assignRole('Personal');


    }
}
