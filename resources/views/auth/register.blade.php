<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Include Bootstrap & Other CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">

    <style>
        body {
            background-color: #30BEB5;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: #ffffff;
            color: #333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            margin: 0 auto;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #ffffff;
            padding: 0.5rem;
        }

        .btn-primary {
            background-color: #fb8149;
            border-color: #fb8149;
        }

        .btn-primary:hover {
            background-color: #e96c3c;
            border-color: #e96c3c;
        }

        .btn-secondary {
            background-color: #ffffff;
            color: #fb8149;
            border-color: #fb8149;
        }

        .btn-secondary:hover {
            background-color: #fb8149;
            color: #ffffff;
        }

        .logo {
            text-align: center;
            margin-bottom: 0px;
        }

        .logo img {
            height: 80px;
        }

        .form-group label {
            color: #333;
        }

        @media (max-width: 767px) {
            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5 mb-5">
                <div class="card-header text-center">
                    <div class="logo">
                        <img src="{{ asset('gambar/logo.png') }}" alt="Logo">
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Name (Optional)') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukan Nama Anda">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukan Email Anda" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukan Password Anda" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Masukan Ulang Password Anda" required>
                        </div>

                        <div class="form-group">
                            <label for="no_hp">{{ __('Nomor HP (Optional)') }}</label>
                            <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukan Nomor HP Anda">
                            @error('no_hp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role">{{ __('Role') }}</label>
                            <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                <option value="pimpinan">Pimpinan</option>
                                <option value="teamleader">Team Leader</option>
                                <option value="karyawan">Karyawan</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Register') }}
                        </button>

                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-block mt-2">
                            Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/dist/js/adminlte.js') }}"></script>
</body>
</html>
