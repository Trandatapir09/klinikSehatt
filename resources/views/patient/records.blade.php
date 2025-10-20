<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Medis - Klinik Sehat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Klinik Sehat</a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
    </form>
  </div>
</nav>

<div class="container mt-5">
  <h3 class="text-center mb-4">Riwayat Medis {{ $user->name }}</h3>

  @if($records->isEmpty())
    <div class="alert alert-info text-center">Belum ada riwayat medis.</div>
  @else
    <table class="table table-bordered shadow-sm bg-white">
      <thead class="table-primary">
        <tr>
          <th>Tanggal Pemeriksaan</th>
          <th>Dokter</th>
          <th>Keluhan</th>
          <th>Diagnosa</th>
          <th>Resep</th>
        </tr>
      </thead>
      <tbody>
        @foreach($records as $record)
          <tr>
            <td>{{ $record->examination_date }}</td>
            <td>{{ $record->doctor->name ?? 'Tidak diketahui' }}</td>
            <td>{{ $record->complaint }}</td>
            <td>{{ $record->diagnosis }}</td>
            <td>{{ $record->prescription }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

</body>
</html>
