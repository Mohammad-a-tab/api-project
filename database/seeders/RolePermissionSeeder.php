<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleSuperAdmin = Role::query()->where('name', 'super-admin')->first();

        $roleSuperAdmin?->givePermissionTo(
            // User
            'show user',
            'create user',
            'update user',
            'delete user',
            'show users',
        );
    }
}
