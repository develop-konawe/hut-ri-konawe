<?php

namespace App\Domain\Content\Contracts;

use Illuminate\Support\Collection;

interface NewsGateway
{
    public function berita(array $filters = []): Collection;

    public function pengumuman(array $filters = []): Collection;
}
