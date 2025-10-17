@extends('layouts.app')

@section('title', 'Data Alumni - SIBAHAS')

@section('content')

<div class="flex flex-col items-center p-4 bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-7xl mx-auto my-12">
        {{-- Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Data Alumni</h1>
            <p class="text-gray-500 mt-2 text-sm">Kelola dan lihat data alumni penerima beasiswa.</p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Area Aksi dan Pencarian --}}
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
            {{-- Form Pencarian --}}
            <form action="{{ route('alumni_data.index') }}" method="GET" class="w-full md:w-1/2 lg:w-1/3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau NIM alumni..."
                        class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </form>

            {{-- Tombol Tambah Data (hanya untuk admin) --}}
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('alumni_data.create') }}" class="w-full md:w-auto px-5 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 transition text-center">
                    + Tambah Data
                </a>
            @endif
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-600">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-600">NIM</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-600">Prodi</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-600">Tahun Lulus</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-600">Status Pekerjaan</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($alumnis as $alumni)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4">{{ $alumnis->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $alumni->user->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $alumni->user->nim ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $alumni->user->prodi ?? 'N/A' }}</td>
                            <td class="py-4 px-6">{{ $alumni->graduation_year ?? '-' }}</td>
                            <td class="py-4 px-6">{{ $alumni->employment_status ?? '-' }}</td>
                            
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('alumni_data.show', $alumni->id) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium hover:bg-blue-200 transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 px-6 text-center text-gray-500 font-medium">
                                @if (request('search'))
                                    Data alumni tidak ditemukan untuk pencarian "{{ request('search') }}".
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
        <div class="mt-6">
            {{ $alumnis->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- JavaScript opsional dapat ditambahkan di sini --}}
@endpush
