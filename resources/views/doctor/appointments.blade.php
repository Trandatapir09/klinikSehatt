@extends('layouts.main')

@section('content')
<div class="container mt-5">

<h3>Daftar Antrian Pasien</h3>
<a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary mb-3">
    ← Kembali
</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Pasien</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($appointments as $a)
<tr>
    <td>{{ $a->patient->name }}</td>
    <td>{{ $a->appointment_date }}</td>
    <td>{{ $a->time_range }}</td>
    <td>{{ $a->status }}</td>
    <td>
        @if ($a->status !== 'completed')
        <form method="POST" action="{{ route('doctor.appointment.complete', $a->id) }}">
            @csrf
            <button class="btn btn-success btn-sm">
                Selesai
            </button>
        </form>
        @else
            <span class="badge bg-success">Selesai</span>
        @endif
    </td>
</tr>
@endforeach
    </tbody>
</table>

</div>
@endsection
