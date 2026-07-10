@extends('layouts.admin')

@section('title', $competition->exists ? 'Edit Lomba' : 'Buat Lomba')
@section('heading', $competition->exists ? 'Edit Lomba' : 'Buat Lomba Baru')

@section('content')
<form method="POST" action="{{ $competition->exists ? route('admin.competitions.update', $competition) : route('admin.competitions.store') }}" class="glass-panel rounded-[2rem] p-8 max-w-4xl space-y-5">
    @csrf
    @if ($competition->exists)
        @method('PUT')
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Nama Lomba</label>
            <input name="name" value="{{ old('name', $competition->name) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
            @error('name') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="font-bold text-sm">Kategori</label>
            <select name="category" class="mt-2 w-full rounded-xl border-surface-variant">
                @foreach (['olahraga' => 'Olahraga', 'seni' => 'Seni', 'umum' => 'Umum'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('category', $competition->category) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="font-bold text-sm">Kuota</label>
            <input type="number" min="1" name="quota" value="{{ old('quota', $competition->quota) }}" class="mt-2 w-full rounded-xl border-surface-variant">
        </div>
        <div>
            <label class="font-bold text-sm">Mulai Kegiatan</label>
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $competition->starts_at?->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
        </div>
        <div>
            <label class="font-bold text-sm">Batas Pendaftaran</label>
            <input type="datetime-local" name="registration_deadline" value="{{ old('registration_deadline', $competition->registration_deadline?->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-xl border-surface-variant">
        </div>
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Lokasi</label>
            <input name="venue" value="{{ old('venue', $competition->venue) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
        </div>
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Deskripsi</label>
            <textarea name="description" rows="4" class="mt-2 w-full rounded-xl border-surface-variant">{{ old('description', $competition->description) }}</textarea>
        </div>
        <label class="md:col-span-2 flex items-center gap-3 font-bold">
            <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $competition->is_open)) class="rounded text-primary">
            Pendaftaran dibuka
        </label>
    </div>
    <div class="flex gap-3">
        <button class="bg-primary-container text-white px-6 py-3 rounded-full font-bold">Simpan</button>
        <a class="bg-surface-container-high px-6 py-3 rounded-full font-bold" href="{{ route('admin.competitions.index') }}">Batal</a>
    </div>
</form>
@endsection
