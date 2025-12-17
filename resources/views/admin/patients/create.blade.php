@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h3>Tambah Pasien</h3>

    <form action="{{ route('admin.patients.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Pasien</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.patients') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
