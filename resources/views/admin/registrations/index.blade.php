@extends('layouts.admin')

@section('title', 'Peserta & Pendaftar Lomba')
@section('heading', 'Peserta & Pendaftar Lomba')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Lihat dan filter peserta yang sudah mengirim formulir pendaftaran lomba.</p>
    <a class="bg-white text-primary px-5 py-3 rounded-full font-bold shadow border border-primary/10" href="{{ route('admin.registrations.index') }}">Reset Filter</a>
</div>

<form method="GET" action="{{ route('admin.registrations.index') }}" class="glass-panel rounded-[2rem] p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label class="font-bold text-sm" for="search">Pencarian</label>
            <input id="search" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama, telepon, email, instansi, atau NIK" class="mt-2 w-full rounded-xl border-surface-variant bg-white/80">
        </div>
        <div>
            <label class="font-bold text-sm" for="competition_id">Lomba</label>
            <select id="competition_id" name="competition_id" class="mt-2 w-full rounded-xl border-surface-variant bg-white/80">
                <option value="">Semua lomba</option>
                @foreach ($competitions as $competition)
                    <option value="{{ $competition->id }}" @selected(($filters['competition_id'] ?? '') == $competition->id)>{{ $competition->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="font-bold text-sm" for="status">Status</label>
            <select id="status" name="status" class="mt-2 w-full rounded-xl border-surface-variant bg-white/80">
                <option value="">Semua status</option>
                @foreach ($statuses as $status => $label)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-5 flex justify-end">
        <button class="bg-primary-container text-white px-6 py-3 rounded-full font-bold shadow" type="submit">Terapkan Filter</button>
    </div>
</form>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3 pr-4">Peserta</th>
            <th class="py-3 pr-4">Lomba</th>
            <th class="py-3 pr-4">Kontak</th>
            <th class="py-3 pr-4">Babak</th>
            <th class="py-3 pr-4 min-w-[200px]">Status & Tampil</th>
            <th class="py-3 pr-4 min-w-[200px]">Status Panggilan</th>
            <th class="py-3 pr-4">Tanggal Daftar</th>
            <th class="py-3">Aksi</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @forelse ($registrations as $registration)
            <tr class="align-top">
                <td class="py-4 pr-4">
                    <p class="font-semibold">{{ $registration->participant_name }}</p>
                    @if ($registration->identity_number)
                        <p class="text-sm text-on-surface-variant mt-1">NIK: {{ $registration->identity_number }}</p>
                    @endif
                </td>
                <td class="py-4 pr-4">
                    <a class="font-semibold text-primary" href="{{ route('admin.registrations.index', ['competition_id' => $registration->competition_id]) }}">
                        {{ $registration->competition?->name ?? '-' }}
                    </a>
                </td>
                <td class="py-4 pr-4">
                    <p>{{ $registration->phone }}</p>
                    @if ($registration->email)
                        <p class="text-sm text-on-surface-variant mt-1">{{ $registration->email }}</p>
                    @endif
                </td>
                <td class="py-4 pr-4">
                    {{ $registration->stage ?? '-' }}
                </td>
                <td class="py-4 pr-4 min-w-56">
                    <form method="POST" action="{{ route('admin.registrations.status', $registration) }}" class="space-y-1 mb-2" data-status-form>
                        @csrf
                        @method('PATCH')
                        <select name="status" data-current-status="{{ $registration->status }}" class="w-full rounded-xl border-surface-variant bg-white/80 text-sm font-semibold">
                            @foreach ($statuses as $status => $label)
                                <option value="{{ $status }}" @selected($registration->status === $status)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-on-surface-variant min-h-4" data-status-feedback></p>
                    </form>
                    <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full {{ $registration->is_published ? 'bg-green-100 text-green-700' : 'bg-surface-variant text-on-surface-variant' }}">
                        <span class="material-symbols-outlined text-[14px]">{{ $registration->is_published ? 'visibility' : 'visibility_off' }}</span>
                        {{ $registration->is_published ? 'Publik' : 'Disembunyikan' }}
                    </span>
                </td>
                <td class="py-4 pr-4 min-w-56">
                    <form method="POST" action="{{ route('admin.registrations.performance_status', $registration) }}" class="space-y-1" data-status-form>
                        @csrf
                        @method('PATCH')
                        <select name="performance_status" data-current-status="{{ $registration->performance_status }}" class="w-full rounded-xl border-surface-variant bg-white/80 text-sm font-semibold {{ $registration->performance_status === 'Sedang Tampil' ? 'bg-primary-container text-primary' : ($registration->performance_status === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-surface-variant text-on-surface-variant') }}">
                            @foreach (\App\Models\Registration::performanceStatuses() as $pStatus)
                                <option value="{{ $pStatus }}" @selected($registration->performance_status === $pStatus)>{{ $pStatus }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-on-surface-variant min-h-4" data-status-feedback></p>
                    </form>
                </td>
                <td class="py-4 pr-4 whitespace-nowrap">{{ $registration->submitted_at?->format('d/m/Y H:i') }}</td>
                <td class="py-4 whitespace-nowrap">
                    <a class="inline-flex items-center justify-center bg-secondary-container text-secondary h-9 w-9 rounded-full hover:bg-primary hover:text-white transition-colors" title="Edit Peserta" href="{{ route('admin.registrations.edit', $registration) }}">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="py-8 text-center text-on-surface-variant">Belum ada pendaftar sesuai filter.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-6">{{ $registrations->links() }}</div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-status-form]').forEach((form) => {
                const select = form.querySelector('select');
                const feedback = form.querySelector('[data-status-feedback]');

                select.addEventListener('change', async () => {
                    const previousStatus = select.dataset.currentStatus;
                    const formData = new FormData(form);

                    select.disabled = true;
                    feedback.textContent = 'Menyimpan...';
                    feedback.className = 'text-xs text-on-surface-variant min-h-4';

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        });

                        if (! response.ok) {
                            throw new Error('Gagal menyimpan status.');
                        }

                        const result = await response.json();
                        select.dataset.currentStatus = result.status || result.performance_status;
                        feedback.textContent = 'Tersimpan';
                        feedback.className = 'text-xs text-green-700 min-h-4 font-semibold';
                        
                        // Update color if performance status
                        if(select.name === 'performance_status') {
                            select.className = "w-full rounded-xl border-surface-variant text-sm font-semibold " + 
                                (select.value === 'Sedang Tampil' ? 'bg-primary-container text-primary' : 
                                (select.value === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-surface-variant text-on-surface-variant'));
                        }
                    } catch (error) {
                        select.value = previousStatus;
                        feedback.textContent = 'Gagal menyimpan';
                        feedback.className = 'text-xs text-primary min-h-4 font-semibold';
                    } finally {
                        select.disabled = false;
                    }
                });
            });
        });
    </script>
@endpush
