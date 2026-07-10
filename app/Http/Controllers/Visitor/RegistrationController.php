<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Services\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class RegistrationController extends Controller
{
    public function create(?Competition $competition = null): View
    {
        return view('visitor.registration', [
            'competition' => $competition,
            'competitions' => Competition::query()->where('is_open', true)->orderBy('starts_at')->get(),
        ]);
    }

    public function store(Request $request, RegistrationService $registrationService): RedirectResponse
    {
        $validated = $request->validate([
            'competition_id' => ['required', 'exists:competitions,id'],
            'participant_name' => ['required', 'string', 'max:255'],
            'identity_number' => ['nullable', 'string', 'max:64'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $competition = Competition::query()->findOrFail($validated['competition_id']);
        unset($validated['competition_id']);

        try {
            $registrationService->register($competition, $validated);
        } catch (RuntimeException $exception) {
            return back()->withInput()->withErrors(['competition_id' => $exception->getMessage()]);
        }

        return to_route('visitor.registration.create')
            ->with('status', 'Pendaftaran berhasil dikirim. Panitia akan menghubungi kontak peserta.');
    }
}
