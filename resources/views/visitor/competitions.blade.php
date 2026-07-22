@extends('layouts.visitor')

@section('title', 'Jadwal Lomba')

@section('content')
@php
    $mapLocations = $competitions->filter(fn($c) => $c->latitude && $c->longitude)->map(function ($competition) {
        return [
            'name' => $competition->name,
            'type' => $competition->category,
            'address' => $competition->venue,
            'latitude' => (float) $competition->latitude,
            'longitude' => (float) $competition->longitude,
            'activity_at' => $competition->starts_at?->translatedFormat('d F Y H:i'),
        ];
    })->values();
@endphp

<section class="max-w-container-max mx-auto px-gutter py-10">
    <h1 class="font-headline text-4xl font-extrabold text-primary mb-3">Jadwal Lomba</h1>
    <p class="text-secondary mb-8">Daftar kegiatan seni, olahraga, dan umum yang dibuka untuk pendaftaran peserta.</p>
    @if ($registrationSetting->isRegistrationClosed())
        <div class="glass-panel rounded-2xl p-5 text-primary font-semibold mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined">info</span>
            {{ $registrationSetting->closedMessage() }}
        </div>
    @endif

    <div class="glass-panel rounded-[2rem] overflow-hidden mb-8">
        <div id="public-locations-map" class="h-[420px] w-full bg-surface-container-low"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($competitions as $competition)
            <article class="glass-panel rounded-[2rem] p-6 flex flex-col h-full">
                <span class="px-3 py-1 rounded-full bg-secondary-container text-secondary text-xs font-bold self-start">{{ strtoupper($competition->category) }}</span>
                <h2 class="font-headline text-2xl font-bold mt-4">{{ $competition->name }}</h2>
                <p class="text-on-surface-variant mt-2 flex-grow">{{ Str::limit($competition->description, 120) }}</p>
                <div class="mt-5 text-sm space-y-2">
                    <p class="flex items-start gap-2"><span class="material-symbols-outlined text-[18px] text-primary mt-0.5">event</span> <span>{{ $competition->getDateText() }}</span></p>
                </div>
                <div class="mt-4 pt-4 border-t border-outline-variant/30 flex justify-between items-center">
                    <button type="button" onclick="openEventModal('competition-modal-{{ $competition->id }}')" class="text-primary font-bold text-sm flex items-center gap-1 hover:text-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">info</span> Detail & Peta
                    </button>
                    <button type="button" onclick="openEventModal('participants-modal-{{ $competition->id }}')" class="text-secondary font-bold text-sm flex items-center gap-1 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">group</span> Daftar Peserta
                    </button>
                </div>
                
                <div class="mt-4">
                    @if ($registrationSetting->isRegistrationOpen() && $competition->is_open && (!$competition->registration_deadline || now()->isBefore($competition->registration_deadline)))
                        <a class="block w-full bg-primary-container text-white text-center rounded-full px-5 py-3 font-bold transition-colors hover:opacity-90" href="{{ route('visitor.registration.competition', $competition) }}">Daftar Sekarang</a>
                    @else
                        <div class="block w-full bg-surface-container-high text-on-surface-variant text-center rounded-full px-5 py-3 font-bold">Pendaftaran Ditutup</div>
                    @endif
                </div>
            </article>
        @endforeach
    </div>

    @if ($competitions->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $competitions->links() }}
        </div>
    @endif
