<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBAHAS - Beasiswa & Alumni</title>
    <link rel="stylesheet" href="{{ asset('css/style-landing.css') }}"> 
</head>
<body>

    <header>
        <h1>Beasiswa & Alumni CSR Hasnur Group</h1>
        <nav>
            <a href="#">Beranda</a>
            <a href="#">Tentang Beasiswa</a>
            <a href="#">Data Mahasiswa</a>
            <a href="#">Data Alumni</a>
            <a href="#">Kontak</a>
        </nav>
        <a href="{{ route('login') }}" class="btn-login">Login / Daftar</a>
    </header>

    <div class="hero">
        <div>
            <h2>Selamat Datang di Portal Beasiswa & Alumni<br>PT Hasnur Jaya Utama</h2>
            <p>Temukan informasi beasiswa, kelola data penerima, dan ikuti perkembangan alumni dalam satu sistem terintegrasi.</p>
            <button>Lihat Selengkapnya</button>
        </div>
        <img src="{{ asset('images/fotolanding.PNG') }}" alt="Mahasiswa" width="00">
    </div>

    <div class="stats">
        <div>
            <h3>18</h3>
            <p>Mahasiswa Penerima</p>
        </div>
        <div>
            <h3>12</h3>
            <p>Alumni Terdaftar</p>
        </div>
        <div>
            <h3>1</h3>
            <p>Program Beasiswa Aktif</p>
        </div>
    </div>

    <section>
        <h2>Tentang Beasiswa</h2>
        <p>Beasiswa Hasnur Group hadir sebagai wujud nyata kepedulian perusahaan terhadap dunia pendidikan. Program ini bertujuan mendukung mahasiswa berprestasi untuk menyelesaikan studi dengan baik dan menjadi generasi unggul.</p>
    </section>

    <section>
        <h2>Berita / Pengumuman Terbaru</h2>
        <div class="berita">
            <ul>
                <li>📢 Pendaftaran Beasiswa 2025 resmi dibuka</li>
                <li>👥 Gathering Alumni 2024 di Banjarmasin</li>
                <li>🏆 Pengumuman Mahasiswa Berprestasi 2024</li>
            </ul>
            <img src="https://img.freepik.com/free-photo/group-graduated-students-posing-campus_23-2148201834.jpg" alt="Wisuda" width="250">
        </div>
    </section>

    <section>
        <h2>Testimoni</h2>
        <div class="testimoni">
            <div>"SIBAHAS membantu saya mendapatkan beasiswa dan lulus tepat waktu."</div>
            <div>"Sistem ini sangat memudahkan alumni untuk tetap terhubung."</div>
        </div>
    </section>

    <footer>
        <p>PT HASNUR JAYA UTAMA</p>
        <p>Sosial Media: 
            <span class="sosmed">
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </span>
        </p>
        <p>No. Telepon: 0812-3456-7891 | Email: sibahas@email.com</p>
    </footer>

</body>
</html>