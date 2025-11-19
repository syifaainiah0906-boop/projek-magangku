<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIBAHAS - Beasiswa & Alumni</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
      integrity="sha512-3h0sPmYUkUf5x7B0OYBW8iFwHjQdZ7V1ReVm3FMJSxZGknz0V8rrPn9Ko7ksHA7JRdYJTkNNjwcB9xIMfLx3NQ==" 
      crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800">

  {{-- Header --}}
  <header class="bg-[#003366] px-8 py-4 flex justify-between items-center shadow-lg">
    <div class="flex items-center space-x-4">
      <img src="{{ asset('images/logo.png') }}" alt="Logo Hasnur Group" class="w-14 h-14">
      <div class="leading-tight">
        <h1 class="text-white text-2xl font-bold">Beasiswa & Alumni</h1>
        <p class="text-white text-sm font-medium">CSR Hasnur Group</p>
      </div>
    </div>

    <nav class="space-x-6 font-semibold">
      <a href="#beranda" class="text-white hover:text-yellow-400 transition">Beranda</a>
      <a href="#tentang-beasiswa" class="text-white hover:text-yellow-400 transition">Tentang Beasiswa</a>
      <a href="#data-mahasiswa" class="text-white hover:text-yellow-400 transition">Data Mahasiswa</a>
      <a href="#data-alumni" class="text-white hover:text-yellow-400 transition">Data Alumni</a>
      <a href="#kontak" class="text-white hover:text-yellow-400 transition">Kontak</a>
    </nav>

    <a href="{{ route('login') }}" 
       class="bg-yellow-400 hover:bg-yellow-500 text-[#003366] font-bold px-5 py-2 rounded-lg shadow-md transition">
       Masuk / Daftar
    </a>
  </header>

  {{-- Beranda --}}
  <section 
    id="beranda"
    class="relative text-white flex flex-col md:flex-row items-center justify-start px-10 py-32 shadow-inner bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/Gambar WhatsApp 2025-10-21 pukul 11.14.53_cbb123bc.JPG') }}'); min-height: 90vh;">
    
    <div class="absolute inset-0 bg-[#0055A5]/60"></div>

    <div class="relative max-w-2xl space-y-6 z-10 text-left">
      <h2 class="text-5xl font-extrabold leading-snug">
        Selamat Datang di Portal Beasiswa & Alumni<br>CSR Hasnur Group
      </h2>
      <p class="text-gray-100 text-lg leading-relaxed">
        Temukan informasi beasiswa, kelola data penerima, dan ikuti perkembangan alumni dalam satu sistem terintegrasi.
      </p>
      <button 
        onclick="alert('Kamu Harus Login Terlebih Dahulu')" 
        class="bg-yellow-400 hover:bg-yellow-500 text-[#003366] font-bold px-6 py-3 rounded-lg shadow-md transition">
        Lihat Selengkapnya
      </button>
    </div>
  </section>

  {{-- Statistik --}}
  <section id="data-mahasiswa" class="py-14 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
      <div class="bg-blue-50 rounded-xl p-8 shadow-md hover:shadow-lg transition">
        <p class="text-blue-900 font-semibold mb-2">Mahasiswa Penerima Beasiswa</p>
        <p class="text-4xl font-extrabold text-blue-900">{{ $activeStudents }}</p>
      </div>
      <div id="data-alumni" class="bg-blue-50 rounded-xl p-8 shadow-md hover:shadow-lg transition">
        <p class="text-blue-900 font-semibold mb-2">Alumni Terdaftar</p>
        <p class="text-4xl font-extrabold text-blue-900">{{ $jumlahAlumni }}</p>
      </div>
      <div class="bg-blue-50 rounded-xl p-8 shadow-md hover:shadow-lg transition">
        <p class="text-blue-900 font-semibold mb-2">Program Beasiswa Aktif</p>
        <p class="text-4xl font-extrabold text-blue-900">{{ $programBeasiswaAktif }}</p>
      </div>
    </div>
  </section>

 {{-- Tentang Beasiswa --}}
<section id="tentang-beasiswa"
    class="px-10 py-20 bg-cover bg-center bg-no-repeat relative"
    style="background-image: url('{{ asset('images/HG-Scholars-Rev-2_01_03 - Salin.jpg') }}');">

    <!-- Overlay gelap -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Konten -->
    <div class="relative z-10 max-w-6xl mx-auto">

        <h2 class="text-3xl font-extrabold text-white mb-10 text-center">
            Tentang Beasiswa
        </h2>

        <!-- Grid 2 Kolom -->
        <div class="grid md:grid-cols-2 gap-10">

            <!-- Paragraf 1 (Kiri) -->
            <p class="leading-relaxed text-gray-100 text-lg md:text-left text-center">
                Beasiswa CSR Hasnur Group hadir sebagai wujud nyata kepedulian perusahaan terhadap dunia pendidikan.
                Program ini bertujuan mendukung mahasiswa berprestasi untuk menyelesaikan studi dengan baik dan menjadi
                generasi unggul yang siap berkontribusi bagi masyarakat.
            </p>

            <!-- Paragraf 2 (Kanan) -->
            <p class="leading-relaxed text-gray-100 text-lg md:text-right text-center">
                Pendidikan (education) merupakan program CSR yang fokus kepada peningkatan tingkat pendidikan dan kualitas
                sumber daya manusia pada masyarakat daerah. Melalui program beasiswa ini, diharapkan dapat membantu
                menurunkan angka putus sekolah serta meningkatkan akses dan kualitas pendidikan di Kalimantan Selatan.
            </p>

        </div>

    </div>
