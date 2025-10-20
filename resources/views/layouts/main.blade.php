<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Sehat')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/templatemo-medic-care.css') }}" rel="stylesheet">
</head>
<body>

    {{-- 🔹 Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="{{ url('/') }}">Klinik Sehat</a>

            <div class="d-flex align-items-center ms-auto">
            @auth
            <div class="d-flex align-items-center ms-auto">
                {{-- Foto Profil --}}
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                        alt="Foto Profil"
                        class="rounded-circle me-2 border border-light"
                        style="width: 40px; height: 40px; object-fit: cover;">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}"
                        alt="Default Avatar"
                        class="rounded-circle me-2 border border-light"
                        style="width: 40px; height: 40px; object-fit: cover;">
                @endif

                <span class="text-black me-3 fw-semibold">{{ Auth::user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-outline-dark btn-sm">Logout</button>
                </form>
              </div>
            @else
              <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
              <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            @endauth
          </div>

        </div>
    </nav>

    {{-- 🔹 Jarak agar konten tidak tertutup navbar --}}
    <div style="margin-top: 80px;">
        @yield('content')
    </div>

    {{-- 🔹 Footer --}}
    <footer class="text-center mt-5 text-muted mb-3">
        <small>© {{ date('Y') }} Klinik Sehat — Semua Hak Dilindungi.</small>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>

    <script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            responsive:{
                0:{ items:1 },
                600:{ items:1 },
                1000:{ items:1 }
            }
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stack('scripts')
</body>
</html>
