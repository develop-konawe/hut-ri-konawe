@extends('layouts.admin')

@section('title', 'Manajemen Lomba')
@section('heading', 'Manajemen Lomba & Pendaftaran')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Kelola jadwal lomba seni, olahraga, dan pendaftaran peserta.</p>
    <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow" href="{{ route('admin.competitions.create') }}">Buat Lomba</a>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3 w-[25%] pr-4">Nama Lomba & Lokasi</th>
            <th class="py-3">Kategori</th>
            <th class="py-3 whitespace-nowrap">Hari/Tanggal</th>
            <th class="py-3 whitespace-nowrap">Waktu</th>
            <th class="py-3">Peserta</th>
            <th class="py-3">Status</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @foreach ($competitions as $competition)
            <tr>
                <td class="py-4 pr-4 whitespace-normal break-words">
                    <div class="font-semibold">{{ $competition->name }}</div>
                    <div class="text-sm text-on-surface-variant mt-1 flex items-start gap-1">
                        <span class="material-symbols-outlined text-[16px]">location_on</span>
                        <span>{{ $competition->venue }}</span>
                    </div>
                </td>
                <td class="py-4"><span class="px-3 py-1 rounded-full bg-secondary-container text-secondary text-xs font-bold uppercase">{{ $competition->category }}</span></td>
                <td class="py-4 whitespace-nowrap">{{ $competition->getAdminDateText() }}</td>
                <td class="py-4 whitespace-nowrap">{{ $competition->getAdminTimeText() }}</td>
                <td class="py-4">
                    <a class="font-bold text-primary" href="{{ route('admin.registrations.index', ['competition_id' => $competition->id]) }}">
                        {{ $competition->registrations_count }}
                    </a>
                </td>
                <td class="py-4">
                    <select class="status-select bg-surface-variant border-0 rounded-lg px-3 py-1 text-sm font-semibold focus:ring-2 focus:ring-primary outline-none cursor-pointer {{ $competition->is_open ? 'text-green-600' : 'text-red-600' }}" data-url="{{ route('admin.competitions.status', $competition) }}">
                        <option value="1" {{ $competition->is_open ? 'selected' : '' }} class="text-green-600">Dibuka</option>
                        <option value="0" {{ !$competition->is_open ? 'selected' : '' }} class="text-red-600">Ditutup</option>
                    </select>
                </td>
                <td class="py-4">
                    <div class="flex gap-3 justify-end items-center">
                        <a class="inline-flex items-center justify-center bg-blue-100 text-blue-700 h-9 w-9 rounded-full hover:bg-blue-600 hover:text-white transition-colors" title="Edit Lomba" href="{{ route('admin.competitions.edit', ['competition' => $competition, 'page' => request('page')]) }}">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.competitions.destroy', $competition) }}" onsubmit="return confirm('Hapus lomba ini?')" class="m-0 p-0 inline-flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center bg-red-100 text-red-700 h-9 w-9 rounded-full hover:bg-red-600 hover:text-white transition-colors" title="Hapus Lomba">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-6">{{ $competitions->links() }}</div>
</div>

<script>
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', async function() {
            const url = this.dataset.url;
            const isOpen = this.value;
            const originalValue = this.value === '1' ? '0' : '1';
            
            try {
                this.disabled = true;
                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ is_open: isOpen })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    if (isOpen === '1') {
                        this.classList.replace('text-red-600', 'text-green-600');
                    } else {
                        this.classList.replace('text-green-600', 'text-red-600');
                    }
                    // Optional: show a small toast notification here
                } else {
                    alert(data.message || 'Terjadi kesalahan saat memperbarui status.');
                    this.value = originalValue;
                }
            } catch (error) {
                alert('Gagal menghubungi server.');
                this.value = originalValue;
            } finally {
                this.disabled = false;
            }
        });
    });
</script>
@endsection
