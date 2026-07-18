<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveStreaming extends Model
{
    protected $fillable = [
        'title',
        'youtube_url',
        'youtube_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->youtube_id = self::extractYoutubeId($model->youtube_url);
        });

        static::updating(function ($model) {
            if ($model->isDirty('youtube_url')) {
                $model->youtube_id = self::extractYoutubeId($model->youtube_url);
            }
        });
    }

    public static function extractYoutubeId($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match);
        return $match[1] ?? null;
    }
}
