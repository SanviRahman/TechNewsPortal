<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Laravel',
            'PHP',
            'MySQL',
            'JavaScript',
            'Blade',
            'Bootstrap',
            'CSS',
            'HTML',
            'API',
            'Web Development',
            'Backend',
            'Frontend',
            'Authentication',
            'RBAC',
            'Optimization',
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                ['name' => $tag],
                ['name' => $tag]
            );
        }
    }
}