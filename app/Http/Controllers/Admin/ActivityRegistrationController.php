<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLocation;
use App\Models\ActivityRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActivityRegistrationController extends Controller
{
    public function index(ActivityLocation $location): View
    {
        $registrations = $location->registrations()->latest('submitted_at')->paginate(20);
        return view('admin.activity_registrations.index', compact('location', 'registrations'));
    }

    public function updateStatus(Request $request, ActivityRegistration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:verified,rejected'],
        ]);

        $registration->update(['status' => $validated['status']]);

        return back()->with('status', 'Status pendaftar berhasil diperbarui.');
    }

    public function destroy(ActivityRegistration $registration): RedirectResponse
    {
        $registration->delete();
        return back()->with('status', 'Pendaftar berhasil dihapus.');
    }
}
