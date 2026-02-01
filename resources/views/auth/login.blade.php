<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff - Klique</title>
    @vite(['resources/css/bootstrap.min.css', 'resources/css/login.css', 'resources/js/bootstrap.bundle.min.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">
        <div class="row row-login">
            {{-- left content --}}
            <div class="col-md-7 col-lg-8 left-side d-none d-md-block">
                <div class="overlay">
                    <div class="logo-circle">
                        <div class="logo-icon">K</div>
                    </div>
                    <h1 class="fw-bold display-5">{{ config('klinik.name') }} Dashboard</h1>
                    <p class="fs-5 opacity-75">{{ config('klinik.short_desc') }}</p>
                </div>
            </div>
            {{-- right content --}}
            <div class="col-md-5 col-lg-4 right-side">
                <div class="form-container">
                    <div class="mb-5">
                        <h3 class="fw-bold text-dark">Selamat Datang</h3>
                        <p class="text-muted">Silakan masuk untuk mengakses panel staf.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                            <small>{{ $errors->first() }}</small>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="usernameInput"
                                placeholder="Username" value="{{ old('username') }}" required>
                            <label for="usernameInput">Username</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="passwordInput"
                                placeholder="Password" required>
                            <label for="passwordInput">Password</label>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-login">Masuk Aplikasi</button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted small">Belum punya akun? <a href="{{ route('register') }}"
                                    class="text-decoration-none fw-bold text-primary">Daftar disini</a></p>
                        </div>
                    </form>

                    <div class="mt-5 text-center text-muted" style="font-size: 0.7rem;">
                        &copy; {{ date('Y') }} Klique App.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
