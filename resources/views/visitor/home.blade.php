@extends('layouts.visitor')

@section('title', 'Portal HUT RI Konawe')

@section('content')
<section class="relative h-[540px] md:h-[680px] overflow-hidden flex items-center justify-center">
    <img class="absolute inset-0 w-full h-full object-cover brightness-75" src="{{ $siteSetting->heroBackgroundUrl() }}" alt="Background HUT RI Konawe">
    <div class="relative z-10 w-full max-w-container-max px-gutter text-center flex flex-col items-center">
        <div class="glass-panel p-7 md:p-10 rounded-3xl max-w-2xl animate-float">
            <img class="mx-auto mb-6 h-28 md:h-40 object-contain drop-shadow-2xl" src="{{ $siteSetting->heroLogoUrl() }}" alt="Logo HUT RI 81 Indonesia Berdaulat Adil dan Makmur">
            <h1 class="font-headline text-4xl md:text-5xl leading-tight font-extrabold text-primary mb-4">Indonesia Berdaulat, Adil dan Makmur</h1>
            <p class="text-base md:text-lg leading-relaxed text-secondary max-w-xl mx-auto">Portal informasi HUT RI Konawe untuk berita, lomba, peta acara, video, dan pendaftaran.</p>
        </div>
    </div>
</section>

<div class="max-w-container-max mx-auto -mt-10 relative z-20 px-gutter">
    <div class="glass-panel rounded-3xl p-3 flex justify-center gap-3 flex-wrap">
    <a class="bg-primary-container text-white px-5 py-3 rounded-full hover:scale-105 transition-transform flex items-center gap-2 font-bold" href="{{ route('visitor.news') }}"><span class="material-symbols-outlined">newspaper</span>Berita</a>
    @if ($registrationSetting->isRegistrationOpen())
        <a class="bg-white text-primary px-5 py-3 rounded-full hover:scale-105 transition-transform flex items-center gap-2 font-bold" href="{{ route('visitor.registration.create') }}"><span class="material-symbols-outlined">app_registration</span>Daftar</a>
    @elseif ($registrationSetting->isRegistrationClosed())
        <div class="bg-white text-primary px-5 py-3 rounded-full flex items-center gap-2 font-bold">
            <span class="material-symbols-outlined">info</span>
            {{ $registrationSetting->closedMessage() }}
        </div>
    @endif
    <a class="bg-secondary-container text-secondary px-5 py-3 rounded-full hover:scale-105 transition-transform flex items-center gap-2 font-bold" href="{{ route('visitor.locations') }}"><span class="material-symbols-outlined">map</span>Kegiatan</a>
    <a class="bg-white text-primary px-5 py-3 rounded-full hover:scale-105 transition-transform flex items-center gap-2 font-bold" href="{{ route('visitor.videos') }}"><span class="material-symbols-outlined">play_circle</span>Video</a>
    </div>
</div>

@php
    $bannerSlides = $banners->isNotEmpty()
        ? $banners
        : collect([
            (object) [
                'title' => 'Semarak Kemerdekaan Konawe',
                'description' => 'Rangkaian kegiatan seni, olahraga, dan kebersamaan masyarakat menuju HUT RI ke-81.',
                'media_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBbxkqpb2m7rFOATPP79gh3y3y3APAgQkc-A8-BHbYWyphAIBU1aKFzF_q18ouDuPeFL5rAYR4hhSxMfpcDTdA6eW2midSQqR7JUu_X7XzKiwji1j9fCND0kGgz1iGsRgi7zxT_g1UDf8OhNepuzHsY0xWaMR6y6QaSuno6m3wz86EtLsvzAPjiXjxoSAkPgpQCWCdf9rDQDwmDJIZLV6Brua6veUiWsOvQfyBR_9wnxMvcGB0RFL8NUFt9rbVMABRVcDIaEPIgxmyr',
                'media_type' => 'image',
                'link_url' => null,
            ],
            (object) [
                'title' => 'Jadwal Seni dan Olahraga',
                'description' => 'Pantau agenda lomba, lokasi kegiatan, dan informasi resmi HUT RI Kabupaten Konawe.',
                'media_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBbxkqpb2m7rFOATPP79gh3y3y3APAgQkc-A8-BHbYWyphAIBU1aKFzF_q18ouDuPeFL5rAYR4hhSxMfpcDTdA6eW2midSQqR7JUu_X7XzKiwji1j9fCND0kGgz1iGsRgi7zxT_g1UDf8OhNepuzHsY0xWaMR6y6QaSuno6m3wz86EtLsvzAPjiXjxoSAkPgpQCWCdf9rDQDwmDJIZLV6Brua6veUiWsOvQfyBR_9wnxMvcGB0RFL8NUFt9rbVMABRVcDIaEPIgxmyr',
                'media_type' => 'image',
                'link_url' => route('visitor.competitions'),
            ],
        ]);
