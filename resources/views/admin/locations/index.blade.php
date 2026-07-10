@extends('layouts.admin')

@section('title', 'Manajemen Lokasi')
@section('heading', 'Manajemen Lokasi Geotag')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Kelola titik lokasi kegiatan seni, olahraga, upacara, dan umum.</p>
    <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow" href="{{ route('admin.locations.create') }}">Tambah Lokasi</a>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3">Nama</th>
            <th class="py-3">Tipe</th>
            <th class="py-3">Alamat</th>
            <th class="py-3">Koordinat</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @foreach ($locations as $location)
            <tr>
                <td class="py-4 font-semibold">{{ $location->name }}</td>
                <td class="py-4">{{ $location->type }}</td>
                <td class="py-4">{{ $location->address }}</td>
                <td class="py-4">{{ $location->latitude }}, {{ $location->longitude }}</td>
                <td class="py-4 flex gap-3 justify-end">
                    <a class="text-primary font-bold" href="{{ route('admin.locations.edit', $location) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" onsubmit="return confirm('Hapus lokasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-on-surface-variant font-bold">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-6">{{ $locations->links() }}</div>
</div>
@endsection
