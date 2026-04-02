<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::role('Super Admin')->first() ?? User::first();

        $categories = [
            [
                'name' => 'Programming',
                'description' => 'Programming tutorials, tips and best practices.',
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'name' => 'Laravel',
                'description' => 'Laravel framework related news and tutorials.',
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'name' => 'PHP',
                'description' => 'PHP language articles and backend development.',
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'name' => 'JavaScript',
                'description' => 'JavaScript ecosystem and frontend development.',
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'name' => 'Database',
                'description' => 'MySQL, query optimization, and database design.',
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}