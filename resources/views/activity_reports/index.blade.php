@extends('layouts.app')

@section('title', 'Laporan Kegiatan - SIBAHAS')

@section('content')

<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">

        <h3 class="text-xl font-bold text-gray-800 mb-6 text-center tracking-wider">
            STUDENT ACTIVITY REPORT
        </h3>

        {{-- Logika Otorisasi untuk Admin --}}
        @if (Auth::user()->role === 'admin')
        
       {{-- Baris Pencarian + Filter Tanggal --}}
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
                    </svg>
                </button>
            </form>

    {{-- BLOK 2: Filter Tanggal (di kanan sejajar) --}}
    <form action="{{ route('student_data.index') }}" method="GET"
          class="flex items-center space-x-2 md:w-auto w-full justify-end">

        <label for="start_date" class="text-sm font-medium text-gray-700 whitespace-nowrap">
            Cari Tanggal
        </label>

        <input type="date" name="start_date" id="start_date"
               value="{{ request('start_date') }}"
               class="w-40 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm
                      focus:ring-blue-500 focus:border-blue-500 transition duration-150">

        <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-2 px-4 
                       rounded-md shadow-sm transition duration-200">
            Cari
        </button>
    </form>

</div>


</form>


        @else
            {{-- Untuk user biasa --}}
            <div class="mb-6">
                <a href="/activity_reports/create" 
                   class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 
                          rounded-lg shadow-md transition duration-300">
                    Tambah Activity
                </a>
            </div>
        @endif

        {{-- Pesan filter aktif --}}
        @if(request('semester') || request('start_date') || request('search'))
            <div class="mb-4 text-sm text-gray-600 italic">
                Menampilkan laporan yang difilter.
                <a href="{{ route('activity_reports.index') }}" 
                   class="text-red-500 hover:underline ml-2">Hapus Semua Filter</a>
            </div>
        @endif

        {{-- TABEL UTAMA --}}
        <div class="overflow-x-auto relative sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">No</th>
                        <th scope="col" class="py-3 px-6">NIM</th>
                        <th scope="col" class="py-3 px-6">Nama</th>
                        <th scope="col" class="py-3 px-6">Prodi</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($groupedReports as $userId => $activityGroup)
                        @php $mahasiswa = $activityGroup->first()->user; @endphp
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $no++ }}</td>
                            <td class="py-4 px-6">{{ $mahasiswa->nim ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $mahasiswa->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $mahasiswa->prodi ?? 'N/A' }}</td>
                            <td class="py-4 px-6">
                                {{-- Dropdown untuk melihat daftar kegiatan --}}
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button 
                                        @click="open = !open"
                                        type="button"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 
                                               shadow-sm px-4 py-2 bg-blue-600 text-sm font-medium text-white 
                                               hover:bg-blue-700 focus:outline-none focus:ring-2 
                                               focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        Lihat
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    {{-- Isi Dropdown --}}
                                    <div x-show="open"
                                         x-cloak
                                         @click.outside="open = false"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white 
                                                ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                    >
                                        <div class="py-1">
                                            @foreach ($activityGroup->sortByDesc('activity_date') as $report)
                                                <a href="{{ route('activity_reports.show', $report->id) }}" 
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                                    {{ $report->activity_name }} 
                                                    <br>
                                                    <span class="text-xs text-gray-500">
                                                        {{ \Carbon\Carbon::parse($report->activity_date)->isoFormat('D MMM YYYY') }}
                                                        — {{ $report->position }}
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                                Tidak ada laporan kegiatan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

{{-- Muat Alpine.js --}}
@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
