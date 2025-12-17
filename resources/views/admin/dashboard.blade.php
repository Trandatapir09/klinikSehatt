@extends('layouts.main')

@section('title', 'Dashboard Admin - Klinik Sehat')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold text-primary mb-4">🏥 Dashboard Admin</h2>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center p-3">
        <h5 class="text-muted">Jumlah Dokter</h5>
        <h2 class="fw-bold text-primary">{{ $totalDoctors }}</h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center p-3">
        <h5 class="text-muted">Jumlah Pasien</h5>
        <h2 class="fw-bold text-success">{{ $totalPatients }}</h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 text-center p-3">
        <h5 class="text-muted">Total Rekam Medis</h5>
        <h2 class="fw-bold text-danger">{{ $totalRecords }}</h2>
      </div>
    </div>
  </div>
  
  </div>

  <div class="text-center mt-4">
    <a href="{{ route('admin.doctors') }}" class="btn btn-primary me-2">Kelola Dokter</a>
    <a href="{{ route('admin.patients') }}" class="btn btn-success me-2">Kelola Pasien</a>
    <a href="{{ route('admin.reports.medical') }}" class="btn btn-dark me-2">laporan</a>

  </div>
</div>
@endsection
