@extends('layouts.app')

@section('title', 'Edit Data Alumni')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 p-6">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-10 border border-blue-100">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 tracking-wide">Edit Data Alumni</h1>
            <p class="text-gray-500 mt-2 text-sm">Perbarui informasi alumni di bawah ini.</p>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-lg text-red-800">
                <strong class="font-bold">Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('alumni_data.update', $alumniDatum->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                {{-- Tahun Lulus --}}
                <div>
                    <label for="graduation_year" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                    <input type="text" name="graduation_year" id="graduation_year" value="{{ old('graduation_year', $alumniDatum->graduation_year) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>
                
                {{-- Nomor Telepon --}}
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $alumniDatum->phone_number) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>

                {{-- Alamat Sekarang --}}
                <div class="md:col-span-2">
                    <label for="current_address" class="block text-sm font-medium text-gray-700">Alamat Sekarang</label>
                    <textarea name="current_address" id="current_address" rows="3" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">{{ old('current_address', $alumniDatum->current_address) }}</textarea>
                </div>
                
                {{-- Status Pekerjaan --}}
                <div>
                    <label for="employment_status" class="block text-sm font-medium text-gray-700">Status Pekerjaan</label>
                    <input type="text" name="employment_status" id="employment_status" value="{{ old('employment_status', $alumniDatum->employment_status) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>

                {{-- Nama Perusahaan --}}
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $alumniDatum->company_name) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>

                {{-- Jabatan --}}
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <input type="text" name="position" id="position" value="{{ old('position', $alumniDatum->position) }}" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                </div>

                {{-- Bidang Industri --}}
                <div>
                    <label for="industry_field" class="block text-sm font-medium text-gray-700">Bidang Industri</label>
                    <select name="industry_field" id="industry_field" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">
                        <option value="" disabled>Pilih Bidang Industri</option>
                        <option value="logistic" @selected(old('industry_field', $alumniDatum->industry_field) == 'logistic')>Logistic</option>
                        <option value="agro_forestry" @selected(old('industry_field', $alumniDatum->industry_field) == 'agro_forestry')>Agro Forestry</option>
                        <option value="energy" @selected(old('industry_field', $alumniDatum->industry_field) == 'energy')>Energy</option>
                        <option value="technology" @selected(old('industry_field', $alumniDatum->industry_field) == 'technology')>Technology</option>
                        <option value="education" @selected(old('industry_field', $alumniDatum->industry_field) == 'education')>Education</option>
                        <option value="consumer" @selected(old('industry_field', $alumniDatum->industry_field) == 'consumer')>Consumer</option>
                        <option value="investment" @selected(old('industry_field', $alumniDatum->industry_field) == 'investment')>Investment</option>
                    </select>
                </div>

                {{-- Alamat Kantor --}}
                <div class="md:col-span-2">
                    <label for="work_address" class="block text-sm font-medium text-gray-700">Alamat Kantor</label>
                    <textarea name="work_address" id="work_address" rows="3" class="mt-1 block w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-base">{{ old('work_address', $alumniDatum->work_address) }}</textarea>
                </div>

                {{-- Foto Tempat Kerja --}}
                <div class="md:col-span-2">
                    <label for="workplace_photo" class="block text-sm font-medium text-gray-700">Foto Tempat Kerja Baru (opsional)</label>
                    <input type="file" name="workplace_photo" id="workplace_photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end gap-4">
                <a href="{{ route('alumni_data.show', $alumniDatum->id) }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@endpush