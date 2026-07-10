<?php

namespace App\Services;

use App\Models\ActivityLocation;
use App\Models\Competition;
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
            'competitions' => Competition::query()->where('is_open', true)->orderBy('starts_at')->limit(4)->get(),
            'locations' => ActivityLocation::query()->orderBy('activity_at')->limit(6)->get(),
            'videos' => IndependenceVideo::query()->latest('published_at')->limit(3)->get(),
        ];
    }
}
