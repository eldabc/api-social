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
        $role = Role::create(['name' => 'Administrador']);
        $permission = Permission::create(['name' => 'Create']);
        $permission = Permission::create(['name' => 'Edit']);
        $permission = Permission::create(['name' => 'Read']);
        $permission = Permission::create(['name' => 'Delete']);

        $role->syncPermissions(1,2);
        $role = Role::create(['name' => 'Cliente']);
        $role = Role::create(['name' => 'Distribuidor']);
    }
}
