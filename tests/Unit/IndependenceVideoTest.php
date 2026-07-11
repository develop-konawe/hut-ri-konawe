<?php

namespace Tests\Unit;

use App\Models\IndependenceVideo;
use PHPUnit\Framework\TestCase;

class IndependenceVideoTest extends TestCase
{
    public function test_youtube_urls_are_normalized_to_embed_urls(): void
    {
        $this->assertSame(
            'https://www.youtube.com/embed/abc123',
            IndependenceVideo::normalizeEmbedUrl('https://www.youtube.com/watch?v=abc123')
        );

        $this->assertSame(
            'https://www.youtube.com/embed/abc123',
            IndependenceVideo::normalizeEmbedUrl('https://youtu.be/abc123')
        );

        $this->assertSame(
            'https://www.youtube.com/embed/abc123',
            IndependenceVideo::normalizeEmbedUrl('https://www.youtube.com/shorts/abc123')
        );
    }
}
