
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Produk - GameStore</title>
    <style>
        body {
            background: #0b1120;
            color: #e5e7eb;
            font-family: Arial, sans-serif;
            padding: 25px;
        }
        .container {
            max-width: 750px;
            margin: auto;
            background: #172033;
            padding: 25px;
            border-radius: 12px;
        }
        h1 { color: #60a5fa; }
        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;
        }
        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            background: #0b1120;
            color: white;
            border: 1px solid #334155;
            border-radius: 7px;
        }
        button, .back {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 17px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
        }
        .error {
            background: #7f1d1d;
            padding: 12px;
            border-radius: 7px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>✏️ Edit Produk Game</h1>
    <p>Ubah informasi produk sesuai kebutuhan.</p>

    <a href="{{ route('products.index') }}" class="back">
        ← Kembali ke Daftar Produk
    </a>

    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Produk</label>
        <input type="text" name="title"
               value="{{ old('title', $product->title) }}"
               maxlength="180" required>

        <label>Game</label>
        <select name="game" required>
            @foreach (['Mobile Legends', 'Free Fire', 'Genshin Impact', 'Valorant'] as $game)
                <option value="{{ $game }}"
                    @selected(old('game', $product->game) === $game)>
                    {{ $game }}
                </option>
            @endforeach
        </select>

        <label>Rank</label>
        <input type="text" name="rank_name"
               value="{{ old('rank_name', $product->rank_name) }}"
               maxlength="100" required>

        <label>Deskripsi</label>
        <textarea name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>

        <label>Harga (Rupiah)</label>
        <input type="number" name="price" min="0" step="0.01"
               value="{{ old('price', $product->price) }}" required>

        <label>Stok</label>
        <input type="number" name="stock" min="0"
               value="{{ old('stock', $product->stock) }}" required>

        <label>Rating (maksimal 9.9)</label>
        <input type="number" name="rating" min="0" max="9.9"
               step="0.1" value="{{ old('rating', $product->rating) }}" required>

        <label>URL Gambar</label>
        <input type="url" name="image_url" maxlength="600"
               value="{{ old('image_url', $product->image_url) }}" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
