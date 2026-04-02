<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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

        $superAdminRole = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $editorRole = Role::firstOrCreate([
            'name' => 'Editor',
            'guard_name' => 'web',
        ]);

        $authorRole = Role::firstOrCreate([
            'name' => 'Author',
            'guard_name' => 'web',
        ]);

        $readerRole = Role::firstOrCreate([
            'name' => 'Reader',
            'guard_name' => 'web',
        ]);

        $superAdminRole->syncPermissions(Permission::all());

        $editorRole->syncPermissions([
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

        $authorRole->syncPermissions([
            'posts.view',
            'posts.create',
            'posts.edit.own',
            'posts.delete.own',
            'posts.submit',
        ]);

        $readerRole->syncPermissions([
            'posts.like',
            'comments.create',
        ]);

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('Super Admin');

        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'username' => 'editor',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $editor->assignRole('Editor');

        $author = User::firstOrCreate(
            ['email' => 'author@example.com'],
            [
                'name' => 'Author User',
                'username' => 'author',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $author->assignRole('Author');

        $reader = User::firstOrCreate(
            ['email' => 'reader@example.com'],
            [
                'name' => 'Reader User',
                'username' => 'reader',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $reader->assignRole('Reader');

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}