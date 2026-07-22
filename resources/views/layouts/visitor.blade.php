<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HUT RI ke-81 Kabupaten Konawe')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/logo_konawe.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@400;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float{animation:float 3s ease-in-out infinite}
        .glass-panel{background:rgba(255,255,255,.68);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.2);box-shadow:0 8px 32px rgba(81,93,132,.06)}
        .mosehe-pattern{background-image:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l30 30-30 30L0 30z' fill='%23be0017' fill-opacity='0.03'/%3E%3C/svg%3E")}
        .merah-semangat-gradient{background:linear-gradient(135deg,#be0017 0%,#93000f 100%)}
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background mosehe-pattern font-body min-h-screen">
<header class="bg-surface/80 backdrop-blur-md sticky top-0 z-50 border-b border-outline-variant/30 shadow-sm">
    <div class="flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-16 md:h-20">
        <a href="{{ route('visitor.home') }}" class="flex items-center gap-3 text-primary">
            <span class="flex items-center gap-2">
                <span class="flex h-11 w-11 items-center justify-center">
                    <img class="max-h-10 max-w-10 object-contain" src="{{ $siteSetting->headerKonaweLogoUrl() }}" alt="Logo Kabupaten Konawe">
                </span>
                <span class="flex h-11 w-11 items-center justify-center">
                    <img class="max-h-11 max-w-11 object-contain" src="{{ $siteSetting->headerHutriLogoUrl() }}" alt="Logo HUT RI 81">
                </span>
            </span>
            <span class="font-headline font-bold text-lg md:text-2xl leading-tight">{{ $siteSetting->headerTitle() }}</span>
        </a>
        <nav class="hidden md:flex gap-7 items-center text-sm font-semibold">
            <a class="{{ request()->routeIs('visitor.home') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-primary' }} py-6" href="{{ route('visitor.home') }}">Beranda</a>
            <a class="{{ request()->routeIs('visitor.news') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-primary' }} py-6" href="{{ route('visitor.news') }}">Berita</a>
            <a class="{{ request()->routeIs('visitor.competitions') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-primary' }} py-6" href="{{ route('visitor.competitions') }}">Lomba</a>
            <a class="{{ request()->routeIs('visitor.locations') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-primary' }} py-6" href="{{ route('visitor.locations') }}">Kegiatan</a>
            <a class="{{ request()->routeIs('visitor.videos') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-primary' }} py-6" href="{{ route('visitor.videos') }}">Video</a>
            <a class="{{ request()->routeIs('visitor.live_streamings') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-primary' }} py-6 flex items-center" href="{{ route('visitor.live_streamings') }}">
                Live
                <span class="relative flex h-2 w-2 ml-1.5 mb-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
            </a>
            @if ($registrationSetting->shouldShowRegistrationMenu())
                <a class="bg-primary-container text-white px-4 py-2 rounded-full shadow" href="{{ route('visitor.registration.create') }}">Daftar</a>
            @endif
        </nav>
    </div>
</header>

@if (session('status'))
    <div class="max-w-container-max mx-auto px-gutter pt-6">
        <div class="glass-panel rounded-2xl p-4 text-primary font-semibold">{{ session('status') }}</div>
    </div>
@endif

<main>
    @yield('content')
</main>

<nav class="fixed bottom-0 left-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl md:hidden h-16 flex justify-around items-center rounded-t-xl shadow-[0_-4px_20px_rgba(81,93,132,0.1)] px-4">
    <a class="flex flex-col items-center justify-center {{ request()->routeIs('visitor.home') ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:scale-110' }} transition-all duration-200" href="{{ route('visitor.home') }}">
        <span class="material-symbols-outlined" @if(request()->routeIs('visitor.home')) style="font-variation-settings: 'FILL' 1;" @endif>home</span>
        <span class="text-[10px] font-label-bold">Beranda</span>
    </a>
    <a class="flex flex-col items-center justify-center {{ request()->routeIs('visitor.news') ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:scale-110' }} transition-all duration-200" href="{{ route('visitor.news') }}">
        <span class="material-symbols-outlined">newspaper</span>
        <span class="text-[10px] font-label-bold">Berita</span>
    </a>
    <a class="flex flex-col items-center justify-center {{ request()->routeIs('visitor.competitions') ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:scale-110' }} transition-all duration-200" href="{{ route('visitor.competitions') }}">
        <span class="material-symbols-outlined">event_note</span>
        <span class="text-[10px] font-label-bold">Lomba</span>
    </a>
    <a class="flex flex-col items-center justify-center {{ request()->routeIs('visitor.locations') ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:scale-110' }} transition-all duration-200" href="{{ route('visitor.locations') }}">
        <span class="material-symbols-outlined">map</span>
        <span class="text-[10px] font-label-bold">Kegiatan</span>
    </a>
    <a class="flex flex-col items-center justify-center {{ request()->routeIs('visitor.videos') ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:scale-110' }} transition-all duration-200" href="{{ route('visitor.videos') }}">
        <span class="material-symbols-outlined">play_circle</span>
        <span class="text-[10px] font-label-bold">Video</span>
    </a>
    <a class="flex flex-col items-center justify-center {{ request()->routeIs('visitor.live_streamings') ? 'bg-primary-container text-on-primary-container rounded-full px-4 py-1' : 'text-secondary hover:scale-110' }} transition-all duration-200" href="{{ route('visitor.live_streamings') }}">
        <div class="relative">
            <span class="material-symbols-outlined">sensors</span>
            <span class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
            </span>
        </div>
        <span class="text-[10px] font-label-bold">Live</span>
    </a>
</nav>

<footer class="bg-surface-container-high border-t border-outline-variant/50 w-full py-12 px-gutter mt-section-gap relative pb-24 md:pb-12">
    <div class="max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-start gap-12">
        <div class="max-w-md">
            <h2 class="text-headline-md font-headline-md font-extrabold text-primary mb-4">{{ $siteSetting->footerTitle() }}</h2>
            <p class="text-body-md font-body-md text-on-surface-variant mb-6 leading-relaxed">
                Pemerintah Kabupaten Konawe berkomitmen untuk terus memajukan kesejahteraan masyarakat dan melestarikan budaya luhur daerah dalam semangat kemerdekaan Republik Indonesia.
            </p>
            <div class="flex gap-4">
                <a class="text-primary hover:scale-110 transition-transform" href="https://api.whatsapp.com/send?text={{ rawurlencode($siteSetting->footerTitle().' - '.url()->current()) }}" target="_blank" rel="noopener" data-share-current-url aria-label="Bagikan halaman ini"><span class="material-symbols-outlined">share</span></a>
                <a class="text-primary hover:scale-110 transition-transform" href="https://konawekab.go.id/" target="_blank" rel="noopener" aria-label="Website resmi Kabupaten Konawe"><span class="material-symbols-outlined">language</span></a>
                <a class="text-primary hover:scale-110 transition-transform" href="mailto:diskominfo@konawekab.go.id" aria-label="Email Diskominfo Konawe"><span class="material-symbols-outlined">mail</span></a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-12">
            <div class="flex flex-col gap-4">
                <span class="font-label-bold text-label-bold text-primary">Tautan Resmi</span>
                <a class="text-on-surface-variant hover:text-primary transition-colors text-body-md" href="{{ route('visitor.news') }}">Berita & Pengumuman</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors text-body-md" href="{{ route('visitor.videos') }}">Video Kemerdekaan</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors text-body-md" href="{{ route('visitor.live_streamings') }}">Live Streaming</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors text-body-md" href="https://logohutri.istanapresiden.go.id/81" target="_blank" rel="noopener">Logo Resmi HUT RI ke-81</a>
                @if ($registrationSetting->shouldShowRegistrationMenu())
                    <a class="text-on-surface-variant hover:text-primary transition-colors text-body-md" href="{{ route('visitor.registration.create') }}">Pendaftaran Lomba</a>
                @endif
            </div>
            <div class="flex flex-col gap-4">
                <span class="font-label-bold text-label-bold text-primary">Kantor</span>
                <p class="text-on-surface-variant text-body-md">Jl. Inolobunggadue No. 1, Unaaha, Konawe, Sulawesi Tenggara</p>
            </div>
        </div>
    </div>
    <div class="max-w-container-max mx-auto mt-12 pt-8 border-t border-outline-variant/30 text-center md:text-left">
        <p class="text-body-md font-body-md text-on-surface-variant opacity-80">
            &copy; 2026 Pemerintah Kabupaten Konawe. Dirgahayu Republik Indonesia ke-81.
        </p>
    </div>
</footer>
@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-share-current-url]').forEach((shareLink) => {
            shareLink.addEventListener('click', async (event) => {
                if (! navigator.share) {
                    return;
                }

                event.preventDefault();
                try {
                    await navigator.share({
                        title: document.title,
                        text: @js($siteSetting->footerTitle()),
                        url: window.location.href,
                    });
                } catch (error) {
                    // User cancelled the native share dialog.
                }
            });
        });
    });
</script>
</body>
</html>
