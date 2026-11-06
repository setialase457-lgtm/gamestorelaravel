
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - GameStore</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        header {
            background: #172554;
            color: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        main { padding: 30px 5%; }
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px #0001;
        }
        .price { color: #2563eb; font-weight: bold; }
        button {
            background: #dc2626;
            color: white;
            border: 0;
            padding: 10px 15px;
            border-radius: 7px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
    <h2>🎮 GameStore</h2>
    <form action="{{ route('customer.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</header>

<main>
    <h2>Selamat Datang, {{ session('customer_name') }}!</h2>
    <p>Silakan lihat produk game yang tersedia.</p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="products">
        @forelse ($products as $product)
            <div class="card">
                <h3>{{ $product->title }}</h3>
                <p>{{ $product->game }}</p>
                <p>{{ $product->description }}</p>
                <p class="price">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <p>Stok: {{ $product->stock }}</p>
            </div>
        @empty
            <p>Belum ada produk tersedia.</p>
        @endforelse
    </div>
</main>
</body>
</html>
