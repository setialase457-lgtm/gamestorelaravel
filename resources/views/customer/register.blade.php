
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Customer - GameStore</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #101827, #253b63);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .box {
            width: 350px;
            background: #1e293b;
            padding: 30px;
            border-radius: 15px;
        }
        h2 { text-align: center; }
        input {
            width: 100%;
            padding: 12px;
            margin: 9px 0;
            box-sizing: border-box;
            border: 0;
            border-radius: 7px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 7px;
            cursor: pointer;
        }
        a { color: #60a5fa; }
        .error { color: #fca5a5; }
    </style>
</head>
<body>
<div class="box">
    <h2>🎮 GameStore</h2>
    <p style="text-align:center">Buat Akun Customer</p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('customer.register.submit') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password minimal 8 karakter" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        <button type="submit">Daftar Sekarang</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('customer.login') }}">Login</a></p>
</div>
</body>
</html>
