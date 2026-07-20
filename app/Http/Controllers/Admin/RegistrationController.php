<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'competition_id' => ['nullable', 'integer', 'exists:competitions,id'],
            'status' => ['nullable', Rule::in(array_keys(Registration::statuses()))],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $registrations = Registration::query()
            ->with('competition')
            ->when($filters['competition_id'] ?? null, fn ($query, $competitionId) => $query->where('competition_id', $competitionId))
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['search'] ?? null, function ($query, $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('participant_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('institution', 'like', "%{$search}%")
                        ->orWhere('identity_number', 'like', "%{$search}%");
                });
            })
            ->latest('submitted_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.registrations.index', [
            'competitions' => Competition::query()->orderBy('name')->get(['id', 'name']),
            'registrations' => $registrations,
            'statuses' => Registration::statuses(),
            'filters' => $filters,
        ]);
    }

    public function updateStatus(Request $request, Registration $registration): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Registration::statuses()))],
        ]);

        $registration->update([
            'status' => $validated['status'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Status pendaftar berhasil diperbarui.',
                'status' => $registration->status,
                'label' => $registration->statusLabel(),
            ]);
        }

        return back()->with('status', 'Status pendaftar berhasil diperbarui.');
    }

    public function updatePerformanceStatus(Request $request, Registration $registration): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'performance_status' => ['required', Rule::in(Registration::performanceStatuses())],
        ]);

        $registration->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'performance_status' => $registration->performance_status,
                'message' => 'Status panggilan berhasil diperbarui',
            ]);
        }

        return back()->with('status', 'Status panggilan berhasil diperbarui.');
    }

    public function edit(Registration $registration): View
    {
        return view('admin.registrations.edit', [
            'registration' => $registration,
            'statuses' => Registration::statuses(),
            'competitions' => Competition::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Registration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'competition_id' => ['required', 'integer', 'exists:competitions,id'],
            'participant_name' => ['required', 'string', 'max:255'],
            'identity_number' => ['nullable', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(array_keys(Registration::statuses()))],
            'stage' => ['nullable', Rule::in(Registration::stages())],
            'is_published' => ['boolean'],
            'performance_status' => ['required', Rule::in(Registration::performanceStatuses())],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        $registration->update($validated);

        return redirect()->route('admin.registrations.index')->with('status', 'Data peserta lomba berhasil diperbarui.');
    }
}