@endphp

<section class="pt-28 pb-section-gap px-gutter max-w-container-max mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch lg:min-h-[500px] xl:min-h-[540px]">
        <div class="lg:col-span-3 h-full bg-primary rounded-[1.75rem] p-5 xl:p-6 text-white relative overflow-hidden shadow-2xl flex flex-col justify-between gap-5">
            <span class="material-symbols-outlined absolute -right-12 -top-12 text-[150px] opacity-15">celebration</span>
            <span class="material-symbols-outlined absolute -left-8 bottom-10 text-[100px] opacity-10">flag</span>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/15 border border-white/20 px-3 py-2 text-[11px] font-bold uppercase tracking-wide mb-4">
                    <span class="material-symbols-outlined text-base">timer</span>
                    Hitung Mundur HUT RI
                </div>
                <h2 class="font-headline text-xl xl:text-2xl font-extrabold leading-tight mb-2">Menuju 17 Agustus</h2>
                <p class="text-sm text-white/80 leading-relaxed">Waktu tersisa menuju perayaan HUT RI ke-81 di Konawe.</p>
            </div>

            <div class="relative z-10 my-5 xl:my-6" aria-live="polite">
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="rounded-2xl bg-white/15 border border-white/20 p-3 backdrop-blur-sm">
                        <div class="text-2xl xl:text-3xl font-extrabold tabular-nums" id="days">00</div>
                        <div class="mt-1 text-xs uppercase tracking-wide text-white/75">Hari</div>
                    </div>
                    <div class="rounded-2xl bg-white/15 border border-white/20 p-3 backdrop-blur-sm">
                        <div class="text-2xl xl:text-3xl font-extrabold tabular-nums" id="hours">00</div>
                        <div class="mt-1 text-xs uppercase tracking-wide text-white/75">Jam</div>
                    </div>
                    <div class="rounded-2xl bg-white/15 border border-white/20 p-3 backdrop-blur-sm">
                        <div class="text-2xl xl:text-3xl font-extrabold tabular-nums" id="minutes">00</div>
                        <div class="mt-1 text-xs uppercase tracking-wide text-white/75">Menit</div>
                    </div>
                    <div class="rounded-2xl bg-white text-primary p-3 shadow-xl">
                        <div class="text-2xl xl:text-3xl font-extrabold tabular-nums" id="seconds">00</div>
                        <div class="mt-1 text-xs uppercase tracking-wide text-primary/75">Detik</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex justify-between text-xs font-semibold text-white/75 mb-2">
                        <span>Hari ini</span>
                        <span>17 Agustus 2026</span>
                    </div>
                    <div class="h-2 rounded-full bg-white/20 overflow-hidden">
                        <div class="h-full rounded-full bg-white transition-all duration-500" id="countdown-progress" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <a class="relative z-10 mb-1 inline-flex w-full items-center justify-center gap-2 bg-white text-primary px-4 py-3 rounded-full text-sm font-bold shadow-lg hover:scale-[1.02] transition-transform" href="{{ route('visitor.competitions') }}">
                <span class="material-symbols-outlined">event_note</span>
                Lihat Jadwal Lomba
            </a>
        </div>
        <div class="lg:col-span-9 h-full">
            <div class="relative h-full min-h-[340px] overflow-hidden rounded-[2rem] shadow-2xl aspect-[16/9] lg:aspect-auto bg-gradient-to-br from-primary via-[#72000e] to-black" id="banner-slider">
                @foreach ($bannerSlides as $index => $slide)
                    <article class="banner-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
                        @php
                            $bannerMediaUrl = $slide->playable_media_url ?? $slide->media_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBbxkqpb2m7rFOATPP79gh3y3y3APAgQkc-A8-BHbYWyphAIBU1aKFzF_q18ouDuPeFL5rAYR4hhSxMfpcDTdA6eW2midSQqR7JUu_X7XzKiwji1j9fCND0kGgz1iGsRgi7zxT_g1UDf8OhNepuzHsY0xWaMR6y6QaSuno6m3wz86EtLsvzAPjiXjxoSAkPgpQCWCdf9rDQDwmDJIZLV6Brua6veUiWsOvQfyBR_9wnxMvcGB0RFL8NUFt9rbVMABRVcDIaEPIgxmyr';
                            $googleDriveFileId = $slide->drive_file_id ?? null;
                            $bannerPath = strtolower(parse_url($bannerMediaUrl, PHP_URL_PATH) ?? '');
                            $isBannerVideo = ($slide->media_type ?? 'image') === 'video'
                                || str_ends_with($bannerPath, '.mp4')
                                || str_ends_with($bannerPath, '.webm')
                                || str_ends_with($bannerPath, '.ogg');
                        @endphp
                        @if ($isBannerVideo && $googleDriveFileId)
                            <video class="absolute inset-0 h-full w-full object-contain brightness-90" autoplay muted playsinline preload="auto">
                                <source src="{{ route('visitor.media.google-drive', $googleDriveFileId) }}" type="video/mp4">
                            </video>
                        @elseif ($isBannerVideo)
                            <video class="absolute inset-0 h-full w-full object-contain brightness-90" autoplay muted playsinline preload="auto">
                                <source src="{{ $bannerMediaUrl }}">
                            </video>
                        @else
                            <img class="absolute inset-0 h-full w-full scale-110 object-cover blur-2xl opacity-50" src="{{ $bannerMediaUrl }}" alt="">
                            <img class="absolute inset-0 h-full w-full object-contain brightness-90" src="{{ $bannerMediaUrl }}" alt="{{ $slide->title }}">
                        @endif
                        @if (! empty($slide->title) || ! empty($slide->description) || ! empty($slide->link_url))
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute left-0 right-0 bottom-0 z-10 p-6 md:p-8 text-white">
                                @if (! empty($slide->title))
                                    <h2 class="font-headline text-3xl md:text-5xl font-extrabold leading-tight max-w-3xl">{{ $slide->title }}</h2>
                                @endif
                                @if (! empty($slide->description))
                                    <p class="mt-3 max-w-2xl text-white/85">{{ $slide->description }}</p>
                                @endif
                                @if (! empty($slide->link_url))
                                    <a class="mt-5 inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 font-bold text-primary shadow-lg" href="{{ $slide->link_url }}">
                                        Buka Informasi
                                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </article>
                @endforeach
                <div class="absolute right-6 bottom-6 z-20 flex gap-2">
                    @foreach ($bannerSlides as $index => $slide)
                        <button class="banner-dot h-2.5 rounded-full transition-all {{ $index === 0 ? 'w-8 bg-white' : 'w-2.5 bg-white/50' }}" type="button" aria-label="Tampilkan banner {{ $index + 1 }}" data-slide-target="{{ $index }}"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@php
    $featuredVideo = $videos->firstWhere('is_featured', true) ?? $videos->first();
