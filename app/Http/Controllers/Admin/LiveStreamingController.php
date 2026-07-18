<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveStreaming;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LiveStreamingController extends Controller
{
    public function index(): View
    {
        return view('admin.live_streamings.index', [
            'liveStreamings' => LiveStreaming::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.live_streamings.form', [
            'liveStreaming' => new LiveStreaming(['is_active' => true]),
            'eventOptions' => $this->getEventOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        LiveStreaming::query()->create($this->validated($request));

        return to_route('admin.live_streamings.index')->with('status', 'Live Streaming berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return to_route('admin.live_streamings.edit', $id);
    }

    public function edit(LiveStreaming $liveStreaming): View
    {
        return view('admin.live_streamings.form', [
            'liveStreaming' => $liveStreaming,
            'eventOptions' => $this->getEventOptions(),
        ]);
    }

    public function update(Request $request, LiveStreaming $liveStreaming): RedirectResponse
    {
        $liveStreaming->update($this->validated($request, $liveStreaming));

        return to_route('admin.live_streamings.index')->with('status', 'Live Streaming berhasil diperbarui.');
    }

    public function destroy(LiveStreaming $liveStreaming): RedirectResponse
    {
        $liveStreaming->delete();

        return to_route('admin.live_streamings.index')->with('status', 'Live Streaming berhasil dihapus.');
    }

    private function validated(Request $request, ?LiveStreaming $liveStreaming = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => ['required', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function getEventOptions()
    {
        $competitions = \App\Models\Competition::query()->orderBy('name')->pluck('name');
        $activities = \App\Models\ActivityLocation::query()->orderBy('name')->pluck('name');
        
        return $competitions->concat($activities)->unique()->sort()->values();
    }
}
