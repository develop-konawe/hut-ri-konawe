<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use App\Models\Competition;
use App\Models\IndependenceVideo;
use App\Models\LiveStreaming;
use App\Services\HomePageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(HomePageService $homePageService): View
    {
        return view('visitor.home', $homePageService->getData());
    }

    public function competitions(Request $request): View
    {
        $search = $request->input('search');
        
        $competitions = Competition::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderByRaw('CASE WHEN starts_at >= ? THEN 0 ELSE 1 END', [now()->startOfDay()])
            ->orderBy('starts_at')
            ->paginate(12)
            ->withQueryString();

        return view('visitor.competitions', [
            'competitions' => $competitions,
            'search' => $search,
        ]);
    }

    public function locations(Request $request): View
    {
        $search = $request->input('search');
        
        $locations = ActivityLocation::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderByRaw('CASE WHEN activity_at >= ? THEN 0 ELSE 1 END', [now()->startOfDay()])
            ->orderBy('activity_at')
            ->get();

        return view('visitor.locations', [
            'locations' => $locations,
            'search' => $search,
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
            ->with(['competition:id,name', 'performances' => function ($query) {
                $query->where('status', 'Sedang Tampil');
            }])
            ->where('status', 'verified')
            ->whereHas('performances', function ($query) {
                $query->where('status', 'Sedang Tampil');
            })
            ->get(['id', 'competition_id', 'participant_name', 'institution']);

        $performing->transform(function ($registration) {
            $performance = $registration->performances->first();
            $registration->stage = $performance ? $performance->stage : '';
            return $registration;
        });

        return response()->json($performing);
    }
}
