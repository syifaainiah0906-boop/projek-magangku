@extends('layouts.app')

@section('title', 'Detail Laporan Semester')

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Detail Laporan Semester</h1>
            <p class="text-gray-500 mt-2 text-sm">Informasi lengkap mengenai laporan nilai semester mahasiswa.</p>
        </div>
        
        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            {{-- Left Panel: Info Mahasiswa --}}
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Mahasiswa</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIM</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->user->nim }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->user->prodi }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Right Panel: Info Akademik --}}
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Akademik</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Semester</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->semester }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Indeks Prestasi (IP)</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->ip }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Indeks Prestasi Kumulatif (IPK)</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->ipk }}</dd>
                    </div>
                </dl>
            </div>

            {{-- File KHS --}}
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">File Kartu Hasil Studi (KHS)</h3>
                <div class="w-full p-4 overflow-hidden rounded-lg shadow-inner border bg-gray-50">
                    @if ($semesterReport->khs_file_path)
                        @php
                            $ext = strtolower(pathinfo($semesterReport->khs_file_path, PATHINFO_EXTENSION));
                        @endphp

                        {{-- Jika file berupa gambar --}}
                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ Storage::url($semesterReport->khs_file_path) }}" 
                                 alt="KHS" 
                                 class="w-full max-w-3xl mx-auto rounded-lg shadow-md border border-gray-200">

                        {{-- Jika file berupa PDF --}}
                        @elseif ($ext === 'pdf')
                            <iframe src="{{ Storage::url($semesterReport->khs_file_path) }}" 
                                    class="w-full h-[600px] border border-gray-300 rounded-lg shadow-md"
                                    title="File KHS"></iframe>

                        {{-- Format lain --}}
                        @else
                            <p class="text-gray-600 text-sm italic">Format file tidak dapat ditampilkan langsung. Silakan unduh manual di penyimpanan.</p>
                        @endif
                    @else
                        <div class="flex items-center gap-3 text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium">File KHS tidak ditemukan.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
<div class="mt-12 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">

    {{-- Tombol Kembali --}}
    <a href="{{ route('semester_reports.index') }}"
        class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2 
               bg-gray-100 text-gray-700 rounded-full border border-gray-300
               hover:bg-gray-200 transition font-medium text-sm shadow-sm">
        ← Kembali ke Daftar
    </a>

    <div class="w-full md:w-auto flex flex-col md:flex-row gap-4">

        {{-- Tombol Download --}}
        <a href="{{ route('semester_reports.download_pdf', $semesterReport->id) }}"
            class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2
                   bg-green-600 text-white rounded-full hover:bg-green-700 transition 
                   font-medium text-sm shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download
        </a>

        @if (Auth::user()->role === 'admin')

        {{-- Tombol Edit --}}
        <a href="{{ route('semester_reports.edit', $semesterReport->id) }}"
            class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2
                   bg-blue-600 text-white rounded-full hover:bg-blue-700 transition 
                   font-medium text-sm shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z"/>
            </svg>
            Edit
        </a>

        {{-- Tombol Hapus --}}
        <form action="{{ route('semester_reports.destroy', $semesterReport->id) }}"
            method="POST"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');"
            class="w-full md:w-auto">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full inline-flex items-center justify-center px-6 py-2
                       bg-red-600 text-white rounded-full hover:bg-red-700 transition 
                       font-medium text-sm shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </form>

        @endif
            </div>
        </div>
    </div>
</div>

@endsection
