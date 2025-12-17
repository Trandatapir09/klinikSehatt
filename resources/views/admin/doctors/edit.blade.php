@extends('layouts.main')
@section('title', 'Edit Dokter - Klinik Sehat')

@section('content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-primary fw-bold">✏️ Edit Data Dokter</h3>
    <a href="{{ route('admin.doctors') }}" class="btn btn-outline-secondary">
      ← Kembali ke Daftar Dokter
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" class="shadow p-4 rounded-3 bg-white">
    @csrf
    @method('PUT')

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama Dokter</label>
        <input type="text" name="name" value="{{ old('name', $doctor->name) }}" class="form-control" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Spesialisasi</label>
        <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" class="form-control" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Hari Praktik</label>
        <input type="text" name="day" value="{{ old('day', $doctor->day) }}" class="form-control" required>
      </div>

      <div class="col-md-3">
        <label class="form-label">Jam Mulai</label>
        <input type="time" name="start_time" value="{{ old('start_time', $doctor->start_time) }}" class="form-control" required>
      </div>

      <div class="col-md-3">
        <label class="form-label">Jam Selesai</label>
        <input type="time" name="end_time" value="{{ old('end_time', $doctor->end_time) }}" class="form-control" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="active" {{ $doctor->status == 'active' ? 'selected' : '' }}>Aktif</option>
          <option value="inactive" {{ $doctor->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
      </div>
    </div>

    <div class="mt-4 text-end">
      <button type="submit" class="btn btn-primary px-4">💾 Simpan Perubahan</button>
    </div>
  </form>
</div>
@endsection
