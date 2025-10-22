<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Klinik Sehat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg border-0">
        <div class="card-body p-4">
          <h3 class="text-center mb-4">Register</h3>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Register As</label>
              <select name="role" class="form-select" required>
                <option value="patient">Patient</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
            <div class="text-center mt-3">
              <small>Already have an account? <a href="/login">Login</a></small>
            </div>
          </form><br>
          <div class="text-center-mt3">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">
              <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
