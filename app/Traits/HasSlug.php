<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug(
                    $model,
                    $model->{$model->getSlugSourceColumn()}
                );
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSlugSourceColumn()) && empty($model->slug)) {
                $model->slug = static::generateUniqueSlug(
                    $model,
                    $model->{$model->getSlugSourceColumn()}
                );
            }
        });
    }

    protected static function generateUniqueSlug($model, string $value): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $count = 1;

        while (
            $model->newQuery()
                ->where('slug', $slug)
                ->when($model->exists, fn ($q) => $q->where('id', '!=', $model->id))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    abstract public function getSlugSourceColumn(): string;
}