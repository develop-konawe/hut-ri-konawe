@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('heading', 'Edit Pengguna Operator')

@section('content')
<div class="glass-panel rounded-[2rem] p-8 max-w-2xl mx-auto">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2">Nama Pengguna</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-surface-variant/50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition-all" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2">Email Login</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-surface-variant/50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition-all" required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2">Nomor HP / WhatsApp <span class="text-xs text-on-surface-variant font-normal">(Opsional)</span></label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="w-full bg-surface-variant/50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition-all">
            @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2">Password <span class="font-normal text-xs">(Kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" name="password" class="w-full bg-surface-variant/50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition-all">
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2">Ulangi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full bg-surface-variant/50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition-all">
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface-variant mb-2">Peran (Role)</label>
            <select name="role" id="role-select" class="w-full bg-surface-variant/50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition-all" required>
                <option value="operator" {{ old('role', $user->role) === 'operator' ? 'selected' : '' }}>Operator Lomba</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin Konten</option>
                <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
            </select>
            @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div id="competition-wrapper" class="{{ (old('role', $user->role) === 'superadmin' || old('role', $user->role) === 'admin') ? 'hidden' : '' }}">
            <label class="block text-sm font-bold text-on-surface-variant mb-2">Akses Lomba (Untuk Operator)</label>
            <select name="competition_id" id="competition-select" class="w-full bg-surface-variant/50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary outline-none transition-all">
                <option value="">-- Pilih Lomba --</option>
                @foreach($competitions as $competition)
                    <option value="{{ $competition->id }}" {{ old('competition_id', $user->competition_id) == $competition->id ? 'selected' : '' }}>{{ $competition->name }}</option>
                @endforeach
            </select>
            @error('competition_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            <p class="text-xs text-on-surface-variant mt-2">Operator hanya dapat melihat dan mengubah peserta untuk lomba yang dipilih.</p>
        </div>

        <div class="pt-4 flex items-center justify-end gap-4">
            <a href="{{ route('admin.users.index') }}" class="font-bold text-on-surface-variant px-5 py-3">Batal</a>
            <button type="submit" class="bg-primary-container text-white px-8 py-3 rounded-full font-bold shadow hover:bg-primary-container/90 transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('role-select').addEventListener('change', function() {
        const compWrapper = document.getElementById('competition-wrapper');
        const compSelect = document.getElementById('competition-select');
        if (this.value === 'superadmin' || this.value === 'admin') {
            compWrapper.classList.add('hidden');
            compSelect.removeAttribute('required');
            compSelect.value = '';
        } else {
            compWrapper.classList.remove('hidden');
            compSelect.setAttribute('required', 'required');
        }
    });
    // Trigger on load
    document.getElementById('role-select').dispatchEvent(new Event('change'));
</script>
@endsection
