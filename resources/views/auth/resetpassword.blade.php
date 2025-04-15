<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<style>
    .btn-primary {
        background-color: #31beb4;
        border-color: #31beb4;
    }

    .btn-primary:hover {
        background-color: #28a7a3;
        border-color: #28a7a3;
    }
</style>
<body style="background-color: #30BEB5;">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
        

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.3rem;"></i>
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<form method="POST" action="{{ route('update.password') }}">
    @csrf
    <input type="hidden" name="email" value="{{ request('email') }}">
    <input type="hidden" name="token" value="{{ request('token') }}">

    <label><i class="bi bi-shield-lock-fill" style="color:#31beb4; margin-right: 5px;"></i>Password Baru</label>
<div class="input-group">
    <input type="password" name="password" placeholder="Masukan password baru anda." required class="form-control" id="password">
    <span class="input-group-text" onclick="togglePasswordVisibility('password')">
        <i class="bi bi-eye-slash" id="password-eye"></i>
    </span>
</div>

<label class="mt-3"><i class="bi bi-check-circle-fill" style="color:#31beb4; margin-right: 5px;"></i>Konfirmasi Password</label>
<div class="input-group">
    <input type="password" name="password_confirmation" placeholder="Masukan ulang password baru anda." required class="form-control" id="password_confirmation">
    <span class="input-group-text" onclick="togglePasswordVisibility('password_confirmation')">
        <i class="bi bi-eye-slash" id="password_confirmation-eye"></i>
    </span>
</div>

    <button class="btn btn-primary w-100 mt-3">Reset Password</button>
</form>
</div>
</div>
</body>
<script>
    function togglePasswordVisibility(inputId) {
        var input = document.getElementById(inputId);
        var icon = document.getElementById(inputId + '-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>