@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h3>Riwayat Antrian</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $a)
                <tr>
                    <td>{{ $a->doctor->name }}</td>
                    <td>{{ $a->appointment_date }}</td>
                    <td>{{ $a->time_range }}</td>
                    <td>{{ ucfirst($a->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
