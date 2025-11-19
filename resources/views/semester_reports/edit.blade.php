@extends('layouts.app')

@section('title', 'Edit Laporan Semester')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Edit Laporan Semester</h1>
            <p class="text-gray-500 mt-2 text-sm">Perbarui informasi laporan semester di bawah ini.</p>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-lg text-red-800">
                <strong class="font-bold">Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('semester_reports.update', $semesterReport->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                {{-- Semester --}}
                <div class="md:col-span-2">
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <input type="text" name="semester" id="semester" value="{{ old('semester', $semesterReport->semester) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>
                
                {{-- IP --}}
                <div>
                    <label for="ip" class="block text-sm font-medium text-gray-700">Indeks Prestasi (IP)</label>
                    <input type="number" step="0.01" name="ip" id="ip" value="{{ old('ip', $semesterReport->ip) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>

                {{-- IPK --}}
                <div>
                    <label for="ipk" class="block text-sm font-medium text-gray-700">Indeks Prestasi Kumulatif (IPK)</label>
                    <input type="number" step="0.01" name="ipk" id="ipk" value="{{ old('ipk', $semesterReport->ipk) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>

            </div>{{-- Unggah Foto --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto KHS</label>
                {{-- Pratinjau Foto Saat Ini --}}
                @if($semesterReport->khs_file_path)
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                        <img src="{{ Storage::url($semesterReport->khs_file_path) }}" alt="Foto saat ini" class="max-h-48 rounded-md border shadow-sm">
                    </div>
                @endif

                <label for="khs" class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto (Opsional)</label>
                <input
                    type="file"
                    name="khs"
                    id="khs"
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4 file:rounded-md
                        file:border-0 file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                @error('khs')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

            {{-- Tombol Aksi --}}
<div class="mt-10 pt-6 border-t border-gray-200 flex justify-end gap-4">

    {{-- Tombol Batal --}}
    <a href="{{ route('semester_reports.show', $semesterReport->id) }}"
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
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
            </path>
        </svg>
        Simpan Perubahan
    </button>
</div>
            </div>
        </form>
    </div>
</div>
@endsection
