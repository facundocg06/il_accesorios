<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $sellerRole = Role::create(['name' => 'Vendedor']);
        $buyerRole = Role::create(['name' => 'Comprador']);

        // Crear un permiso para cada rol con el mismo nombre que el rol
        $adminPermission = Permission::create(['name' => 'Administrador']);
        $sellerPermission = Permission::create(['name' => 'Vendedor']);
        $buyerPermission = Permission::create(['name' => 'Comprador']);

        // Asignar permisos a los roles correspondientes
        $adminRole->givePermissionTo($adminPermission,$sellerPermission,$buyerPermission);
        $sellerRole->givePermissionTo($sellerPermission,$buyerPermission);
        $buyerRole->givePermissionTo($buyerPermission);
    }
}