@endphp

<section class="px-gutter max-w-container-max mx-auto pb-section-gap">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 text-primary px-4 py-2 text-sm font-bold mb-4">
                <span class="material-symbols-outlined text-base">play_circle</span>
                Video Kemerdekaan
            </span>
            <h2 class="font-headline text-3xl md:text-4xl font-extrabold text-primary">Sorotan Semarak HUT RI</h2>
            <p class="text-secondary mt-3 max-w-2xl">Dokumentasi video resmi kegiatan kemerdekaan Kabupaten Konawe.</p>
        </div>
        <a class="inline-flex items-center gap-2 text-primary font-bold" href="{{ route('visitor.videos') }}">
            Lihat Semua Video
            <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>

    <article class="glass-panel rounded-[2rem] overflow-hidden shadow-xl grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-8 relative aspect-video bg-primary">
                @if ($featuredVideo)
                    <iframe class="absolute inset-0 h-full w-full" src="{{ $featuredVideo->embed_url }}" title="{{ $featuredVideo->title }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                @else
                    <img class="absolute inset-0 h-full w-full object-cover brightness-75" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbxkqpb2m7rFOATPP79gh3y3y3APAgQkc-A8-BHbYWyphAIBU1aKFzF_q18ouDuPeFL5rAYR4hhSxMfpcDTdA6eW2midSQqR7JUu_X7XzKiwji1j9fCND0kGgz1iGsRgi7zxT_g1UDf8OhNepuzHsY0xWaMR6y6QaSuno6m3wz86EtLsvzAPjiXjxoSAkPgpQCWCdf9rDQDwmDJIZLV6Brua6veUiWsOvQfyBR_9wnxMvcGB0RFL8NUFt9rbVMABRVcDIaEPIgxmyr" alt="Banner kemerdekaan Konawe">
                    <div class="absolute inset-0 flex items-center justify-center text-center text-white p-8">
                        <div>
                            <span class="material-symbols-outlined text-6xl mb-4">photo_camera</span>
                            <h3 class="font-headline text-3xl font-extrabold">Banner Gambar Kemerdekaan</h3>
                            <p class="mt-3 text-white/85 max-w-xl">Tambahkan video kemerdekaan di panel admin agar area ini otomatis menampilkan video utama.</p>
                        </div>
                    </div>
                @endif
        </div>
        <div class="lg:col-span-4 p-6 md:p-8 flex flex-col justify-center">
                <span class="text-primary font-bold text-sm mb-3">{{ $featuredVideo?->published_at?->translatedFormat('d M Y') ?? 'Media utama' }}</span>
                <h3 class="font-headline text-2xl md:text-3xl font-bold">{{ $featuredVideo?->title ?? 'Dokumentasi HUT RI Kabupaten Konawe' }}</h3>
                <p class="text-on-surface-variant mt-2">{{ $featuredVideo?->description ?? 'Ruang publikasi visual untuk rangkaian kegiatan kemerdekaan, lomba, pengumuman, dan dokumentasi lapangan.' }}</p>
                <a class="mt-6 inline-flex items-center gap-2 text-primary font-bold" href="{{ route('visitor.videos') }}">
                    Buka Galeri Video
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
        </div>
    </article>
