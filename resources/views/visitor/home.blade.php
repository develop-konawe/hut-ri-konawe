@extends('layouts.visitor')

@section('title', 'Portal HUT RI Konawe')

@section('content')
<section class="relative h-[600px] md:h-[800px] overflow-hidden flex items-center justify-center">
    <img class="absolute inset-0 w-full h-full object-cover brightness-75" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbxkqpb2m7rFOATPP79gh3y3y3APAgQkc-A8-BHbYWyphAIBU1aKFzF_q18ouDuPeFL5rAYR4hhSxMfpcDTdA6eW2midSQqR7JUu_X7XzKiwji1j9fCND0kGgz1iGsRgi7zxT_g1UDf8OhNepuzHsY0xWaMR6y6QaSuno6m3wz86EtLsvzAPjiXjxoSAkPgpQCWCdf9rDQDwmDJIZLV6Brua6veUiWsOvQfyBR_9wnxMvcGB0RFL8NUFt9rbVMABRVcDIaEPIgxmyr" alt="Konawe Independence">
    <div class="relative z-10 w-full max-w-container-max px-gutter text-center flex flex-col items-center">
        <div class="glass-panel p-8 md:p-12 rounded-3xl max-w-3xl animate-float">
            <img class="mx-auto mb-8 h-28 md:h-40 object-contain drop-shadow-2xl" src="{{ asset('assets/logo/hutri81-full-red.png') }}" alt="Logo HUT RI 81 Indonesia Berdaulat Adil dan Makmur">
            <h1 class="font-headline text-4xl md:text-[56px] leading-[1.1] font-extrabold text-primary mb-4">Indonesia Berdaulat, Adil dan Makmur</h1>
            <p class="text-lg leading-relaxed text-secondary max-w-xl mx-auto">Merayakan semangat 81 tahun kemerdekaan di Bumi Konawe melalui berita olahraga, jadwal lomba, peta kegiatan, video, dan pendaftaran daring.</p>
        </div>
    </div>
</section>

<div class="flex justify-center -mt-12 relative z-20 px-gutter gap-4 md:gap-8 flex-wrap">
    <a class="bg-primary-container text-white px-6 py-4 rounded-full shadow-lg hover:scale-105 transition-transform flex items-center gap-3" href="{{ route('visitor.news') }}"><span class="material-symbols-outlined">newspaper</span>Berita Terbaru</a>
    <a class="bg-surface-container-highest text-primary px-6 py-4 rounded-full shadow-lg hover:scale-105 transition-transform flex items-center gap-3" href="{{ route('visitor.registration.create') }}"><span class="material-symbols-outlined">app_registration</span>Pendaftaran Lomba</a>
    <a class="bg-secondary-container text-secondary px-6 py-4 rounded-full shadow-lg hover:scale-105 transition-transform flex items-center gap-3" href="{{ route('visitor.locations') }}"><span class="material-symbols-outlined">map</span>Peta Acara</a>
</div>

<section class="pt-28 pb-section-gap px-gutter max-w-container-max mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4 bg-primary rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
            <span class="material-symbols-outlined absolute -right-10 -top-10 text-[180px] opacity-20">celebration</span>
            <h2 class="font-headline text-2xl font-bold mb-6 relative">Menuju 17 Agustus</h2>
            <div class="grid grid-cols-3 gap-3 relative">
                <div><div class="text-5xl font-extrabold" id="days">00</div><div class="text-xs uppercase opacity-80">Hari</div></div>
                <div><div class="text-5xl font-extrabold" id="hours">00</div><div class="text-xs uppercase opacity-80">Jam</div></div>
                <div><div class="text-5xl font-extrabold" id="minutes">00</div><div class="text-xs uppercase opacity-80">Menit</div></div>
            </div>
            <a class="inline-flex mt-8 bg-white/20 border border-white/30 px-6 py-3 rounded-full font-semibold" href="{{ route('visitor.competitions') }}">Lihat Jadwal</a>
        </div>
        <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse ($competitions as $competition)
                <article class="glass-panel p-6 rounded-[2rem] shadow-sm flex flex-col">
                    <span class="inline-block px-3 py-1 bg-tertiary-container text-white rounded-full text-xs font-bold mb-4 self-start">{{ strtoupper($competition->category) }}</span>
                    <h3 class="font-headline text-2xl font-bold mb-2">{{ $competition->name }}</h3>
                    <p class="text-on-surface-variant flex-grow">{{ $competition->description }}</p>
                    <div class="mt-5 flex items-center justify-between text-sm font-bold">
                        <span class="text-primary flex items-center gap-2"><span class="material-symbols-outlined text-base">calendar_today</span>{{ $competition->starts_at->translatedFormat('d M H:i') }}</span>
                        <a class="text-primary hover:underline" href="{{ route('visitor.registration.competition', $competition) }}">Daftar</a>
                    </div>
                </article>
            @empty
                <div class="glass-panel p-6 rounded-[2rem] md:col-span-2">Belum ada jadwal lomba yang dibuka.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="px-gutter max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div>
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-headline text-3xl font-bold">Berita Olahraga</h2>
            <a class="text-primary font-semibold" href="{{ route('visitor.news') }}">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse ($sportsNews as $item)
                <article class="glass-panel rounded-2xl p-5">
                    <p class="text-xs font-bold text-primary mb-2">{{ $item->category ?? 'olahraga' }} - {{ $item->publishedAt ?? 'terbaru' }}</p>
                    <h3 class="font-headline text-xl font-bold">{{ $item->title }}</h3>
                    <p class="text-on-surface-variant mt-2">{{ $item->excerpt }}</p>
                </article>
            @empty
                <article class="glass-panel rounded-2xl p-5">Berita olahraga belum tersedia atau API tidak dapat dijangkau.</article>
            @endforelse
        </div>
    </div>
    <div>
        <h2 class="font-headline text-3xl font-bold mb-5">Pengumuman</h2>
        <div class="space-y-4">
            @forelse ($announcements as $item)
                <article class="glass-panel rounded-2xl p-5">
                    <p class="text-xs font-bold text-primary mb-2">{{ $item->publishedAt ?? 'terbaru' }}</p>
                    <h3 class="font-headline text-xl font-bold">{{ $item->title }}</h3>
                    <p class="text-on-surface-variant mt-2">{{ $item->excerpt }}</p>
                </article>
            @empty
                <article class="glass-panel rounded-2xl p-5">Pengumuman belum tersedia atau API tidak dapat dijangkau.</article>
            @endforelse
        </div>
    </div>
</section>

<script>
    const target = new Date('2026-08-17T08:00:00+08:00').getTime();
    setInterval(() => {
        const gap = Math.max(0, target - Date.now());
        document.getElementById('days').textContent = String(Math.floor(gap / 86400000)).padStart(2, '0');
        document.getElementById('hours').textContent = String(Math.floor((gap % 86400000) / 3600000)).padStart(2, '0');
        document.getElementById('minutes').textContent = String(Math.floor((gap % 3600000) / 60000)).padStart(2, '0');
    }, 1000);
</script>
@endsection