</section>

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
                <div class="sm:col-span-2 space-y-2">
                    <span class="block text-on-surface-variant font-bold mb-1">Waktu Pelaksanaan</span>
                    <span class="flex items-start gap-1">
                        <span class="material-symbols-outlined text-[16px] mt-0.5">event</span> 
                        <span>{{ $competition->getDateText() }}</span>
                    </span>
                    <span class="flex items-start gap-1">
                        <span class="material-symbols-outlined text-[16px] mt-0.5">schedule</span> 
                        <span>{{ $competition->getTimeText() }}</span>
                    </span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-on-surface-variant font-bold mb-1">Alamat / Lokasi</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">location_on</span> {{ $competition->venue }}</span>
                </div>
                <div class="sm:col-span-2 {{ $competition->registration_deadline ? 'text-red-600' : 'text-primary' }}">
                    <span class="block font-bold mb-1">Batas Akhir Pendaftaran</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">{{ $competition->registration_deadline ? 'warning' : 'info' }}</span> {{ $competition->registration_deadline ? $competition->registration_deadline->translatedFormat('d F Y H:i') : 'Tidak dibatasi' }}</span>
                </div>
                <div class="sm:col-span-2 pt-3 border-t border-outline-variant/30 mt-1">
                    <span class="block text-on-surface-variant font-bold mb-1">Jumlah Pendaftar Lomba</span>
                    <span class="flex items-center gap-1 text-primary font-bold"><span class="material-symbols-outlined text-[18px]">group</span> {{ $competition->registrations()->count() }} Peserta/Tim</span>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-2">Deskripsi Lomba</h4>
                <p class="text-on-surface-variant leading-relaxed">{{ $competition->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>

            @if($competition->operators->whereNotNull('phone')->isNotEmpty())
            <div>
                <h4 class="font-bold text-lg mb-3">Kontak Panitia</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($competition->operators->whereNotNull('phone') as $operator)
                        <div class="bg-surface-container-high rounded-xl p-3 flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">support_agent</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-on-surface">{{ $operator->name }}</p>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $operator->phone) }}" target="_blank" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1 mt-0.5"><span class="material-symbols-outlined text-[14px]">chat</span> {{ $operator->phone }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <div>
                <h4 class="font-bold text-lg mb-3">Peta Lokasi</h4>
                <div class="rounded-2xl overflow-hidden aspect-video bg-surface-container-high relative">
                    @if($competition->latitude && $competition->longitude)
                        <div id="map-competition-modal-{{ $competition->id }}" 
                             class="modal-map-container absolute inset-0 w-full h-full"
                             data-lat="{{ $competition->latitude }}"
                             data-lng="{{ $competition->longitude }}">
                        </div>
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
            @if ($registrationSetting->isRegistrationOpen() && $competition->is_open && (!$competition->registration_deadline || now()->isBefore($competition->registration_deadline)))
                <a href="{{ route('visitor.registration.competition', $competition) }}" class="bg-primary hover:bg-primary-container text-white px-6 py-2.5 rounded-full font-bold shadow-md transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">edit_document</span> Daftar Lomba
                </a>
            @endif
        </div>
    </div>
</div>

<div id="participants-modal-{{ $competition->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeEventModal('participants-modal-{{ $competition->id }}')"></div>
    <div class="relative bg-surface rounded-[2rem] w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between p-6 border-b border-outline-variant/30 bg-surface-container-low">
            <h3 class="font-headline text-2xl font-bold text-primary">Daftar Peserta: {{ $competition->name }}</h3>
            <button onclick="closeEventModal('participants-modal-{{ $competition->id }}')" class="text-on-surface-variant hover:text-primary transition-colors bg-white shadow-sm border border-outline-variant/30 rounded-full w-10 h-10 flex items-center justify-center">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-5 custom-scrollbar bg-surface flex-1">
            @php
                $competition->load('registrations.performances');
                $publishedRegistrations = $competition->registrations
                    ->where('status', 'verified');
            @endphp
            @if($publishedRegistrations->isEmpty())
                <div class="bg-surface-container-low p-8 rounded-2xl text-center border border-outline-variant/30">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">group_off</span>
                    <p class="text-on-surface-variant font-semibold">Belum ada daftar peserta yang dipublikasikan untuk lomba ini.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-xl border border-outline-variant/30 bg-white">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-surface-container-high text-on-surface-variant border-b border-outline-variant/30">
                            <tr>
                                <th class="py-3 px-4 font-bold w-20 text-center">No. Urut</th>
                                <th class="py-3 px-4 font-bold">Nama Peserta / Tim</th>
                                <th class="py-3 px-4 font-bold">Asal / Instansi</th>
                                <th class="py-3 px-4 font-bold">Babak</th>
                                <th class="py-3 px-4 font-bold">Status Penampilan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/30">
                            @foreach($publishedRegistrations->sortBy(fn($r) => $r->performances->last()?->order_number ?? 9999) as $reg)
                                @php $latestPerf = $reg->performances->last(); @endphp
                                <tr class="hover:bg-primary/5 transition-colors">
                                    <td class="py-3 px-4 font-semibold text-center text-on-surface-variant">
                                        {{ $latestPerf?->order_number ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 font-bold text-on-surface">
                                        {{ $reg->participant_name }}
                                    </td>
                                    <td class="py-3 px-4 text-on-surface-variant">
                                        {{ $reg->institution ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-on-surface-variant font-semibold">
                                        {{ $latestPerf?->stage ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($latestPerf && $latestPerf->status === 'Sedang Tampil')
                                            <span class="inline-flex items-center gap-1 bg-gradient-to-r from-primary to-[#ff4b4b] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-sm"><span class="material-symbols-outlined text-[14px] animate-pulse">graphic_eq</span> Sedang Tampil</span>
                                        @elseif($latestPerf && $latestPerf->status === 'Selesai')
                                            <span class="inline-flex items-center gap-1 bg-green-100 border border-green-200 text-green-700 text-[11px] font-bold px-3 py-1 rounded-full"><span class="material-symbols-outlined text-[14px]">check_circle</span> Selesai</span>
                                        @elseif($latestPerf)
                                            <span class="inline-flex items-center gap-1 bg-surface-variant text-on-surface-variant text-[11px] font-bold px-3 py-1 rounded-full"><span class="material-symbols-outlined text-[14px]">schedule</span> Menunggu</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-surface-variant text-on-surface-variant text-[11px] font-bold px-3 py-1 rounded-full">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="p-6 border-t border-outline-variant/30 flex justify-end gap-3 bg-surface-container-lowest">
            <button onclick="closeEventModal('participants-modal-{{ $competition->id }}')" class="bg-surface-container-high hover:bg-surface-variant px-6 py-2.5 rounded-full font-bold transition-colors">Tutup</button>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        #public-locations-map {
            width: 100%;
            min-height: 420px;
            position: relative;
            overflow: hidden;
        }
        #public-locations-map .leaflet-pane,
        #public-locations-map .leaflet-tile,
        #public-locations-map .leaflet-marker-icon,
        #public-locations-map .leaflet-marker-shadow,
        #public-locations-map .leaflet-tile-container {
            position: absolute;
            left: 0;
            top: 0;
        }
        #public-locations-map .leaflet-tile {
            max-width: none !important;
            width: 256px !important;
            height: 256px !important;
        }
        #public-locations-map .leaflet-control-container .leaflet-top,
        #public-locations-map .leaflet-control-container .leaflet-bottom {
            position: absolute;
            z-index: 1000;
            pointer-events: none;
        }
        #public-locations-map .leaflet-control-container .leaflet-top {
            top: 0;
        }
        #public-locations-map .leaflet-control-container .leaflet-left {
            left: 0;
        }
        #public-locations-map .leaflet-control-container .leaflet-right {
            right: 0;
        }
        #public-locations-map .leaflet-control-container .leaflet-bottom {
            bottom: 0;
        }
        #public-locations-map .leaflet-control {
            pointer-events: auto;
        }
        #public-locations-map .leaflet-popup-content {
            margin: 12px 14px;
        }
        .independence-marker {
            background: transparent;
            border: 0;
        }
        .independence-marker-pin {
            width: 36px;
            height: 48px;
            position: relative;
            filter: drop-shadow(0 10px 18px rgba(65, 0, 3, .35));
        }
        .independence-marker-pin::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 0;
            width: 34px;
            height: 34px;
            transform: translateX(-50%);
            border-radius: 9999px;
            background: #be0017;
            border: 3px solid #ffffff;
        }
        .independence-marker-pin::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 0;
            transform: translateX(-50%);
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 18px solid #be0017;
        }
        .independence-marker-flag {
            position: absolute;
            left: 50%;
            top: 17px;
            width: 18px;
            height: 13px;
            transform: translate(-50%, -50%);
            border-radius: 2px;
            overflow: hidden;
            box-shadow: 0 0 0 1px rgba(255, 255, 255, .8);
            z-index: 1;
        }
        .independence-marker-flag::before,
        .independence-marker-flag::after {
            content: "";
            display: block;
            height: 50%;
        }
        .independence-marker-flag::before {
            background: #e62129;
        }
        .independence-marker-flag::after {
            background: #ffffff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const locations = @json($mapLocations);
            
            if (locations.length === 0) {
                document.getElementById('public-locations-map').parentElement.style.display = 'none';
                return;
            }

            const defaultCenter = [-3.8549500, 122.0415600];
            const firstLocation = locations[0] ? [locations[0].latitude, locations[0].longitude] : defaultCenter;
            const map = L.map('public-locations-map', {
                center: firstLocation,
                zoom: 14,
                scrollWheelZoom: true,
            });

            const googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Hybrid',
            });

            const googleSatellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Satellite',
            });

            const streetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors',
            });

            googleHybrid.addTo(map);
            L.control.layers({
                'Satelit + Nama Jalan': googleHybrid,
                'Satelit Murni': googleSatellite,
                'Peta Jalan': streetMap,
            }, null, {
                collapsed: true,
            }).addTo(map);

            const bounds = [];
            const independenceIcon = L.divIcon({
                className: 'independence-marker',
                html: '<div class="independence-marker-pin"><span class="independence-marker-flag"></span></div>',
                iconSize: [36, 48],
                iconAnchor: [18, 48],
                popupAnchor: [0, -48],
            });

            locations.forEach((location) => {
                const position = [location.latitude, location.longitude];
                bounds.push(position);
                L.marker(position, {icon: independenceIcon})
                    .addTo(map)
                    .bindPopup(`
                        <strong>${location.name}</strong><br>
                        <span>${location.type.toUpperCase()}</span><br>
                        ${location.address}<br>
                        ${location.activity_at || ''}
                    `);
            });

            if (bounds.length > 1) {
                map.fitBounds(bounds, {padding: [32, 32], maxZoom: 17});
            }

            requestAnimationFrame(() => map.invalidateSize());
            setTimeout(() => map.invalidateSize(), 250);
        });

        const modalMaps = {};

        function openEventModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                
                requestAnimationFrame(() => {
                    modal.classList.remove('opacity-0');
                    const modalContent = modal.children[1];
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                });
                document.body.style.overflow = 'hidden';

                const mapContainerId = 'map-' + modalId;
                const mapContainer = document.getElementById(mapContainerId);
                
                if (mapContainer && !modalMaps[mapContainerId]) {
                    const lat = parseFloat(mapContainer.dataset.lat);
                    const lng = parseFloat(mapContainer.dataset.lng);
                    
                    if (!isNaN(lat) && !isNaN(lng)) {
                        const map = L.map(mapContainerId, {
                            center: [lat, lng],
                            zoom: 16,
                            scrollWheelZoom: false
                        });
                        
                        L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                        }).addTo(map);

                        const independenceIcon = L.divIcon({
                            className: 'independence-marker',
                            html: '<div class="independence-marker-pin"><span class="independence-marker-flag"></span></div>',
                            iconSize: [36, 48],
                            iconAnchor: [18, 48]
                        });
                        
                        L.marker([lat, lng], {icon: independenceIcon}).addTo(map);
                        modalMaps[mapContainerId] = map;
                    }
                }

                if (mapContainer && modalMaps[mapContainerId]) {
                    setTimeout(() => {
                        modalMaps[mapContainerId].invalidateSize();
                    }, 300);
                }
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
                }, 300);
            }
        }
    </script>
@endpush
