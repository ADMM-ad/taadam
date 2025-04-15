<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
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
        
    <div class="alert-area"></div>

        <!-- Form untuk verifikasi username dan email -->
        <form id="verifyAccountForm" method="POST" action="{{ route('forgot.verify') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label"><i class="bi bi-person-fill" style="color:#31beb4; margin-right: 5px;"></i>Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username anda." required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><i class="bi bi-envelope-fill" style="color:#31beb4; margin-right: 5px;"></i>Email Pemulihan</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email pemulihan anda." required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Kirim Link Verifikasi</button>
            <a href="{{ route('login') }}" class="btn btn-secondary w-100 mt-1">Kembali</a>
        </form>

    </div>
</div>

<script>
    document.getElementById('verifyAccountForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let username = document.getElementById('username').value;
        let formData = new FormData(this);

        fetch("{{ route('forgot.verify') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            let alertArea = document.querySelector('.alert-area');
            let icon = data.success
                ? '<i class="bi bi-check-circle-fill me-2" style="font-size: 1.3rem;"></i>'
                : '<i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.3rem;"></i>';

            let alertClass = data.success ? 'alert-success' : 'alert-danger';

            alertArea.innerHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show d-flex align-items-center" role="alert">
                    ${icon}
                    <div>${data.message}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            if (data.success) {
                document.getElementById('verifyAccountForm').reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
