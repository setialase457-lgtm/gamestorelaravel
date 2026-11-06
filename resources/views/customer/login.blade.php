
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Customer - GameStore</title>
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
            box-shadow: 0 10px 30px #0005;
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
            margin-top: 10px;
        }
        a { color: #60a5fa; }
        .error { color: #fca5a5; }
    </style>
</head>
<body>
<div class="box">
    <h2>🎮 GameStore</h2>
    <p style="text-align:center">Login Akun Customer</p>

    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('customer.login.submit') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('customer.register') }}">Daftar sekarang</a></p>
    <p><a href="{{ route('login') }}">Login Admin</a></p>
</div>
</body>
</html>
