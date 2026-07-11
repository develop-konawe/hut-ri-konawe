@extends('layouts.admin')

@section('title', $banner->exists ? 'Edit Banner' : 'Tambah Banner')
@section('heading', $banner->exists ? 'Edit Banner Beranda' : 'Tambah Banner Beranda')

@section('content')
<form method="POST" action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}" class="glass-panel rounded-[2rem] p-8 max-w-4xl space-y-5">
    @csrf
    @if ($banner->exists)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Judul Banner</label>
            <input name="title" value="{{ old('title', $banner->title) }}" placeholder="Opsional, kosongkan jika banner sudah memiliki teks sendiri" class="mt-2 w-full rounded-xl border-surface-variant">
            <p class="text-sm text-on-surface-variant mt-2">Jika dikosongkan, judul tidak akan tampil di atas banner.</p>
            @error('title') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="font-bold text-sm">Jenis Media</label>
            <select name="media_type" class="mt-2 w-full rounded-xl border-surface-variant">
                @foreach (['image' => 'Gambar', 'video' => 'Video pendek'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('media_type', $banner->media_type) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('media_type') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="font-bold text-sm">Urutan</label>
            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" class="mt-2 w-full rounded-xl border-surface-variant">
            @error('sort_order') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="font-bold text-sm">URL Media Banner</label>
            <input type="url" name="media_url" value="{{ old('media_url', $banner->media_url) }}" placeholder="https://domain.go.id/banner.jpg atau https://domain.go.id/banner.mp4" class="mt-2 w-full rounded-xl border-surface-variant" required>
            <p class="text-sm text-on-surface-variant mt-2">Gunakan URL gambar, URL video langsung seperti .mp4/.webm, atau link share Google Drive. Video YouTube dikelola lewat menu Video.</p>
            @error('media_url') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="font-bold text-sm">URL Link Aksi</label>
            <input type="url" name="link_url" value="{{ old('link_url', $banner->link_url) }}" placeholder="Opsional, misalnya halaman pendaftaran atau berita" class="mt-2 w-full rounded-xl border-surface-variant">
            @error('link_url') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="font-bold text-sm">Deskripsi</label>
            <textarea name="description" rows="4" class="mt-2 w-full rounded-xl border-surface-variant">{{ old('description', $banner->description) }}</textarea>
            @error('description') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <label class="md:col-span-2 flex items-center gap-3 font-bold">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active)) class="rounded text-primary">
            Tampilkan di beranda
        </label>
    </div>

    <div class="flex gap-3">
        <button class="bg-primary-container text-white px-6 py-3 rounded-full font-bold">Simpan</button>
        <a class="bg-surface-container-high px-6 py-3 rounded-full font-bold" href="{{ route('admin.banners.index') }}">Batal</a>
    </div>
</form>
@endsection
