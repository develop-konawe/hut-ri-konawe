@extends('layouts.admin')

@section('title', $location->exists ? 'Edit Lokasi' : 'Tambah Lokasi')
@section('heading', $location->exists ? 'Edit Lokasi Geotag' : 'Tambah Lokasi Geotag')

@section('content')
<form method="POST" action="{{ $location->exists ? route('admin.locations.update', $location) : route('admin.locations.store') }}" class="glass-panel rounded-[2rem] p-8 max-w-4xl space-y-5">
    @csrf
    @if ($location->exists)
        @method('PUT')
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="font-bold text-sm">Nama Lokasi</label>
            <input name="name" value="{{ old('name', $location->name) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
        </div>
        <div>
            <label class="font-bold text-sm">Tipe Kegiatan</label>
            <select name="type" class="mt-2 w-full rounded-xl border-surface-variant">
                @foreach (['seni' => 'Seni', 'olahraga' => 'Olahraga', 'upacara' => 'Upacara', 'umum' => 'Umum'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('type', $location->type) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Alamat</label>
            <input name="address" value="{{ old('address', $location->address) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
        </div>
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Titik Lokasi Map</label>
            <p class="text-sm text-on-surface-variant mt-1 mb-3">Klik peta atau geser marker untuk mengisi koordinat lokasi kegiatan.</p>
            <div id="location-map" class="h-[420px] rounded-2xl overflow-hidden ring-1 ring-surface-variant bg-surface-container-low"></div>
        </div>
        <div>
            <label class="font-bold text-sm">Latitude</label>
            <input id="latitude" name="latitude" value="{{ old('latitude', $location->latitude) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
        </div>
        <div>
            <label class="font-bold text-sm">Longitude</label>
            <input id="longitude" name="longitude" value="{{ old('longitude', $location->longitude) }}" class="mt-2 w-full rounded-xl border-surface-variant" required>
        </div>
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Waktu Kegiatan</label>
            <input type="datetime-local" name="activity_at" value="{{ old('activity_at', $location->activity_at?->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-xl border-surface-variant">
        </div>
        <div class="md:col-span-2">
            <label class="font-bold text-sm">Deskripsi</label>
            <textarea name="description" rows="4" class="mt-2 w-full rounded-xl border-surface-variant">{{ old('description', $location->description) }}</textarea>
        </div>
    </div>
    @if ($errors->any())
        <div class="rounded-2xl bg-red-50 text-primary p-4">
            {{ $errors->first() }}
        </div>
    @endif
    <div class="flex gap-3">
        <button class="bg-primary-container text-white px-6 py-3 rounded-full font-bold">Simpan</button>
        <a class="bg-surface-container-high px-6 py-3 rounded-full font-bold" href="{{ route('admin.locations.index') }}">Batal</a>
    </div>
</form>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        #location-map {
            width: 100%;
            min-height: 420px;
            position: relative;
            overflow: hidden;
        }
        #location-map .leaflet-pane,
        #location-map .leaflet-tile,
        #location-map .leaflet-marker-icon,
        #location-map .leaflet-marker-shadow,
        #location-map .leaflet-tile-container {
            position: absolute;
            left: 0;
            top: 0;
        }
        #location-map .leaflet-tile {
            max-width: none !important;
            width: 256px !important;
            height: 256px !important;
        }
        #location-map .leaflet-control-container .leaflet-top,
        #location-map .leaflet-control-container .leaflet-bottom {
            position: absolute;
            z-index: 1000;
            pointer-events: none;
        }
        #location-map .leaflet-control-container .leaflet-top {
            top: 0;
        }
        #location-map .leaflet-control-container .leaflet-left {
            left: 0;
        }
        #location-map .leaflet-control-container .leaflet-right {
            right: 0;
        }
        #location-map .leaflet-control-container .leaflet-bottom {
            bottom: 0;
        }
        #location-map .leaflet-control {
            pointer-events: auto;
        }
        #location-map .leaflet-control-attribution {
            font-size: 11px;
        }
        #location-map .independence-marker {
            background: transparent;
            border: 0;
        }
        #location-map .independence-marker-pin {
            width: 36px;
            height: 48px;
            position: relative;
            filter: drop-shadow(0 10px 18px rgba(65, 0, 3, .35));
        }
        #location-map .independence-marker-pin::before {
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
        #location-map .independence-marker-pin::after {
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
        #location-map .independence-marker-flag {
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
        #location-map .independence-marker-flag::before,
        #location-map .independence-marker-flag::after {
            content: "";
            display: block;
            height: 50%;
        }
        #location-map .independence-marker-flag::before {
            background: #e62129;
        }
        #location-map .independence-marker-flag::after {
            background: #ffffff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const defaultLatitude = -3.8549500;
            const defaultLongitude = 122.0415600;
            const initialLatitude = parseFloat(latitudeInput.value) || defaultLatitude;
            const initialLongitude = parseFloat(longitudeInput.value) || defaultLongitude;
            const initialPosition = [initialLatitude, initialLongitude];

            const map = L.map('location-map', {
                center: initialPosition,
                zoom: 16,
                scrollWheelZoom: true,
            });

            L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Satellite',
            }).addTo(map);

            const independenceIcon = L.divIcon({
                className: 'independence-marker',
                html: '<div class="independence-marker-pin"><span class="independence-marker-flag"></span></div>',
                iconSize: [36, 48],
                iconAnchor: [18, 48],
                popupAnchor: [0, -48],
            });

            const marker = L.marker(initialPosition, {
                draggable: true,
                icon: independenceIcon,
            }).addTo(map);

            const setCoordinate = (latlng) => {
                const latitude = Number(latlng.lat).toFixed(7);
                const longitude = Number(latlng.lng).toFixed(7);
                latitudeInput.value = latitude;
                longitudeInput.value = longitude;
                marker.setLatLng([latitude, longitude]);
            };

            setCoordinate({lat: initialLatitude, lng: initialLongitude});
            requestAnimationFrame(() => map.invalidateSize());
            setTimeout(() => map.invalidateSize(), 250);

            map.on('click', (event) => setCoordinate(event.latlng));
            marker.on('dragend', (event) => setCoordinate(event.target.getLatLng()));

            latitudeInput.addEventListener('change', () => {
                const lat = parseFloat(latitudeInput.value);
                const lng = parseFloat(longitudeInput.value);

                if (!Number.isNaN(lat) && !Number.isNaN(lng)) {
                    const position = [lat, lng];
                    marker.setLatLng(position);
                    map.setView(position, map.getZoom());
                }
            });

            longitudeInput.addEventListener('change', () => {
                const lat = parseFloat(latitudeInput.value);
                const lng = parseFloat(longitudeInput.value);

                if (!Number.isNaN(lat) && !Number.isNaN(lng)) {
                    const position = [lat, lng];
                    marker.setLatLng(position);
                    map.setView(position, map.getZoom());
                }
            });
        });
    </script>
@endpush
