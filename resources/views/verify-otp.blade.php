<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP | Puncak Pasir Ipis</title>
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
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="logo">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo GPPI" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
            </div>
            <h1>VERIFIKASI OTP</h1>
            <p style="text-align: center; color: #1a3c2c; margin-bottom: 20px; font-size: 14px;">
                Kode OTP telah dikirim ke email <b>{{ session('otp_email') }}</b>
            </p>
            <form method="POST" action="/verify-otp" id="otp-form">
                @csrf
                <div class="otp-container" style="display: flex; gap: 10px; justify-content: center; margin-bottom: 20px;">
                    <input type="text" class="otp-input" maxlength="1" inputmode="numeric" style="width: 40px; height: 50px; text-align: center; font-size: 20px;">
                    <input type="text" class="otp-input" maxlength="1" inputmode="numeric" style="width: 40px; height: 50px; text-align: center; font-size: 20px;">
                    <input type="text" class="otp-input" maxlength="1" inputmode="numeric" style="width: 40px; height: 50px; text-align: center; font-size: 20px;">
                    <input type="text" class="otp-input" maxlength="1" inputmode="numeric" style="width: 40px; height: 50px; text-align: center; font-size: 20px;">
                    <input type="text" class="otp-input" maxlength="1" inputmode="numeric" style="width: 40px; height: 50px; text-align: center; font-size: 20px;">
                    <input type="text" class="otp-input" maxlength="1" inputmode="numeric" style="width: 40px; height: 50px; text-align: center; font-size: 20px;">
                </div>

                <input type="hidden" name="otp" id="otp-hidden">

                <button type="submit">VERIFIKASI KODE</button>
            </form>
            <div class="back-link">
                <form action="/resend-otp" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #2d5a3e; text-decoration: underline; cursor: pointer; font-size: 13px; padding: 0;">
                        KIRIM ULANG KODE
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenInput = document.getElementById('otp-hidden');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length > 0) {
                // Pindah ke kotak berikutnya jika diisi
                if (index < inputs.length - 1) inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            // Pindah ke kotak sebelumnya jika tombol Backspace ditekan
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    // Gabungkan semua nilai ke input tersembunyi sebelum submit
    document.getElementById('otp-form').addEventListener('submit', () => {
        let otpValue = '';
        inputs.forEach(input => otpValue += input.value);
        hiddenInput.value = otpValue;
    });
</script>
</body>
</html>
