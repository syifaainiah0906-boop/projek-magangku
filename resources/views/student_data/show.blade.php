@extends('layouts.app')

@section('title', 'Detail Mahasiswa - SIBAHAS')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Profil Mahasiswa</h1>
            <p class="text-gray-500 mt-2 text-sm">Informasi lengkap mengenai data mahasiswa.</p>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">

            {{-- Left Panel: Profile Picture & Basic Info --}}
            <div class="md:col-span-1 flex flex-col items-center text-center">
                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4 border-4 border-white shadow-md">
                    {{-- Placeholder Icon --}}
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">{{ $mahasiswa->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $mahasiswa->email }}</p>
            </div>

            {{-- Right Panel: Detailed Info --}}
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
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $mahasiswa->angkatan ?? ('20' . substr($mahasiswa->nim, 0, 2)) }}
                            </dd>
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

        {{-- Tombol Aksi --}}
        <div class="mt-12 pt-6 border-t border-gray-200 flex justify-center gap-4">

            {{-- Tombol Kembali --}}
            <a href="{{ route('student_data.index') }}"
                class="inline-flex items-center justify-center px-6 py-2
                       bg-gray-100 text-gray-700 rounded-full border border-gray-300
                       hover:bg-gray-200 transition font-medium text-sm shadow-sm">
               ← Kembali
            </a>

            @if(auth()->user()->role === 'admin')

                {{-- Tombol Edit --}}
                <a href="{{ route('student_data.edit', $mahasiswa->id) }}"
                    class="inline-flex items-center justify-center px-6 py-2 
                           bg-blue-600 text-white rounded-full hover:bg-blue-700 transition 
                           font-medium text-sm shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z">
                        </path>
                    </svg>
                    Edit Data
                </a>

                {{-- Tombol Hapus --}}
                <form action="{{ route('student_data.destroy', $mahasiswa->id) }}" 
                      method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2 
                               bg-red-600 text-white rounded-full hover:bg-red-700 transition 
                               font-medium text-sm shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>

            @endif

        </div>

    </div>
</div>
@endsection
