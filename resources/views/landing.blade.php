<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIBAHAS - Beasiswa & Alumni</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800">

  <!-- NAVBAR -->
  <header class="bg-[#003366] px-8 py-4 flex justify-between items-center shadow-lg">
    <!-- Kiri: Logo + Nama -->
    <div class="flex items-center space-x-4">
      <img src="{{ asset('images/logo.png') }}" alt="Logo Hasnur Group" class="w-14 h-14">
      <div class="leading-tight">
        <h1 class="text-white text-2xl font-bold">Beasiswa & Alumni</h1>
        <p class="text-white text-sm font-medium">CSR Hasnur Group</p>
      </div>
    </div>

    <nav class="space-x-6 font-semibold">
      <a href="#" class="text-white hover:text-yellow-400 transition">Beranda</a>
      <a href="#" class="text-white hover:text-yellow-400 transition">Tentang Beasiswa</a>
      <a href="#" class="text-white hover:text-yellow-400 transition">Data Mahasiswa</a>
      <a href="#" class="text-white hover:text-yellow-400 transition">Data Alumni</a>
      <a href="#" class="text-white hover:text-yellow-400 transition">Kontak</a>
    </nav>

    <a href="{{ route('login') }}" 
       class="bg-yellow-400 hover:bg-yellow-500 text-[#003366] font-bold px-5 py-2 rounded-lg shadow-md transition">
       Login / Daftar
    </a>
  </header>

  <!-- Hero Section -->
  <section class="bg-[#0055A5] text-white flex flex-col md:flex-row items-center justify-between px-10 py-16 shadow-inner">
    <div class="max-w-xl space-y-6">
      <h2 class="text-4xl font-extrabold leading-snug text-white">
        Selamat Datang di Portal Beasiswa & Alumni<br>CSR Hasnur Group
      </h2>
      <p class="text-gray-100 text-lg leading-relaxed">
        Temukan informasi beasiswa, kelola data penerima, dan ikuti perkembangan alumni dalam satu sistem terintegrasi.
      </p>
      <button class="bg-yellow-400 hover:bg-yellow-500 text-[#003366] font-bold px-6 py-3 rounded-lg shadow-md transition">
        Lihat Selengkapnya
      </button>
    </div>
    <img src="{{ asset('images/fotolanding.PNG') }}" alt="Mahasiswa" 
         class="w-96 mt-8 md:mt-0 rounded-xl shadow-2xl">
  </section>

  <!-- Statistik -->
  <div class="text-center">
    <p class="text-blue-900 font-semibold mb-2">Mahasiswa Penerima Beasiswa</p>
    <p class="text-3xl font-bold text-blue-900">{{ $jumlahMahasiswaBeasiswa }}</p>
</div>
<div class="text-center">
    <p class="text-blue-900 font-semibold mb-2">Alumni Terdaftar</p>
    <p class="text-3xl font-bold text-blue-900">{{ $jumlahAlumni }}</p>
</div>
<div class="text-center">
    <p class="text-blue-900 font-semibold mb-2">Program Beasiswa Aktif</p>
    <p class="text-3xl font-bold text-blue-900">{{ $programBeasiswaAktif }}</p>
</div>


  <!-- Tentang Beasiswa -->
  <section class="px-10 py-14 text-center md:text-left bg-gray-50">
    <h2 class="text-3xl font-extrabold text-[#003366] mb-6">Tentang Beasiswa</h2>
    <p class="max-w-4xl mx-auto leading-relaxed text-gray-700 text-lg">
      Beasiswa Hasnur Group hadir sebagai wujud nyata kepedulian perusahaan terhadap dunia pendidikan. 
      Program ini bertujuan mendukung mahasiswa berprestasi untuk menyelesaikan studi dengan baik 
      dan menjadi generasi unggul yang siap berkontribusi bagi masyarakat.
    </p>
  </section>

  <!-- Berita -->
  <section class="px-10 py-14 bg-white shadow-inner">
    <h2 class="text-3xl font-extrabold text-[#003366] mb-8 text-center md:text-left">Berita / Pengumuman Terbaru</h2>
    <div class="flex flex-col md:flex-row justify-between items-start gap-10">
      <ul class="space-y-5 text-gray-700 text-lg">
        <li>📢 Pendaftaran Beasiswa 2025 resmi dibuka</li>
        <li>👥 Gathering Alumni 2024 di Banjarmasin</li>
        <li>🏆 Pengumuman Mahasiswa Berprestasi 2024</li>
      </ul>
      <img src="https://img.freepik.com/free-photo/group-graduated-students-posing-campus_23-2148201834.jpg" 
           alt="Wisuda" class="w-72 rounded-xl shadow-lg">
    </div>
  </section>

  <!-- Testimoni -->
  <section class="px-10 py-14 bg-gray-50">
    <h2 class="text-3xl font-extrabold text-[#003366] mb-8 text-center md:text-left">Testimoni</h2>
    <div class="flex flex-col md:flex-row gap-6">
      <div class="bg-[#0055A5] text-white p-6 rounded-xl shadow-lg flex-1 text-lg font-medium">
        "SIBAHAS membantu saya mendapatkan beasiswa dan lulus tepat waktu."
      </div>
      <div class="bg-[#0055A5] text-white p-6 rounded-xl shadow-lg flex-1 text-lg font-medium">
        "Sistem ini sangat memudahkan alumni untuk tetap terhubung."
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[#003366] text-white text-center py-8 mt-8 shadow-inner">
    <p class="font-semibold text-lg">PT HASNUR JAYA UTAMA</p>
    <p class="mt-2 text-sm">
      Sosial Media:
      <span class="space-x-2 font-medium">
        <a href="#" class="hover:underline">Facebook</a> | 
        <a href="#" class="hover:underline">Twitter</a> | 
        <a href="#" class="hover:underline">Instagram</a>
      </span>
    </p>
    <p class="mt-2 text-sm font-medium">
      No. Telepon: 0812-3456-7891 | Email: sibahas@email.com
    </p>
  </footer>

</body>
</html>
