@extends('layouts.admin')

@section('title', 'Manajemen Lomba')
@section('heading', 'Manajemen Lomba & Pendaftaran')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Kelola jadwal lomba seni, olahraga, dan pendaftaran peserta.</p>
    <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow" href="{{ route('admin.competitions.create') }}">Buat Lomba</a>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3">Nama</th>
            <th class="py-3">Kategori</th>
            <th class="py-3">Jadwal</th>
            <th class="py-3">Lokasi</th>
            <th class="py-3">Peserta</th>
            <th class="py-3">Status</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @foreach ($competitions as $competition)
            <tr>
                <td class="py-4 font-semibold">{{ $competition->name }}</td>
                <td class="py-4">{{ $competition->category }}</td>
                <td class="py-4">{{ $competition->starts_at->format('d/m/Y H:i') }}</td>
                <td class="py-4">{{ $competition->venue }}</td>
                <td class="py-4">{{ $competition->registrations_count }}</td>
                <td class="py-4">{{ $competition->is_open ? 'Dibuka' : 'Ditutup' }}</td>
                <td class="py-4 flex gap-3 justify-end">
                    <a class="text-primary font-bold" href="{{ route('admin.competitions.edit', $competition) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.competitions.destroy', $competition) }}" onsubmit="return confirm('Hapus lomba ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-on-surface-variant font-bold">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-6">{{ $competitions->links() }}</div>
</div>
@endsection
