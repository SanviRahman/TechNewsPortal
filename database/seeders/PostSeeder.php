<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author     = User::role('Author')->first() ?? User::first();
        $editor     = User::role('Editor')->first() ?? User::first();
        $categories = Category::all();
        $tags       = Tag::all();

        if (! $author || $categories->isEmpty()) {
            return;
        }

        $posts = [
            [
                'title'       => 'Getting Started with Laravel Service Pattern',
                'excerpt'     => 'Learn how to structure business logic using service classes in Laravel.',
                'body'        => 'Laravel service pattern helps keep controllers thin and business logic reusable. You can create dedicated service classes for posts, comments, settings and more.',
                'status'      => 'published',
                'is_featured' => true,
            ],
            [
                'title'       => 'Mastering RBAC in Laravel with Spatie Permission',
                'excerpt'     => 'Implement robust role and permission management in Laravel applications.',
                'body'        => 'Spatie permission package is one of the most popular RBAC solutions in Laravel. It supports roles, permissions, middleware integration and caching.',
                'status'      => 'published',
                'is_featured' => true,
            ],
            [
                'title'       => 'How to Optimize MySQL Queries for Blog Portals',
                'excerpt'     => 'Practical tips to improve query performance in a real-world Laravel blog portal.',
                'body'        => 'Add indexing, avoid N+1 issues, use eager loading, and paginate large datasets. These are key ways to optimize MySQL queries in Laravel.',
                'status'      => 'published',
                'is_featured' => false,
            ],
            [
                'title'       => 'Building Reusable Traits in Laravel',
                'excerpt'     => 'Traits can help you reuse upload logic, slug generation and API responses.',
                'body'        => 'Common examples of reusable traits include HasSlug, UploadsFiles, and ApiResponse. They reduce duplication and improve maintainability.',
                'status'      => 'pending_review',
                'is_featured' => false,
            ],
            [
                'title'       => 'Blade Tips for Clean Frontend Development',
                'excerpt'     => 'Useful Blade techniques for building maintainable Laravel frontend pages.',
                'body'        => 'Use components, layouts, stacks, slots and includes to create modular Blade templates for frontend and admin panels.',
                'status'      => 'draft',
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $item) {
            $post = Post::updateOrCreate(
                ['title' => $item['title']],
                [
                    'user_id'          => $author->id,
                    'editor_id'        => in_array($item['status'], ['approved', 'published']) ? $editor?->id : null,
                    'category_id'      => $categories->random()->id,

                    'title'            => $item['title'],
                    'slug'             => Str::slug($item['title']), // ✅ FIX

                    'excerpt'          => $item['excerpt'],
                    'body'             => $item['body'],
                    'status'           => $item['status'],

                    'submitted_at'     => in_array($item['status'], ['pending_review', 'approved', 'published']) ? now() : null,
                    'approved_at'      => in_array($item['status'], ['approved', 'published']) ? now() : null,
                    'published_at'     => $item['status'] === 'published' ? now()->subDays(rand(1, 30)) : null,

                    'meta_title'       => $item['title'],
                    'meta_description' => Str::limit($item['excerpt'], 160),

                    'views_count'      => rand(50, 500),
                    'is_featured'      => $item['is_featured'],
                ]
            );

            if ($tags->isNotEmpty()) {
                $post->tags()->sync(
                    $tags->random(min(3, $tags->count()))
                        ->pluck('id')
                        ->toArray()
                );
            }
        }
    }
}
