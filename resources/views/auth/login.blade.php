<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <style>
        body {
            background-color: #30BEB5;
            color: #ffffff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 450px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .logo {
            max-width: 100%;
            height: auto;
            max-height: 100px;
        }

        .card-body {
            padding: 30px;
        }

        .btn-primary {
            background-color: #fb8149;
            border-color: #fb8149;
        }

        .btn-primary:hover {
            background-color: #e96c3c;
            border-color: #e96c3c;
        }

        @media (min-width: 768px) {
            .card {
                max-width: 600px;
            }

            .logo-container {
                height: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> 
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> 
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 d-flex justify-content-center">
            <div class="card">
                <div class="row g-0 flex-column flex-md-row">
                    <!-- Logo (Atas di HP, Kiri di Desktop) -->
                    <div class="col-12 col-md-4 logo-container">
                        <img src="{{ asset('gambar/logo.png') }}" alt="Logo" class="logo">
                    </div>

                    <!-- Form Login -->
                    <div class="col-12 col-md-8">
                        <div class="card-body">
                            <h4 class="text-center text-dark mb-3">Login</h4>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="username" class="text-dark">Username</label>
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                                           name="username" value="{{ old('username') }}" 
                                           placeholder="Masukkan Username Anda" required autofocus>
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
    <label for="password" class="text-dark">Password</label>
    <div class="input-group">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
               name="password" placeholder="Masukkan Password Anda" required>
        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="bi bi-eye-slash"></i>
        </button>
    </div>
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>


                                <!-- Lupa Password -->
                                <div class="mb-3 text-end">
                                    <a href="{{ route('forgot.password') }}" class="text-decoration-none text-primary">
                                        Lupa Password?
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block w-100">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        let passwordField = document.getElementById('password');
        let icon = this.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    });
</script>

</body>
</html>