</section>

  {{-- Berita --}}
  <section class="px-10 py-14 bg-white shadow-inner">
    <h2 class="text-3xl font-extrabold text-[#003366] mb-8 text-center md:text-left">Berita / Pengumuman Terbaru</h2>
    <div class="flex flex-col md:flex-row justify-between items-start gap-10">
      <ul class="space-y-5 text-gray-700 text-lg">
        <li>📢 Pendaftaran Beasiswa 2025 resmi dibuka</li>
        <li>👥 Gathering Alumni 2024 di Banjarmasin</li>
        <li>🏆 Pengumuman Mahasiswa Berprestasi 2024</li>
      </ul>
     <div class="flex items-center justify-center space-x-6">
    <!-- Foto 1 -->
    <img src="{{ asset('images/HG-Scholars-Rev-2_01_02.jpg') }}" 
         alt="Wisuda 1" 
         class="w-72 rounded-xl shadow-lg">

    <!-- Foto 2 -->
    <img src="{{ asset('images/HG-Scholars-Rev-2_01_01.jpg') }}" 
         alt="Wisuda 2" 
         class="w-72 rounded-xl shadow-lg">
</div>

    </div>
  </section>

  {{-- Testimoni Dinamis --}}
<section class="px-6 md:px-12 py-14 bg-gray-50">
    <h2 class="text-3xl font-extrabold text-[#003366] mb-8 text-center md:text-left">
        Kata Alumni
    </h2>

    @if ($testimonis->isEmpty())
        <p class="text-center text-gray-500 italic">Belum ada testimoni dari alumni.</p>
    @else
        {{-- Container scroll horizontal --}}
        <div class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory">
            @foreach ($testimonis as $testimoni)
                <div class="min-w-[320px] max-w-sm flex-shrink-0 snap-start 
                            bg-[#0055A5] text-white border border-blue-700 shadow-lg 
                            rounded-xl p-6 hover:shadow-2xl transition-all duration-300">

                    {{-- Isi Testimoni --}}
                    <p class="text-blue-100 italic leading-relaxed mb-4">
                        “{{ $testimoni->isi_testimoni }}”
                    </p>

                    {{-- Info User + Tombol Hapus --}}
                    <div class="mt-auto flex flex-col items-end text-right">
                        <h4 class="font-semibold text-white">
                            {{ $testimoni->user->name ?? 'Alumni' }}
                        </h4>
                        <p class="text-sm text-blue-200">
                            {{ $testimoni->user->prodi ?? '-' }}
                        </p>

                        {{-- Tombol hapus testimoni --}}
                        @if(auth()->check() && (auth()->id() === $testimoni->user_id || auth()->user()->role === 'admin'))
                            <form action="{{ route('testimoni.destroy', $testimoni->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-300 hover:text-red-500 text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>



  {{-- Footer --}}
<footer id="kontak" class="bg-[#003366] text-white text-center py-8 mt-8 shadow-inner">

    <p class="font-semibold text-lg tracking-wide">HASNUR GROUP</p>

    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="text-center mt-6">
    <h3 class="text-lg font-semibold text-white mb-3">Sosial Media:</h3>

    <div class="flex items-center justify-center space-x-6 text-white text-base flex-wrap">

        <!-- LinkedIn -->
        <a href="https://linkedin.com/company/hasnurgroup" class="flex items-center gap-2 hover:text-gray-300">
            <i class="fab fa-linkedin text-xl"></i> hasnurgroup
        </a>

        <!-- Instagram -->
        <a href="https://instagram.com/hasnurgroup" class="flex items-center gap-2 hover:text-gray-300">
            <i class="fab fa-instagram text-xl"></i> hasnurgroup
        </a>

        <!-- Twitter -->
        <a href="https://twitter.com/hasnurgroup" class="flex items-center gap-2 hover:text-gray-300">
            <i class="fab fa-twitter text-xl"></i> hasnurgroup
        </a>

        <!-- YouTube -->
        <a href="https://youtube.com/@hasnurgroup" class="flex items-center gap-2 hover:text-gray-300">
            <i class="fab fa-youtube text-xl"></i> hasnurgroup6533
        </a>

    </div>
</div>
    </div>

    <p class="mt-4 text-sm font-medium">
        No. Telepon: 0812-3456-7891 | Email: sibahas@email.com
    </p>

</footer>
</body>
</html>
