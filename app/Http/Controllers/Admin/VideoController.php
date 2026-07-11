<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndependenceVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        return view('admin.videos.index', [
            'videos' => IndependenceVideo::query()
                ->orderByDesc('is_featured')
                ->latest('published_at')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.videos.form', [
            'video' => new IndependenceVideo([
                'provider' => 'youtube',
                'published_at' => now(),
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $video = IndependenceVideo::query()->create($this->validated($request));
        $this->syncFeaturedVideo($video);

        return to_route('admin.videos.index')->with('status', 'Video kemerdekaan berhasil dibuat.');
    }

    public function show(IndependenceVideo $video): RedirectResponse
    {
        return to_route('admin.videos.edit', $video);
    }

    public function edit(IndependenceVideo $video): View
    {
        return view('admin.videos.form', compact('video'));
    }

    public function update(Request $request, IndependenceVideo $video): RedirectResponse
    {
        $video->update($this->validated($request));
        $this->syncFeaturedVideo($video);

        return to_route('admin.videos.index')->with('status', 'Video kemerdekaan berhasil diperbarui.');
    }

    public function destroy(IndependenceVideo $video): RedirectResponse
    {
        $video->delete();

        return to_route('admin.videos.index')->with('status', 'Video kemerdekaan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'provider' => ['required', 'string', 'max:50'],
            'embed_url' => ['required', 'url', 'max:255'],
            'thumbnail_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function syncFeaturedVideo(IndependenceVideo $video): void
    {
        if (! $video->is_featured) {
            return;
        }

        IndependenceVideo::query()
            ->whereKeyNot($video->getKey())
            ->update(['is_featured' => false]);
    }
}
