@extends('layouts.app')

@section('title', 'Edit Data Mahasiswa')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100/0">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Edit Data Saya</h2>

        <form action="{{ route('student_data.update') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">NIM</label>
                <input type="text" name="nim" value="{{ old('nim', $user->nim) }}"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Angkatan</label>
                <input type="text" name="angkatan" value="{{ old('angkatan', $user->angkatan) }}"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('student_data.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