</section>

<section class="px-gutter max-w-container-max mx-auto pb-section-gap">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-headline text-3xl font-bold">Kegiatan</h2>
        <a class="text-primary font-semibold" href="{{ route('visitor.locations') }}">Lihat Semua</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($locations as $location)
            <article class="glass-panel rounded-2xl p-5">
                <p class="text-xs font-bold text-primary mb-2 uppercase">{{ $location->type }}</p>
                <h3 class="font-headline text-xl font-bold">{{ $location->name }}</h3>
                <p class="text-on-surface-variant mt-2">{{ Str::limit($location->description, 100) }}</p>
                @if($location->activity_at)
                    <p class="text-sm mt-3 font-semibold text-secondary flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">schedule</span> {{ $location->activity_at->translatedFormat('d F Y H:i') }}</p>
                @endif
                <div class="mt-4 pt-4 border-t border-outline-variant/30 flex justify-between items-center">
                    <button type="button" onclick="openEventModal('activity-modal-{{ $location->id }}')" class="text-primary font-bold text-sm flex items-center gap-1 hover:text-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">info</span> Detail & Peta
                    </button>
                    @if($location->is_registration_open && (!$location->registration_deadline || now()->isBefore($location->registration_deadline)))
                        <a href="{{ route('visitor.activity_registration.create', $location) }}" class="bg-primary hover:bg-primary-container text-white px-4 py-1.5 rounded-full text-xs font-bold transition-colors shadow-sm">Daftar Hadir</a>
                    @endif
                </div>
            </article>
        @empty
            <article class="glass-panel rounded-2xl p-5 md:col-span-3 text-center text-secondary">Data kegiatan belum tersedia.</article>
        @endforelse
    </div>
