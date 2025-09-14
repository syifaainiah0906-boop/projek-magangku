@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="min-h-screen">
        <h2>Dashboard</h2>
        @if (Auth::user()->role === 'user')
        <div class="welcome-box">
            <h3 class="welcome-title">Hai {{ Auth::user()->name ?? 'Pengguna' }}!</h3>
            <p>
                Kamu telah berhasil mempertahankan status sebagai penerima Beasiswa CSR Hasnur Group
                pada semester ini. Silakan unggah laporan kegiatan untuk melanjutkan ke semester berikutnya.
            </p>
        </div>

        <div class="card">
            <h3>Profil Mahasiswa</h3>
            <div class="profile-grid">
                <p><strong>Nama Lengkap</strong><br>{{ Auth::user()->name ?? '' }}</p>
                <p><strong>Semester</strong><br>4</p>
                <p><strong>NIM</strong><br>{{ Auth::user()->nim ?? '' }}</p>
                <p><strong>Kelas</strong><br>{{ Auth::user()->kelas ?? '' }}</p>
                <p><strong>Prodi</strong><br>{{ Auth::user()->prodi ?? '' }}</p>
                <p><strong>Jenis Beasiswa</strong><br>{{ Auth::user()->jenis_beasiswa ?? '' }}</p>
            </div>
        </div>

        <div class="card">
            <h3>Rata-Rata Nilai</h3>
            <canvas id="chartNilai"></canvas>
        </div>
        @endif
        @if (Auth::user()->role === 'admin')
        <div class="text-white">hallo saya admin</div>
        @endif
    </div>
    

@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('chartNilai').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['SMT 1', 'SMT 2', 'SMT 3'],
                datasets: [{
                    label: 'Nilai IP',
                    data: [3.8, 3.7, 3.9],
                    borderWidth: 2,
                    borderColor: '#003366',
                    fill: false
                }]
            }
        });
    </script>
@endpush