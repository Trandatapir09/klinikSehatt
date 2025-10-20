@extends('layouts.main')

@section('title', 'Jadwal Dokter - Klinik Sehat')

@section('content')

{{-- Carousel (tetap di atas navbar) --}}
<div id="clinicCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('images/carousel3.png') }}" class="d-block mx-auto rounded-4" style="max-height: 350px; width: auto;" alt="Slide 1">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('images/carousel2.png') }}" class="d-block mx-auto rounded-4" style="max-height: 350px; width: auto;" alt="Slide 2">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#clinicCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#clinicCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

{{-- Section dua kolom --}}
<div class="container my-5">
  <div class="row g-4 align-items-start">

    {{-- Kolom kiri: Riwayat singkat klinik --}}
    <div class="col-lg-6">
      <h3 class="text-primary fw-bold mb-3">🏥 Tentang Klinik Sehat</h3>
      <p class="text-muted">
        Klinik Sehat berdiri sejak tahun <strong>2010</strong> dan berkomitmen untuk memberikan pelayanan kesehatan yang cepat, ramah, dan profesional.
        Dengan tim dokter berpengalaman dan fasilitas modern, kami berupaya menjaga kesehatan masyarakat dengan sepenuh hati.
      </p>
      <p class="text-muted">
        Kami melayani berbagai pemeriksaan umum, gigi, dan spesialis dengan jadwal yang fleksibel.
        Setiap pasien akan mendapatkan perawatan terbaik sesuai kebutuhan medisnya.
      </p>
    </div>

    {{-- Kolom kanan: Jadwal Dokter --}}
    <div class="col-lg-6">
      <h3 class="text-primary text-center mb-3">🩺 Jadwal Dokter</h3>
      @if(isset($doctors) && count($doctors) > 0)
        <div class="table-responsive shadow rounded-3">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-primary text-center">
              <tr>
                <th>Nama Dokter</th>
                <th>Spesialisasi</th>
                <th>Hari</th>
                <th>Jam</th>
              </tr>
            </thead>
            <tbody class="text-center">
              @foreach($doctors as $doctor)
                <tr>
                  <td class="fw-semibold">{{ $doctor->name }}</td>
                  <td>{{ $doctor->specialization }}</td>
                  <td>{{ $doctor->day }}</td>
                  <td>{{ $doctor->start_time }} - {{ $doctor->end_time }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="alert alert-warning text-center mt-4">
          Belum ada jadwal dokter saat ini.
        </div>
      @endif
    </div>

  </div>
</div>

@endsection
