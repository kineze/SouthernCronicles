<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        $permissions = [
            'Manage Users',
            'Access Admin Dashboard',
            'Manage Festivals',
            'Manage Partners',
            'Manage Events',
            'Manage Teams',
            'Manage Bookings',
            'Manage News',
            'Manage Careers',
            'Manage Partner Inquiries',
            'Manage Advisors',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }
    }
}
