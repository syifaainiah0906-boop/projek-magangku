@extends('layouts.app')

@section('title', 'Data Mahasiswa - SIBAHAS')

@section('content')
<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">

        <h3 class="text-xl font-bold text-gray-800 mb-6 text-center tracking-wider">
            STUDENT DATA 
            @if (!empty($filterAngkatan))
                ANGKATAN {{ $filterAngkatan }}
            @endif
        </h3>

        {{-- 🔹 Search Bar hanya tampil untuk ADMIN --}}
        @if(auth()->user()->role === 'admin')
            <div class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-4 md:space-y-0">
                <form action="{{ route('student_data.index') }}" method="GET"
                    class="w-full md:w-2/3 flex items-center bg-blue-600 rounded-full overflow-hidden shadow-lg">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama mahasiswa..." 
                        class="w-full py-3 px-6 text-white bg-blue-600 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                    
                    {{-- Hidden filters agar tidak error --}}
                    @if(!empty($filterProdi))
                        <input type="hidden" name="prodi" value="{{ $filterProdi }}">
                    @endif
                    @if(!empty($filterAngkatan))
                        <input type="hidden" name="angkatan" value="{{ $filterAngkatan }}">
                    @endif

                    <button type="submit" 
                        class="px-6 py-3 bg-yellow-400 text-blue-900 hover:bg-yellow-500 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        @endif

        {{-- 🔹 Jika yang login adalah ADMIN: tampilkan tabel --}}
        @if(auth()->user()->role === 'admin')
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                    <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-800 tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-center">NO</th>
                            <th class="px-6 py-3 text-center">NAMA</th>
                            <th class="px-6 py-3 text-center">NIM</th>

                            {{-- Header PROGRAM STUDI + Filter --}}
                            <th class="px-6 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span>PROGRAM STUDI</span>
                                    <form action="{{ route('student_data.index') }}" method="GET" id="filterProdiForm">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                                        <select name="prodi" onchange="document.getElementById('filterProdiForm').submit()"
                                            class="border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-blue-400">
                                            @foreach ($daftarProdi as $program)
                                                <option value="{{ $program }}" {{ request('prodi') == $program ? 'selected' : '' }}>
                                                    {{ $program }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </th>

                            {{-- Header TAHUN + Filter --}}
                            <th class="px-6 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span>TAHUN</span>
                                    <form action="{{ route('student_data.index') }}" method="GET" id="filterTahunForm">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                                        <select name="tahun" onchange="document.getElementById('filterTahunForm').submit()"
                                            class="border border-gray-300 text-gray-700 rounded-md px-2 py-1 text-xs focus:ring-2 focus:ring-blue-400">
                                            @foreach ($daftarTahun as $tahun)
                                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </th>

                            <th class="px-6 py-3 text-center">AKSI</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($mahasiswas as $index => $mahasiswa)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 text-center">{{ $index + $mahasiswas->firstItem() }}</td>
                                <td class="px-6 py-4 text-center">{{ $mahasiswa->name }}</td>
                                <td class="px-6 py-4 text-center">{{ $mahasiswa->nim }}</td>
                                <td class="px-6 py-4 text-center">{{ $mahasiswa->prodi ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    {{ '20' . substr($mahasiswa->nim, 0, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('student_data.show', $mahasiswa->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada data mahasiswa ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $mahasiswas->links() }}
            </div>

        {{-- 🔹 Jika USER: tampil detail pribadi --}}
        @else
            @php $mahasiswa = auth()->user(); @endphp
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 shadow-inner">
                <h4 class="text-xl font-bold text-blue-800 mb-6 text-center">Detail Mahasiswa</h4>
                <div class="space-y-4 text-gray-800">
                    <div><strong>Nama:</strong> {{ $mahasiswa->name }}</div>
                    <div><strong>NIM:</strong> {{ $mahasiswa->nim }}</div>
                    <div><strong>Program Studi:</strong> {{ $mahasiswa->prodi ?? '-' }}</div>
                    <div><strong>Angkatan:</strong> {{ '20' . substr($mahasiswa->nim, 0, 2) }}</div>
                    <div><strong>Email:</strong> {{ $mahasiswa->email }}</div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
