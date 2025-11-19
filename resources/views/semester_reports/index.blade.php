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
        <form action="{{ route('semester_reports.index') }}" method="GET" 
              class="w-full bg-gray-50 p-5 rounded-xl flex flex-wrap gap-4 items-end">

            {{-- Cari Nama / NIM --}}
            <div class="flex flex-col flex-grow">
                <label class="text-sm font-semibold text-gray-700 mb-1">Cari Nama / NIM</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" placeholder="Masukkan nama atau NIM..."
                        value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2 border-gray-300 rounded-md shadow focus:ring-blue-500 focus:border-blue-500 w-full">
                </div>
            </div>

           {{-- Filter Tahun --}}
<div class="flex flex-col">
    <label class="text-sm font-semibold text-gray-700 mb-1">Tahun</label>
    <select name="tahun"
            class="w-40 py-2 border-gray-300 rounded-md shadow focus:ring-blue-500 focus:border-blue-500">
        <option value="" {{ request('tahun') == '' ? 'selected' : '' }}>Pilih Tahun</option>
        @foreach ($daftarTahun as $tahun)
            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                {{ $tahun }}
            </option>
        @endforeach
    </select>
</div>


            {{-- Filter Semester --}}
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-gray-700 mb-1">Semester</label>
                <select name="semester" 
                        class="w-44 py-2 border-gray-300 rounded-md shadow focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Semester</option>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

           <div class="flex space-x-2">

    {{-- Tombol Filter --}}
    <button type="submit"
        class="w-full px-4 py-2 bg-blue-100 text-blue-600 rounded-full 
               text-sm hover:bg-blue-200 transition font-medium">
        Filter
    </button>

    {{-- Tombol Reset --}}
    <a href="{{ route('student_data.index') }}"
        class="px-4 py-2 bg-blue-100 text-blue-600 rounded-full 
               text-sm hover:bg-blue-200 transition font-medium">
        Reset
    </a>

</div>

        </form>
    @elseif (Auth::user()->role === 'user')
        {{-- Tombol Tambah hanya untuk Mahasiswa --}}
        <div class="w-full flex justify-end">
            <a href="{{ route('semester_reports.create') }}"
                class="px-5 py-2 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 transition text-center">
                + Tambah Laporan
            </a>
        </div>
    @endif
</div>

        {{-- TABEL LAPORAN --}}
        <div class="overflow-x-visible rounded-lg border border-gray-200 shadow-md relative">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="bg-gray-100 text-xs text-gray-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">NIM</th>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Prodi</th>
                        <th class="py-3 px-6 text-center">
                            @if(Auth::user()->role === 'admin') Laporan Tersedia @else Semester & IPK @endif
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @php $no = 1; @endphp

                    @forelse ($groupedReports as $userId => $reportsGroup)
                        @php $mahasiswa = $reportsGroup->first()->user; @endphp

                        {{-- Role Admin --}}
                        @if(Auth::user()->role === 'admin')
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">{{ $no++ }}</td>
                                <td class="py-4 px-6">{{ $mahasiswa->nim ?? 'N/A' }}</td>
                                <td class="py-4 px-6 font-medium text-gray-900">{{ $mahasiswa->name ?? 'N/A' }}</td>
                                <td class="py-4 px-6">{{ $mahasiswa->prodi ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-center">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        {{-- Tombol seragam dengan "Detail" --}}
                                        <button 
                                            @click="open = !open"
                                            type="button"
                                            class="inline-flex items-center justify-center rounded-full px-4 py-1
                                                bg-blue-100 text-blue-700 text-xs font-medium hover:bg-blue-200
                                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
                                        >
                                            Lihat Laporan
                                            <svg class="ml-1 w-3 h-3 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        {{-- Dropdown --}}
                                        <div 
                                            x-show="open"
                                            x-cloak
                                            @click.outside="open = false"
                                            x-transition:enter="transition ease-out duration-150"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-100"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                                        >
                                            <div class="py-1">
                                                @foreach ($reportsGroup->sortBy('semester') as $report)
                                                    <a href="{{ route('semester_reports.show', $report->id) }}"
                                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-700">
                                                        Semester {{ $report->semester }} (IPK {{ $report->ipk }})
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        {{-- Role User (Mahasiswa) & Alumni --}}
                        @if(Auth::user()->role === 'user' || Auth::user()->role === 'alumni')
                            @foreach ($reportsGroup->sortBy('semester') as $report)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4">{{ $no++ }}</td>
                                    <td class="py-4 px-6">{{ $mahasiswa->nim ?? 'N/A' }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $mahasiswa->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">{{ $mahasiswa->prodi ?? 'N/A' }}</td>
                                    <td class="py-4 px-6 text-center">
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

{{-- Alpine.js untuk dropdown --}}
@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
