@extends('layouts.admin')

@section('title', 'Manajemen Banner')
@section('heading', 'Banner Beranda')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Kelola slider gambar atau video pendek yang tampil di samping hitung mundur beranda.</p>
    <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow" href="{{ route('admin.banners.create') }}">Tambah Banner</a>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3">Judul</th>
            <th class="py-3">Jenis</th>
            <th class="py-3">Urutan</th>
            <th class="py-3">Status</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @forelse ($banners as $banner)
            <tr>
                <td class="py-4">
                    <div class="font-semibold">{{ $banner->title ?: 'Tanpa judul' }}</div>
                    <div class="text-sm text-on-surface-variant line-clamp-1">{{ $banner->media_url }}</div>
                </td>
                <td class="py-4">{{ $banner->media_type === 'video' ? 'Video' : 'Gambar' }}</td>
                <td class="py-4">{{ $banner->sort_order }}</td>
                <td class="py-4">
                    <span class="rounded-full px-3 py-1 text-sm font-bold {{ $banner->is_active ? 'bg-primary/10 text-primary' : 'bg-surface-container-high text-on-surface-variant' }}">
                        {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="py-4 flex gap-3 justify-end">
                    <a class="text-primary font-bold" href="{{ route('admin.banners.edit', $banner) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Hapus banner ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-on-surface-variant font-bold">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-8 text-on-surface-variant">Belum ada banner beranda.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-6">{{ $banners->links() }}</div>
</div>
@endsection
