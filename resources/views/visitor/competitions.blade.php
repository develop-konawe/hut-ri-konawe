@extends('layouts.visitor')

@section('title', 'Jadwal Lomba')

@section('content')
<section class="max-w-container-max mx-auto px-gutter py-10">
    <h1 class="font-headline text-4xl font-extrabold text-primary mb-3">Jadwal Lomba</h1>
    <p class="text-secondary mb-8">Daftar kegiatan seni, olahraga, dan umum yang dibuka untuk pendaftaran peserta.</p>
    @if ($registrationSetting->isRegistrationClosed())
        <div class="glass-panel rounded-2xl p-5 text-primary font-semibold mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined">info</span>
            {{ $registrationSetting->closedMessage() }}
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($competitions as $competition)
            <article class="glass-panel rounded-[2rem] p-6 flex flex-col">
                <span class="px-3 py-1 rounded-full bg-secondary-container text-secondary text-xs font-bold self-start">{{ strtoupper($competition->category) }}</span>
                <h2 class="font-headline text-2xl font-bold mt-4">{{ $competition->name }}</h2>
                <p class="text-on-surface-variant mt-2 flex-grow">{{ $competition->description }}</p>
                <div class="mt-5 text-sm space-y-2">
                    <p><strong>Tanggal:</strong> {{ $competition->starts_at->translatedFormat('d F Y H:i') }} WITA</p>
                    <p><strong>Lokasi:</strong> {{ $competition->venue }}</p>
                    <p><strong>Kuota:</strong> {{ $competition->quota ?: 'Tidak dibatasi' }}</p>
                </div>
                @if ($registrationSetting->isRegistrationOpen())
                    <a class="mt-6 bg-primary-container text-white text-center rounded-full px-5 py-3 font-bold" href="{{ route('visitor.registration.competition', $competition) }}">Daftar Sekarang</a>
                @elseif ($registrationSetting->isRegistrationClosed())
                    <div class="mt-6 bg-surface-container-high text-primary text-center rounded-full px-5 py-3 font-bold">Pendaftaran Ditutup</div>
                @endif
            </article>
        @endforeach
    </div>
</section>
@endsection
