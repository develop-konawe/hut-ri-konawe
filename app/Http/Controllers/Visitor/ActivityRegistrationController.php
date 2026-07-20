<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use App\Models\ActivityRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityRegistrationController extends Controller
{
    public function create(ActivityLocation $location): View
    {
        if (!$location->is_registration_open) {
            abort(404, 'Pendaftaran untuk kegiatan ini tidak dibuka.');
        }

        if ($location->registration_deadline && now()->isAfter($location->registration_deadline)) {
            abort(404, 'Pendaftaran untuk kegiatan ini telah ditutup.');
        }

        return view('visitor.activity_registrations.create', compact('location'));
    }

    public function store(Request $request, ActivityLocation $location): RedirectResponse
    {
        if (!$location->is_registration_open || ($location->registration_deadline && now()->isAfter($location->registration_deadline))) {
            return back()->withErrors(['error' => 'Mohon maaf, pendaftaran untuk kegiatan ini sudah tidak tersedia.']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'captcha' => ['required', 'captcha'],
        ], [
            'captcha.required' => 'Kode keamanan wajib diisi.',
            'captcha.captcha' => 'Kode keamanan tidak sesuai.',
        ]);

        $location->registrations()->create(array_merge($validated, [
            'status' => ActivityRegistration::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]));

        return to_route('visitor.activity_registration.success')->with('status', 'Pendaftaran kehadiran Anda berhasil dikirim.');
    }

    public function success(): View
    {
        return view('visitor.activity_registrations.success');
    }
}
