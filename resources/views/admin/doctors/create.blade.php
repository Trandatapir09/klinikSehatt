@extends('layouts.main')
@section('title', 'Tambah Dokter - Klinik Sehat')

@section('content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-primary fw-bold">➕ Tambah Dokter Baru</h3>
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

  <form action="{{ route('admin.doctors.store') }}" method="POST" class="shadow p-4 rounded-3 bg-white">
    @csrf

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama Dokter</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Contoh: dr. Hima" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Spesialisasi</label>
        <input type="text" name="specialization" value="{{ old('specialization') }}" class="form-control" placeholder="Contoh: Umum, Gigi, Anak..." required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Hari Praktik</label>
        <input type="text" name="day" value="{{ old('day') }}" class="form-control" placeholder="Contoh: Senin - Jumat" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Jam Mulai</label>
        <input type="time" name="start_time" value="{{ old('start_time') }}" class="form-control" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Jam Selesai</label>
        <input type="time" name="end_time" value="{{ old('end_time') }}" class="form-control" required>
      </div>

      {{-- Email otomatis --}}
      <div class="col-md-6">
        <label class="form-label">Email (otomatis)</label>
        <input type="email" id="email" name="email" class="form-control" readonly>
      </div>

      {{-- Password otomatis --}}
      <div class="col-md-6">
        <label class="form-label">Password Default</label>
        <input type="text" name="password" value="123123" class="form-control" readonly>
      </div>
    </div>

          <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="active" selected>Aktif</option>
          <option value="inactive">Tidak Aktif</option>
        </select>
      </div>

    <div class="mt-4 text-end">
      <button type="submit" class="btn btn-success px-4">
        💾 Simpan Dokter
      </button>
    </div>
  </form>
</div>

{{-- 🔹 Script otomatis buat email --}}
@push('scripts')
<script>
document.getElementById('name').addEventListener('input', function() {
    const name = this.value.trim().toLowerCase();
    const cleanName = name.replace(/[^a-z0-9]/g, '');
    document.getElementById('email').value = cleanName ? cleanName + '@klinik.com' : '';
});
</script>
@endpush
@endsection
