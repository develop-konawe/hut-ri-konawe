<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndependenceBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        return view('admin.banners.index', [
            'banners' => IndependenceBanner::query()
                ->orderBy('sort_order')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.banners.form', [
            'banner' => new IndependenceBanner([
                'media_type' => 'image',
                'is_active' => true,
                'sort_order' => 0,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        IndependenceBanner::query()->create($this->validated($request));

        return to_route('admin.banners.index')->with('status', 'Banner berhasil dibuat.');
    }

    public function show(IndependenceBanner $banner): RedirectResponse
    {
        return to_route('admin.banners.edit', $banner);
    }

    public function edit(IndependenceBanner $banner): View
    {
        return view('admin.banners.form', compact('banner'));
    }

    public function update(Request $request, IndependenceBanner $banner): RedirectResponse
    {
        $banner->update($this->validated($request));

        return to_route('admin.banners.index')->with('status', 'Banner berhasil diperbarui.');
    }

    public function destroy(IndependenceBanner $banner): RedirectResponse
    {
        $banner->delete();

        return to_route('admin.banners.index')->with('status', 'Banner berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'media_url' => ['required', 'url', 'max:2048'],
            'media_type' => ['required', 'in:image,video'],
            'description' => ['nullable', 'string'],
            'link_url' => ['nullable', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['title'] = filled($data['title'] ?? null) ? $data['title'] : null;

        return $data;
    }
}
