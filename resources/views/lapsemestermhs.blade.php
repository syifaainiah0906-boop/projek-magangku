<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Semester</title>
    <link rel="stylesheet" href="{{ asset('css/style-lapsemestermhs.css') }}">
    </head>
<body>

    <div class="container-dashboard">
        <aside class="sidebar">
            <div class="menu-header">
                <div class="logo">
                    <img src="path/to/your/logo.png" alt="Logo">
                    <span>Beasiswa & Alumni</span>
                </div>
            </div>
            <ul class="menu-items">
                <li><a href="#"><div class="icon-menu"></div><span>Dashboard</span></a></li>
                <li><a href="#"><div class="icon-menu"></div><span>Laporan Kegiatan</span></a></li>
                <li class="active"><a href="#"><div class="icon-menu"></div><span>Laporan Semester</span></a></li>
                <li><a href="#"><div class="icon-menu"></div><span>Data Alumni</span></a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header class="navbar-header">
                <nav>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Tentang Beasiswa</a></li>
                        <li><a href="#">Data Mahasiswa</a></li>
                        <li><a href="#">Data Alumni</a></li>
                    </ul>
                </nav>
                <div class="user-profile">
                    <span>SYIFA</span>
                    <span class="user-avatar">SA</span>
                </div>
            </header>

            <div class="content-form">
                <h1 class="form-title">Laporan Semester</h1>

                <form action="{{ route('laporan-semester.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" name="nama" placeholder=" " required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <input type="number" id="semester" name="semester" placeholder=" " required>
                        </div>
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" id="nim" name="nim" placeholder=" " required>
                        </div>
                        <div class="form-group">
                            <label for="ip">IP</label>
                            <input type="text" id="ip" name="ip" placeholder=" " required>
                        </div>
                        <div class="form-group">
                            <label for="prodi">Prodi</label>
                            <input type="text" id="prodi" name="prodi" placeholder=" " required>
                        </div>
                        <div class="form-group">
                            <label for="ipk">IPK</label>
                            <input type="text" id="ipk" name="ipk" placeholder=" " required>
                        </div>
                    </div>
                    
                    <div class="form-upload">
                        <label for="khs" class="upload-area">
                            <div class="upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            </div>
                            <span class="upload-text">Upload KHS</span>
                        </label>
                        <input type="file" id="khs" name="khs" style="display: none;" required>
                    </div>

                    <button type="submit" class="btn-submit">Kirim</button>
                </form>
            </div>
        </main>
    </div>

</body>
</html>