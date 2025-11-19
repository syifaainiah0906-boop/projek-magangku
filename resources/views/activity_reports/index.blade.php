@extends('layouts.app')

@section('title', 'Laporan Kegiatan - SIBAHAS')

@section('content')

<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">

        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Laporan Kegiatan Mahasiswa</h1>
            <p class="text-gray-500 mt-2 text-sm">Kelola dan lihat laporan kegiatan mahasiswa penerima beasiswa.</p>
        </div>

        {{-- Area Aksi dan Filter --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
        @if (Auth::user()->role === 'admin')
            {{-- Form Filter untuk Admin --}}
            <form action="{{ route('activity_reports.index') }}" method="GET" class="w-full flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama mahasiswa..."
                        class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="w-full md:w-auto px-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                
                 {{-- Tombol Filter + Reset --}}
                    <div class="flex space-x-2">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                            Filter
                        </button>
                        </div>
            </form>
        @elseif (Auth::user()->role === 'mahasiswa')
            {{-- Tombol Tambah hanya untuk Mahasiswa --}}
            <div class="w-full flex justify-end">
                <a href="{{ route('activity_reports.create') }}"
                   class="px-5 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 transition text-center">
                    + Tambah Laporan
                </a>
            </div>
        @endif
        </div>

        {{-- Pesan filter aktif --}}
        @if(request('start_date') || request('search'))
            <div class="mb-4 text-sm text-gray-600 italic">
                Menampilkan laporan yang difilter.
                <a href="{{ route('activity_reports.index') }}" 
                   class="text-red-500 hover:underline ml-2">Hapus Filter</a>
            </div>
        @endif

        {{-- TABEL UTAMA --}}
        <div class="overflow-x-visible rounded-lg border border-gray-200 shadow-md relative">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="bg-gray-100 text-xs text-gray-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">NIM</th>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Prodi</th>
                        <th class="py-3 px-6">Semester</th> {{-- ✅ Tambahan kolom Semester --}}
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @php $no = 1; @endphp

                    {{-- ADMIN --}}
                    @if (Auth::user()->role === 'admin')
                        @foreach ($allReports->groupBy('user_id') as $userId => $reports)
                            @php 
                                $user = $reports->first()->user; 
                                $semesterTerbaru = $reports->sortByDesc('semester')->first()->semester ?? '-';
                            @endphp
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 font-semibold">{{ $no++ }}</td>
                                <td class="py-4 px-6 font-semibold">{{ $user->nim ?? 'N/A' }}</td>
                                <td class="py-4 px-6 font-semibold text-gray-900">{{ $user->name ?? 'N/A' }}</td>
                                <td class="py-4 px-6 font-semibold">{{ $user->prodi ?? 'N/A' }}</td>
                                <td class="py-4 px-6 font-semibold text-center">{{ $semesterTerbaru }}</td> {{-- ✅ Semester --}}
                                <td class="py-4 px-6 text-center">
                                    <div class="relative inline-block text-left">
                                        {{-- Tombol seperti "Detail" --}}
                                        <button id="dropdownButton-{{ $userId }}" 
                                            class="px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200 transition flex items-center justify-center gap-1">
                                            Lihat Laporan
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>

                                        {{-- Dropdown daftar laporan --}}
                                        <div id="dropdownMenu-{{ $userId }}" 
                                             class="hidden absolute right-0 mt-2 w-52 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                            @foreach ($reports as $r)
                                                <div class="flex items-center justify-between px-4 py-2 text-sm hover:bg-gray-100">
                                                    <a href="{{ route('activity_reports.show', $r->id) }}" 
                                                       class="text-gray-700">
                                                        Semester {{ $r->semester }}
                                                    </a>
                                                    <a href="{{ route('activity_reports.edit', $r->id) }}" 
                                                       class="text-yellow-600 hover:text-yellow-800 font-medium text-xs">
                                                        Edit
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('click', function (e) {
                                            const btn = document.getElementById('dropdownButton-{{ $userId }}');
                                            const menu = document.getElementById('dropdownMenu-{{ $userId }}');
                                            if (btn.contains(e.target)) {
                                                menu.classList.toggle('hidden');
                                            } else {
                                                menu.classList.add('hidden');
                                            }
                                        });
                                    </script>
                                </td>
                            </tr>
                        @endforeach

                    {{-- MAHASISWA & ALUMNI --}}
                    @else
                        @forelse ($allReports as $report)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">{{ $no++ }}</td>
                                <td class="py-4 px-6">{{ $report->user->nim ?? 'N/A' }}</td>
                                <td class="py-4 px-6 font-medium text-gray-900">{{ $report->user->name ?? 'N/A' }}</td>
                                <td class="py-4 px-6">{{ $report->user->prodi ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-center">{{ $report->semester ?? '-' }}</td>
                                <td class="py-4 px-6 text-center flex justify-center gap-2">
                                    <a href="{{ route('activity_reports.show', $report->id) }}"
                                       class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 px-6 text-center text-gray-500 font-medium">
                                    Tidak ada laporan kegiatan.
                                </td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
