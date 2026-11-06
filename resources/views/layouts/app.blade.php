
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GameStore Admin')</title>

    <style>
        :root {
            --bg: #0b1120;
            --panel: #111c31;
            --panel-light: #1a2942;
            --border: #293952;
            --text: #e5edf9;
            --muted: #94a3b8;
            --blue: #3b82f6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app {
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            inset: 0 auto 0 0;
            background: #0f192b;
            border-right: 1px solid var(--border);
            padding: 24px 16px;
            overflow-y: auto;
        }

        .brand {
            font-size: 22px;
            font-weight: 800;
            color: #60a5fa;
            padding: 8px 12px 28px;
        }

        .brand small {
            display: block;
            font-size: 11px;
            color: var(--muted);
            margin-top: 7px;
            font-weight: normal;
            letter-spacing: 2px;
        }

        .menu-label {
            color: #64748b;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.5px;
            padding: 12px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin: 5px 0;
            border-radius: 9px;
            color: #b9c6d9;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu-link:hover,
        .menu-link.active {
            background: #1d3a65;
            color: #ffffff;
        }

        .menu-link.active {
            border-left: 3px solid #60a5fa;
        }

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            min-height: 76px;
            padding: 18px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            background: #0f192b;
            border-bottom: 1px solid var(--border);
        }

        .topbar h2 {
            font-size: 20px;
            margin: 0;
        }

        .topbar p {
            color: var(--muted);
            font-size: 12px;
            margin: 6px 0 0;
        }

        .admin-chip {
            background: var(--panel-light);
            border: 1px solid var(--border);
            padding: 10px 13px;
            border-radius: 9px;
            font-size: 13px;
        }

        .content {
            padding: 30px;
            max-width: 1600px;
            margin: auto;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 22px;
        }

        .btn {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 8px;
            background: var(--blue);
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #2563eb;
        }

        .notice {
            background: #064e3b;
            border: 1px solid #047857;
            color: #d1fae5;
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .footer {
            padding: 20px 30px;
            color: #64748b;
            font-size: 12px;
        }

        @media (max-width: 760px) {
            .sidebar {
                position: static;
                width: 100%;
                padding: 12px;
            }

            .brand {
                padding: 10px;
            }

            .sidebar nav {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .menu-label {
                width: 100%;
            }

            .menu-link {
                padding: 10px;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 18px;
            }

            .content {
                padding: 18px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="app">

    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            🎮 GameStore
            <small>ADMIN CONTROL PANEL</small>
        </a>

        <nav>
            <div class="menu-label">MENU UTAMA</div>

            <a href="{{ route('dashboard') }}"
               class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span>🏠</span> Dashboard
            </a>

            <a href="{{ route('products.index') }}"
               class="menu-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span>🎮</span> Kelola Produk
            </a>

            <div class="menu-label">TRANSAKSI</div>

            <a href="{{ route('orders.index') }}"
                class="menu-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <span>🛒</span> Pesanan
            </a>

           
            <a href="{{ route('payments.index') }}"
            class="menu-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <span>💳</span> Pembayaran
            </a>


            <div class="menu-label">MANAJEMEN</div>

            
            <a href="{{ route('users.index') }}"
             class="menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
             <span>👥</span> Pengguna
            </a>


            <a href="#" class="menu-link">
                <span>📊</span> Laporan
            </a>
            
            <a href="{{ route('admin.settings') }}"
             class="menu-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <span>⚙️</span> Pengaturan Akun
            </a>
      </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h2>@yield('heading', 'Dashboard')</h2>
                <p>GameStore / @yield('breadcrumb', 'Dashboard')</p>
            </div>

            <div class="admin-chip">
                👤 Administrator
                
         <form action="{{ route('logout') }}" method="POST" style="margin-top: 15px;">
                 @csrf
            <button type="submit"
        style="width:100%; padding:12px; border:0; border-radius:8px;
        background:#dc2626; color:white; cursor:pointer; text-align:left;">
             🚪 Logout
        </button>
        </form>

            </div>
        </header>

        <section class="content">
            @if (session('success'))
                <div class="notice">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </section>

        <footer class="footer">
            © {{ date('Y') }} GameStore Admin Panel
        </footer>
    </main>

</div>

@stack('scripts')
</body>
</html>
