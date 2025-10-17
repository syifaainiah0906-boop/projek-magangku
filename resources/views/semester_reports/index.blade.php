@extends('layouts.app')

@section('title', 'Laporan Semester - SIBAHAS')

@section('content')

<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">
        
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Laporan Semester Mahasiswa</h1>
            <p class="text-gray-500 mt-2 text-sm">Kelola dan lihat laporan nilai semester mahasiswa penerima beasiswa.</p>
        </div>

        {{-- Area Aksi dan Filter --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
            @if (Auth::user()->role === 'admin')
                {{-- Form Filter untuk Admin --}}
                <form action="{{ route('semester_reports.index') }}" method="GET" class="w-full flex flex-col md:flex-row gap-4">
                    {{-- Input Pencarian --}}
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama mahasiswa..."
                            class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    {{-- Select Semester --}}
                    <select name="semester" class="w-full md:w-auto px-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Semester</option>
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                                Semester {{ $i }}
                            </option>
                        @endfor
                    </select>
                    {{-- Tombol Filter --}}
                    <button type="submit" class="w-full md:w-auto px-5 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 transition text-center">
                        Filter
                    </button>
                </form>
            @else
                {{-- Tombol Tambah untuk User --}}
                <div class="w-full flex justify-end">
                    <a href="{{ route('semester_reports.create') }}" class="px-5 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 transition text-center">
                        + Tambah Laporan
                    </a>
                </div>
            @endif
        </div>

        {{-- Pesan filter aktif --}}
        @if(request('semester') || request('search'))
            <div class="mb-4 text-sm text-gray-600 italic">
                Menampilkan laporan yang difilter.
                <a href="{{ route('semester_reports.index') }}" class="text-red-500 hover:underline ml-2">Hapus Filter</a>
            </div>
        @endif

        {{-- TABEL LAPORAN --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="bg-gray-100 text-xs text-gray-600 uppercase font-semibold">
                    <tr>
                        <th scope="col" class="py-3 px-6">No</th>
                        <th scope="col" class="py-3 px-6">NIM</th>
                        <th scope="col" class="py-3 px-6">Nama</th>
                        <th scope="col" class="py-3 px-6">Prodi</th>
                        <th scope="col" class="py-3 px-6">
                            @if(Auth::user()->role === 'admin') Laporan Tersedia @else Semester & IPK @endif
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @php $no = 1; @endphp
                    @forelse ($groupedReports as $userId => $reportsGroup)
                        @php $mahasiswa = $reportsGroup->first()->user; @endphp

                        {{-- Role Admin tetap seperti sebelumnya --}}
                        @if(Auth::user()->role === 'admin')
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">{{ $no++ }}</td>
                                <td class="py-4 px-6">{{ $mahasiswa->nim ?? 'N/A' }}</td>
                                <td class="py-4 px-6 font-medium text-gray-900">{{ $mahasiswa->name ?? 'N/A' }}</td>
                                <td class="py-4 px-6">{{ $mahasiswa->prodi ?? 'N/A' }}</td>
                                
                                <td class="py-4 px-6">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <button 
                                            @click="open = !open" 
                                            type="button"
                                            class="inline-flex items-center justify-center rounded-full border border-gray-300 shadow-sm px-4 py-1 
                                                bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none 
                                                focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            Lihat Laporan
                                            <svg class="-mr-1 ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        <div 
                                            x-show="open"
                                            x-cloak
                                            @click.outside="open = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white 
                                                   ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                        >
                                            <div class="py-1">
                                                @foreach ($reportsGroup->sortBy('semester') as $report)
                                                    <a href="{{ route('semester_reports.show', $report->id) }}" 
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                                        Semester {{ $report->semester }} (IPK {{ $report->ipk }})
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        {{-- Role User: langsung tampil semua laporan per semester --}}
                        @if(Auth::user()->role === 'user')
                            @foreach ($reportsGroup->sortBy('semester') as $report)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4">{{ $no++ }}</td>
                                    <td class="py-4 px-6">{{ $mahasiswa->nim ?? 'N/A' }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $mahasiswa->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">{{ $mahasiswa->prodi ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('semester_reports.show', $report->id) }}" 
                                           class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                                            Semester {{ $report->semester }} (IPK {{ $report->ipk }})
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    @empty
                        <tr>
                            <td colspan="5" class="py-6 px-6 text-center text-gray-500 font-medium">
                                Tidak ada laporan semester yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

{{-- PENTING: Pastikan Alpine.js dimuat dengan benar --}}
@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
