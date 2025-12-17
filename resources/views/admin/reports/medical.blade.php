@extends('layouts.main')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">📊 Laporan Rekam Medis</h3>

    <a href="{{ route('admin.reports.medical.download', request()->query()) }}"
    class="btn btn-success">
    ⬇ Download Rekam Medis
    </a>
    <br>
    <br>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Keluhan</th>
                        <th>Diagnosis</th>
                        <th>Resep</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $r)
                    <tr>
                        <td>{{ $r->examination_date }}</td>
                        <td>{{ $r->patient_name }}</td>
                        <td>{{ $r->doctor->name ?? '-' }}</td>
                        <td>{{ $r->complaint }}</td>
                        <td>{{ $r->diagnosis }}</td>
                        <td>{{ $r->prescription }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($records->count() == 0)
            <p class="text-center mt-3 text-muted">Tidak ada data untuk ditampilkan.</p>
            @endif
        </div>
    </div>
<br>
<div class="container mt-4">
    <h3 class="mb-4">📊 Laporan Rekam Transaki</h3>

<a href="{{ route('admin.reports.transactions.download', request()->query()) }}"
   class="btn btn-success">
   ⬇ Download Transaksi Selesai
</a>
<br>
<br>

<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
      ← Kembali
    </a>
</div>
@endsection


