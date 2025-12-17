<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Klinik Sehat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="card shadow p-4" style="width: 400px;">
    <h4 class="text-center mb-3 text-primary">🏥 Klinik Sehat</h4>

    <form action="{{ route('login.post') }}" method="POST">
      @csrf

      {{-- Email --}}
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Captcha --}}
      <div class="mb-3">
        <label for="captcha" class="form-label">Captcha</label>
        <div class="d-flex align-items-center">
          <span>{!! captcha_img() !!}</span>
          <button type="button" class="btn btn-outline-secondary ms-2" id="reload-captcha" title="Reload Captcha">
            🔄
          </button>
        </div>
        <input id="captcha" type="text" class="form-control mt-2 @error('captcha') is-invalid @enderror" name="captcha" placeholder="Masukkan captcha" required>
        @error('captcha')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      {{-- Tombol Login --}}
      <button type="submit" class="btn btn-primary w-100">Login</button>

      <div class="text-center mt-2">
  <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa Password?</a>
</div>

    </form>

    {{-- Tombol Kembali --}}
    <div class="text-center mt-3">
      <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">
        <i class="bi bi-house"></i> Kembali ke Beranda
      </a>
    </div>

    {{-- Register Link --}}
    <p class="text-center mt-3 mb-0">
      Belum punya akun?
      <a href="{{ route('register.form') }}" class="text-primary text-decoration-none">Daftar Sekarang</a>
    </p>
  </div>
</div>

{{-- Script Reload Captcha --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#reload-captcha').click(function () {
    $.ajax({
      type: 'GET',
      url: '{{ url("reload-captcha") }}',
      success: function (data) {
        $('span').html(data.captcha);
      }
    });
  });
</script>

</body>
</html>