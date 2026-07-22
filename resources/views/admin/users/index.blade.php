@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('heading', 'Manajemen Pengguna Operator')

@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
    <p class="text-on-surface-variant">Kelola akses superadmin dan operator lomba.</p>
    <a class="bg-primary-container text-white px-5 py-3 rounded-full font-bold shadow hover:bg-primary-container/90 transition-colors" href="{{ route('admin.users.create') }}">Tambah Pengguna</a>
</div>

<div class="glass-panel rounded-[2rem] p-6 overflow-x-auto">
    <table class="w-full text-left">
        <thead class="text-sm text-on-surface-variant">
        <tr>
            <th class="py-3">Nama</th>
            <th class="py-3">Email</th>
            <th class="py-3">Peran (Role)</th>
            <th class="py-3">Akses Lomba</th>
            <th class="py-3"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-variant">
        @foreach ($users as $user)
            <tr>
                <td class="py-4 font-semibold">{{ $user->name }}</td>
                <td class="py-4">{{ $user->email }}</td>
                <td class="py-4">
                    @if($user->role === 'superadmin')
                        <span class="bg-primary text-white text-xs px-2 py-1 rounded">Super Admin</span>
                    @else
                        <span class="bg-surface-variant text-on-surface-variant text-xs px-2 py-1 rounded">Operator</span>
                    @endif
                </td>
                <td class="py-4">
                    @if($user->role === 'superadmin')
                        <span class="text-on-surface-variant italic">Semua Akses</span>
                    @elseif($user->competition)
                        <span class="font-medium">{{ $user->competition->name }}</span>
                    @else
                        <span class="text-red-500 italic">Belum ditentukan</span>
                    @endif
                </td>
                <td class="py-4">
                    <div class="flex gap-3 justify-end items-center">
                        <a class="inline-flex items-center justify-center bg-blue-100 text-blue-700 h-9 w-9 rounded-full hover:bg-blue-600 hover:text-white transition-colors" title="Edit Pengguna" href="{{ route('admin.users.edit', $user) }}">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun pengguna ini?')" class="m-0 p-0 inline-flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center bg-red-100 text-red-700 h-9 w-9 rounded-full hover:bg-red-600 hover:text-white transition-colors" title="Hapus Pengguna">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
