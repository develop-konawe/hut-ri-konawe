@extends('layouts.admin')

@section('title', 'Manajemen Live Streaming')
@section('heading', 'Live Streaming')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Kelola siaran langsung (Live Streaming) via YouTube.</p>
    <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow" href="{{ route('admin.live_streamings.create') }}">Tambah Siaran</a>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3">Judul Siaran</th>
            <th class="py-3">URL YouTube</th>
            <th class="py-3">Status</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @forelse ($liveStreamings as $live)
            <tr>
                <td class="py-4">
                    <div class="font-semibold">{{ $live->title }}</div>
                    @if($live->youtube_id)
                        <div class="text-xs text-on-surface-variant">ID: {{ $live->youtube_id }}</div>
                    @endif
                </td>
                <td class="py-4">
                    <a href="{{ $live->youtube_url }}" target="_blank" class="text-primary font-medium flex items-center gap-1 hover:underline">
                        Buka Video <span class="material-symbols-outlined text-[1rem]">open_in_new</span>
                    </a>
                </td>
                <td class="py-4">
                    <span class="rounded-full px-3 py-1 text-sm font-bold {{ $live->is_active ? 'bg-primary/10 text-primary' : 'bg-surface-container-high text-on-surface-variant' }}">
                        {{ $live->is_active ? 'Aktif (Live)' : 'Selesai / Nonaktif' }}
                    </span>
                </td>
                <td class="py-4">
                    <div class="flex gap-3 justify-end items-center">
                        <a class="inline-flex items-center justify-center bg-blue-100 text-blue-700 h-9 w-9 rounded-full hover:bg-blue-600 hover:text-white transition-colors" title="Edit Siaran" href="{{ route('admin.live_streamings.edit', $live) }}">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.live_streamings.destroy', $live) }}" onsubmit="return confirm('Hapus siaran langsung ini?')" class="m-0 p-0 inline-flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center bg-red-100 text-red-700 h-9 w-9 rounded-full hover:bg-red-600 hover:text-white transition-colors" title="Hapus Siaran">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="py-8 text-on-surface-variant">Belum ada data siaran langsung.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-6">{{ $liveStreamings->links() }}</div>
</div>
@endsection
