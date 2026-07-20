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
            <th class="py-3 pr-4">Babak & Penampilan</th>
            <th class="py-3 pr-4 min-w-[200px]">Status Registrasi</th>
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
                    @if($registration->performances->isEmpty())
                        <div class="mb-2"><span class="text-xs italic text-on-surface-variant">Belum ada jadwal babak</span></div>
                    @else
                        @php $latest = $registration->performances->last(); @endphp
                        <div class="mb-2">
                            <p class="font-bold text-sm">{{ $latest->stage }} @if($latest->order_number)<span class="text-primary text-xs">(Urutan Tampil {{ $latest->order_number }})</span>@endif</p>
                            <p class="text-xs font-semibold {{ $latest->status === 'Sedang Tampil' ? 'text-primary' : ($latest->status === 'Selesai' ? 'text-green-600' : 'text-on-surface-variant') }}">{{ $latest->status }}</p>
                        </div>
                    @endif
                    <button type="button" onclick="openPerfModal('perf-modal-{{ $registration->id }}')" class="bg-secondary-container/50 text-secondary hover:bg-primary hover:text-white transition-colors px-3 py-1.5 rounded-full text-xs font-bold inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">tune</span> Kelola Jadwal
                    </button>
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

@foreach ($registrations as $registration)
<div id="perf-modal-{{ $registration->id }}" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center bg-on-surface/40 p-4 opacity-0 transition-opacity duration-300">
    <div class="glass-panel w-full max-w-3xl transform rounded-[2rem] bg-surface-container-lowest p-0 shadow-2xl scale-95 transition-transform duration-300 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-5 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-low">
             <h3 class="font-headline font-bold text-primary">Kelola Jadwal: {{ $registration->participant_name }}</h3>
             <button onclick="closePerfModal('perf-modal-{{ $registration->id }}')" type="button" class="text-on-surface-variant hover:text-primary transition-colors h-8 w-8 rounded-full flex items-center justify-center bg-white shadow-sm border border-outline-variant/30"><span class="material-symbols-outlined text-[20px]">close</span></button>
        </div>
        <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
            @if($registration->performances->isNotEmpty())
                <div class="space-y-4 mb-8">
                    <h4 class="font-bold text-sm text-on-surface-variant mb-2">Riwayat Jadwal</h4>
                    @foreach($registration->performances as $perf)
                        <div class="bg-surface-container-low p-4 rounded-xl border border-surface-variant/50 relative">
                            <form method="POST" action="{{ route('admin.performances.destroy', $perf) }}" onsubmit="return confirm('Hapus jadwal ini?')" class="absolute top-4 right-4">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:bg-red-50 h-8 w-8 rounded-full flex items-center justify-center transition-colors" title="Hapus"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                            </form>
                            <form method="POST" action="{{ route('admin.performances.update', $perf) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end pr-10" data-perf-form>
                                @csrf @method('PUT')
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Babak</label>
                                    <select name="stage" class="w-full rounded-xl border-surface-variant bg-white/80 px-3 py-2 text-sm font-semibold">
                                        @foreach (\App\Models\Registration::stages() as $stage)
                                            <option value="{{ $stage }}" @selected($perf->stage === $stage)>{{ $stage }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant mb-1">No. Urut</label>
                                    <input type="number" name="order_number" value="{{ $perf->order_number }}" placeholder="-" class="w-full rounded-xl border-surface-variant bg-white/80 px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Jadwal Tampil</label>
                                    <input type="datetime-local" name="scheduled_at" value="{{ $perf->scheduled_at?->format('Y-m-d\TH:i') }}" class="w-full rounded-xl border-surface-variant bg-white/80 px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Status Penampilan</label>
                                    <select name="status" class="w-full rounded-xl border-surface-variant bg-white/80 px-3 py-2 text-sm font-semibold {{ $perf->status === 'Sedang Tampil' ? 'text-primary border-primary' : ($perf->status === 'Selesai' ? 'text-green-700 bg-green-50' : 'text-on-surface-variant') }}">
                                        <option value="Menunggu Panggilan" @selected($perf->status === 'Menunggu Panggilan')>Menunggu Panggilan</option>
                                        <option value="Sedang Tampil" @selected($perf->status === 'Sedang Tampil')>Sedang Tampil</option>
                                        <option value="Selesai" @selected($perf->status === 'Selesai')>Selesai</option>
                                    </select>
                                </div>
                                <div class="md:col-span-4 mt-2">
                                    <p class="text-xs text-on-surface-variant min-h-[16px]" data-perf-feedback></p>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="bg-surface-container p-5 rounded-2xl border border-outline-variant/30">
                <h4 class="font-bold text-primary mb-4">Tambah Jadwal Baru</h4>
                <form method="POST" action="{{ route('admin.registrations.performances.store', $registration) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Babak <span class="text-primary">*</span></label>
                        <select name="stage" required class="w-full rounded-xl border-surface-variant bg-white/80 px-3 py-2 text-sm">
                            @foreach (\App\Models\Registration::stages() as $stage)
                                <option value="{{ $stage }}">{{ $stage }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">No. Urut (Opsional)</label>
                        <input type="number" name="order_number" min="1" class="w-full rounded-xl border-surface-variant bg-white/80 px-3 py-2 text-sm" placeholder="Contoh: 12">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1">Waktu (Opsional)</label>
                        <input type="datetime-local" name="scheduled_at" class="w-full rounded-xl border-surface-variant bg-white/80 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <button type="submit" class="w-full px-4 py-2 rounded-xl font-bold bg-primary text-white hover:bg-primary-container transition-colors text-sm">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.openPerfModal = (id) => {
                const el = document.getElementById(id);
                if(!el) return;
                el.classList.remove('hidden');
                el.style.display = 'flex';
                // Trigger reflow
                void el.offsetWidth;
                el.classList.remove('opacity-0');
                const inner = el.querySelector('.transform');
                if(inner) {
                    inner.classList.remove('scale-95');
                    inner.classList.add('scale-100');
                }
            };

            window.closePerfModal = (id) => {
                const el = document.getElementById(id);
                if(!el) return;
                el.classList.add('opacity-0');
                const inner = el.querySelector('.transform');
                if(inner) {
                    inner.classList.remove('scale-100');
                    inner.classList.add('scale-95');
                }
                setTimeout(() => {
                    el.classList.add('hidden');
                    el.style.display = 'none';
                }, 300);
            };

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
                        select.dataset.currentStatus = result.status;
                        feedback.textContent = 'Tersimpan';
                        feedback.className = 'text-xs text-green-700 min-h-4 font-semibold';
                    } catch (error) {
                        select.value = previousStatus;
                        feedback.textContent = 'Gagal menyimpan';
                        feedback.className = 'text-xs text-primary min-h-4 font-semibold';
                    } finally {
                        select.disabled = false;
                    }
                });
            });
            document.querySelectorAll('[data-perf-form]').forEach((form) => {
                const inputs = form.querySelectorAll('input, select');
                const feedback = form.querySelector('[data-perf-feedback]');
                
                inputs.forEach(input => {
                    input.addEventListener('change', async () => {
                        const formData = new FormData(form);
                        feedback.textContent = 'Menyimpan...';
                        feedback.className = 'text-[10px] min-h-[16px] text-on-surface-variant';
                        
                        try {
                            const response = await fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                            });
                            
                            if (!response.ok) throw new Error();
                            
                            const result = await response.json();
                            feedback.textContent = 'Tersimpan';
                            feedback.className = 'text-[10px] min-h-[16px] text-green-700 font-bold';
                        } catch (e) {
                            feedback.textContent = 'Gagal menyimpan';
                            feedback.className = 'text-[10px] min-h-[16px] text-primary font-bold';
                        }
                    });
                });
            });
        });
    </script>
@endpush
