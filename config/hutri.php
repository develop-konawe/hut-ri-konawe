<?php

return [
    'news_api' => [
        'base_url' => env('KONAWE_NEWS_API_BASE_URL', 'https://berita.konawekab.go.id/api/v1'),
        'api_key' => env('KONAWE_NEWS_API_KEY', '418595a9a453178dbdc3ea13af01789324f967e9cd60069e624de8b92003a613'),
        'timeout' => (int) env('KONAWE_NEWS_API_TIMEOUT', 8),
    ],
];
