@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h3>🗑 Trash Bin Pasien</h3>

    <a href="{{ route('admin.patients') }}" class="btn btn-primary mb-3">⬅ Kembali</a>

    <table class="table table-bordered table-striped">
        <thead class="table-warning">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Dihapus Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->deleted_at }}</td>
                <td>
                    <form action="{{ route('admin.patients.restore', $patient->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Restore</button>
                    </form>

                    <form action="{{ route('admin.patients.forceDelete', $patient->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete Permanen</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection
