<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - SIBAHAS</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/style-register.css') }}">
</head>
<body>
  <!-- Bagian kiri -->
  <div class="left">
    <img src="{{ asset('images/logo.PNG') }}" alt="Hasnur Group" class="logo-hg">

    <div class="text-wrapper">
      <h1>ACHIEVE HIGHER</h1>
      <p>Impact More</p>
      <h3>HG Scholars</h3>
    </div>

    <!-- ✅ Siluet dipisah, di paling bawah -->
    <img src="{{ asset('images/siluet.png') }}" alt="Graduates" class="siluet">
        </div>

  <!-- Bagian kanan -->
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
        <input type="text" name="prodi" placeholder="Masukkan Prodi" required>

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
