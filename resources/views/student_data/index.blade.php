@extends('layouts.app')

@section('title', 'Data Mahasiswa - SIBAHAS')

@section('content')
<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">

        {{-- ===== Header Halaman ===== --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Data Mahasiswa</h1>
            <p class="text-gray-500 mt-2 text-sm">
                {{-- Pesan berbeda untuk Admin dan User Biasa --}}
                @if(auth()->user()->role === 'admin')
                    Kelola dan lihat data mahasiswa penerima beasiswa.
                @else
                    Informasi data pribadi Anda.
                @endif
            </p>
        </div>

        {{-- ===== Notifikasi Sukses (Flash Message) ===== --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- ========================================================= --}}
        {{-- =============== TAMPILAN ADMIN ========================== --}}
        {{-- ========================================================= --}}
        @if(auth()->user()->role === 'admin')

            {{-- 🔍 Filter Pencarian Data Mahasiswa --}}
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                <form action="{{ route('student_data.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                        {{-- Kolom Pencarian Nama/NIM --}}
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-700 mb-1 block">Cari Nama / NIM</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Masukkan nama atau NIM..."
                                       class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        {{-- Dropdown Program Studi --}}
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1 block">Program Studi</label>
                            <select name="prodi"
                                class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach ($daftarProdi as $program)
                                    <option value="{{ $program }}" {{ request('prodi') == $program ? 'selected' : '' }}>
                                        {{ $program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dropdown Tahun Angkatan --}}
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1 block">Tahun</label>
                            <select name="tahun"
                                class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach ($daftarTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex space-x-2">

    {{-- Tombol Filter --}}
    <button type="submit"
        class="w-full px-4 py-2 bg-blue-100 text-blue-600 rounded-full 
               text-sm hover:bg-blue-200 transition font-medium">
        Filter
    </button>

    {{-- Tombol Reset --}}
    <a href="{{ route('student_data.index') }}"
        class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full 
               text-sm hover:bg-blue-200 transition font-medium">
        Reset
    </a>

</div>
                    </div>
                </form>
            </div>

            {{-- 📊 TABEL DATA MAHASISWA --}}
            <div class="overflow-x-auto border rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">No</th>
                            <th class="px-6 py-4 text-left font-semibold">Nama</th>
                            <th class="px-6 py-4 text-left font-semibold">NIM</th>
                            <th class="px-6 py-4 text-left font-semibold">Program Studi</th>
                            <th class="px-6 py-4 text-left font-semibold">Angkatan</th>
                            <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($mahasiswas as $index => $mhs)
                            <tr class="hover:bg-blue-50">
                                <td class="px-6 py-4">{{ $loop->iteration + $mahasiswas->firstItem() - 1 }}</td>
                                <td class="px-6 py-4 font-medium">{{ $mhs->name }}</td>
                                <td class="px-6 py-4">{{ $mhs->nim }}</td>
                                <td class="px-6 py-4">{{ $mhs->prodi ?? '-' }}</td>

                                {{-- Hitung angkatan dari 2 digit awal NIM jika angkatan kosong --}}
                                <td class="px-6 py-4">
                                    {{ $mhs->angkatan ?? ($mhs->nim ? '20' . substr($mhs->nim, 0, 2) : '-') }}
                                </td>

                                {{-- Tombol Detail --}}
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('student_data.show', $mhs->id) }}"
                                       class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada data mahasiswa yang cocok.
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

        {{-- ========================================================= --}}
        {{-- =============== TAMPILAN USER BIASA ===================== --}}
        {{-- ========================================================= --}}
        @else
            @php $mhs = auth()->user(); @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-8">

                {{-- Foto User & Info Dasar --}}
                <div class="flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-white shadow-md mb-4">
                        {{-- Placeholder Avatar --}}
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $mhs->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $mhs->email }}</p>
                </div>

                {{-- Detail Informasi Mahasiswa --}}
                <div class="md:col-span-2 border-t md:border-t-0 md:border-l border-gray-200 md:pl-8 pt-6">
                    <dl class="space-y-6">

                        <div>
                            <dt class="text-sm font-medium text-gray-500">NIM</dt>
                            <dd class="mt-1 text-lg font-semibold">{{ $mhs->nim ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                            <dd class="mt-1 text-lg font-semibold">{{ $mhs->prodi ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Angkatan</dt>
                            <dd class="mt-1 text-lg font-semibold">
                                {{ $mhs->angkatan ?? ($mhs->nim ? '20' . substr($mhs->nim, 0, 2) : '-') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-3 py-1 text-sm font-medium rounded-full capitalize
                                    @if($mhs->role === 'alumni') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{-- Role disesuaikan untuk user aktif --}}
                                    {{ $mhs->role === 'user' ? 'Mahasiswa Aktif' : $mhs->role }}
                                </span>
                            </dd>
                        </div>

                    </dl>
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
