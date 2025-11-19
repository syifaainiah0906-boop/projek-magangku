<!DOCTYPE html>
<html>
<head>
    <title>Data Alumni - {{ $alumniDatum->name }}</title> 
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; color: #333; }
        .section { margin-bottom: 20px; padding: 10px; border: 1px solid #eee; border-radius: 5px; }
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .data-row { margin-bottom: 8px; }
        .label { font-weight: bold; color: #555; width: 150px; display: inline-block; }
        .value { display: inline-block; }
        .description { margin-top: 15px; background-color: #f9f9f9; padding: 15px; border-radius: 5px; }
        .photo { text-align: center; margin-top: 20px; }
        .photo img { max-width: 100%; height: auto; border: 1px solid #ccc; padding: 5px; }
    </style>
</head>
<body>
    {{-- KOP SURAT --}}
<div class="kop-surat" style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/Picture2.png') }}" 
         alt="Kop Surat Politeknik Hasnur" 
         style="width: 100%; max-width: 950px; height: auto;">
</div>
    <div class="header">
        <h1>DATA ALUMNI</h1>
        <p>Tanggal Dibuat: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
    </div>

    <div class="section">
        <div class="section-title">INFORMASI ALUMNI</div>
        <div class="data-row"><span class="label">Nama Lengkap:</span> <span class="value">{{ $alumniDatum->user->name }}</span></div>
        <div class="data-row"><span class="label">NIM:</span> <span class="value">{{ $alumniDatum->user->nim }}</span></div>
        <div class="data-row"><span class="label">Prodi:</span> <span class="value">{{ $alumniDatum->user->prodi }}</span></div>
        <div class="data-row"><span class="label">Tahun Lulus:</span> <span class="value">{{ $alumniDatum->graduation_year }}</span></div>
        <div class="data-row"><span class="label">Posisi/Jabatan:</span> <span class="value">{{ $alumniDatum->position }}</span></div>
        <div class="data-row"><span class="label">Alamat Pekerjaan:</span> <span class="value">{{ $alumniDatum->work_address }}</span></div>
        <div class="data-row"><span class="label">Nomor HP:</span> <span class="value">{{ $alumniDatum->phone_number }}</span></div>
        <div class="data-row"><span class="label">Alamat Sekarang:</span> <span class="value">{{ $alumniDatum->current_address }}</span></div>
        <div class="data-row"><span class="label">Status Pekerjaan:</span> <span class="value">{{ $alumniDatum->employment_status }}</span></div>
        <div class="data-row"><span class="label">Nama Perusahaan:</span> <span class="value">{{ $alumniDatum->company_name }}</span></div>
        <div class="data-row"><span class="label">Bidang Industri:</span> <span class="value">{{ $alumniDatum->industry_field }}</span></div>
    </div>
    
    @if ($alumniDatum->workplace_photo_path)
    <div class="photo">
        <div class="section-title">FOTO ALUMNI</div>
        {{-- CATATAN: Dompdf memerlukan path absolut (dengan http:// atau https://) untuk gambar --}}
        <img src="{{ public_path('storage/' . $alumniDatum->workplace_photo_path) }}" alt="Foto Pekerjaan">
    </div>
    @endif

</body>
</html>