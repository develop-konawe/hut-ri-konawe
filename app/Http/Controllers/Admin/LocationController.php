<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.locations.index', [
            'locations' => ActivityLocation::query()->latest('activity_at')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.locations.form', [
            'location' => new ActivityLocation(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        ActivityLocation::query()->create($this->validated($request));

        return to_route('admin.locations.index')->with('status', 'Lokasi kegiatan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('admin.locations.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityLocation $location): View
    {
        return view('admin.locations.form', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityLocation $location): RedirectResponse
    {
        $location->update($this->validated($request));

        return to_route('admin.locations.index')->with('status', 'Lokasi kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLocation $location): RedirectResponse
    {
        $location->delete();

        return to_route('admin.locations.index')->with('status', 'Lokasi kegiatan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:seni,olahraga,upacara,umum'],
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'activity_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
