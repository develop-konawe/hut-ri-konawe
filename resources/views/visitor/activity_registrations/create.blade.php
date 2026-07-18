@extends('layouts.visitor')

@section('title', 'Pendaftaran Kehadiran: ' . $location->name)

@section('content')
<section class="max-w-3xl mx-auto px-gutter py-10">
    <div class="mb-8">
        <a class="inline-flex items-center gap-2 text-secondary hover:text-primary font-bold mb-6 transition-colors" href="{{ route('visitor.home') }}">
            <span class="material-symbols-outlined text-[1.2rem]">arrow_back</span> Kembali ke Beranda
        </a>
        <h1 class="font-headline text-3xl font-extrabold text-primary mb-2">Pendaftaran Kehadiran</h1>
        <p class="text-secondary text-lg">{{ $location->name }}</p>
    </div>

    @if($errors->has('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-bold flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="glass-panel rounded-[2rem] p-6 md:p-8">
        <form action="{{ route('visitor.activity_registration.store', $location) }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant/30 mb-8">
                <h3 class="font-bold text-primary mb-3">Informasi Kegiatan</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="font-bold inline-block w-24">Waktu:</span> {{ $location->activity_at ? $location->activity_at->translatedFormat('d F Y H:i') : 'Menyusul' }}</p>
                    <p><span class="font-bold inline-block w-24">Lokasi:</span> {{ $location->address }}</p>
                    @if($location->registration_deadline)
                        <p class="text-red-600"><span class="font-bold inline-block w-24 text-on-surface-variant">Batas Daftar:</span> {{ $location->registration_deadline->translatedFormat('d F Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <div>
                <label for="name" class="block font-bold mb-2">Nama Lengkap <span class="text-primary">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-xl border-surface-variant focus:border-primary focus:ring focus:ring-primary/20 p-3">
                @error('name') <p class="text-primary text-sm mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block font-bold mb-2">Nomor HP/WhatsApp <span class="text-primary">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full rounded-xl border-surface-variant focus:border-primary focus:ring focus:ring-primary/20 p-3">
                @error('phone') <p class="text-primary text-sm mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="institution" class="block font-bold mb-2">Instansi/Asal/Utusan</label>
                <input type="text" name="institution" id="institution" value="{{ old('institution') }}" class="w-full rounded-xl border-surface-variant focus:border-primary focus:ring focus:ring-primary/20 p-3" placeholder="Opsional">
                @error('institution') <p class="text-primary text-sm mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block font-bold mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-xl border-surface-variant focus:border-primary focus:ring focus:ring-primary/20 p-3" placeholder="Opsional">
                @error('email') <p class="text-primary text-sm mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary hover:bg-primary-container text-white px-6 py-4 rounded-xl font-bold text-lg transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">send</span> Kirim Pendaftaran Kehadiran
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
