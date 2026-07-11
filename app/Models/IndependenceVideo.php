<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    protected function embedUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => self::normalizeEmbedUrl($value),
            set: fn (?string $value) => self::normalizeEmbedUrl($value),
        );
    }

    public static function normalizeEmbedUrl(?string $url): ?string
    {
        if (! $url) {
            return $url;
        }

        $parts = parse_url($url);
        $host = Str::of($parts['host'] ?? '')->lower()->replace('www.', '')->toString();
        $path = trim($parts['path'] ?? '', '/');

        if (in_array($host, ['youtube.com', 'm.youtube.com', 'music.youtube.com'], true)) {
            if (Str::startsWith($path, 'embed/')) {
                return $url;
            }

            parse_str($parts['query'] ?? '', $query);
            $videoId = $query['v'] ?? null;

            if (! $videoId && Str::startsWith($path, 'shorts/')) {
                $videoId = Str::after($path, 'shorts/');
            }

            if (! $videoId && Str::startsWith($path, 'live/')) {
                $videoId = Str::after($path, 'live/');
            }

            return $videoId ? 'https://www.youtube.com/embed/'.Str::before($videoId, '?') : $url;
        }

        if ($host === 'youtu.be') {
            $videoId = Str::before($path, '?');

            return $videoId ? 'https://www.youtube.com/embed/'.$videoId : $url;
        }

        return $url;
    }
}
