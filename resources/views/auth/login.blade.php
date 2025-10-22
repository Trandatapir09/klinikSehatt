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
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required autofocus>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger py-2">{{ $errors->first('email') }}</div>
      @endif

      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

            <div class="text-center mt-3">
              <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-house"></i> Kembali ke Beranda
              </a>
            </div>

            <p class="text-center mt-3 mb-0">
              Belum punya akun?
              <a href="{{ route('register.form') }}" class="text-primary text-decoration-none">Daftar Sekarang</a>
            </p>

  </div>
</div>

</body>
</html>