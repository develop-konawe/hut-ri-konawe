@extends('layouts.visitor')

@section('title', 'Peta Lokasi Kegiatan')

@section('content')
@php
    $mapLocations = $locations->map(function ($location) {
        return [
            'name' => $location->name,
            'type' => $location->type,
            'address' => $location->address,
            'latitude' => (float) $location->latitude,
            'longitude' => (float) $location->longitude,
            'activity_at' => $location->activity_at?->translatedFormat('d F Y H:i'),
        ];
    })->values();
@endphp

<section class="max-w-container-max mx-auto px-gutter py-10">
    <h1 class="font-headline text-4xl font-extrabold text-primary mb-3">Peta Lokasi Kegiatan</h1>
    <p class="text-secondary mb-8">Geotag lokasi kegiatan seni dan olahraga HUT RI Kabupaten Konawe.</p>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-panel rounded-[2rem] overflow-hidden min-h-[520px]">
            <div id="public-locations-map" class="h-[520px] w-full bg-surface-container-low"></div>
        </div>
        <div class="space-y-4">
            @foreach ($locations as $location)
                <article class="glass-panel rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="text-xs font-bold text-primary uppercase">{{ $location->type }}</span>
                            <h2 class="font-headline text-xl font-bold">{{ $location->name }}</h2>
                        </div>
                        <a class="text-primary font-bold text-sm" target="_blank" rel="noopener" href="https://www.google.com/maps?q={{ $location->latitude }},{{ $location->longitude }}">Maps</a>
                    </div>
                    <p class="text-on-surface-variant mt-2">{{ $location->address }}</p>
                    <p class="text-sm mt-2"><span class="material-symbols-outlined text-[16px] align-text-bottom">schedule</span> {{ $location->activity_at?->translatedFormat('d F Y H:i') }}</p>
                    @if($location->registration_deadline)
                        <p class="text-sm mt-1 text-red-600 font-semibold"><span class="material-symbols-outlined text-[16px] align-text-bottom">warning</span> Batas Pendaftaran: {{ $location->registration_deadline->translatedFormat('d F Y H:i') }}</p>
                    @endif
                    <p class="text-sm text-on-surface-variant mt-3">{{ $location->description }}</p>
                    <div class="mt-4 pt-4 border-t border-outline-variant/30 flex justify-between items-center">
                        <span class="flex items-center gap-1 text-primary font-bold text-sm"><span class="material-symbols-outlined text-[18px]">group</span> {{ $location->registrations()->count() }} Hadir</span>
                        @if($location->is_registration_open && (!$location->registration_deadline || now()->isBefore($location->registration_deadline)))
                            <a href="{{ route('visitor.activity_registration.create', $location) }}" class="bg-primary hover:bg-primary-container text-white px-4 py-1.5 rounded-full text-xs font-bold transition-colors shadow-sm">Daftar Hadir</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        #public-locations-map {
            width: 100%;
            min-height: 520px;
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
        #public-locations-map .independence-marker {
            background: transparent;
            border: 0;
        }
        #public-locations-map .independence-marker-pin {
            width: 36px;
            height: 48px;
            position: relative;
            filter: drop-shadow(0 10px 18px rgba(65, 0, 3, .35));
        }
        #public-locations-map .independence-marker-pin::before {
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
        #public-locations-map .independence-marker-pin::after {
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
        #public-locations-map .independence-marker-flag {
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
        #public-locations-map .independence-marker-flag::before,
        #public-locations-map .independence-marker-flag::after {
            content: "";
            display: block;
            height: 50%;
        }
        #public-locations-map .independence-marker-flag::before {
            background: #e62129;
        }
        #public-locations-map .independence-marker-flag::after {
            background: #ffffff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const locations = @json($mapLocations);

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
    </script>
@endpush
