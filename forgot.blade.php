<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password | Puncak Pasir Ipis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a3c2c, #2d5a3e);
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

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
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
</head>
<body>
    <div class="container">
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="card">
            <div class="logo">🏔️</div>
            <h1>LUPA PASSWORD</h1>
            <form method="POST" action="/forgot">
                @csrf
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password Baru" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" required>
                </div>
                <button type="submit">RESET PASSWORD</button>
            </form>
            <div class="back-link">
                <a href="/login">KEMBALI KE LOGIN</a>
            </div>
        </div>
    </div>
</body>
</html>