@extends('layouts.visitor')

@section('title', 'Berita dan Pengumuman')

@section('content')
<section class="max-w-container-max mx-auto px-gutter py-10">
    <form class="flex flex-col md:flex-row gap-4 items-center mb-10">
        <div class="relative w-full md:w-1/2">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input class="w-full pl-12 pr-4 py-4 rounded-xl border-none ring-1 ring-outline-variant/50 focus:ring-2 focus:ring-primary bg-surface-container-low" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari berita olahraga atau pengumuman">
        </div>
        <button class="merah-semangat-gradient text-white px-6 py-4 rounded-full font-bold shadow">Cari</button>
        <a class="bg-surface-container-high text-secondary px-6 py-4 rounded-full font-bold" href="{{ route('visitor.news') }}">Reset</a>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8">
            <h1 class="font-headline text-3xl font-bold mb-6">Berita Olahraga Terbaru</h1>
            <div class="space-y-6">
                @forelse ($sportsNews as $item)
                    <article class="glass-panel rounded-2xl overflow-hidden group">
                        <div class="md:flex">
                            <div class="md:w-2/5 h-60 bg-surface-container-high overflow-hidden">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="{{ $item->imageUrl ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBdfGiBlfvZrgIVx6YyiXWFXuKQSb1Rk0zBJ0nZGbwS51eyv0N8XefEaYDv_MjW8zySGXC1UTGo4b_fv9KQbljg3AxCLUmgTH7f00cwmKAcZG2I-m4betBSFYmuI8isN_GPRP6M85FV6tkDEC6ifSG1pADWu-4X8HA6Z381ukDLSRK8tSriG8KtWOjQekx2j3hVs-kgW6iTz-KesDorCQnIvmkbu8QmO0UUjw9rirjlpOeQXT7x09tK--s8aJmA6WQAKhtCVn9k2jx7' }}" alt="{{ $item->title }}">
                            </div>
                            <div class="md:w-3/5 p-6">
                                <p class="text-xs uppercase tracking-widest font-bold text-primary mb-2">{{ $item->category ?? 'sports' }} - {{ $item->publishedAt ?? 'terbaru' }}</p>
                                <h2 class="font-headline text-2xl font-bold mb-3">{{ $item->title }}</h2>
                                <p class="text-on-surface-variant">{{ $item->excerpt }}</p>
                                @if ($item->url)
                                    <a class="inline-flex mt-5 text-primary font-bold" href="{{ $item->url }}" target="_blank" rel="noopener">Baca selengkapnya</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="glass-panel rounded-2xl p-6">Berita olahraga tidak tersedia.</div>
                @endforelse
            </div>
        </div>
        <aside class="lg:col-span-4">
            <h2 class="font-headline text-2xl font-bold mb-6">Pengumuman Resmi</h2>
            <div class="space-y-4">
                @forelse ($announcements as $item)
                    <article class="glass-panel rounded-2xl p-5 border-l-4 border-primary">
                        <p class="text-xs font-bold text-primary mb-2">{{ $item->publishedAt ?? 'terbaru' }}</p>
                        <h3 class="font-headline text-lg font-bold">{{ $item->title }}</h3>
                        <p class="text-sm text-on-surface-variant mt-2">{{ $item->excerpt }}</p>
                    </article>
                @empty
                    <div class="glass-panel rounded-2xl p-5">Pengumuman tidak tersedia.</div>
                @endforelse
            </div>
        </aside>
    </div>
</section>
@endsection
