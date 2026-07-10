@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('heading', 'Konawe 81 Portal')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass-panel rounded-[2rem] p-6">
        <span class="material-symbols-outlined text-primary text-4xl">event_available</span>
        <p class="text-on-surface-variant mt-4">Jadwal Lomba</p>
        <h2 class="font-headline text-4xl font-extrabold text-primary">{{ $competitionCount }}</h2>
    </div>
    <div class="glass-panel rounded-[2rem] p-6">
        <span class="material-symbols-outlined text-primary text-4xl">app_registration</span>
        <p class="text-on-surface-variant mt-4">Pendaftaran</p>
        <h2 class="font-headline text-4xl font-extrabold text-primary">{{ $registrationCount }}</h2>
    </div>
    <div class="glass-panel rounded-[2rem] p-6">
        <span class="material-symbols-outlined text-primary text-4xl">map</span>
        <p class="text-on-surface-variant mt-4">Lokasi Geotag</p>
        <h2 class="font-headline text-4xl font-extrabold text-primary">{{ $locationCount }}</h2>
    </div>
</div>

<div class="glass-panel rounded-[2rem] p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-headline text-2xl font-bold">Pendaftaran Terbaru</h2>
        <a class="text-primary font-bold" href="{{ route('admin.competitions.index') }}">Kelola Lomba</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="text-sm text-on-surface-variant">
            <tr>
                <th class="py-3">Peserta</th>
                <th class="py-3">Lomba</th>
                <th class="py-3">Kontak</th>
                <th class="py-3">Status</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-surface-variant">
            @forelse ($latestRegistrations as $registration)
                <tr>
                    <td class="py-4 font-semibold">{{ $registration->participant_name }}</td>
                    <td class="py-4">{{ $registration->competition->name }}</td>
                    <td class="py-4">{{ $registration->phone }}</td>
                    <td class="py-4"><span class="rounded-full bg-secondary-container px-3 py-1 text-sm font-bold">{{ $registration->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-6 text-on-surface-variant">Belum ada pendaftaran masuk.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
