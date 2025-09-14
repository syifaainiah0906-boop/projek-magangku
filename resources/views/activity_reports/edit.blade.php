<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan Kegiatan</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* CSS Tambahan untuk memastikan sidebar memenuhi tinggi */
        html, body {
            height: 100%;
            margin: 0;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 256px; /* 64 * 4px = 256px */
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .content {
            flex-grow: 1;
            padding: 1.5rem; /* 6 * 4px = 24px */
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-100">
@extends('layouts.app')

@section('title', 'Edit Laporan Kegiatan')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Edit Laporan Kegiatan</h1>
    
    @if ($errors->any())
        <div class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activity_reports.update', $activityReport->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="activity_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kegiatan:</label>
            <input type="text" name="activity_name" id="activity_name" value="{{ old('activity_name', $activityReport->activity_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        
        <div class="mb-4">
            <label for="activity_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kegiatan:</label>
            <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', $activityReport->activity_date) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Kegiatan:</label>
            <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $activityReport->description) }}</textarea>
        </div>
        
        <div class="mb-4">
            <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Unggah Bukti Foto Baru (opsional):</label>
            @if($activityReport->photo_file_path)
                <p class="text-xs text-gray-500 mb-2">File saat ini: {{ basename($activityReport->photo_file_path) }}</p>
            @endif
            <input type="file" name="photo" id="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Laporan
            </button>
            <a href="{{ route('activity_reports.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection