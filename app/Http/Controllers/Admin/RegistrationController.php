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

        $user = auth()->user();
        if ($user->isOperator()) {
            $filters['competition_id'] = $user->competition_id ?? 0;
        }

        $registrations = Registration::query()
            ->with(['competition', 'performances'])
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

        $competitions = Competition::query()->orderBy('name');
        if ($user->isOperator()) {
            $competitions->where('id', $user->competition_id ?? 0);
        }

        return view('admin.registrations.index', [
            'competitions' => $competitions->get(['id', 'name']),
            'registrations' => $registrations,
            'statuses' => Registration::statuses(),
            'filters' => $filters,
        ]);
    }

    public function updateStatus(Request $request, Registration $registration): RedirectResponse|JsonResponse
    {
        $this->authorizeCompetition($registration);

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

    public function edit(Registration $registration): View
    {
        $this->authorizeCompetition($registration);

        $user = auth()->user();
        $competitions = Competition::query()->orderBy('name');
        if ($user->isOperator()) {
            $competitions->where('id', $user->competition_id ?? 0);
        }

        return view('admin.registrations.edit', [
            'registration' => $registration,
            'statuses' => Registration::statuses(),
            'competitions' => $competitions->get(['id', 'name']),
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
            'status' => ['required', Rule::in(array_keys(Registration::statuses()))],
        ]);

        $registration->update($validated);

        return redirect()->route('admin.registrations.index')->with('status', 'Data peserta lomba berhasil diperbarui.');
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $this->authorizeCompetition($registration);
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('status', 'Data peserta lomba berhasil dihapus.');
    }

    private function authorizeCompetition(Registration $registration): void
    {
        $user = auth()->user();
        if ($user->isOperator()) {
            abort_if($registration->competition_id !== $user->competition_id, 403, 'Anda tidak memiliki akses untuk mengubah data peserta di lomba ini.');
        }
    }
}
