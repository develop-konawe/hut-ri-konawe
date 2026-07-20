<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.competitions.index', [
            'competitions' => Competition::query()->withCount('registrations')->latest('starts_at')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.competitions.form', [
            'competition' => new Competition(['is_open' => true]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Competition::query()->create($this->validated($request));

        return to_route('admin.competitions.index')->with('status', 'Jadwal lomba berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('admin.competitions.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competition $competition): View
    {
        return view('admin.competitions.form', compact('competition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competition $competition): RedirectResponse
    {
        $competition->update($this->validated($request, $competition));

        return to_route('admin.competitions.index')->with('status', 'Jadwal lomba berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competition $competition): RedirectResponse
    {
        $competition->delete();

        return to_route('admin.competitions.index')->with('status', 'Jadwal lomba berhasil dihapus.');
    }

    private function validated(Request $request, ?Competition $competition = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:olahraga,seni,umum'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'registration_deadline' => ['nullable', 'date'],
            'venue' => ['required', 'string', 'max:255'],
            'quota' => ['nullable', 'integer', 'min:1'],
            'is_open' => ['nullable', 'boolean'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $data['slug'] = $competition?->slug ?: Str::slug($data['name']).'-'.Str::lower(Str::random(5));
        $data['is_open'] = $request->boolean('is_open');
        
        $data['starts_at'] = $data['event_date'] . ' ' . $data['start_time'] . ':00';
        $data['ends_at'] = !empty($data['end_time']) ? $data['event_date'] . ' ' . $data['end_time'] . ':00' : null;

        unset($data['event_date'], $data['start_time'], $data['end_time']);

        return $data;
    }
}
