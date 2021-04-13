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
        $admin = Role::create(['name' => 'Administrador']);
        $client = Role::create(['name' => 'Cliente']);
        $distri = Role::create(['name' => 'Distribuidor']);

        // Permission::create(['name' => 'list-distri-client']);
        Permission::create(['name' => 'detail-distri-client'])->syncRoles([$admin, $client]);
        // $permission = Permission::create(['name' => 'Create']);
        // $permission = Permission::create(['name' => 'Edit']);
        // $permission = Permission::create(['name' => 'Read']);
        // $permission = Permission::create(['name' => 'Delete']);

        // $admin->syncPermissions(1,2);
        
    }
}
