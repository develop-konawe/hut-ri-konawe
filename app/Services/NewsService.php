<?php

namespace App\Services;

use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Support\Collection;

final readonly class NewsService
{
    public function __construct(private NewsRepositoryInterface $newsRepository)
    {
    }

    public function sports(array $filters = []): Collection
    {
        return $this->newsRepository->berita($filters + [
            'category' => 'olahraga',
            'per_page' => 6,
        ]);
    }

    public function announcements(array $filters = []): Collection
    {
        return $this->newsRepository->pengumuman($filters + [
            'per_page' => 6,
        ]);
    }
}
