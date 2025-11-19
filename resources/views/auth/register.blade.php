<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - SIBAHAS</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style-register.css') }}">
</head>
<body>
  <div class="left">
      <img src="{{ asset('images/logo.PNG') }}" alt="Logo Hasnur Group" class="logo">
      <img src="{{ asset('images/siluet.png') }}" alt="Graduates" class="siluet">
    <div class="text-wrapper">
      <h1>ACHIEVE HIGHER<br><span>Impact More</span></h1>   
      </div>

    <img src="{{ asset('images/siluet.png') }}" alt="Graduates" class="siluet">
    
    <div class="footer-text-overlay">
        Hasnur Group Scholars
    </div>
  </div>

  <div class="right">
    <div class="form-box">
      <h2>Daftar Akun</h2>
      <p>Buat akun Anda</p>
      <form action="{{ url('/register') }}" method="post">
        @csrf
        <label>Nama Lengkap</label>
        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Masukkan email" required>

        <label>Nim</label>
        <input type="text" name="nim" placeholder="Masukkan nim" required>

        <label>Prodi</label>
        <select name="prodi" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-family: inherit; font-size: 14px; color: #333; background-color: #fff;">
          <option value="" disabled selected>Masukkan Prodi</option>
          <option value="D3 Teknik Otomotif">D3 Teknik Otomotif</option>
          <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
          <option value="D3 Budidaya Tanaman Perkebunan">D3 Budidaya Tanaman Perkebunan</option>
          <option value="D4 Bisnis Digital">D4 Bisnis Digital</option>
          <option value="D4 Akuntansi Bisnis Digital">D4 Akuntansi Bisnis Digital</option>
          <option value="D4 Manajemen Pemasaran Internasional">D4 Manajemen Pemasaran Internasional</option>
          <option value="D4 Teknologi Rekayasa Multimedia">D4 Teknologi Rekayasa Multimedia</option>
        </select>
      
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi password" required>

        <div class="checkbox">
          <input type="checkbox" required>
          <span class="small-text">Saya menyetujui syarat dan ketentuan</span>
        </div>

        <button type="submit">Daftar</button>
      </form>

      <div class="login-link">
        Sudah punya akun? <a href="{{ url('/login') }}">Masuk</a>
      </div>
    </div>
  </div>
</body>
</html>