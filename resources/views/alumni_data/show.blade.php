@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-4xl">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-blue-900">Detail Data Alumni</h2>
            <a href="{{ route('alumni_data.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                Kembali ke Daftar
            </a>
        </div>
        
        <div class="border-t border-gray-200 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Data Alumni</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">NIM</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->user->nim }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Prodi</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->user->prodi }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tahun Lulus</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->graduation_year }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Posisi / Jabatan</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->position }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alamat Pekerjaan</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->work_address }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nomor HP</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->phone_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alamat Sekarang</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->current_address }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status Pekerjaan</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->employment_status }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Perusahaan</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->company_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Bidang Industri</p>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->industry_field }}</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Alumni</h3>
                    <div class="w-full h-80 overflow-hidden rounded-lg shadow-md">
                        @if ($alumniDatum->workplace_photo_path)
                            <img src="{{ Storage::url($alumniDatum->workplace_photo_path) }}" alt="Foto Kegiatan" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center w-full h-full bg-gray-200 text-gray-500">
                                Foto tidak tersedia.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-2 mt-8 flex justify-end space-x-4">
                    <a href="{{ route('alumni_data.edit', $alumniDatum->id) }}" class="px-6 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Edit
                    </a>
                    <form action="{{ route('alumni_data.destroy', $alumniDatum->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700">
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