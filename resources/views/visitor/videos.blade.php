@extends('layouts.visitor')

@section('title', 'Video Kemerdekaan')

@section('content')
<section class="max-w-container-max mx-auto px-gutter py-10">
    <h1 class="font-headline text-4xl font-extrabold text-primary mb-3">Video Kemerdekaan</h1>
    <p class="text-secondary mb-8">Kumpulan video resmi rangkaian HUT RI Kabupaten Konawe.</p>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach ($videos as $video)
            <article class="glass-panel rounded-[2rem] overflow-hidden">
                <div class="aspect-video bg-black">
                    <iframe class="w-full h-full" src="{{ $video->embed_url }}" title="{{ $video->title }}" allowfullscreen></iframe>
                </div>
                <div class="p-6">
                    <h2 class="font-headline text-2xl font-bold">{{ $video->title }}</h2>
                    <p class="text-on-surface-variant mt-2">{{ $video->description }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection
