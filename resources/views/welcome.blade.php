
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameStore - Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #020617, #172554, #1e3a8a);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: white;
        }

        .container {
            width: 100%;
            max-width: 850px;
            text-align: center;
        }

        .logo {
            font-size: 65px;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        h1 span {
            color: #60a5fa;
        }

        .subtitle {
            color: #cbd5e1;
            margin-bottom: 40px;
        }

        .login-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .login-box {
            background: #1e293b;
            padding: 40px 30px;
            border-radius: 18px;
            border: 1px solid #475569;
        }

        .admin {
            border-top: 5px solid #3b82f6;
        }

        .customer {
            border-top: 5px solid #22c55e;
        }

        .icon {
            font-size: 55px;
            margin-bottom: 15px;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            outline: none;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-admin {
            background: #2563eb;
        }

        .btn-customer {
            background: #16a34a;
        }

        button:hover {
            opacity: 0.85;
        }

        .register {
            margin-top: 30px;
            color: #cbd5e1;
        }

        .register a {
            color: #4ade80;
            text-decoration: none;
            font-weight: bold;
        }

        footer {
            margin-top: 40px;
            color: #94a3b8;
            font-size: 13px;
        }

        @media(max-width: 650px) {
            .login-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="logo">🎮</div>

    <h1>GAME<span>STORE</span></h1>

    <p class="subtitle">
        Silakan login sesuai jenis akun Anda
    </p>

    <div class="login-container">

        <!-- FORM LOGIN ADMIN -->
        <div class="login-box admin">

            <div class="icon">🛡️</div>
            <h2>LOGIN ADMIN</h2>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <input
                    type="email"
                    name="email"
                    placeholder="Email Admin"
                    required
                >

                <input
                    type="password"
                    name="password"
                    placeholder="Password Admin"
                    required
                >

                <button type="submit" class="btn-admin">
                    LOGIN ADMIN
                </button>
            </form>

        </div>

        <!-- FORM LOGIN CUSTOMER -->
        <div class="login-box customer">

            <div class="icon">🎮</div>
            <h2>LOGIN CUSTOMER</h2>

            <form action="{{ route('customer.login.submit') }}" method="POST">
                @csrf

                <input
                    type="email"
                    name="email"
                    placeholder="Email Customer"
                    required
                >

                <input
                    type="password"
                    name="password"
                    placeholder="Password Customer"
                    required
                >

                <button type="submit" class="btn-customer">
                    LOGIN CUSTOMER
                </button>
            </form>

        </div>

    </div>

    <div class="register">
        Belum memiliki akun Customer?
        <a href="{{ route('customer.register') }}">
            DAFTAR SEKARANG
        </a>
    </div>

    <footer>
        © 2026 GameStore | All Rights Reserved
    </footer>

</div>

</body>
</html>
