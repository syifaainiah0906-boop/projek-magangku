@extends('layouts.app')

@section('title', 'Dashboard - SIBAHAS')

@section('content')
<div class="min-h-screen">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard</h2>
    
    {{-- ==================================================================== --}}
    {{-- BAGIAN UNTUK ROLE MAHASISWA (USER) --}}
    {{-- ==================================================================== --}}
    @if (Auth::user()->role === 'user')
    <div class="welcome-box bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
        <h3 class="welcome-title text-xl font-bold">Hai {{ Auth::user()->name ?? 'Pengguna' }}! 👋</h3>
        <p class="mt-2 text-sm">
            Kamu telah berhasil mempertahankan status sebagai penerima Beasiswa CSR Hasnur Group
            pada semester ini. Jangan lupa unggah laporan kegiatan (minimal 20) untuk melanjutkan ke semester berikutnya.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Card Profil --}}
        <div class="bg-white rounded-lg shadow-lg p-6 md:col-span-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Profil Mahasiswa</h3>
            <div class="space-y-2 text-sm">
                <p><strong>Nama Lengkap</strong><br>{{ Auth::user()->name ?? '-' }}</p>
                <p><strong>NIM</strong><br>{{ Auth::user()->nim ?? '-' }}</p>
                <p><strong>Prodi</strong><br>{{ Auth::user()->prodi ?? '-' }}</p>
            </div>
        </div>

        {{-- Card Jumlah Laporan Kegiatan --}}
        <div class="bg-white rounded-lg shadow-lg p-6 md:col-span-1 flex flex-col items-center justify-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 text-center">Jumlah Laporan Kegiatan</h3>
            <h2 class="text-5xl font-extrabold text-blue-900 mt-2" style="color: #104bc2ff !important;">{{ $activityReportsCount ?? 0 }}</h2>
            @if (isset($isKegiatanKurang) && $isKegiatanKurang)
                <p class="mt-2 text-sm text-red-500 font-semibold">Laporan kegiatanmu masih kurang! ⚠️</p>
            @else
                <p class="mt-2 text-sm text-green-500 font-semibold">Kegiatanmu sudah mencukupi. 👍</p>
            @endif
        </div>
        
        {{-- Card Status Beasiswa --}}
        <div class="bg-blue-600 text-white rounded-lg shadow-lg p-6 md:col-span-1 flex flex-col items-center justify-center">
            <h3 class="text-lg font-semibold mb-2 text-center">Status Beasiswa</h3>
            <p class="text-3xl font-extrabold mt-2 text-center">AKTIF</p>
            <p class="mt-2 text-sm text-blue-200">Terima kasih atas dedikasi Anda.</p>
        </div>
    </div>

    {{-- Grafik Nilai IP Semester --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Indeks Prestasi (IP) Semester</h3>
        <div style="height: 400px;">
            <canvas id="chartNilai"></canvas>
        </div>
    </div>
    @endif

    {{-- ==================================================================== --}}
    {{-- BAGIAN UNTUK ROLE ADMIN --}}
    {{-- ==================================================================== --}}
    @if (Auth::user()->role === 'admin')
        
        {{-- Bagian atas: Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            {{-- Card 1: Mahasiswa Aktif --}}
            <div class="bg-blue-600 text-white rounded-lg shadow-lg p-6 flex items-center justify-between min-w-[200px] transform hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-sm font-light">Jumlah Mahasiswa Beasiswa Aktif</p>
                    <h2 class="text-4xl font-bold mt-2">{{ $activeStudents ?? 0 }}</h2>
                </div>
                <div class="p-3 bg-blue-500 rounded-full">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
            </div>

            {{-- Card 2: Alumni Beasiswa --}}
            <div class="bg-blue-600 text-white rounded-lg shadow-lg p-6 flex items-center justify-between min-w-[200px] transform hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-sm font-light">Jumlah Alumni Beasiswa</p>
                    <h2 class="text-4xl font-bold mt-2">{{ $totalAlumni ?? 0 }}</h2>
                </div>
                <div class="p-3 bg-blue-500 rounded-full"> 
                    <i class="fa-solid fa-user-tie text-2xl"></i> 
                </div>
            </div>
            
            {{-- Card 3: Kegiatan Bulan Ini --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col justify-between min-w-[200px] border transform hover:scale-[1.02] transition duration-300">
                
                {{-- Header dengan Dropdown Bulan --}}
                <div class="mb-4">
                    <p class="text-sm font-light text-gray-700 block mb-1">Jumlah Laporan Kegiatan:</p>
                    <select id="month-year-select" onchange="filterMonthlyActivities(this.value)" class="text-sm font-semibold text-gray-700 border border-gray-300 rounded-md p-1 pr-8 bg-white cursor-pointer appearance-none focus:ring-blue-500 focus:border-blue-500">
                        @php
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        @foreach ($months as $num => $name)
                            <option value="{{ $num }}:{{ date('Y') }}" {{ $num == $month ? 'selected' : '' }}>
                                {{ $name }} {{ date('Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah Kegiatan --}}
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-4xl font-bold mt-2 text-blue-900" style="color: #104bc2ff !important;">
                            {{ $monthlyActivitiesCount ?? 0 }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">Laporan di {{ $currentMonthName }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full -translate-y-9">
                        <i class="fa-solid fa-calendar-days text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            {{-- Card 4: Laporan Semester --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between min-w-[200px] border transform hover:scale-[1.02] transition duration-300">
                <div>
                    <p class="text-sm font-light text-gray-700">Total Laporan Semester</p>
                    <h2 class="text-4xl font-bold mt-2 text-blue-900" style="color: #104bc2ff !important;">{{ $semesterReports ?? 0 }}</h2>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fa-solid fa-file-circle-exclamation text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        {{-- Bagian tengah: Bagan Status Prodi & Grafik Kegiatan Bulanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            {{-- Bagan Status Prodi (Doughnut Chart) --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Komposisi Mahasiswa Beasiswa per Prodi</h3>
                <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-8">
                    <div class="w-full max-w-xs h-64 flex items-center justify-center">
                        <canvas id="prodiChart"></canvas>
                    </div>
                    <div class="space-y-3 text-sm max-w-xs">
                        @php
                            $prodiColors = [
                                'D3 Teknik Otomotif' => '#3B82F6', 
                                'D3 Teknik Informatika' => '#F97316', 
                                'D3 Budidaya Tanaman Perkebunan' => '#4ADE80',
                                'D4 Bisnis Digital' => '#e0c4faff', 
                                'D4 Akuntansi Bisnis Digital' => '#A855F7', 
                                'D4 Manajemen Pemasaran Internasional' => '#F87171', 
                                'D4 Teknologi Rekayasa Multimedia' => '#EC4899',
                            ];
                        @endphp
                        @foreach ($prodiCounts as $prodi)
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $prodiColors[$prodi->prodi] ?? '#94A3B8' }}"></div>
                                {{ $prodi->prodi }} ({{ $prodi->count }})
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Grafik Batang Kegiatan Bulanan --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Kegiatan Bulanan (Tahun {{ date('Y') }})</h3>
                <div style="height: 300px;">
                    <canvas id="monthlyActivitiesChart"></canvas>
                </div>
            </div>

        </div>

        {{-- Script Filter --}}
        <script>
            function filterMahasiswa(angkatan) {
                const url = new URL(window.location.href);
                if (angkatan) url.searchParams.set('angkatan', angkatan);
                else url.searchParams.delete('angkatan');
                window.location.href = url.toString();
            }

            function filterMonthlyActivities(value) {
                const [month, year] = value.split(':');
                const url = new URL(window.location.href);
                url.searchParams.set('month', month);
                url.searchParams.set('year', year);
                window.location.href = url.toString();
            }
        </script>
    @endif
</div> {{-- min-h-screen --}}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Chart IP Mahasiswa --}}
@if (Auth::user()->role === 'user')
<script>
    const dataNilai = {
        labels: @json($labelsSemester ?? []),
        datasets: [{
            label: 'Indeks Prestasi',
            data: @json($nilaiIp ?? []),
            borderColor: '#003366',
            backgroundColor: 'rgba(0, 51, 102, 0.1)',
            fill: false,
            tension: 0.4,
            pointStyle: 'circle',
            pointRadius: 6,
            pointBackgroundColor: '#003366',
            pointBorderColor: '#003366',
            pointBorderWidth: 0,
            pointHoverRadius: 8
        }]
    };

    const configNilai = {
        type: 'line',
        data: dataNilai,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, max: 4.0, title: { display: true, text: 'IP Semester' } },
                x: { title: { display: true, text: 'Semester' } }
            }
        }
    };

    new Chart(document.getElementById('chartNilai'), configNilai);
</script>
@endif

{{-- Chart Admin --}}
@if (Auth::user()->role === 'admin')
<script>
    // Chart Prodi
    const prodiData = @json($prodiCounts ?? []);
    const prodiColors = {
        'D3 Teknik Otomotif': '#3B82F6',
        'D3 Teknik Informatika': '#F97316',
        'D3 Budidaya Tanaman Perkebunan': '#4ADE80',
        'D4 Bisnis Digital': '#e0c4faff', 
        'D4 Akuntansi Bisnis Digital': '#A855F7',
        'D4 Manajemen Pemasaran Internasional': '#F87171',
        'D4 Teknologi Rekayasa Multimedia': '#EC4899',
    };

    const labels = prodiData.map(item => item.prodi);
    const counts = prodiData.map(item => item.count);
    const backgroundColors = prodiData.map(item => prodiColors[item.prodi] || '#94A3B8');

    const prodiChart = new Chart(
        document.getElementById('prodiChart'),
        {
            type: 'doughnut',
            data: { labels, datasets: [{ data: counts, backgroundColor: backgroundColors, borderColor: '#fff', borderWidth: 1.5 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        }
    );

    // Chart Kegiatan Bulanan
    const chartLabels = @json($chartLabels ?? []);
    const chartData = @json($chartData ?? []);

    const monthlyActivityChart = new Chart(
        document.getElementById('monthlyActivitiesChart'),
        {
            type: 'bar',
            data: { labels: chartLabels, datasets: [{ label: 'Jumlah Kegiatan', data: chartData, backgroundColor: '#3B82F6', borderColor: '#1D4ED8', borderWidth: 1, borderRadius: 4 }] },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Total Laporan' }, ticks: { precision: 0 } },
                    x: { title: { display: true, text: 'Bulan' } }
                },
                plugins: { legend: { display: false } }
            }
        }
    );
</script>
@endif
@endpush
