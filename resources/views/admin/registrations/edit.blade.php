@extends('layouts.admin')

@section('title', 'Edit Peserta Lomba')
@section('heading', 'Edit Peserta Lomba')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.registrations.index') }}" class="text-primary font-semibold hover:underline">&larr; Kembali ke Daftar Peserta</a>
</div>

<form action="{{ route('admin.registrations.update', $registration) }}" method="POST" class="glass-panel rounded-[2rem] p-6 md:p-8 max-w-4xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom Kiri: Data Diri -->
        <div class="space-y-5">
            <h3 class="font-headline text-xl font-bold text-primary mb-4 border-b border-primary/20 pb-2">Data Diri Peserta</h3>
            
            <div>
                <label for="participant_name" class="block text-sm font-bold text-on-surface-variant mb-2">Nama Lengkap / Tim <span class="text-primary">*</span></label>
                <input type="text" id="participant_name" name="participant_name" value="{{ old('participant_name', $registration->participant_name) }}" required class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                @error('participant_name') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="identity_number" class="block text-sm font-bold text-on-surface-variant mb-2">NIK (Opsional)</label>
                <input type="text" id="identity_number" name="identity_number" value="{{ old('identity_number', $registration->identity_number) }}" class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                @error('identity_number') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-bold text-on-surface-variant mb-2">Nomor HP/WhatsApp <span class="text-primary">*</span></label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $registration->phone) }}" required class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                @error('phone') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-on-surface-variant mb-2">Email (Opsional)</label>
                <input type="email" id="email" name="email" value="{{ old('email', $registration->email) }}" class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                @error('email') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="institution" class="block text-sm font-bold text-on-surface-variant mb-2">Instansi/Kecamatan/Desa (Opsional)</label>
                <input type="text" id="institution" name="institution" value="{{ old('institution', $registration->institution) }}" class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                @error('institution') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-bold text-on-surface-variant mb-2">Alamat (Opsional)</label>
                <textarea id="address" name="address" rows="3" class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">{{ old('address', $registration->address) }}</textarea>
                @error('address') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Kolom Kanan: Pengaturan Lomba -->
        <div class="space-y-5">
            <h3 class="font-headline text-xl font-bold text-primary mb-4 border-b border-primary/20 pb-2">Status & Lomba</h3>
            
            <div>
                <label for="competition_id" class="block text-sm font-bold text-on-surface-variant mb-2">Lomba <span class="text-primary">*</span></label>
                <select id="competition_id" name="competition_id" required class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                    @foreach ($competitions as $competition)
                        <option value="{{ $competition->id }}" @selected(old('competition_id', $registration->competition_id) == $competition->id)>{{ $competition->name }}</option>
                    @endforeach
                </select>
                @error('competition_id') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-bold text-on-surface-variant mb-2">Status Pendaftaran <span class="text-primary">*</span></label>
                <select id="status" name="status" required class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                    @foreach ($statuses as $status => $label)
                        <option value="{{ $status }}" @selected(old('status', $registration->status) === $status)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant/30 space-y-4">
                <h4 class="font-bold text-on-surface-variant">Publikasi & Babak (Tampil di Web)</h4>
                
                <div>
                    <label for="stage" class="block text-sm font-bold text-on-surface-variant mb-2">Babak Lomba</label>
                    <select id="stage" name="stage" class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                        <option value="">- Tidak ada / Belum ditentukan -</option>
                        @foreach (\App\Models\Registration::stages() as $stage)
                            <option value="{{ $stage }}" @selected(old('stage', $registration->stage) === $stage)>{{ $stage }}</option>
                        @endforeach
                    </select>
                    @error('stage') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="performance_status" class="block text-sm font-bold text-on-surface-variant mb-2">Status Panggilan</label>
                    <select id="performance_status" name="performance_status" required class="w-full rounded-xl border-surface-variant bg-white/80 px-4 py-2.5">
                        @foreach (\App\Models\Registration::performanceStatuses() as $pStatus)
                            <option value="{{ $pStatus }}" @selected(old('performance_status', $registration->performance_status) === $pStatus)>{{ $pStatus }}</option>
                        @endforeach
                    </select>
                    @error('performance_status') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="flex items-center gap-3 pt-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" id="is_published" name="is_published" value="1" @checked(old('is_published', $registration->is_published)) class="w-5 h-5 rounded border-surface-variant text-primary focus:ring-primary">
                    <label for="is_published" class="text-sm font-bold text-on-surface-variant cursor-pointer">
                        Tampilkan peserta ini di halaman publik (Website)
                    </label>
                </div>
                @error('is_published') <p class="text-primary text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-surface-variant">
        <a href="{{ route('admin.registrations.index') }}" class="px-6 py-3 rounded-full font-bold bg-white text-on-surface-variant border border-surface-variant shadow-sm hover:bg-surface-variant transition-colors">Batal</a>
        <button type="submit" class="px-6 py-3 rounded-full font-bold bg-primary text-white shadow hover:bg-primary-container transition-colors">Simpan Perubahan</button>
    </div>
</form>
@endsection
