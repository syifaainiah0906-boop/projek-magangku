@extends('layouts.app')

@section('title', 'Detail Laporan Kegiatan')

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Detail Laporan Kegiatan</h1>
            <p class="text-gray-500 mt-2 text-sm">Informasi lengkap mengenai laporan kegiatan mahasiswa.</p>
        </div>
        
        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            {{-- Left Panel: Info Mahasiswa --}}
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Mahasiswa</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIM</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->user->nim }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->user->prodi }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Semester</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->semester }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Right Panel: Info Kegiatan --}}
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Detail Kegiatan</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Kegiatan</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->activity_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Kegiatan</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($activityReport->activity_date)->isoFormat('D MMMM YYYY') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Posisi / Peran</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ $activityReport->position }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Uraian Kegiatan --}}
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Uraian Kegiatan</h3>
                <div class="w-full p-4 overflow-hidden rounded-lg shadow-inner border bg-gray-50 text-gray-700 leading-relaxed">
                    {!! nl2br(e($activityReport->description)) !!}
                </div>
            </div>

            {{-- Foto Kegiatan --}}
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Foto Kegiatan</h3>
                <div class="w-full overflow-hidden rounded-lg shadow-md border bg-gray-50">
                    @if ($activityReport->photo_file_path)
                        <a href="{{ Storage::url($activityReport->photo_file_path) }}" target="_blank">
                            <img src="{{ Storage::url($activityReport->photo_file_path) }}" alt="Foto Kegiatan" class="w-full h-auto object-contain max-h-[500px]">
                        </a>
                    @else
                        <div class="flex items-center justify-center w-full h-48 bg-gray-100 text-gray-500">
                            Foto tidak tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-12 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('activity_reports.index') }}" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                ← Kembali ke Daftar
            </a>
            <div class="w-full md:w-auto flex flex-col md:flex-row gap-4">
                <a href="{{ route('activity_reports.download_pdf', $activityReport->id) }}" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download
                </a>
                <a href="{{ route('activity_reports.edit', $activityReport->id) }}" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z"></path></svg>
                    Edit
                </a>
                <form action="{{ route('activity_reports.destroy', $activityReport->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');" class="w-full md:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush