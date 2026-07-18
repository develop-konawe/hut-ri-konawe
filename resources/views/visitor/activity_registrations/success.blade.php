@extends('layouts.visitor')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<section class="max-w-2xl mx-auto px-gutter py-16 text-center">
    <div class="glass-panel rounded-[2rem] p-10">
        <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-[4rem]">check_circle</span>
        </div>
        
        <h1 class="font-headline text-3xl font-extrabold text-primary mb-4">Pendaftaran Berhasil!</h1>
        
        <p class="text-secondary text-lg mb-8">
            {{ session('status') ?? 'Pendaftaran kehadiran Anda telah berhasil kami terima. Terima kasih atas partisipasi Anda dalam memeriahkan HUT RI ke-81 Kabupaten Konawe.' }}
        </p>

        <a href="{{ route('visitor.home') }}" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-container text-white px-8 py-4 rounded-full font-bold transition-colors">
            <span class="material-symbols-outlined">home</span> Kembali ke Beranda
        </a>
    </div>
</section>
@endsection
