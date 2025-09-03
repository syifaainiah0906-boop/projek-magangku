@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<div class="flex flex-col items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-7xl">
        <h2 class="text-2xl font-semibold text-blue-900 mb-6 text-center">Laporan Semester Mahasiswa</h2>

        <!-- <div class="flex items-center justify-between mb-6">
            <form action="{{ route('semester_reports.index') }}" method="GET" class="w-full max-w-lg flex items-center bg-blue-500 rounded-full overflow-hidden shadow-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mahasiswa..." class="w-full py-3 px-6 text-white bg-blue-500 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="px-6 py-3 bg-yellow-400 text-blue-900 hover:bg-yellow-500 transition duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div> -->

        @if (Auth::user()->role === 'user')
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <a href="/semester_reports/create">
                Tambah Laporan Semester
            </a>
            
        </button>
        @endif

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">No</th>
                        <th scope="col" class="py-3 px-6">NIM</th>
                        <th scope="col" class="py-3 px-6">Nama</th>
                        <th scope="col" class="py-3 px-6">Prodi</th>
                        <th scope="col" class="py-3 px-6">Semester</th>
                        <th scope="col" class="py-3 px-6">IP</th>
                        <th scope="col" class="py-3 px-6">IPK</th>
                        <th scope="col" class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6">{{ $report->user->nim ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $report->user->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $report->user->prodi ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $report->semester }}</td>
                            <td class="py-4 px-6">{{ $report->ip }}</td>
                            <td class="py-4 px-6">{{ $report->ipk }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('semester_reports.show', $report->id) }}" class="font-medium text-blue-600 hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="9" class="py-4 px-6 text-center text-gray-500">
                                Tidak ada laporan kegiatan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush