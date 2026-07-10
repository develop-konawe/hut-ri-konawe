<?php

namespace App\Repositories;

use App\Data\NewsItem;
use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;

final class KonaweNewsRepository implements NewsRepositoryInterface
{
    public function __construct(private readonly HttpFactory $http)
    {
    }

    public function berita(array $filters = []): Collection
    {
        return $this->fetch('/berita', $filters);
    }

    public function pengumuman(array $filters = []): Collection
    {
        return $this->fetch('/pengumuman', $filters);
    }

    private function fetch(string $endpoint, array $filters): Collection
    {
        $query = array_filter([
            'api_key' => config('hutri.news_api.api_key'),
            'page' => $filters['page'] ?? 1,
            'per_page' => $filters['per_page'] ?? 10,
            'category' => $filters['category'] ?? null,
            'opd' => $filters['opd'] ?? null,
            'search' => $filters['search'] ?? null,
        ], static fn ($value) => filled($value));

        try {
            $response = $this->http
                ->baseUrl(config('hutri.news_api.base_url'))
                ->timeout(config('hutri.news_api.timeout'))
                ->acceptJson()
                ->get($endpoint, $query);

            if (! $response->successful()) {
                return collect();
            }

            return $this->normalize($response->json());
        } catch (Throwable) {
            return collect();
        }
    }

    private function normalize(array $payload): Collection
    {
        $items = data_get($payload, 'data.data', data_get($payload, 'data', $payload));

        if (! is_array($items)) {
            return collect();
        }

        return collect($items)
            ->filter(fn ($item) => is_array($item))
            ->map(fn (array $item) => new NewsItem(
                title: (string) data_get($item, 'judul', data_get($item, 'title', 'Tanpa Judul')),
                excerpt: Str::limit(strip_tags((string) data_get($item, 'ringkasan', data_get($item, 'excerpt', data_get($item, 'konten', data_get($item, 'content', ''))))), 180),
                publishedAt: data_get($item, 'tanggal_publish', data_get($item, 'published_at', data_get($item, 'created_at'))),
                category: data_get($item, 'kategori.slug', data_get($item, 'category.slug', data_get($item, 'category'))),
                source: data_get($item, 'opd.nama', data_get($item, 'opd.name', data_get($item, 'source'))),
                imageUrl: data_get($item, 'gambar', data_get($item, 'image_url', data_get($item, 'thumbnail'))),
                url: data_get($item, 'url', data_get($item, 'link')),
            ));
    }
}
