@extends('layouts.main')
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="card shadow p-4" style="width: 400px;">
    <h4 class="text-center mb-3 text-primary">🔐 Lupa Password</h4>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required autofocus>
        @error('email')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
      <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 mt-2">Kembali ke Login</a>
    </form>
  </div>
</div>
@endsection
