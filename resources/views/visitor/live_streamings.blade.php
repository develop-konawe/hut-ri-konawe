@extends('layouts.visitor')

@section('title', 'Live Streaming')

@section('content')
<section class="max-w-container-max mx-auto px-gutter py-10">
    <div class="mb-8 p-6 glass-panel rounded-[2rem] merah-semangat-gradient text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-3xl font-extrabold flex items-center gap-3">
                <span class="w-3 h-3 bg-white rounded-full animate-ping shadow"></span>
                <span class="material-symbols-outlined text-[2rem]">sensors</span>
                Siaran Langsung
            </h1>
            <p class="text-white/80 mt-2 font-medium">Tonton kegiatan dan lomba kemerdekaan secara langsung.</p>
        </div>
    </div>

    @if($liveStreamings->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($liveStreamings as $live)
                <article class="glass-panel rounded-[2rem] overflow-hidden flex flex-col shadow-sm border border-white/20">
                    <div class="relative w-full aspect-video bg-surface-on">
                        @if($live->youtube_id)
                            <iframe 
                                class="absolute inset-0 w-full h-full" 
                                src="https://www.youtube.com/embed/{{ $live->youtube_id }}?autoplay=0" 
                                title="YouTube video player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-on-surface-variant flex-col">
                                <span class="material-symbols-outlined text-4xl mb-2">videocam_off</span>
                                <p>Video tidak tersedia</p>
                            </div>
                        @endif
                        
                        <div class="absolute top-4 left-4 z-10 flex items-center gap-2 bg-primary text-white px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow">
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                            Live
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h2 class="font-headline text-2xl font-bold text-on-surface mb-3">{{ $live->title }}</h2>
                        <div class="mt-auto flex items-center justify-between border-t border-surface-variant pt-4">
                            <span class="text-sm font-medium text-on-surface-variant flex items-center gap-2">
                                <span class="material-symbols-outlined text-[1.2rem]">schedule</span> Dimulai {{ $live->created_at->diffForHumans() }}
                            </span>
                            <a href="{{ $live->youtube_url }}" target="_blank" class="text-sm font-bold text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                Tonton di YouTube <span class="material-symbols-outlined text-[1rem]">open_in_new</span>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="glass-panel rounded-[2rem] p-12 text-center max-w-2xl mx-auto flex flex-col items-center">
            <div class="w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-[3rem] text-on-surface-variant">videocam_off</span>
            </div>
            <h3 class="font-headline text-2xl font-bold mb-3">Belum Ada Siaran Langsung</h3>
            <p class="text-on-surface-variant mb-6">Saat ini tidak ada kegiatan kemerdekaan yang sedang disiarkan. Silakan kembali lagi nanti sesuai dengan jadwal.</p>
            <a href="{{ route('visitor.competitions') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white px-6 py-3 rounded-full font-bold transition-colors">
                <span class="material-symbols-outlined">event_available</span>
                Lihat Jadwal Lomba
            </a>
        </div>
    @endif
</section>
@endsection
