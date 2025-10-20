<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pasien - Klinik Sehat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3>Riwayat Medis Pasien: {{ $patient->name }}</h3>

  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Keluhan</th>
        <th>Diagnosis</th>
        <th>Resep</th>
        <th>Catatan</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $r)
        <tr>
          <td>{{ $r->examination_date }}</td>
          <td>{{ $r->complaint }}</td>
          <td>{{ $r->diagnosis }}</td>
          <td>{{ $r->prescription }}</td>
          <td>{{ $r->notes }}</td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted">Belum ada riwayat medis</td></tr>
      @endforelse
    </tbody>
  </table>

  <hr>
  <h5>Tambah Riwayat Baru</h5>
  <form action="{{ route('doctor.record.store') }}" method="POST">
  @csrf
  <input type="hidden" name="patient_id" value="{{ $patient->id }}">
  <input type="hidden" name="patient_name" value="{{ $patient->name }}">

  <div class="mb-3">
    <label for="complaint" class="form-label">Keluhan</label>
    <textarea name="complaint" id="complaint" class="form-control" required></textarea>
  </div>

  <div class="mb-3">
    <label for="diagnosis" class="form-label">Diagnosis</label>
    <input type="text" name="diagnosis" id="diagnosis" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="prescription" class="form-label">Resep</label>
    <textarea name="prescription" id="prescription" class="form-control" required></textarea>
  </div>

  <div class="mb-3">
    <label for="notes" class="form-label">catatan</label>
    <textarea name="notes" id="notes" class="form-control" required></textarea>
  </div>

  <div class="mb-3">
    <label for="examination_date" class="form-label">Tanggal Pemeriksaan</label>
    <input type="date" name="examination_date" id="examination_date" class="form-control" required>
  </div>

  <div class="d-flex justify-content-between">
      <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary">← Kembali</a>
      <button class="btn btn-success">💾 Simpan</button>
    </div>
</form>

</div>
</body>
</html>
