<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | Puncak Pasir Ipis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
    font-family: Arial, sans-serif;
    /* Gabungan gambar dan overlay gradasi hijau transparan */
    background: linear-gradient(
            rgba(26, 60, 44, 0.7),
            rgba(45, 90, 62, 0.6)
        ),
        url("{{ asset('img/puncak.jpg') }}") no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .card {
            background: #f5f0e1;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .logo {
            text-align: center;
            font-size: 50px;
            margin-bottom: 10px;
        }

        h1 {
            text-align: center;
            color: #1a3c2c;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #c4b99a;
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1a3c2c;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #2d5a3e;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #2d5a3e;
            text-decoration: none;
            font-size: 13px;
        }

        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-success {
            background: #2e7d5e;
            color: white;
        }

        .alert-error {
            background: #c62828;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="card">
            <div class="logo">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo GPPI" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
            </div>
            <h1>REGISTER</h1>
            <form method="POST" action="/register">
                @csrf
                <div class="input-group">
                    <input type="text" name="nama_user" placeholder="Nama Lengkap" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group" style="position: relative;">
                    <input type="password" name="password" id="password" placeholder="Password" required style="width: 100%; padding-right: 40px;">
                    <i class="fa fa-eye-slash" id="togglePassword1" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #728156; opacity: 0.7;"></i>
                </div>

                <div class="input-group" style="position: relative;">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required style="width: 100%; padding-right: 40px;">
                    <i class="fa fa-eye-slash" id="togglePassword2" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #728156; opacity: 0.7;"></i>
                </div>
                <button type="submit">DAFTAR</button>
            </form>
            <div class="login-link">
                <a href="/login">SUDAH PUNYA AKUN? LOGIN</a>
            </div>
        </div>
    </div>
    <script>
    // FUNGSI MATA 1 (PASSWORD UTAMA)
    const togglePassword1 = document.querySelector('#togglePassword1');
    const passwordField1 = document.querySelector('#password');

    togglePassword1.addEventListener('click', function () {
        const type = passwordField1.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField1.setAttribute('type', type);

        // Tukar ikon
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });

    // FUNGSI MATA 2 (KONFIRMASI PASSWORD)
    const togglePassword2 = document.querySelector('#togglePassword2');
    const passwordField2 = document.querySelector('#password_confirmation');

    togglePassword2.addEventListener('click', function () {
        const type = passwordField2.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField2.setAttribute('type', type);

        // Tukar ikon
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });
</script>
</body>
</html>
