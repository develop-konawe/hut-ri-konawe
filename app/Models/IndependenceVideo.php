<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndependenceVideo extends Model
{
    protected $fillable = [
        'title',
        'provider',
        'embed_url',
        'thumbnail_url',
        'description',
        'is_featured',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'date',
        ];
    }
}
