@extends('layouts.main')

@section('content')
<section class="hero-section d-flex align-items-center text-center text-white" 
         style="background: url('{{ asset('images/hero-bg.png') }}') center/cover no-repeat; height: 100vh; margin-top: 0;">
  <div class="container" data-aos="fade-up">
    <h1 class="fw-bold mb-3">Selamat Datang di <span class="text-warning">Klinik Sehat</span></h1>
    <p class="lead mb-4">Pelayanan Kesehatan Cepat, Ramah, dan Profesional</p>
    <a href="{{ route('register.form') }}" class="btn btn-light btn-lg shadow">Daftar Online Sekarang</a>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container" data-aos="fade-right">
    <h2 class="text-center mb-4 fw-bold text-primary">Tentang Klinik Sehat</h2>
    <p class="text-center mx-auto" style="max-width: 700px;">
      Klinik Sehat berdiri sejak tahun <strong>2010</strong> sebagai pusat layanan kesehatan terpercaya 
      dengan komitmen memberikan pelayanan terbaik bagi masyarakat. Kami menghadirkan tenaga medis profesional 
      dan fasilitas modern untuk mendukung kesehatan Anda dan keluarga.
    </p>
  </div>
</section>

<section class="py-5">
  <div class="container" data-aos="fade-left">
    <h2 class="text-center mb-4 fw-bold text-primary">Visi & Misi</h2>
    <div class="row">
      <div class="col-md-6">
        <h5 class="fw-bold">Visi</h5>
        <p>Menjadi klinik pilihan utama masyarakat dalam pelayanan kesehatan yang profesional, cepat, dan terjangkau.</p>
      </div>
      <div class="col-md-6">
        <h5 class="fw-bold">Misi</h5>
        <ul>
          <li>Memberikan pelayanan medis berkualitas tinggi dengan empati dan kejujuran.</li>
          <li>Mengedepankan kenyamanan serta keamanan pasien.</li>
          <li>Mengembangkan inovasi pelayanan berbasis teknologi.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light" id="doctors">
  <div class="container">
    <div class="text-center mb-5"  data-aos="fade-up">
      <h2 class="fw-bold text-primary">Tim Dokter Kami</h2>
      <p class="text-muted">Dokter berpengalaman dan profesional siap membantu Anda</p>
    </div>
    <div class="row justify-content-center">
      @forelse ($doctors as $doctor)
        <div class="col-md-4 col-lg-3 mb-4"  data-aos="fade-up">
          <div class="card shadow-sm border-0 h-100">
            <img src="{{ asset('storage/' . $doctor->photo) }}" class="card-img-top" alt="{{ $doctor->name }}" style="height: 220px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title mb-0">{{ $doctor->name }}</h5>
              <small class="text-muted">{{ $doctor->specialization }}</small>
            </div>
          </div>
        </div>
      @empty
        <p class="text-center text-muted">Belum ada dokter yang terdaftar.</p>
      @endforelse
    </div>
  </div>
</section>

<section class="py-5" id="schedule" style="background-color: #f8f9fa;">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold text-primary">Jadwal Praktik Dokter</h2>
      <p class="text-muted">Cek jadwal dokter kami untuk pelayanan terbaik</p>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover shadow-sm align-middle" data-aos="fade-up">
        <thead class="table-primary text-center">
          <tr>
            <th>Nama Dokter</th>
            <th>Spesialisasi</th>
            <th>Hari Praktik</th>
            <th>Jam</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($doctors as $doctor)
            <tr>
              <td>{{ $doctor->name }}</td>
              <td>{{ $doctor->specialization }}</td>
              <td>{{ $doctor->day }}</td>
              <td>
                @if ($doctor->start_time && $doctor->end_time)
                  {{ \Carbon\Carbon::parse($doctor->start_time)->format('H:i') }}
                  -
                  {{ \Carbon\Carbon::parse($doctor->end_time)->format('H:i') }}
                @else
                  08:00 - 15:00
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">Belum ada jadwal dokter yang tersedia.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>

<footer class="text-white py-4 mt-5" style="background-color: #004da5ff;">
  <div class="container text-center">
    <p class="mb-1 fw-bold">🏥 Klinik Sehat</p>
    <p class="mb-0">Jl. Sehat No. 123, Jakarta | Telp: (021) 123-4567 | Email: info@kliniksehat.id</p>
    <small>&copy; {{ date('Y') }} Klinik Sehat. All rights reserved.</small>
  </div>
</footer>
@endsection
