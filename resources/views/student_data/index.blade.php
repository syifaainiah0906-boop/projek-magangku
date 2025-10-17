@extends('layouts.app')

@section('title', 'Data Mahasiswa - SIBAHAS')

@section('content')
<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">

        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Data Mahasiswa</h1>
            <p class="text-gray-500 mt-2 text-sm">
                @if(auth()->user()->role === 'admin')
                    Kelola dan lihat data mahasiswa penerima beasiswa.
                @else
                    Informasi data pribadi Anda.
                @endif
            </p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- 🔹 Tampilan untuk ADMIN --}}
        @if(auth()->user()->role === 'admin')
            {{-- Area Filter --}}
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                <form action="{{ route('student_data.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        {{-- Pencarian Nama/NIM --}}
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama / NIM</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Masukkan nama atau NIM..."
                                    class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        {{-- Filter Program Studi --}}
                        <div>
                            <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                            <select name="prodi" id="prodi" class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach ($daftarProdi as $program)
                                    <option value="{{ $program }}" {{ request('prodi') == $program ? 'selected' : '' }}>
                                        {{ $program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Tahun --}}
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <select name="tahun" id="tahun" class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach ($daftarTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex space-x-2">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium text-sm transition">
                                Filter
                            </button>
                            <a href="{{ route('student_data.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 font-medium text-sm transition" title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 4l16 16"></path></svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabel Data Mahasiswa --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Nama</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">NIM</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Program Studi</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Angkatan</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($mahasiswas as $index => $mahasiswa)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">{{ $index + $mahasiswas->firstItem() }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $mahasiswa->name }}</td>
                                <td class="px-6 py-4">{{ $mahasiswa->nim }}</td>
                                <td class="px-6 py-4">{{ $mahasiswa->prodi ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $mahasiswa->angkatan ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('student_data.show', $mahasiswa->id) }}"
                                       class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada data mahasiswa yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $mahasiswas->appends(request()->query())->links() }}
            </div>

        {{-- 🔹 Tampilan untuk USER BIASA --}}
        @else
            @php $mahasiswa = auth()->user(); @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start mt-8">
                {{-- Panel Kiri: Foto & Info Dasar --}}
                <div class="md:col-span-1 flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4 border-4 border-white shadow-md">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $mahasiswa->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $mahasiswa->email }}</p>
                </div>

                {{-- Panel Kanan: Detail Info --}}
                <div class="md:col-span-2">
                    <div class="border-t md:border-t-0 md:border-l border-gray-200 md:pl-8 pt-6 md:pt-0">
                        <dl class="space-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">NIM</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $mahasiswa->nim ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $mahasiswa->prodi ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Angkatan</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $mahasiswa->angkatan ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-3 py-1 text-sm font-medium rounded-full capitalize 
                                        @if($mahasiswa->role === 'alumni') bg-green-100 text-green-800 @else bg-blue-100 text-blue-800 @endif">
                                        {{ $mahasiswa->role === 'user' ? 'Mahasiswa Aktif' : $mahasiswa->role }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
