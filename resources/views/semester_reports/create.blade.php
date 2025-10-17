@extends('layouts.app')

@section('title', 'Tambah Laporan Semester')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Tambah Laporan Semester</h1>
            <p class="text-gray-500 mt-2 text-sm">Lengkapi formulir di bawah ini untuk mengirimkan laporan semester baru.</p>
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
        <form action="{{ route('semester_reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                {{-- Left Column: User Info (Disabled) --}}
                <div class="space-y-6">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama" value="{{ Auth::user()->name }}" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border-gray-300 rounded-lg shadow-sm cursor-not-allowed text-base">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    </div>
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" id="nim" value="{{ Auth::user()->nim }}" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border-gray-300 rounded-lg shadow-sm cursor-not-allowed text-base">
                    </div>
                    <div>
                        <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                        <input type="text" id="prodi" value="{{ Auth::user()->prodi }}" disabled class="mt-1 block w-full px-4 py-2 bg-gray-100 border-gray-300 rounded-lg shadow-sm cursor-not-allowed text-base">
                    </div>
                </div>

                {{-- Right Column: Report Data --}}
                <div class="space-y-6">
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <input type="text" id="semester" name="semester" placeholder="Contoh: 4" value="{{ old('semester') }}" required class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                    </div>
                    <div>
                        <label for="ip" class="block text-sm font-medium text-gray-700">Indeks Prestasi (IP)</label>
                        <input type="number" step="0.01" id="ip" name="ip" placeholder="Contoh: 3.75" value="{{ old('ip') }}" required class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                    </div>
                    <div>
                        <label for="ipk" class="block text-sm font-medium text-gray-700">Indeks Prestasi Kumulatif (IPK)</label>
                        <input type="number" step="0.01" id="ipk" name="ipk" placeholder="Contoh: 3.80" value="{{ old('ipk') }}" required class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                    </div>
                </div>

                {{-- File KHS --}}
                <div class="md:col-span-2">
                    <label for="khs" class="block text-sm font-medium text-gray-700">Unggah File KHS</label>
                    <input type="file" name="khs" id="khs" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">File PDF, JPG, atau PNG. Maksimal 5MB.</p>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end gap-4">
                <a href="{{ route('semester_reports.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@endpush