<?php

namespace Tests\Feature;

use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_news_gateway_sends_required_api_key_and_normalizes_sports_news(): void
    {
        Http::fake([
            'berita.konawekab.go.id/api/v1/berita*' => Http::response([
                'data' => [
                    'data' => [
                        [
                            'judul' => 'Turnamen Sepak Bola HUT RI Dibuka',
                            'konten' => '<p>Berita olahraga Kabupaten Konawe.</p>',
                            'kategori' => ['slug' => 'olahraga'],
                            'opd' => ['nama' => 'Dinas Pemuda dan Olahraga'],
                            'tanggal_publish' => '2026-08-01',
                        ],
                    ],
                ],
            ]),
        ]);

        $items = app(NewsRepositoryInterface::class)->berita(['category' => 'olahraga']);

        $this->assertCount(1, $items);
        $this->assertSame('Turnamen Sepak Bola HUT RI Dibuka', $items->first()->title);
        $this->assertSame('Dinas Pemuda dan Olahraga', $items->first()->source);

        Http::assertSent(fn ($request) => Str::startsWith($request->url(), 'https://berita.konawekab.go.id/api/v1/berita')
            && $request['api_key'] === config('hutri.news_api.api_key')
            && $request['category'] === 'olahraga');
    }
}
