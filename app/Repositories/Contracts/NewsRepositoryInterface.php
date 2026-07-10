<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface NewsRepositoryInterface
{
    public function berita(array $filters = []): Collection;

    public function pengumuman(array $filters = []): Collection;
}
