@extends('layouts.app')

@section('title', 'Laporan Semester - SIBAHAS')

@section('content')

<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">

        <h3 class="text-xl font-bold text-gray-800 mb-6 text-center tracking-wider">
            STUDENT SEMESTER REPORT
        </h3>

        {{-- FILTER UNTUK ADMIN --}}
        @if (Auth::user()->role === 'admin')
        <div class="flex items-center justify-between mb-6">
            {{-- Search Bar --}}
            <form action="{{ route('semester_reports.index') }}" method="GET" 
                class="w-2/3 flex items-center bg-blue-600 rounded-full overflow-hidden shadow-lg">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama mahasiswa..." 
                    class="w-full py-3 px-6 text-white bg-blue-600 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" 
                    class="px-6 py-3 bg-yellow-400 text-blue-900 hover:bg-yellow-500 transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>

            {{-- Filter Semester --}}
            <div class="w-1/4 max-w-xs relative bg-blue-600 rounded-full shadow-lg"> 
                <form action="{{ route('semester_reports.index') }}" method="GET">
                    <select name="semester" 
                        class="w-full py-3 px-6 text-white bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 appearance-none pr-10 rounded-full"
                        onchange="this.form.submit()"
                    >
                        <option value="" class="bg-white text-gray-700">Pilih Semester</option> 
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }} class="bg-white text-gray-700">
                                Semester {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
            </div>
        </div>
        @endif
        {{-- AKHIR FILTER ADMIN --}}

        @if (Auth::user()->role === 'user')
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
            <a href="{{ route('semester_reports.create') }}">
                Tambah Laporan Semester
            </a>
        </button>
        @endif

        {{-- TABEL LAPORAN --}}
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">No</th>
                        <th scope="col" class="py-3 px-6">NIM</th>
                        <th scope="col" class="py-3 px-6">Nama</th>
                        <th scope="col" class="py-3 px-6">Prodi</th>
                        <th scope="col" class="py-3 px-6">Semester & IPK</th> 
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($groupedReports as $userId => $reportsGroup)
                        @php $mahasiswa = $reportsGroup->first()->user; @endphp

                        {{-- Role Admin tetap seperti sebelumnya --}}
                        @if(Auth::user()->role === 'admin')
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $no++ }}</td>
                                <td class="py-4 px-6">{{ $mahasiswa->nim ?? 'N/A' }}</td>
                                <td class="py-4 px-6">{{ $mahasiswa->name ?? 'N/A' }}</td>
                                <td class="py-4 px-6">{{ $mahasiswa->prodi ?? 'N/A' }}</td>
                                
                                <td class="py-4 px-6">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <button 
                                            @click="open = !open" 
                                            type="button"
                                            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 
                                                bg-blue-600 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none 
                                                focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            Lihat
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                                viewBox="0 0 24 24" stroke="currentColor">
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
                                            class="origin-top-right absolute right-0 mt-2 w-52 rounded-md shadow-lg bg-white 
                                                   ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
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
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $no++ }}</td>
                                    <td class="py-4 px-6">{{ $mahasiswa->nim ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">{{ $mahasiswa->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">{{ $mahasiswa->prodi ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('semester_reports.show', $report->id) }}" 
                                           class="text-blue-600 hover:underline">
                                            Semester {{ $report->semester }} (IPK {{ $report->ipk }})
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">
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
