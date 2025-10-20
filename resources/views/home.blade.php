<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Klinik Sederhana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Klinik Sederhana</a>

    <div class="d-flex align-items-center ms-auto">
      @auth
        <span class="text-white me-3">
          👋 Halo, <strong>{{ Auth::user()->name }}</strong>
        </span>

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
      @endauth
    </div>
  </div>
</nav>

<div class="container mt-5 text-center">
  <h2 class="mb-3">Selamat Datang di Klinik Sederhana</h2>
  <p class="lead">Sistem Manajemen Klinik untuk Admin, Dokter, dan Pasien</p>

  <div class="mt-4">
    <a href="#" class="btn btn-success m-2">Lihat Jadwal Dokter</a>
    <a href="#" class="btn btn-info m-2">Riwayat Medis</a>
    <a href="#" class="btn btn-secondary m-2">Profil</a>
  </div>
</div>

</body>
</html>
