<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Performance;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerformanceController extends Controller
{
    private function authorizeCompetition(Registration $registration): void
    {
        $user = auth()->user();
        if ($user->isOperator()) {
            abort_if($registration->competition_id !== $user->competition_id, 403, 'Anda tidak memiliki akses untuk mengubah data peserta di lomba ini.');
        }
    }

    public function store(Request $request, Registration $registration)
    {
        $this->authorizeCompetition($registration);

        $validated = $request->validate([
            'stage' => ['required', 'string', 'max:50'],
            'scheduled_at' => ['nullable', 'date'],
            'order_number' => ['nullable', 'integer', 'min:1'],
        ]);

        $registration->performances()->create([
            ...$validated,
            'status' => 'Menunggu Panggilan',
        ]);

        return redirect()->back()->with('status', 'Jadwal tampil berhasil ditambahkan.');
    }

    public function update(Request $request, Performance $performance)
    {
        $performance->load('registration');
        $this->authorizeCompetition($performance->registration);

        $validated = $request->validate([
            'stage' => ['required', 'string', 'max:50'],
            'scheduled_at' => ['nullable', 'date'],
            'order_number' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['Menunggu Panggilan', 'Sedang Tampil', 'Selesai'])],
        ]);

        $performance->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $performance->status]);
        }

        return redirect()->back()->with('status', 'Jadwal tampil berhasil diperbarui.');
    }

    public function destroy(Performance $performance)
    {
        $performance->load('registration');
        $this->authorizeCompetition($performance->registration);

        $performance->delete();

        return redirect()->back()->with('status', 'Jadwal tampil berhasil dihapus.');
    }
}
