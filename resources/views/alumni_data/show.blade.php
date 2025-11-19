@extends('layouts.app')

@section('title', 'Detail Alumni - SIBAHAS')

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Profil Alumni</h1>
            <p class="text-gray-500 mt-2 text-sm">Informasi lengkap mengenai data alumni.</p>
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
                {{-- Name and Email are commented out for brevity based on the image, but kept for a complete template --}}
                {{-- <h2 class="text-xl font-bold text-gray-800">{{ $alumniDatum->user->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $alumniDatum->user->email }}</p> --}}
                <div class="mt-4 text-left space-y-3 text-sm w-full bg-blue-50 p-4 rounded-xl border border-blue-200">
                    <p class="flex justify-between items-center"><strong class="text-gray-600">NIM:</strong> <span class="text-gray-900 font-semibold">{{ $alumniDatum->user->nim ?? '-' }}</span></p>
                    <p class="flex justify-between items-center"><strong class="text-gray-600">Prodi:</strong> <span class="text-gray-900 font-semibold">{{ $alumniDatum->user->prodi ?? '-' }}</span></p>
                    @php
    // Ambil dua digit pertama dari NIM (misalnya 21 -> 2021)
    $tahunMasuk = null;
    $tahunLulus = null;

    if (!empty($alumniDatum->user->nim)) {
        $nim = $alumniDatum->user->nim;
        $duaDigit = substr($nim, 0, 2);
        $tahunMasuk = 2000 + intval($duaDigit);

        // Tentukan lama studi berdasarkan prodi
        $lamaStudi = 0;
        if (str_contains($alumniDatum->user->prodi, 'D3')) {
            $lamaStudi = 3;
        } elseif (str_contains($alumniDatum->user->prodi, 'D4')) {
            $lamaStudi = 4;
        }

        // Hitung tahun lulus
        if ($lamaStudi > 0) {
            $tahunLulus = $tahunMasuk + $lamaStudi;
        }
    }
@endphp

<p class="flex justify-between items-center">
    <strong class="text-gray-600">Lulus:</strong> 
    <span class="text-gray-900 font-semibold">
        {{ $tahunLulus ?? '-' }}
    </span>
</p>

                </div>
            </div>

            {{-- Right Panel: Detailed Info --}}
            <div class="md:col-span-2">
                <div class="border-t md:border-t-0 md:border-l border-gray-200 md:pl-8 pt-6 md:pt-0">

                    {{-- 1. Contact & Status Information --}}
                    <h3 class="text-xl font-bold text-blue-700 mb-4 border-b pb-2">Informasi Kontak & Status</h3>
                    <dl class="space-y-4 mb-8">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status Pekerjaan</dt>
                            <dd class="mt-1 text-lg font-bold text-gray-900">{{ $alumniDatum->employment_status ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nomor HP</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->phone_number ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat Sekarang</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->current_address ?? '-' }}</dd>
                        </div>
                    </dl>

                    {{-- 2. Job Details (Conditional) --}}
                    @if($alumniDatum->employment_status !== 'Belum Bekerja')
                        <h3 class="text-xl font-bold text-blue-700 mb-4 border-b pb-2">Detail Pekerjaan</h3>
                        <dl class="space-y-4 mb-8">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Perusahaan & Posisi</dt>
                                <dd class="mt-1 text-base font-semibold text-gray-900">
                                    {{ $alumniDatum->company_name ?? '-' }} -
                                    <span class="font-normal">{{ $alumniDatum->position ?? '-' }}</span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Bidang Industri</dt>
                                <dd class="mt-1 text-base font-semibold text-gray-900">{{ $alumniDatum->industry_field ?? '-' }}</dd>
                            </div>
                        </dl>

                        {{-- 3. Workplace Photo (Conditional) --}}
                        <h3 class="text-xl font-bold text-blue-700 mb-4 border-b pb-2">Foto Tempat Kerja</h3>
                        <div class="w-full h-72 overflow-hidden rounded-xl shadow-lg border border-gray-200">
                            @if ($alumniDatum->workplace_photo_path)
                                <img src="{{ Storage::url($alumniDatum->workplace_photo_path) }}" alt="Foto Pekerjaan" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center w-full h-full bg-gray-100 text-gray-500 font-medium">
                                    Foto tempat kerja tidak tersedia.
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
<div class="mt-12 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-end items-center gap-4">

    {{-- Tombol Kembali --}}
    <a href="{{ route('alumni_data.index', ['tahun' => $alumniDatum->graduation_year]) }}"
        class="order-first md:order-none w-full md:w-auto inline-flex justify-center items-center px-6 py-2 
               bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition font-medium text-sm 
               border border-gray-300 shadow-sm">
        ← Kembali ke Daftar
    </a>

    @if(auth()->user()->role === 'admin')

        {{-- Tombol Edit --}}
        <a href="{{ route('alumni_data.edit', $alumniDatum->id) }}"
            class="w-full md:w-auto inline-flex justify-center items-center px-6 py-2 
                   bg-blue-600 text-white rounded-full hover:bg-blue-700 transition font-medium text-sm 
                   shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z"></path>
            </svg>
            Edit Data
        </a>

        {{-- Tombol Hapus --}}
        <form action="{{ route('alumni_data.destroy', $alumniDatum->id) }}" 
              method="POST" 
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini?');"
              class="w-full md:w-auto">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full inline-flex justify-center items-center px-6 py-2 
                       bg-red-600 text-white rounded-full hover:bg-red-700 transition font-medium text-sm 
                       shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus
            </button>
        </form>

    @endif
</div>
@endsection

@push('scripts')
@endpush