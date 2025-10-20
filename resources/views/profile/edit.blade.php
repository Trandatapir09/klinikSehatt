@extends('layouts.main')

@section('content')
<div class="container mt-5">
  <h3 class="mb-4 text-center">Edit Profil</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow-sm mx-auto" style="max-width:600px;">
    <div class="card-body">
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="text-center mb-3">
          @if($user->photo)
            <img src="{{ asset('storage/'.$user->photo) }}" class="rounded-circle" width="120" height="120" style="object-fit: cover;">
          @else
            <img src="{{ asset('images/default-avatar.png') }}" class="rounded-circle" width="120" height="120" style="object-fit: cover;">
          @endif
          <div class="mt-2">
            <input type="file" name="photo" class="form-control">
          </div>
        </div>

        <div class="mb-3">
          <label>Nama</label>
          <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>No. Telepon</label>
          <input type="text" name="phone" value="{{ $user->phone ?? '' }}" class="form-control">
        </div>

        <div class="mb-3">
          <label>Alamat</label>
          <textarea name="address" class="form-control">{{ $user->address ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
      </form>
      <div class="d-flex justify-content-between mt-4">
  <a href="{{ route('dashboard.redirect') }}" class="btn btn-secondary">
    ← Kembali
  </a>
</div>

    </div>
  </div>
</div>
@endsection
