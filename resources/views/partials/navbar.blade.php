<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <span class="logo-text">Beasiswa & Alumni <br><small>CSR Hasnur Group</small></span>
    </div>
    <ul>
        <li><a href="#">Beranda</a></li>
        <li><a href="#">Tentang Beasiswa</a></li>
        <li><a href="#">Data Mahasiswa</a></li>
        <li><a href="#">Data Alumni</a></li>
        <li><a href="#">Kontak</a></li>
        <li class="user">
            {{ Auth::user()->name ?? 'User' }} 
            <span class="circle">{{ substr(Auth::user()->name ?? 'U', 0, 2) }}</span>
        </li>
    </ul>
</nav>