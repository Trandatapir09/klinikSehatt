@extends('layouts.main')

@section('content')
<div class="container mt-5">

<h3>Kelola Antrian</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Pasien</th>
            <th>Dokter</th>
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
                <td>{{ $a->doctor->name }}</td>
                <td>{{ $a->appointment_date }}</td>
                <td>{{ $a->time_range }}</td>
                <td>{{ $a->status }}</td>
                <td>
                    <form action="{{ route('admin.appointments.update', $a->id) }}" method="POST">
                        @csrf
                        <select name="status" class="form-control">
                            <option value="pending">Menunggu</option>
                            <option value="in-progress">Diproses</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                        <button class="btn btn-success btn-sm mt-1">Update</button>
                    </form>

                    <form action="{{ route('admin.appointments.delete', $a->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm mt-1">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection
