@extends('layouts.app')

@section('title', 'Data Alumni - SIBAHAS')

@section('content')
<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">

        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Data Alumni</h1>
            <p class="text-gray-500 mt-2 text-sm">
                @if(optional(auth()->user())->role === 'admin')
                    Kelola dan lihat data alumni.
                @else
                    Informasi data alumni Anda.
                @endif
            </p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tampilan Admin --}}
        @if(optional(auth()->user())->role === 'admin')

            {{-- Filter --}}
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                <form action="{{ route('alumni_data.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        {{-- Cari Nama/NIM --}}
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama / NIM</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
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
                                <option value="">Semua Prodi</option>
                                @foreach ($daftarProdi as $program)
                                    <option value="{{ $program }}" {{ request('prodi') == $program ? 'selected' : '' }}>
                                        {{ $program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Tahun Lulus --}}
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
                            <select name="tahun" id="tahun" class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Tahun</option>
                                @foreach ($daftarTahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Filter + Reset --}}
                        <div class="flex space-x-2">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                                Filter
                            </button>

                            <a href="{{ route('alumni_data.index') }}"
                                class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Tabel Data Alumni --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Nama</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">NIM</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Program Studi</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-600">Tahun Lulus</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($alumniDatum as $index => $alumni)
                        @php
                            $user = $alumni->user;
                            $tahunLulus = 'Belum Lulus';

                            if ($user && !empty($user->nim)) {
                                $duaDigit = substr($user->nim, 0, 2);
                                $tahunMasuk = 2000 + intval($duaDigit);

                                $lamaStudi = 0;
                                if (str_contains($user->prodi, 'D3')) $lamaStudi = 3;
                                elseif (str_contains($user->prodi, 'D4')) $lamaStudi = 4;

                                if ($lamaStudi > 0) {
                                    $tahunLulus = $tahunMasuk + $lamaStudi;
                                }
                            }
                        @endphp
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4">{{ $index + $alumniDatum->firstItem() }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $user->nim ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $user->prodi ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $tahunLulus }}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <a href="{{ route('alumni_data.show', $alumni->id) }}"
                                   class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                                    Detail
                                </a>
                                <a href="{{ route('alumni_data.edit', $alumni->id) }}"
                                   class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium hover:bg-yellow-200 transition">
                                    Edit
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
                {{ $alumniDatum->appends(request()->query())->links() }}
            </div>

        {{-- Tampilan Alumni / User --}}
        @else
            @php $mhs = auth()->user(); @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-8">
                {{-- Foto User & Info Dasar --}}
                <div class="flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-white shadow-md mb-4">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $mhs->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $mhs->email }}</p>
                </div>

                {{-- Detail Informasi Alumni --}}
                <div class="md:col-span-2 border-t md:border-t-0 md:border-l border-gray-200 md:pl-8 pt-6 flex flex-col justify-between">
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
                            <dt class="text-sm font-medium text-gray-500">Tahun Lulus</dt>
                            <dd class="mt-1 text-lg font-semibold">
                                @php
                                    $angkatan = $mhs->angkatan ?? ($mhs->nim ? '20' . substr($mhs->nim, 0, 2) : null);
                                    $inkapProdi = strtolower($mhs->prodi ?? '');

                                    if ($angkatan) {
                                        if (str_contains($inkapProdi, 'd3')) {
                                            $tahun_lulus = (int)$angkatan + 3;
                                        } elseif (str_contains($inkapProdi, 'd4')) {
                                            $tahun_lulus = (int)$angkatan + 4;
                                        } else {
                                            $tahun_lulus = '-';
                                        }
                                    } else {
                                        $tahun_lulus = '-';
                                    }
                                @endphp

                                {{ $tahun_lulus ?? '-' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 flex flex-col gap-2">
                                <span class="px-3 py-1 text-sm font-medium rounded-full capitalize
                                    @if($mhs->role === 'alumni') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $mhs->role === 'user' ? 'Mahasiswa Aktif' : $mhs->role }}
                                </span>
                            </dd>
                        </div>
                    </dl>

                    {{-- Tombol Aksi Alumni --}}
                    <div class="mt-4 flex gap-2">
                        {{-- Edit Data --}}
                        <a href="{{ route('alumni_data.edit', $alumniDatum->id) }}"
                           class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 text-sm">
                            Edit Data
                        </a>

                        {{-- Tambah Testimoni --}}
                        @if(optional(auth()->user())->role === 'alumni' || optional(auth()->user())->role === 'user')
                        <button id="btnTestimoni" class="px-4 py-2 bg-green-100 text-green-700 rounded hover:bg-green-200 text-sm">
                            Tambah Testimoni
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Form Testimoni Alumni --}}
            @if(optional(auth()->user())->role === 'alumni' || optional(auth()->user())->role === 'user')
            <div class="mt-4">
                <form id="formTestimoni" class="hidden" action="{{ route('testimoni.store') }}" method="POST">
                    @csrf
                    <textarea name="isi_testimoni" rows="3" placeholder="Tulis testimoni..." class="w-full p-3 border rounded-md">{{ old('isi_testimoni') }}</textarea>
                    @error('pesan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="flex space-x-2 mt-2">
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                            Kirim
                        </button>
                        <button type="button" id="batalTestimoni" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Script tombol Tambah Testimoni --}}
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnTestimoni = document.getElementById('btnTestimoni');
                const formTestimoni = document.getElementById('formTestimoni');
                const batalTestimoni = document.getElementById('batalTestimoni');

                if(btnTestimoni && formTestimoni && batalTestimoni) {
                    btnTestimoni.addEventListener('click', () => {
                        formTestimoni.classList.remove('hidden');
                        btnTestimoni.disabled = true;
                    });

                    batalTestimoni.addEventListener('click', () => {
                        formTestimoni.classList.add('hidden');
                        btnTestimoni.disabled = false;
                    });
                }
            });
            </script>
        @endif
    </div>
</div>
@endsection
