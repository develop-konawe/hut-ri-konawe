@extends('layouts.admin')

@section('title', 'Pengaturan Portal')
@section('heading', 'Pengaturan Portal')

@section('content')
<div class="max-w-5xl">
    <div class="glass-panel rounded-[2rem] p-6 md:p-8">
        <div class="flex items-start justify-between gap-6 mb-8">
            <div>
                <h1 class="font-headline text-3xl font-extrabold text-primary">Pengaturan Portal</h1>
                <p class="text-on-surface-variant mt-2">Atur branding portal, logo, judul header/footer, dan akses pendaftaran.</p>
            </div>
            <span class="rounded-full px-4 py-2 text-sm font-bold {{ $setting->isRegistrationOpen() ? 'bg-green-100 text-green-700' : 'bg-primary/10 text-primary' }}">
                {{ ['open' => 'Dibuka', 'closed' => 'Ditutup', 'hidden' => 'Disembunyikan'][$setting->registrationStatus()] }}
            </span>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <section class="rounded-3xl bg-white/60 border border-white/60 p-5 md:p-6">
                <h2 class="font-headline text-2xl font-bold text-primary">Branding</h2>
                <p class="text-sm text-on-surface-variant mt-1">Kosongkan upload logo jika tidak ingin mengganti file yang sedang dipakai.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="font-bold text-sm" for="header_title">Judul Header</label>
                        <input id="header_title" name="header_title" value="{{ old('header_title', $setting->header_title) }}" placeholder="{{ \App\Models\SiteSetting::DEFAULT_HEADER_TITLE }}" class="mt-2 w-full rounded-xl border-surface-variant bg-white/80">
                        <p class="text-sm text-on-surface-variant mt-2">Tampil di samping logo pada header menu.</p>
                        @error('header_title') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="font-bold text-sm" for="footer_title">Judul Footer</label>
                        <input id="footer_title" name="footer_title" value="{{ old('footer_title', $setting->footer_title) }}" placeholder="{{ \App\Models\SiteSetting::DEFAULT_FOOTER_TITLE }}" class="mt-2 w-full rounded-xl border-surface-variant bg-white/80">
                        <p class="text-sm text-on-surface-variant mt-2">Tampil sebagai judul utama pada footer.</p>
                        @error('footer_title') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                    <div class="rounded-2xl bg-white/70 border border-white/60 p-4">
                        <div class="h-20 flex items-center justify-center mb-4">
                            <img class="max-h-16 max-w-full object-contain" src="{{ $setting->headerKonaweLogoUrl() }}" alt="Logo Konawe saat ini">
                        </div>
                        <label class="font-bold text-sm" for="header_konawe_logo">Logo Konawe Header</label>
                        <input id="header_konawe_logo" type="file" name="header_konawe_logo" accept=".png,.jpg,.jpeg,.webp,.svg" class="mt-2 w-full text-sm">
                        @error('header_konawe_logo') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="rounded-2xl bg-white/70 border border-white/60 p-4">
                        <div class="h-20 flex items-center justify-center mb-4">
                            <img class="max-h-16 max-w-full object-contain" src="{{ $setting->headerHutriLogoUrl() }}" alt="Logo HUT RI header saat ini">
                        </div>
                        <label class="font-bold text-sm" for="header_hutri_logo">Logo HUT RI Header</label>
                        <input id="header_hutri_logo" type="file" name="header_hutri_logo" accept=".png,.jpg,.jpeg,.webp,.svg" class="mt-2 w-full text-sm">
                        @error('header_hutri_logo') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="rounded-2xl bg-white/70 border border-white/60 p-4">
                        <div class="h-20 flex items-center justify-center mb-4">
                            <img class="max-h-16 max-w-full object-contain" src="{{ $setting->heroLogoUrl() }}" alt="Logo banner utama saat ini">
                        </div>
                        <label class="font-bold text-sm" for="hero_logo">Logo Banner Utama</label>
                        <input id="hero_logo" type="file" name="hero_logo" accept=".png,.jpg,.jpeg,.webp,.svg" class="mt-2 w-full text-sm">
                        @error('hero_logo') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-3xl bg-white/60 border border-white/60 p-5 md:p-6">
                <h2 class="font-headline text-2xl font-bold text-primary">Pendaftaran</h2>
                <p class="text-sm text-on-surface-variant mt-1">Atur apakah menu dan halaman pendaftaran lomba bisa diakses pengunjung.</p>

                <div class="mt-5">
                <label class="font-bold text-sm">Status pendaftaran</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                    <label class="rounded-2xl bg-white/70 p-5 border border-white/60 cursor-pointer">
                        <input type="radio" name="registration_status" value="open" @checked(old('registration_status', $setting->registrationStatus()) === 'open') class="text-primary focus:ring-primary">
                        <span class="block font-bold mt-3">Dibuka</span>
                        <span class="block text-sm text-on-surface-variant mt-1">Menu tampil, halaman pendaftaran bisa diakses, dan form aktif.</span>
                    </label>
                    <label class="rounded-2xl bg-white/70 p-5 border border-white/60 cursor-pointer">
                        <input type="radio" name="registration_status" value="closed" @checked(old('registration_status', $setting->registrationStatus()) === 'closed') class="text-primary focus:ring-primary">
                        <span class="block font-bold mt-3">Ditutup</span>
                        <span class="block text-sm text-on-surface-variant mt-1">Menu tetap tampil, halaman pendaftaran menampilkan pesan penutupan.</span>
                    </label>
                    <label class="rounded-2xl bg-white/70 p-5 border border-white/60 cursor-pointer">
                        <input type="radio" name="registration_status" value="hidden" @checked(old('registration_status', $setting->registrationStatus()) === 'hidden') class="text-primary focus:ring-primary">
                        <span class="block font-bold mt-3">Disembunyikan</span>
                        <span class="block text-sm text-on-surface-variant mt-1">Menu disembunyikan dan URL pendaftaran menjadi tidak ditemukan.</span>
                    </label>
                </div>
                @error('registration_status') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                </div>

            <div class="mt-6">
                <label class="font-bold text-sm" for="registration_closed_message">Pesan saat pendaftaran ditutup</label>
                <textarea id="registration_closed_message" name="registration_closed_message" rows="4" class="mt-2 w-full rounded-xl border-surface-variant bg-white/80">{{ old('registration_closed_message', $setting->closedMessage()) }}</textarea>
                <p class="text-sm text-on-surface-variant mt-2">Pesan ini tampil di beranda dan halaman jadwal lomba ketika pendaftaran ditutup.</p>
                @error('registration_closed_message') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            </section>

            <button class="bg-primary-container text-white px-8 py-3 rounded-full font-bold shadow-lg">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
