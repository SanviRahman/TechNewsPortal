<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group_name',
        'autoload',
    ];

    protected function casts(): array
    {
        return [
            'autoload' => 'boolean',
        ];
    }

    public function getValueAttribute($value)
    {
        return match ($this->type) {
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }

    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = json_encode($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    public function scopeGroup($query, string $group)
    {
        return $query->where('group_name', $group);
    }

    public function scopeAutoload($query)
    {
        return $query->where('autoload', true);
    }
}