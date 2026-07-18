@extends('layouts.admin')

@section('title', $liveStreaming->exists ? 'Edit Siaran Langsung' : 'Tambah Siaran Langsung')
@section('heading', $liveStreaming->exists ? 'Edit Siaran Langsung' : 'Tambah Siaran Langsung')

@section('content')
<form method="POST" action="{{ $liveStreaming->exists ? route('admin.live_streamings.update', $liveStreaming) : route('admin.live_streamings.store') }}" class="glass-panel rounded-[2rem] p-8 max-w-4xl space-y-5">
    @csrf
    @if ($liveStreaming->exists)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Judul Kegiatan / Lomba</label>
            <input list="event-options" name="title" value="{{ old('title', $liveStreaming->title) }}" class="mt-2 w-full rounded-xl border-surface-variant" required autocomplete="off">
            <datalist id="event-options">
                @foreach($eventOptions as $option)
                    <option value="{{ $option }}">
                @endforeach
            </datalist>
            <p class="text-sm text-on-surface-variant mt-2">Ketik judul manual atau klik untuk memilih dari data lomba/kegiatan yang sudah ada.</p>
            @error('title') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="font-bold text-sm">URL Video YouTube / Embed</label>
            <input type="url" name="youtube_url" value="{{ old('youtube_url', $liveStreaming->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." class="mt-2 w-full rounded-xl border-surface-variant" required>
            <p class="text-sm text-on-surface-variant mt-2">Gunakan URL asli video atau live streaming YouTube. Sistem akan otomatis mendeteksi ID-nya.</p>
            @error('youtube_url') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <label class="md:col-span-2 flex items-center gap-3 font-bold">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $liveStreaming->is_active)) class="rounded text-primary">
            Siaran sedang aktif / berlangsung (centang untuk menampilkan di halaman Live Streaming)
        </label>
    </div>

    <div class="flex gap-3 mt-8">
        <button class="bg-primary-container text-white px-6 py-3 rounded-full font-bold">Simpan</button>
        <a class="bg-surface-container-high px-6 py-3 rounded-full font-bold" href="{{ route('admin.live_streamings.index') }}">Batal</a>
    </div>
</form>
@endsection
