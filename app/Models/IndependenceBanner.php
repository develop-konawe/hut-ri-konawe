<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IndependenceBanner extends Model
{
    protected $fillable = [
        'title',
        'media_url',
        'media_type',
        'description',
        'link_url',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function isVideo(): bool
    {
        return $this->media_type === 'video';
    }

    protected function playableMediaUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => self::normalizeMediaUrl($this->media_url));
    }

    protected function drivePreviewUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => self::googleDrivePreviewUrl($this->media_url));
    }

    protected function driveFileId(): Attribute
    {
        return Attribute::get(fn (): ?string => self::googleDriveFileId($this->media_url));
    }

    public static function normalizeMediaUrl(?string $url): ?string
    {
        if (! $url) {
            return $url;
        }

        $fileId = self::googleDriveFileId($url);

        if ($fileId) {
            return 'https://drive.google.com/uc?export=download&id='.$fileId;
        }

        return $url;
    }

    public static function googleDrivePreviewUrl(?string $url): ?string
    {
        $fileId = self::googleDriveFileId($url);

        return $fileId ? 'https://drive.google.com/file/d/'.$fileId.'/preview' : null;
    }

    public static function googleDriveFileId(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $parts = parse_url($url);
        $host = Str::of($parts['host'] ?? '')->lower()->replace('www.', '')->toString();

        if ($host !== 'drive.google.com') {
            return null;
        }

        parse_str($parts['query'] ?? '', $query);
        $fileId = $query['id'] ?? null;
        $path = trim($parts['path'] ?? '', '/');

        if (! $fileId && preg_match('#^file/d/([^/]+)#', $path, $matches)) {
            $fileId = $matches[1];
        }

        return $fileId;
    }
}
