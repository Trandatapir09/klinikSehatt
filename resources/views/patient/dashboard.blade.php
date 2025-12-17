@extends('layouts.main')

@section('content')
<div class="container mt-5">
  <h3 class="mb-4 text-center">Selamat Datang, {{ $user->name }}</h3>

  <div class="row justify-content-center">

  <div class="card mt-4">
    <div class="card-body text-center">
        <h5 class="card-title">Pendaftaran Online</h5>
        <p class="card-text">Daftar antrian pemeriksaan dengan cepat dan mudah.</p>

        <a href="{{ route('appointment.create') }}" class="btn btn-primary btn-lg">
            Daftar Periksa
        </a>
    </div>
</div>

    {{-- 🔹 Kartu Riwayat Medis --}}
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <h5 class="card-title">Riwayat Medis</h5>
          <p class="card-text text-muted">Lihat riwayat pemeriksaan dan resep dokter Anda.</p>
          <a href="{{ route('patient.records') }}" class="btn btn-primary w-100">Lihat Riwayat</a>
        </div>
      </div>
    </div>

    {{-- 🔹 Kartu Edit Profil --}}
    <div class="col-md-4 mt-3 mt-md-0">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <h5 class="card-title">Edit Profil</h5>
          <p class="card-text text-muted">Perbarui data pribadi dan foto profil Anda.</p>
          <a href="{{ route('profile.edit') }}" class="btn btn-success w-100">Edit Profil</a>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
