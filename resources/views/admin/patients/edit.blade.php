@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h3>Edit Data Pasien</h3>

    <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" value="{{ $patient->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="phone" value="{{ $patient->phone }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control">{{ $patient->address }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.patients') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
