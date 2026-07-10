<?php

namespace App\Http\Controllers\Visitor;

use App\Application\Portal\GetVisitorHomeData;
use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use App\Models\Competition;
use App\Models\IndependenceVideo;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(GetVisitorHomeData $homeData): View
    {
        return view('visitor.home', $homeData->handle());
    }

    public function competitions(): View
    {
        return view('visitor.competitions', [
            'competitions' => Competition::query()->where('is_open', true)->orderBy('starts_at')->get(),
        ]);
    }

    public function locations(): View
    {
        return view('visitor.locations', [
            'locations' => ActivityLocation::query()->orderBy('activity_at')->get(),
        ]);
    }

    public function videos(): View
    {
        return view('visitor.videos', [
            'videos' => IndependenceVideo::query()->latest('published_at')->get(),
        ]);
    }
}
