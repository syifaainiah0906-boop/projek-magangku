<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kegiatan - {{ $activityReport->activity_name }}</title>
    <style>
        /* === ATURAN HALAMAN PDF === */
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

        /* === KOP SURAT === */
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

        /* === KONTEN UTAMA === */
        .content {
            padding: 40px; /* beri jarak agar isi tidak menempel ke tepi halaman */
        }

        /* === HEADER === */
        .header {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .header p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }

        /* === SECTION === */
        .section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
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
            margin-top: 20px;
        }

        .photo img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>
<body>

    {{-- === KOP SURAT (MENTOK ATAS) === --}}
    <div class="kop-surat">
        <img src="{{ public_path('images/Picture2.png') }}" 
             alt="Kop Surat Politeknik Hasnur">
    </div>

    {{-- === ISI LAPORAN === --}}
    <div class="content">

        <div class="header">
            <h1>LAPORAN KEGIATAN MAHASISWA</h1>
            <p><strong>Laporan Kegiatan ke-{{ $laporanKe }}</strong></p>
            <p>Tanggal Dibuat: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
        </div>

        <div class="section">
            <div class="section-title">Informasi Mahasiswa</div>
            <div class="data-row"><span class="label">Nama Lengkap:</span> <span class="value">{{ $activityReport->user->name }}</span></div>
            <div class="data-row"><span class="label">NIM:</span> <span class="value">{{ $activityReport->user->nim }}</span></div>
            <div class="data-row"><span class="label">Prodi:</span> <span class="value">{{ $activityReport->user->prodi }}</span></div>
            <div class="data-row"><span class="label">Semester:</span> <span class="value">{{ $activityReport->semester }}</span></div>
        </div>

        <div class="section">
            <div class="section-title">Detail Kegiatan</div>
            <div class="data-row"><span class="label">Nama Kegiatan:</span> <span class="value">{{ $activityReport->activity_name }}</span></div>
            <div class="data-row"><span class="label">Tanggal Kegiatan:</span> <span class="value">{{ \Carbon\Carbon::parse($activityReport->activity_date)->isoFormat('D MMMM YYYY') }}</span></div>
            <div class="data-row"><span class="label">Posisi / Peran:</span> <span class="value">{{ $activityReport->position }}</span></div>
        </div>

        <div class="section">
            <div class="section-title">Uraian Kegiatan</div>
            <div class="description">
                {!! nl2br(e($activityReport->description)) !!}
            </div>
        </div>

        @if ($activityReport->photo_file_path)
        <div class="photo">
            <div class="section-title">Foto Kegiatan</div>
            <img src="{{ public_path('storage/' . $activityReport->photo_file_path) }}" alt="Foto Kegiatan">
        </div>
        @endif

    </div> <!-- end content -->

</body>
</html>
