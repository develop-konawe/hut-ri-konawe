@extends('layouts.admin')

@section('title', 'Manajemen Lokasi')
@section('heading', 'Manajemen Lokasi Geotag')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-on-surface-variant">Kelola titik lokasi kegiatan seni, olahraga, upacara, dan umum.</p>
    <div class="flex flex-wrap items-center justify-end gap-3 mt-4 md:mt-0">
        <form action="{{ route('admin.locations.index') }}" method="GET" class="w-48 md:w-64">
            <div class="flex items-center w-full bg-white/80 backdrop-blur-md border border-gray-200 rounded-full overflow-hidden shadow-sm p-1 focus-within:ring-2 focus-within:ring-primary/50 focus-within:border-primary">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..." class="w-full bg-transparent text-sm px-4 py-2 rounded-full placeholder:text-gray-500" style="border: none !important; box-shadow: none !important; outline: none !important; background-color: transparent !important;">
                <button type="submit" class="bg-primary text-white w-9 h-9 flex-shrink-0 rounded-full flex items-center justify-center hover:bg-primary-container transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </button>
            </div>
        </form>
        <form id="bulkDeleteForm" action="{{ route('admin.locations.bulk-destroy') }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
        <button type="button" id="bulkDeleteBtn" class="bg-red-100 text-red-700 px-5 py-3 rounded-full font-bold shadow hidden hover:bg-red-600 hover:text-white transition-colors" onclick="submitBulkDelete()">Hapus Terpilih</button>
        <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow whitespace-nowrap" href="{{ route('admin.locations.create') }}">Tambah Lokasi</a>
    </div>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3 pl-6 pr-2 w-12"><input type="checkbox" id="selectAll" class="rounded border-outline-variant/50 text-primary shadow-sm focus:ring-primary w-4 h-4 cursor-pointer"></th>
            <th class="py-3 w-[30%] pr-4">Nama Kegiatan & Lokasi</th>
            <th class="py-3 pr-4">Tipe</th>
            <th class="py-3 whitespace-nowrap">Jadwal</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @foreach ($locations as $location)
            <tr>
                <td class="py-4 pl-6 pr-2"><input type="checkbox" value="{{ $location->id }}" class="row-checkbox rounded border-outline-variant/50 text-primary shadow-sm focus:ring-primary w-4 h-4 cursor-pointer"></td>
                <td class="py-4 pr-4 whitespace-normal break-words">
                    <div class="font-semibold">{{ $location->name }}</div>
                    <div class="text-sm text-on-surface-variant mt-1 flex items-start gap-1">
                        <span class="material-symbols-outlined text-[16px]">location_on</span>
                        <span>{{ $location->address }}</span>
                    </div>
                </td>
                <td class="py-4 pr-4"><span class="px-3 py-1 rounded-full bg-secondary-container text-secondary text-xs font-bold uppercase">{{ $location->type }}</span></td>
                <td class="py-4 whitespace-nowrap">
                    @if($location->activity_at)
                        {{ $location->activity_at->format('d/m/Y H:i') }} WITA
                    @else
                        <span class="text-on-surface-variant italic">Menyusul</span>
                    @endif
                </td>
                <td class="py-4">
                    <div class="flex gap-3 justify-end items-center">
                        @if($location->is_registration_open || $location->registrations()->count() > 0)
                            <a class="inline-flex items-center justify-center bg-secondary-container text-secondary h-9 w-9 rounded-full hover:bg-primary hover:text-white transition-colors relative" title="Pendaftar" href="{{ route('admin.locations.registrations.index', $location) }}">
                                <span class="material-symbols-outlined text-[18px]">group</span>
                                <span class="absolute -top-1 -right-1 bg-primary text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $location->registrations()->count() }}</span>
                            </a>
                        @endif
                        <a class="inline-flex items-center justify-center bg-blue-100 text-blue-700 h-9 w-9 rounded-full hover:bg-blue-600 hover:text-white transition-colors" title="Edit Kegiatan" href="{{ route('admin.locations.edit', ['location' => $location, 'page' => request('page')]) }}">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" onsubmit="return confirm('Hapus lokasi ini?')" class="m-0 p-0 inline-flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center bg-red-100 text-red-700 h-9 w-9 rounded-full hover:bg-red-600 hover:text-white transition-colors" title="Hapus Kegiatan">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-6">{{ $locations->links() }}</div>
</div>

<script>
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    
    function updateBulkDeleteBtn() {
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.innerText = `Hapus Terpilih (${checkedCount})`;
        } else {
            bulkDeleteBtn.classList.add('hidden');
        }
    }

    if(selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => cb.checked = this.checked);
            updateBulkDeleteBtn();
        });
    }

    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length;
            selectAll.checked = allChecked;
            updateBulkDeleteBtn();
        });
    });

    function submitBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (!confirm('Hapus ' + checkedBoxes.length + ' data terpilih?')) return;
        
        const form = document.getElementById('bulkDeleteForm');
        form.querySelectorAll('.dynamic-id').forEach(el => el.remove());
        
        checkedBoxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            input.className = 'dynamic-id';
            form.appendChild(input);
        });
        
        form.submit();
    }
</script>
@endsection
