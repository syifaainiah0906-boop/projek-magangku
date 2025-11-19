<!DOCTYPE html>
<html>
<head>
    <title>Laporan Semester - {{ $semesterReport->activity_name }}</title>
    <style>
        @page {
            size: A4;
            margin: 30; /* hilangkan margin default agar kop surat bisa mentok atas */
        }
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 12px; 
            line-height: 1.6; 
            margin: 0; 
            padding: 0;
        }
        .kop-surat { 
            text-align: center; 
            margin: 0; 
            padding: 0; 
        }
        .kop-surat img { 
            width: 100%; 
            height: auto; 
            display: block; 
            margin: 0; 
            padding: 0; 
        }
        .content { 
            padding: 40px; /* beri jarak agar isi tidak menempel ke tepi halaman */ 
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        .header h1 { 
            font-size: 18px; 
            color: #333; 
            margin-bottom: 5px;
        }
        .section { 
            margin-bottom: 20px; 
            padding: 10px; 
            border: 1px solid #eee; 
            border-radius: 5px; 
        }
        .section-title { 
            font-size: 14px; 
            font-weight: bold; 
            margin-bottom: 10px; 
            border-bottom: 1px solid #ddd; 
            padding-bottom: 5px;
            text-transform: uppercase; 
        }
        .data-row { 
            margin-bottom: 8px; 
        }
        .label { 
            font-weight: bold; 
            color: #555; 
            width: 150px; 
            display: inline-block; 
        }
        .value { 
            display: inline-block; 
        }
        .description {
            margin-top: 15px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .photo { 
            text-align: center; 
            margin-top: 25px; 
        }
        .photo img { 
            max-width: 100%; 
            height: auto; 
            border: 1px solid #ccc; 
            padding: 5px; 
            border-radius: 5px; 
        }
    </style>
</head>
<body>
    {{-- KOP SURAT --}}
    <div class="kop-surat">
        <img src="{{ public_path('images/Picture2.png') }}" 
             alt="Kop Surat Politeknik Hasnur">
    </div>

    {{-- === ISI LAPORAN === --}}
    <div class="content">

    <div class="header">
        <h1>LAPORAN SEMESTER</h1>
        <p>Tanggal Dibuat: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
    </div>

    <div class="section">
        <div class="section-title">INFORMASI MAHASISWA</div>
        <div class="data-row"><span class="label">Nama Lengkap:</span> <span class="value">{{ $semesterReport->user->name }}</span></div>
        <div class="data-row"><span class="label">NIM:</span> <span class="value">{{ $semesterReport->user->nim }}</span></div>
        <div class="data-row"><span class="label">Prodi:</span> <span class="value">{{ $semesterReport->user->prodi }}</span></div>
        <div class="data-row"><span class="label">Semester:</span> <span class="value">{{ $semesterReport->semester }}</span></div>
    </div>
    @if ($semesterReport->khs_file_path)
        <div class="photo">
            <div class="section-title">FOTO KHS</div>
            {{-- CATATAN: Dompdf memerlukan path absolut (dengan http:// atau https://) untuk gambar --}}
            <img src="{{ public_path('storage/' . $semesterReport->khs_file_path) }}" alt="Foto KHS">
        </div>
    @endif

</body>
</html>
