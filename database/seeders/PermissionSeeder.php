<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // User permissions
        Permission::query()->updateOrCreate(['name' => 'show user']);
        Permission::query()->updateOrCreate(['name' => 'create user']);
        Permission::query()->updateOrCreate(['name' => 'update user']);
        Permission::query()->updateOrCreate(['name' => 'delete user']);
        Permission::query()->updateOrCreate(['name' => 'show users']);
    }
}
