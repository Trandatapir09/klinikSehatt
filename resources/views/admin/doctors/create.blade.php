@extends('layouts.main')

@section('title', 'Tambah Dokter - Klinik Sehat')

@section('content')
<div class="container mt-5">
  <h3 class="mb-4 text-primary">Tambah Dokter Baru</h3>

  <form action="{{ route('admin.doctors.store') }}" method="POST">
    @csrf

    {{-- Pilih User yang sudah terdaftar --}}
    <div class="mb-3">
      <label for="user_id" class="form-label">Pilih User</label>
      <select name="user_id" id="user_id" class="form-select" required>
        <option value="">-- Pilih User --</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="name" class="form-label">Nama Dokter</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="specialization" class="form-label">Spesialisasi</label>
      <input type="text" name="specialization" id="specialization" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="day" class="form-label">Hari Praktek</label>
      <input type="text" name="day" id="day" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="start_time" class="form-label">Jam Mulai</label>
      <input type="time" name="start_time" id="start_time" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="end_time" class="form-label">Jam Selesai</label>
      <input type="time" name="end_time" id="end_time" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="status" class="form-label">Status</label>
      <select name="status" id="status" class="form-select" required>
        <option value="active">Aktif</option>
        <option value="inactive">Nonaktif</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.doctors') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
