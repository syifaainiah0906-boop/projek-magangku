<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Alumni</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Edit Data Alumni</h1>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumni_data.update', $alumniDatum->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="graduation_year" class="block text-gray-700 text-sm font-bold mb-2">Tahun Lulus:</label>
                <input type="text" name="graduation_year" id="graduation_year" value="{{ old('graduation_year', $alumniDatum->graduation_year) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon:</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $alumniDatum->phone_number) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="current_address" class="block text-gray-700 text-sm font-bold mb-2">Alamat Sekarang:</label>
                <textarea name="current_address" id="current_address" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('current_address', $alumniDatum->current_address) }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="employment_status" class="block text-gray-700 text-sm font-bold mb-2">Status Pekerjaan:</label>
                <input type="text" name="employment_status" id="employment_status" value="{{ old('employment_status', $alumniDatum->employment_status) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Perusahaan:</label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $alumniDatum->company_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Jabatan:</label>
                <input type="text" name="position" id="position" value="{{ old('position', $alumniDatum->position) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="work_address" class="block text-gray-700 text-sm font-bold mb-2">Alamat Kantor:</label>
                <textarea name="work_address" id="work_address" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('work_address', $alumniDatum->work_address) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="industry_field" class="block text-gray-700 text-sm font-bold mb-2">Bidang Industri:</label>
                <input type="text" name="industry_field" id="industry_field" value="{{ old('industry_field', $alumniDatum->industry_field) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="workplace_photo" class="block text-gray-700 text-sm font-bold mb-2">Foto Tempat Kerja Baru (opsional):</label>
                <input type="file" name="workplace_photo" id="workplace_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Data
                </button>
                <a href="{{ route('alumni_data.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</body>
</html>