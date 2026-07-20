@extends('layouts.visitor')

@section('title', 'Pendaftaran Lomba')

@section('content')
<section class="max-w-container-max mx-auto px-gutter py-10">
    @if ($registrationSetting->isRegistrationClosed())
        <div class="glass-panel rounded-[2rem] p-8 max-w-3xl mx-auto text-center">
            <span class="material-symbols-outlined text-primary text-6xl mb-4">info</span>
            <h1 class="font-headline text-4xl font-extrabold text-primary mb-4">Pendaftaran Ditutup</h1>
            <p class="text-secondary text-lg leading-relaxed">{{ $registrationSetting->closedMessage() }}</p>
            <a class="inline-flex mt-8 bg-primary-container text-white px-8 py-4 rounded-full font-bold shadow-lg" href="{{ route('visitor.competitions') }}">Lihat Jadwal Lomba</a>
        </div>
    @else
        @if($competitions->isEmpty())
            <div class="glass-panel rounded-[2rem] p-8 max-w-3xl mx-auto text-center">
                <span class="material-symbols-outlined text-primary text-6xl mb-4">event_busy</span>
                <h1 class="font-headline text-4xl font-extrabold text-primary mb-4">Belum Ada Lomba</h1>
                <p class="text-secondary text-lg leading-relaxed">Saat ini belum ada lomba yang dibuka untuk pendaftaran. Silakan cek kembali nanti.</p>
                <a class="inline-flex mt-8 bg-primary-container text-white px-8 py-4 rounded-full font-bold shadow-lg" href="{{ route('visitor.competitions') }}">Lihat Jadwal Lomba</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-5">
                    <h1 class="font-headline text-4xl font-extrabold text-primary mb-4">Formulir Pendaftaran</h1>
                    <p class="text-secondary mb-6">Isi data peserta untuk mengikuti lomba HUT RI. Pastikan nomor kontak aktif agar panitia dapat melakukan verifikasi.</p>
                    <div class="glass-panel rounded-[2rem] p-6">
                        <h2 class="font-headline text-xl font-bold mb-4">Lomba Dibuka</h2>
                        <div class="space-y-3">
                            @foreach ($competitions as $item)
                                <a class="block rounded-2xl bg-white/70 p-4 hover:ring-2 hover:ring-primary" href="{{ route('visitor.registration.competition', $item) }}">
                                    <strong>{{ $item->name }}</strong>
                                    <span class="block text-sm text-on-surface-variant">{{ $item->starts_at->translatedFormat('d M Y H:i') }} - {{ $item->venue }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-7">
                    <form method="POST" action="{{ route('visitor.registration.store') }}" class="glass-panel rounded-[2rem] p-6 md:p-8 space-y-5">
                        @csrf
                        <div>
                            <label class="font-bold text-sm">Pilih Lomba</label>
                            <select name="competition_id" class="mt-2 w-full rounded-xl border-outline-variant bg-white/80">
                                @foreach ($competitions as $item)
                                    <option value="{{ $item->id }}" @selected(old('competition_id', $competition?->id) == $item->id)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('competition_id') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="font-bold text-sm">Nama Peserta/Tim</label>
                                <input name="participant_name" value="{{ old('participant_name') }}" class="mt-2 w-full rounded-xl border-outline-variant bg-white/80" required>
                                @error('participant_name') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="font-bold text-sm">NIK/Nomor Identitas</label>
                                <input name="identity_number" value="{{ old('identity_number') }}" class="mt-2 w-full rounded-xl border-outline-variant bg-white/80">
                            </div>
                            <div>
                                <label class="font-bold text-sm">No. HP</label>
                                <input name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-xl border-outline-variant bg-white/80" required>
                                @error('phone') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="font-bold text-sm">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border-outline-variant bg-white/80">
                            </div>
                        </div>
                        <div>
                            <label class="font-bold text-sm">Instansi/Komunitas</label>
                            <input name="institution" value="{{ old('institution') }}" class="mt-2 w-full rounded-xl border-outline-variant bg-white/80">
                        </div>
                        <div>
                            <label class="font-bold text-sm">Alamat</label>
                            <textarea name="address" rows="4" class="mt-2 w-full rounded-xl border-outline-variant bg-white/80">{{ old('address') }}</textarea>
                        </div>
                        <button class="bg-primary-container text-white px-8 py-4 rounded-full font-bold shadow-lg">Kirim Pendaftaran</button>
                    </form>
                </div>
            </div>
        @endif
    @endif
</section>
@endsection
