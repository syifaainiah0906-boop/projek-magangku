@extends('layouts.app')

@section('title', 'Edit Laporan Kegiatan')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-10 border border-blue-100">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Edit Laporan Kegiatan</h1>
            <p class="text-gray-500 mt-2 text-sm">Perbarui detail laporan kegiatan Anda.</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('activity_reports.update', $activityReport->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Baris 1: Nama Kegiatan & Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="activity_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan</label>
                    <input type="text" name="activity_name" id="activity_name" value="{{ old('activity_name', $activityReport->activity_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="activity_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kegiatan</label>
                    <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', $activityReport->activity_date) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            {{-- Baris 2: Semester & Posisi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <input type="number" name="semester" id="semester" value="{{ old('semester', $activityReport->semester) }}" placeholder="Contoh: 5" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Posisi / Peran</label>
                    <input type="text" name="position" id="position" value="{{ old('position', $activityReport->position) }}" placeholder="Contoh: Peserta, Panitia, Ketua Pelaksana" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            {{-- Uraian Kegiatan --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Uraian Kegiatan</p>
                <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ old('description', $activityReport->description) }}</textarea>
            </div>

            {{-- Unggah Foto --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Bukti Kegiatan</label>
                {{-- Pratinjau Foto Saat Ini --}}
                @if($activityReport->photo_file_path)
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                        <img src="{{ Storage::url($activityReport->photo_file_path) }}" alt="Foto saat ini" class="max-h-48 rounded-md border shadow-sm">
                    </div>
                @endif
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto (Opsional)</label>
                <input type="file" name="photo" id="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('activity_reports.show', $activityReport->id) }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Update Laporan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection