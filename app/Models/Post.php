<?php

namespace App\Models;

use App\Models\PostLike;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'user_id',
        'editor_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'status',
        'review_notes',
        'published_at',
        'approved_at',
        'submitted_at',
        'meta_title',
        'meta_description',
        'views_count',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'approved_at' => 'datetime',
            'submitted_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopePendingReview($query)
    {
        return $query->where('status', 'pending_review');
    }

    public function getSlugSourceColumn(): string
    {
        return 'title';
    }
}