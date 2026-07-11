@extends('layouts.admin')

@section('title', 'Manajemen Video')
@section('heading', 'Video Kemerdekaan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Kelola video YouTube atau embed dokumentasi kemerdekaan yang tampil di portal.</p>
    <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow" href="{{ route('admin.videos.create') }}">Tambah Video</a>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3">Judul</th>
            <th class="py-3">Provider</th>
            <th class="py-3">Tanggal</th>
            <th class="py-3">Status</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @forelse ($videos as $video)
            <tr>
                <td class="py-4">
                    <div class="font-semibold">{{ $video->title }}</div>
                    <div class="text-sm text-on-surface-variant line-clamp-1">{{ $video->embed_url }}</div>
                </td>
                <td class="py-4">{{ ucfirst($video->provider) }}</td>
                <td class="py-4">{{ $video->published_at?->format('d/m/Y') ?? '-' }}</td>
                <td class="py-4">
                    <span class="rounded-full px-3 py-1 text-sm font-bold {{ $video->is_featured ? 'bg-primary/10 text-primary' : 'bg-surface-container-high text-on-surface-variant' }}">
                        {{ $video->is_featured ? 'Unggulan' : 'Reguler' }}
                    </span>
                </td>
                <td class="py-4 flex gap-3 justify-end">
                    <a class="text-primary font-bold" href="{{ route('admin.videos.edit', $video) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" onsubmit="return confirm('Hapus video ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-on-surface-variant font-bold">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-8 text-on-surface-variant">Belum ada video kemerdekaan.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-6">{{ $videos->links() }}</div>
</div>
@endsection
