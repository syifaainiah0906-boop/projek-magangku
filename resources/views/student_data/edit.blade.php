@extends('layouts.app')

@section('title', 'Edit Data Mahasiswa')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Edit Data Mahasiswa</h1>
            <p class="text-gray-500 mt-2 text-sm">Perbarui informasi mahasiswa di bawah ini.</p>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-lg text-red-800">
                <strong class="font-bold">Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('student_data.update', $mahasiswa->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $mahasiswa->name) }}" required maxlength="100" 
                        class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>
                
                {{-- NIM --}}
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" maxlength="20" 
                        class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>
                
                {{-- Program Studi --}}
                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <select id="prodi" name="prodi" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach ([
                            'D3 Teknik Otomotif', 'D3 Teknik Informatika', 'D3 Budidaya Tanaman Perkebunan',
                            'D4 Bisnis Digital', 'D4 Akuntansi Bisnis Digital', 'D4 Manajemen Pemasaran Internasional',
                            'D4 Teknologi Rekayasa Multimedia',
                        ] as $p)
                            <option value="{{ $p }}" {{ old('prodi', $mahasiswa->prodi) === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Angkatan --}}
                <div>
                    <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                    <input type="text" id="angkatan" value="{{ $mahasiswa->angkatan ?? 'Otomatis dari NIM' }}" disabled 
                        class="mt-1 block w-full px-4 py-2 bg-gray-100 border-gray-300 rounded-lg shadow-sm cursor-not-allowed text-base">
                </div>

                {{-- Email --}}
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $mahasiswa->email) }}" required 
                        class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>

                {{-- Role --}}
                <div class="md:col-span-2">
                    <label for="role" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="role" name="role" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                        <option value="user" {{ old('role', $mahasiswa->role) === 'user' ? 'selected' : '' }}>Mahasiswa Aktif</option>
                        <option value="alumni" {{ old('role', $mahasiswa->role) === 'alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                </div>
            </div>
            {{-- Tombol Aksi --}}
<div class="mt-10 pt-6 border-t border-gray-200 flex justify-end gap-4">

    {{-- Tombol Batal --}}
    <a href="{{ route('student_data.show', $mahasiswa->id) }}"
        class="inline-flex items-center justify-center px-6 py-2 
               bg-gray-100 text-gray-700 rounded-full border border-gray-300
               hover:bg-gray-200 transition font-medium text-sm shadow-sm">
        Batal
    </a>

    {{-- Tombol Simpan --}}
    <button type="submit"
        class="inline-flex items-center justify-center px-6 py-2 
               bg-blue-600 text-white rounded-full hover:bg-blue-700 transition 
               font-medium text-sm shadow-md">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
        </svg>
        Simpan Perubahan
    </button>
</div>
        </form>
    </div>
</div>
@endsection