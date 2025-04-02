<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
        <h4 class="text-center">Lupa Password</h4>

        <!-- Form untuk cek username -->
        <form id="checkUsernameForm" method="POST" action="{{ route('check.username') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Masukkan Username Anda</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cek Username</button>
        </form>

        <!-- Form untuk reset password (disembunyikan awalnya) -->
        <form id="resetPasswordForm" method="POST" action="{{ route('update.password') }}" style="display: none;">
            @csrf
            <input type="hidden" id="resetUsername" name="username">

            <!-- Input Password Baru -->
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'togglePasswordIcon1')">
                        <i id="togglePasswordIcon1" class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>

            <!-- Input Konfirmasi Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')">
                        <i id="togglePasswordIcon2" class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Reset Password</button>
        </form>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        let input = document.getElementById(inputId);
        let icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    }

    document.getElementById('checkUsernameForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let username = document.getElementById('username').value;
        let formData = new FormData(this);

        fetch("{{ route('check.username') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('resetPasswordForm').style.display = 'block';
                document.getElementById('resetUsername').value = username;
                document.getElementById('checkUsernameForm').style.display = 'none';
            } else {
                alert("Username tidak ditemukan!");
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

</body>
</html>
