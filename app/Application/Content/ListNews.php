<?php

namespace App\Application\Content;

use App\Domain\Content\Contracts\NewsGateway;
use Illuminate\Support\Collection;

final readonly class ListNews
{
    public function __construct(private NewsGateway $newsGateway)
    {
    }

    public function sports(array $filters = []): Collection
    {
        return $this->newsGateway->berita($filters + [
            'category' => 'olahraga',
            'per_page' => 6,
        ]);
    }

    public function announcements(array $filters = []): Collection
    {
        return $this->newsGateway->pengumuman($filters + [
            'per_page' => 6,
        ]);
    }
}
