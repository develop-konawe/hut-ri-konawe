<?php

namespace App\Services;

use App\Models\ActivityLocation;
use App\Models\Competition;
use App\Models\IndependenceBanner;
use App\Models\IndependenceVideo;

final readonly class HomePageService
{
    public function __construct(private NewsService $newsService)
    {
    }

    public function getData(): array
    {
        return [
            'sportsNews' => $this->newsService->sports(['per_page' => 3]),
            'announcements' => $this->newsService->announcements(['per_page' => 3]),
            'locations' => ActivityLocation::query()->orderByRaw('CASE WHEN activity_at >= ? THEN 0 ELSE 1 END', [now()->startOfDay()])->orderBy('activity_at')->limit(6)->get(),
            'competitions' => Competition::query()->with('registrations')->orderByRaw('CASE WHEN starts_at >= ? THEN 0 ELSE 1 END', [now()->startOfDay()])->orderBy('starts_at')->limit(6)->get(),
            'banners' => IndependenceBanner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->latest()
                ->limit(5)
                ->get(),
            'videos' => IndependenceVideo::query()
                ->orderByDesc('is_featured')
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ];
    }
}
