
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - GameStore</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #0b1120;
            color: #e5edf9;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 35px;
            background: #111c31;
            border: 1px solid #293952;
            border-radius: 18px;
            box-shadow: 0 20px 60px #0005;
        }

        .logo {
            text-align: center;
            font-size: 42px;
        }

        h1 {
            text-align: center;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #94a3b8;
            text-align: center;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin: 16px 0 8px;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #293952;
            border-radius: 8px;
            background: #0b1120;
            color: white;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: 0;
            border-radius: 8px;
            background: #3b82f6;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .error {
            padding: 12px;
            border-radius: 8px;
            background: #451a1a;
            color: #fecaca;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="logo">🎮</div>
        <h1>GameStore Admin</h1>
        <p class="subtitle">Masuk ke panel pengelolaan toko</p>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <label for="email">Email Admin</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="admin@email.com"
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Masuk ke Dashboard</button>
        </form>
    </div>
</body>
</html>
