<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use App\Models\Competition;
use App\Models\IndependenceVideo;
use App\Models\LiveStreaming;
use App\Services\HomePageService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(HomePageService $homePageService): View
    {
        return view('visitor.home', $homePageService->getData());
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

    public function liveStreamings(): View
    {
        return view('visitor.live_streamings', [
            'liveStreamings' => LiveStreaming::query()->where('is_active', true)->latest()->get(),
        ]);
    }

    public function livePerformances(): \Illuminate\Http\JsonResponse
    {
        $performing = \App\Models\Registration::query()
            ->with('competition:id,name')
            ->where('status', 'verified')
            ->where('is_published', true)
            ->where('performance_status', 'Sedang Tampil')
            ->get(['id', 'competition_id', 'participant_name', 'institution', 'stage']);

        return response()->json($performing);
    }
}
