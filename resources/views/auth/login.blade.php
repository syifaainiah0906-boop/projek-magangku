<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIBAHAS</title>
    <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/style-login.css') }}">
</head>
<body>
  <div class="container">
    <!-- Bagian Kiri -->
    <div class="left">
      <img src="{{ asset('images/logo.PNG') }}" alt="Logo Hasnur Group" class="logo">
    <img src="{{ asset('images/siluet.png') }}" alt="Siluet Wisuda" class="siluet">
      <h1>ACHIEVE HIGHER<br><span>Impact More</span></h1>
      <p class="footer-text">HG Scholars</p>
    </div>

    <!-- Bagian Kanan -->
    <div class="right">
      <div class="form-box">
        <h2>Selamat Datang</h2>
        <p class="sub-text">Silakan masuk ke akun Anda</p>
        
        @if(session('success'))
          <div style="color: green; text-align: center; margin-bottom: 15px;">
            {{ session('success') }}
          </div>
        @endif

        <form action="{{ url('/login') }}" method="post">
          @csrf

          <label>Email</label>
          <input type="email" name="email" placeholder="Masukkan email" required>

          <label>Password</label>
          <input type="password" name="password" placeholder="Masukkan password" required>

          <div class="forgot">
            <a href="#">Lupa Password?</a>
          </div>

          <button type="submit" class="btn">Masuk</button>
        </form>

        <div class="divider">
          <span>atau</span>
        </div>

        <p class="signup">
          Belum memiliki akun? <a href="{{ url('/register') }}">Daftar sekarang</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
