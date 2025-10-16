
@extends('layouts.app')

@section('title', 'Detail Mahasiswa - SIBAHAS')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Detail Mahasiswa</h1>
            <p class="text-gray-500 mt-2 text-sm">Informasi lengkap data mahasiswa</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-100 rounded">
                <ul class="text-sm text-red-700">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form (bisa di-edit oleh admin) --}}
        <form method="POST" action="{{ route('student_data.update', $mahasiswa->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6 text-gray-800">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
                        <label class="text-sm text-gray-500">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $mahasiswa->name) }}"
                            class="mt-1 w-full bg-transparent focus:outline-none @if(auth()->user()->role !== 'admin') cursor-not-allowed @endif"
                            @if(auth()->user()->role !== 'admin') disabled @else required maxlength="100" @endif>
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
                        <label class="text-sm text-gray-500">NIM</label>
                        <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}"
                            class="mt-1 w-full bg-transparent focus:outline-none @if(auth()->user()->role !== 'admin') cursor-not-allowed @endif"
                            @if(auth()->user()->role !== 'admin') disabled @else maxlength="20" @endif>
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
                        <label class="text-sm text-gray-500">Program Studi</label>
                        @if(auth()->user()->role === 'admin')
                            <select name="prodi" class="mt-1 w-full">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach ([
                                    'D3 Teknik Otomotif',
                                    'D3 Teknik Informatika',
                                    'D3 Budidaya Tanaman Perkebunan',
                                    'D4 Bisnis Digital',
                                    'D4 Akuntansi Bisnis Digital',
                                    'D4 Manajemen Pemasaran Internasional',
                                    'D4 Teknologi Rekayasa Multimedia',
                                ] as $p)
                                    <option value="{{ $p }}" {{ old('prodi', $mahasiswa->prodi) === $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        @else
                            <p class="font-semibold text-blue-800 text-lg mt-2">{{ $mahasiswa->prodi ?? '-' }}</p>
                        @endif
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
                        <label class="text-sm text-gray-500">Angkatan</label>
                        <input type="text" value="{{ old('angkatan', $mahasiswa->angkatan ?? ( !empty($mahasiswa->nim) ? '20'.substr($mahasiswa->nim,0,2) : '' )) }}"
                            class="mt-1 w-full bg-transparent focus:outline-none" disabled>
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg md:col-span-2">
                        <label class="text-sm text-gray-500">Email</label>
                        <input type="email" name="email" value="{{ old('email', $mahasiswa->email) }}"
                            class="mt-1 w-full bg-transparent focus:outline-none @if(auth()->user()->role !== 'admin') cursor-not-allowed @endif"
                            @if(auth()->user()->role !== 'admin') disabled @else required @endif>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
                <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg">
                    <label class="text-sm text-gray-500">Role</label>
                    <select name="role" class="mt-1 w-full">
                        <option value="user" {{ old('role', $mahasiswa->role) === 'user' ? 'selected' : '' }}>User</option>
                        <option value="alumni" {{ old('role', $mahasiswa->role) === 'alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-10 flex justify-center gap-4">
                <a href="{{ route('student_data.index') }}"
                    class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition font-medium">
                    ← Kembali
                </a>

                @if(auth()->user()->role === 'admin')
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        ✏️ Simpan Perubahan
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection