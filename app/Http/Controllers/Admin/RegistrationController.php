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
    public function __invoke(Request $request): View
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
}
