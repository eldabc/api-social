<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Oficina']);
        Role::create(['name' => 'Personal']);
    }
}
