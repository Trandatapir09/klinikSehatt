@extends('layouts.main')

@section('content')

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
