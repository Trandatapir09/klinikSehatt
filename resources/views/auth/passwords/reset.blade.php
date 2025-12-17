@extends('layouts.main')
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="card shadow p-4" style="width: 400px;">
    <h4 class="text-center mb-3 text-primary">🔑 Atur Ulang Password</h4>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required>
      </div>

      <div class="mb-3">
        <label>Password Baru</label>
        <input type="password" class="form-control" name="password" required>
      </div>

      <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input type="password" class="form-control" name="password_confirmation" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Simpan Password Baru</button>
    </form>
  </div>
</div>
@endsection
