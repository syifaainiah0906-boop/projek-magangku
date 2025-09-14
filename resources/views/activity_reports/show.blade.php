@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-blue-900">Detail Laporan Kegiatan</h2>
            <a href="{{ route('activity_reports.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
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
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">NIM</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->user->nim }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Prodi</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->user->prodi }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Semester</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->semester }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Kegiatan</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Kegiatan</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->activity_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Kegiatan</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($activityReport->activity_date)->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Posisi / Peran</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->position }}</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Uraian Kegiatan</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 leading-relaxed">{{ $activityReport->description }}</p>
                    </div>
                </div>

                <div class="md:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Kegiatan</h3>
                    <div class="w-full h-80 overflow-hidden rounded-lg shadow-md">
                        @if ($activityReport->photo_file_path)
                            <img src="{{ Storage::url($activityReport->photo_file_path) }}" alt="Foto Kegiatan" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center w-full h-full bg-gray-200 text-gray-500">
                                Foto tidak tersedia.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-2 mt-8 flex justify-end space-x-4">
                    <a href="{{ route('activity_reports.edit', $activityReport->id) }}" class="px-6 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Update
                    </a>
                    <form action="{{ route('activity_reports.destroy', $activityReport->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

@endpush