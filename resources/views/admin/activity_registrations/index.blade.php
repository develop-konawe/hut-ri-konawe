@extends('layouts.admin')

@section('title', 'Pendaftar Kegiatan: ' . $location->name)
@section('heading', 'Pendaftar: ' . $location->name)

@section('content')
<div class="mb-6 flex gap-3">
    <a href="{{ route('admin.locations.index') }}" class="bg-surface-container-high px-5 py-2.5 rounded-full font-bold text-sm">Kembali ke Kegiatan</a>
</div>

<div class="glass-panel rounded-[2rem] p-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/50">
                    <th class="p-4 font-bold text-sm text-on-surface-variant">Nama / Instansi</th>
                    <th class="p-4 font-bold text-sm text-on-surface-variant">Kontak</th>
                    <th class="p-4 font-bold text-sm text-on-surface-variant">Waktu Daftar</th>
                    <th class="p-4 font-bold text-sm text-on-surface-variant">Status</th>
                    <th class="p-4 font-bold text-sm text-on-surface-variant">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $registration)
                <tr class="border-b border-outline-variant/30 hover:bg-surface-container-lowest/50 transition-colors">
                    <td class="p-4">
                        <div class="font-bold">{{ $registration->name }}</div>
                        <div class="text-sm text-on-surface-variant">{{ $registration->institution ?? '-' }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-sm"><span class="material-symbols-outlined text-[14px] align-middle">call</span> {{ $registration->phone }}</div>
                        @if($registration->email)
                            <div class="text-sm"><span class="material-symbols-outlined text-[14px] align-middle">mail</span> {{ $registration->email }}</div>
                        @endif
                    </td>
                    <td class="p-4 text-sm">{{ $registration->submitted_at?->translatedFormat('d M Y H:i') }}</td>
                    <td class="p-4">
                        @if($registration->status === 'verified')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">{{ $registration->statusLabel() }}</span>
                        @elseif($registration->status === 'rejected')
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">{{ $registration->statusLabel() }}</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">{{ $registration->statusLabel() }}</span>
                        @endif
                    </td>
                    <td class="p-4 flex gap-2">
                        @if($registration->status === 'submitted')
                            <form action="{{ route('admin.activity_registrations.status', $registration) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="verified">
                                <button class="text-green-600 hover:text-green-800 font-bold text-sm" title="Terima"><span class="material-symbols-outlined">check_circle</span></button>
                            </form>
                            <form action="{{ route('admin.activity_registrations.status', $registration) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button class="text-red-600 hover:text-red-800 font-bold text-sm" title="Tolak"><span class="material-symbols-outlined">cancel</span></button>
                            </form>
                        @endif
                        <form action="{{ route('admin.activity_registrations.destroy', $registration) }}" method="POST" onsubmit="return confirm('Hapus pendaftar ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-secondary hover:text-primary font-bold text-sm" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-on-surface-variant">Belum ada pendaftar untuk kegiatan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
</div>
@endsection
