<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);

        Permission::create(['name' => 'Manage Users']);
        Permission::create(['name' => 'Access Admin Dashboard']);
        
        $admin->givePermissionTo('Access Admin Dashboard');
        $admin->givePermissionTo('Manage Users');

    }
}

