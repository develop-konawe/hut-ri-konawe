<?php

namespace App\Domain\Content\Data;

final readonly class NewsItem
{
    public function __construct(
        public string $title,
        public string $excerpt,
        public ?string $publishedAt,
        public ?string $category,
        public ?string $source,
        public ?string $imageUrl,
        public ?string $url,
    ) {
    }
}
