<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'collector.list', 'collector.create', 'collector.update', 'collector.delete',
            'delivery-company.list', 'delivery-company.create', 'delivery-company.update', 'delivery-company.delete',
            'storage.list', 'storage.view', 'storage.create', 'storage.update', 'storage.delete',
            'unit.list', 'unit.view', 'unit.create', 'unit.update', 'unit.delete',
            'package.list', 'package.view', 'package.create', 'package.update', 'package.delete',
        ];

        $roleWithPermissions = [
            ['name' => 'super-admin', 'rolePermissions' => $permissions],
            ['name' => 'admin', 'rolePermissions' => $permissions],
            ['name' => 'developer', 'rolePermissions' => $permissions],
            [
                'name' => 'user',
                'rolePermissions' => [
                    'collector.list', 'collector.create',
                    'delivery-company.list', 'delivery-company.create',
                    'storage.list',
                    'unit.list',
                    'package.list', 'package.view', 'package.create', 'package.update',
                ],
            ],
        ];

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Schema::disableForeignKeyConstraints();
        $permissionsData = collect($permissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        $permissionsData->each(function ($permission) {
            Permission::updateOrCreate($permission);
        });

        collect($roleWithPermissions)->each(function ($roleWithPermission) {
            $role = Role::firstOrCreate(['name' => $roleWithPermission['name']]);
            $role->syncPermissions($roleWithPermission['rolePermissions']);
        });
    }
}
