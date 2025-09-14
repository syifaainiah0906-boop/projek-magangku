@extends('layouts.app')

@section('title', 'Edit Laporan Semester')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Edit Laporan Semester</h1>
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('semester_reports.update', $semesterReport->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="semester" class="block text-gray-700 text-sm font-bold mb-2">Semester:</label>
            <input type="text" name="semester" id="semester" value="{{ old('semester', $semesterReport->semester) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        
        <div class="mb-4">
            <label for="tahun_akademik" class="block text-gray-700 text-sm font-bold mb-2">Tahun Akademik:</label>
            <input type="text" name="tahun_akademik" id="tahun_akademik" value="{{ old('tahun_akademik', $semesterReport->tahun_akademik) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="ip" class="block text-gray-700 text-sm font-bold mb-2">IP:</label>
            <input type="number" step="0.01" name="ip" id="ip" value="{{ old('ip', $semesterReport->ip) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="ipk" class="block text-gray-700 text-sm font-bold mb-2">IPK:</label>
            <input type="number" step="0.01" name="ipk" id="ipk" value="{{ old('ipk', $semesterReport->ipk) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="khs" class="block text-gray-700 text-sm font-bold mb-2">Unggah Transkrip Nilai Baru (opsional):</label>
            @if($semesterReport->khs_file_path)
                <p class="text-xs text-gray-500 mb-2">File saat ini: {{ basename($semesterReport->khs_file_path) }}</p>
            @endif
            <input type="file" name="khs" id="khs" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Laporan
            </button>
            <a href="{{ route('semester_reports.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
