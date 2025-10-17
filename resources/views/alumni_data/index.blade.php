@extends('layouts.app')

@section('title', 'Data Alumni - SIBAHAS')

@section('content')

<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">
        <h3 class="text-xl font-bold text-gray-800 mb-6 text-center tracking-wider">
            ALUMNI DATA 
        </h3>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Baris Pencarian dan Tombol (Disesuaikan agar lebih rapat dan sesuai) --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 space-y-4 md:space-y-0">
            
            {{-- BLOK 1: Search Bar (Gabungan Input Nama dan Tombol Search) --}}
            {{-- Ini adalah blok lebar yang menggabungkan input nama dan tombol search --}}
            <form action="{{ route('alumni_data.index') }}" method="GET" class="w-2/3 flex items-center bg-blue-500 rounded-full overflow-hidden shadow-lg">
                {{-- Input Pencarian Nama --}}
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama alumni..." 
                    class="w-full py-3 px-6 text-white bg-blue-600 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                {{-- Tombol Search/Submit --}}
                <button type="submit" class="px-6 py-3 bg-yellow-400 text-blue-900 hover:bg-yellow-500 transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
            
            {{-- Tombol Tambah Data --}}
            @if (Auth::user()->role === 'admin')
                
            @endif
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50"> 
                    <tr>
                        <th scope="col" class="py-3 px-6">No</th>
                        <th scope="col" class="py-3 px-6">NIM</th>
                        <th scope="col" class="py-3 px-6">Nama</th>
                        <th scope="col" class="py-3 px-6">Prodi</th>
                        <th scope="col" class="py-3 px-6">Tahun Lulus</th>
                        <th scope="col" class="py-3 px-6">Status Pekerjaan</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alumnis as $alumni)
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                {{ $alumnis->firstItem() + $loop->index }}
                            </td>
                            <td class="py-4 px-6">{{ $alumni->user->nim ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $alumni->user->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $alumni->user->prodi ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $alumni->graduation_year ?? '-' }}</td>
                            <td class="py-4 px-6">{{ $alumni->employment_status ?? '-' }}</td>
                            
                            {{-- KOLOM AKSI: Menghilangkan tombol Edit --}}
                            <td class="py-4 px-6 flex space-x-2">
                                <a href="{{ route('alumni_data.show', $alumni->id) }}" class="font-medium text-blue-600 hover:text-blue-800 transition duration-150">Lihat</a>
                                
                                {{-- Blok Edit Dihilangkan: Garis pemisah dan tombol Edit tidak ada lagi --}}
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="7" class="py-6 px-6 text-center text-gray-500 font-medium">
                                @if (request('search'))
                                    **Mahasiswa tidak ditemukan.**
                                @else
                                    Tidak ada data alumni yang ditemukan.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $alumnis->links() }} 
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- JavaScript opsional dapat ditambahkan di sini --}}
@endpush