@extends('layouts.main')

@section('content')
<div class="container mt-5">
  <h3 class="mb-4 text-center">Jadwal Praktek Dokter</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body">
      <h5>Informasi Jadwal Saat Ini</h5>
      <p><strong>Hari:</strong> {{ $doctor->day ?? 'Belum diatur' }}</p>
      <p><strong>Jam Mulai:</strong> {{ $doctor->start_time ?? '-' }}</p>
      <p><strong>Jam Selesai:</strong> {{ $doctor->end_time ?? '-' }}</p>
      <p><strong>Status:</strong> 
        @if($doctor->status == 'active')
          <span class="badge bg-success">Aktif</span>
        @else
          <span class="badge bg-secondary">Nonaktif</span>
        @endif
      </p>
    </div>
  </div>

  <hr>

  <div class="card shadow-sm mt-3">
    <div class="card-body">
      <h5 class="card-title">Ubah Jadwal Praktek</h5>
      <form action="{{ route('doctor.schedule.update') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="day" class="form-label">Hari Praktek</label>
          <input type="text" name="day" class="form-control" value="{{ $doctor->day ?? '' }}" placeholder="Contoh: Senin - Rabu" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="start_time" class="form-label">Jam Mulai</label>
            <input type="time" name="start_time" class="form-control" value="{{ $doctor->start_time ?? '' }}" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="end_time" class="form-label">Jam Selesai</label>
            <input type="time" name="end_time" class="form-control" value="{{ $doctor->end_time ?? '' }}" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select name="status" class="form-select" required>
            <option value="active" {{ $doctor->status == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ $doctor->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
@endsection
