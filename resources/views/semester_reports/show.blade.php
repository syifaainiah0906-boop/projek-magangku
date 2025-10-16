@extends('layouts.app')

@section('title', 'Detail Laporan Semester')

@section('content')

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-blue-900">Detail Laporan Semester</h2>
            <a href="{{ route('semester_reports.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                Kembali ke Daftar
            </a>
        </div>
        
        <div class="border-t border-gray-200 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Mahasiswa</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">NIM</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->user->nim }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Prodi</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->user->prodi }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Akademik</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Semester</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->semester }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">IP</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->ip }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">IPK</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $semesterReport->ipk }}</p>
                        </div>
                    </div>
                </div>

                {{-- Bagian Tampilan KHS (File) --}}
                <div class="md:col-span-2 mt-4 border-t pt-4">
                    <h3 class="font-bold text-lg mb-3 text-blue-800">File Kartu Hasil Studi (KHS)</h3>
                    @if ($semesterReport->khs_file_path)
                        <a href="{{ Storage::url($semesterReport->khs_file_path) }}" 
                            target="_blank" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-150">
                             Lihat File KHS
                        </a>
                    @else
                        <p class="text-red-500">File KHS tidak ditemukan.</p>
                    @endif
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="md:col-span-2 mt-8 flex justify-end space-x-4">
                    
                    <a href="{{ route('semester_reports.download_pdf', $semesterReport->id) }}" class="px-6 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download Laporan Semester
                    </a>

                    <a href="{{ route('semester_reports.edit', $semesterReport->id) }}" class="px-6 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Update
                    </a>
                    
                    <form action="{{ route('semester_reports.destroy', $semesterReport->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-gray-500 rounded-lg hover:bg-gray-600">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush
