@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h3>Manajemen Pasien</h3>

    <a href="{{ route('admin.patients.create') }}" class="btn btn-primary mb-3">+ Tambah Pasien</a>
    <a href="{{ route('admin.patients.trash') }}" class="btn btn-secondary mb-3">
        🗑 Trash Bin
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->phone ?? '-' }}</td>
                <td>{{ $p->address ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.patients.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('admin.patients.delete', $p->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus pasien ini?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $patients->links() }}
</div>
@endsection