</section>

<section class="px-gutter max-w-container-max mx-auto pb-section-gap">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-headline text-3xl font-bold">Lomba Kemerdekaan</h2>
        <a class="text-primary font-semibold" href="{{ route('visitor.competitions') }}">Lihat Semua</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($competitions as $competition)
            <article class="glass-panel rounded-2xl p-5 border-t-4 border-primary">
                <span class="px-3 py-1 rounded-full bg-secondary-container text-secondary text-xs font-bold self-start">{{ strtoupper($competition->category) }}</span>
                <h3 class="font-headline text-xl font-bold text-primary mt-3">{{ $competition->name }}</h3>
                <p class="text-on-surface-variant mt-2 text-sm">{{ Str::limit($competition->description, 100) }}</p>
                @if($competition->starts_at)
                    <p class="text-sm mt-3 font-semibold text-secondary flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">event</span> {{ $competition->starts_at->translatedFormat('d F Y H:i') }} WITA</p>
                @endif
                <div class="mt-4 pt-4 border-t border-outline-variant/30 flex justify-between items-center">
                    <button type="button" onclick="openEventModal('competition-modal-{{ $competition->id }}')" class="text-primary font-bold text-sm flex items-center gap-1 hover:text-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">info</span> Detail & Peta
                    </button>
                    @if($competition->is_open && (!$competition->registration_deadline || now()->isBefore($competition->registration_deadline)))
                        <a href="{{ route('visitor.registration.create', ['competition' => $competition->slug]) }}" class="bg-primary hover:bg-primary-container text-white px-4 py-1.5 rounded-full text-xs font-bold transition-colors shadow-sm">Daftar Lomba</a>
                    @endif
                </div>
            </article>
        @empty
            <article class="glass-panel rounded-2xl p-5 md:col-span-3 text-center text-secondary">Data lomba belum tersedia.</article>
        @endforelse
    </div>
</section>

<section class="px-gutter max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 pb-section-gap">
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

<!-- Modals for Activities -->
@foreach($locations as $location)
<div id="activity-modal-{{ $location->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeEventModal('activity-modal-{{ $location->id }}')"></div>
    <div class="relative bg-surface rounded-[2rem] w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between p-6 border-b border-outline-variant/30">
            <h3 class="font-headline text-2xl font-bold text-primary">{{ $location->name }}</h3>
            <button onclick="closeEventModal('activity-modal-{{ $location->id }}')" class="text-on-surface-variant hover:text-primary transition-colors bg-surface-container-high rounded-full w-10 h-10 flex items-center justify-center">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-surface-container-low p-4 rounded-2xl">
                <div>
                    <span class="block text-on-surface-variant font-bold mb-1">Kategori</span>
                    <span class="inline-block px-3 py-1 bg-secondary-container text-secondary font-bold rounded-full text-xs uppercase">{{ $location->type }}</span>
                </div>
                <div>
                    <span class="block text-on-surface-variant font-bold mb-1">Waktu Pelaksanaan</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">schedule</span> {{ $location->activity_at ? $location->activity_at->translatedFormat('d F Y H:i') : 'Menyusul' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-on-surface-variant font-bold mb-1">Alamat / Lokasi</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">location_on</span> {{ $location->address }}</span>
                </div>
                <div class="sm:col-span-2 pt-3 border-t border-outline-variant/30 mt-1">
                    <span class="block text-on-surface-variant font-bold mb-1">Jumlah Pendaftar Hadir</span>
                    <span class="flex items-center gap-1 text-primary font-bold"><span class="material-symbols-outlined text-[18px]">group</span> {{ $location->registrations()->count() }} Orang</span>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-2">Deskripsi</h4>
                <p class="text-on-surface-variant leading-relaxed">{{ $location->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-3">Peta Lokasi</h4>
                <div class="rounded-2xl overflow-hidden aspect-video bg-surface-container-high relative">
                    @if($location->latitude && $location->longitude)
                        <iframe 
                            class="absolute inset-0 w-full h-full border-0" 
                            src="https://maps.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}&t=m&z=15&output=embed&iwloc=near" 
                            allowfullscreen 
                            loading="lazy">
                        </iframe>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl mr-2">map</span> Koordinat tidak tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="p-6 border-t border-outline-variant/30 flex justify-end gap-3 bg-surface-container-lowest">
            <button onclick="closeEventModal('activity-modal-{{ $location->id }}')" class="bg-surface-container-high px-6 py-2.5 rounded-full font-bold">Tutup</button>
            @if($location->is_registration_open && (!$location->registration_deadline || now()->isBefore($location->registration_deadline)))
                <a href="{{ route('visitor.activity_registration.create', $location) }}" class="bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-full font-bold shadow-md transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">edit_document</span> Daftar Hadir
                </a>
            @endif
        </div>
    </div>
</div>
@endforeach

<!-- Modals for Competitions -->
@foreach($competitions as $competition)
<div id="competition-modal-{{ $competition->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeEventModal('competition-modal-{{ $competition->id }}')"></div>
    <div class="relative bg-surface rounded-[2rem] w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between p-6 border-b border-outline-variant/30">
            <h3 class="font-headline text-2xl font-bold text-primary">{{ $competition->name }}</h3>
            <button onclick="closeEventModal('competition-modal-{{ $competition->id }}')" class="text-on-surface-variant hover:text-primary transition-colors bg-surface-container-high rounded-full w-10 h-10 flex items-center justify-center">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-surface-container-low p-4 rounded-2xl">
                <div>
                    <span class="block text-on-surface-variant font-bold mb-1">Kategori</span>
                    <span class="inline-block px-3 py-1 bg-secondary-container text-secondary font-bold rounded-full text-xs uppercase">{{ $competition->category }}</span>
                </div>
                <div>
                    <span class="block text-on-surface-variant font-bold mb-1">Waktu Pelaksanaan</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">event</span> {{ $competition->starts_at ? $competition->starts_at->translatedFormat('d F Y H:i') : 'Menyusul' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-on-surface-variant font-bold mb-1">Alamat / Lokasi</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">location_on</span> {{ $competition->venue }}</span>
                </div>
                @if($competition->registration_deadline)
                <div class="sm:col-span-2 text-red-600">
                    <span class="block font-bold mb-1">Batas Akhir Pendaftaran</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">warning</span> {{ $competition->registration_deadline->translatedFormat('d F Y H:i') }}</span>
                </div>
                @endif
                <div class="sm:col-span-2 pt-3 border-t border-outline-variant/30 mt-1">
                    <span class="block text-on-surface-variant font-bold mb-1">Jumlah Pendaftar Lomba</span>
                    <span class="flex items-center gap-1 text-primary font-bold"><span class="material-symbols-outlined text-[18px]">group</span> {{ $competition->registrations()->count() }} Peserta/Tim</span>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-2">Deskripsi Lomba</h4>
                <p class="text-on-surface-variant leading-relaxed">{{ $competition->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-3">Peta Lokasi</h4>
                <div class="rounded-2xl overflow-hidden aspect-video bg-surface-container-high relative">
                    @if($competition->latitude && $competition->longitude)
                        <iframe 
                            class="absolute inset-0 w-full h-full border-0" 
                            src="https://maps.google.com/maps?q={{ $competition->latitude }},{{ $competition->longitude }}&t=m&z=15&output=embed&iwloc=near" 
                            allowfullscreen 
                            loading="lazy">
                        </iframe>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl mr-2">map</span> Koordinat tidak tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="p-6 border-t border-outline-variant/30 flex justify-end gap-3 bg-surface-container-lowest">
            <button onclick="closeEventModal('competition-modal-{{ $competition->id }}')" class="bg-surface-container-high px-6 py-2.5 rounded-full font-bold">Tutup</button>
            @if($competition->is_open && (!$competition->registration_deadline || now()->isBefore($competition->registration_deadline)))
                <a href="{{ route('visitor.registration.create', ['competition' => $competition->slug]) }}" class="bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-full font-bold shadow-md transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">edit_document</span> Daftar Lomba
                </a>
            @endif
        </div>
    </div>
</div>
@endforeach

<script>
    const countdownStart = new Date('2026-01-01T00:00:00+08:00').getTime();
    const countdownTarget = new Date('2026-08-17T08:00:00+08:00').getTime();

    function updateCountdown() {
        const now = Date.now();
        const gap = Math.max(0, countdownTarget - now);
        const totalDuration = countdownTarget - countdownStart;
        const elapsed = Math.min(Math.max(now - countdownStart, 0), totalDuration);
        const progress = totalDuration > 0 ? (elapsed / totalDuration) * 100 : 100;

        document.getElementById('days').textContent = String(Math.floor(gap / 86400000)).padStart(2, '0');
        document.getElementById('hours').textContent = String(Math.floor((gap % 86400000) / 3600000)).padStart(2, '0');
        document.getElementById('minutes').textContent = String(Math.floor((gap % 3600000) / 60000)).padStart(2, '0');
        document.getElementById('seconds').textContent = String(Math.floor((gap % 60000) / 1000)).padStart(2, '0');
        document.getElementById('countdown-progress').style.width = `${progress}%`;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    const bannerSlides = Array.from(document.querySelectorAll('.banner-slide'));
    const bannerDots = Array.from(document.querySelectorAll('.banner-dot'));
    let activeBanner = 0;
    let bannerTimer = null;

    function clearBannerTimer() {
        if (bannerTimer) {
            clearTimeout(bannerTimer);
            bannerTimer = null;
        }
    }

    function scheduleNextBanner() {
        clearBannerTimer();

        const activeSlide = bannerSlides[activeBanner];
        const activeVideo = activeSlide?.querySelector('video');

        if (activeVideo) {
            activeVideo.onended = () => showBanner(activeBanner + 1);

            if (activeVideo.readyState >= 1) {
                activeVideo.currentTime = 0;
            }

            activeVideo.play().catch(() => {
                bannerTimer = setTimeout(() => showBanner(activeBanner + 1), 8000);
            });

            return;
        }

        bannerTimer = setTimeout(() => showBanner(activeBanner + 1), 5000);
    }

    function showBanner(index) {
        if (bannerSlides.length === 0) {
            return;
        }

        activeBanner = index % bannerSlides.length;
        bannerSlides.forEach((slide, slideIndex) => {
            slide.classList.toggle('opacity-100', slideIndex === activeBanner);
            slide.classList.toggle('opacity-0', slideIndex !== activeBanner);

            const video = slide.querySelector('video');
            if (video && slideIndex !== activeBanner) {
                video.pause();
                video.currentTime = 0;
                video.onended = null;
            }
        });
        bannerDots.forEach((dot, dotIndex) => {
            dot.classList.toggle('w-8', dotIndex === activeBanner);
            dot.classList.toggle('w-2.5', dotIndex !== activeBanner);
            dot.classList.toggle('bg-white', dotIndex === activeBanner);
            dot.classList.toggle('bg-white/50', dotIndex !== activeBanner);
        });

        scheduleNextBanner();
    }

    bannerDots.forEach((dot) => {
        dot.addEventListener('click', () => showBanner(Number(dot.dataset.slideTarget)));
    });
    showBanner(0);

    // Modal Control Functions
    function openEventModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Allow browser to render display:flex before animating opacity/transform
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                const modalContent = modal.children[1];
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            });
            document.body.style.overflow = 'hidden';
        }
    }

    function closeEventModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('opacity-0');
            const modalContent = modal.children[1];
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }, 300); // Matches duration-300
        }
    }
</script>
@endsection
