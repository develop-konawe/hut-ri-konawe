<?php

namespace App\Application\Portal;

use App\Application\Content\ListNews;
use App\Models\ActivityLocation;
use App\Models\Competition;
use App\Models\IndependenceVideo;

final readonly class GetVisitorHomeData
{
    public function __construct(private ListNews $listNews)
    {
    }

    public function handle(): array
    {
        return [
            'sportsNews' => $this->listNews->sports(['per_page' => 3]),
            'announcements' => $this->listNews->announcements(['per_page' => 3]),
            'competitions' => Competition::query()->where('is_open', true)->orderBy('starts_at')->limit(4)->get(),
            'locations' => ActivityLocation::query()->orderBy('activity_at')->limit(6)->get(),
            'videos' => IndependenceVideo::query()->latest('published_at')->limit(3)->get(),
        ];
    }
}
