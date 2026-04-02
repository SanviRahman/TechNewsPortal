<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.manage',
            'permissions.manage',
            'posts.view',
            'posts.create',
            'posts.edit.own',
            'posts.edit.any',
            'posts.delete.own',
            'posts.delete.any',
            'posts.submit',
            'posts.review',
            'posts.approve',
            'posts.publish',
            'posts.unpublish',
            'categories.manage',
            'tags.manage',
            'comments.create',
            'comments.moderate',
            'comments.delete',
            'settings.manage',
            'posts.like',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $editor = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);
        $author = Role::firstOrCreate(['name' => 'Author', 'guard_name' => 'web']);
        $reader = Role::firstOrCreate(['name' => 'Reader', 'guard_name' => 'web']);

        $superAdmin->givePermissionTo(Permission::all());

        $editor->givePermissionTo([
            'posts.view',
            'posts.edit.any',
            'posts.review',
            'posts.approve',
            'posts.publish',
            'categories.manage',
            'tags.manage',
            'comments.moderate',
            'comments.delete',
        ]);

        $author->givePermissionTo([
            'posts.view',
            'posts.create',
            'posts.edit.own',
            'posts.delete.own',
            'posts.submit',
        ]);

        $reader->givePermissionTo([
            'posts.like',
            'comments.create',
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'status' => 'active',
            ]
        );

        $adminUser->assignRole('Super Admin');

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}