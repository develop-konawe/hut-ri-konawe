@extends('layouts.admin')

@section('title', $video->exists ? 'Edit Video' : 'Tambah Video')
@section('heading', $video->exists ? 'Edit Video Kemerdekaan' : 'Tambah Video Kemerdekaan')

@section('content')
<form method="POST" action="{{ $video->exists ? route('admin.videos.update', $video) : route('admin.videos.store') }}" class="glass-panel rounded-[2rem] p-8 max-w-4xl space-y-5">
    @csrf
    @if ($video->exists)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Judul Video</label>
            <input name="title" value="{{ old('title', $video->title) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
            @error('title') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="font-bold text-sm">Provider</label>
            <select name="provider" class="mt-2 w-full rounded-xl border-surface-variant">
                @foreach (['youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'other' => 'Lainnya'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('provider', $video->provider) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('provider') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="font-bold text-sm">Tanggal Publikasi</label>
            <input type="date" name="published_at" value="{{ old('published_at', $video->published_at?->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border-surface-variant">
            @error('published_at') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="font-bold text-sm">URL Video YouTube / Embed</label>
            <input type="url" name="embed_url" value="{{ old('embed_url', $video->embed_url) }}" placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." class="mt-2 w-full rounded-xl border-surface-variant" required>
            <p class="text-sm text-on-surface-variant mt-2">Boleh gunakan link YouTube asli. Sistem akan otomatis mengubahnya menjadi URL embed agar bisa tampil di halaman.</p>
            @error('embed_url') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="font-bold text-sm">URL Thumbnail Video</label>
            <input type="url" name="thumbnail_url" value="{{ old('thumbnail_url', $video->thumbnail_url) }}" class="mt-2 w-full rounded-xl border-surface-variant">
            <p class="text-sm text-on-surface-variant mt-2">Opsional. Gunakan URL gambar thumbnail video. Banner beranda dikelola terpisah lewat menu Banner.</p>
            @error('thumbnail_url') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="font-bold text-sm">Deskripsi</label>
            <textarea name="description" rows="4" class="mt-2 w-full rounded-xl border-surface-variant">{{ old('description', $video->description) }}</textarea>
            @error('description') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <label class="md:col-span-2 flex items-center gap-3 font-bold">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $video->is_featured)) class="rounded text-primary">
            Jadikan video utama di section Video Kemerdekaan
        </label>
    </div>

    <div class="flex gap-3">
        <button class="bg-primary-container text-white px-6 py-3 rounded-full font-bold">Simpan</button>
        <a class="bg-surface-container-high px-6 py-3 rounded-full font-bold" href="{{ route('admin.videos.index') }}">Batal</a>
    </div>
</form>
@endsection
