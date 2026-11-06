
@extends('layouts.app')

@section('title', 'Kelola Produk - GameStore')
@section('heading', 'Kelola Produk')
@section('breadcrumb', 'Manajemen Produk')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap;margin-bottom:24px">
    <div>
        <h1 style="margin:0 0 8px">Daftar Produk 🎮</h1>
        <p style="color:#94a3b8;margin:0">
            Kelola produk game digital di toko kamu.
        </p>
    </div>

    <a href="{{ route('products.create') }}" class="btn">
        + Tambah Produk
    </a>
</div>

<div class="panel">
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;min-width:750px">
            <thead>
                <tr style="color:#94a3b8;text-align:left">
                    <th style="padding:14px">Produk</th>
                    <th style="padding:14px">Game</th>
                    <th style="padding:14px">Harga</th>
                    <th style="padding:14px">Stok</th>
                    <th style="padding:14px">Rating</th>
                    <th style="padding:14px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td style="padding:14px;border-top:1px solid #293952">
                            <div style="display:flex;align-items:center;gap:12px">
                                <img
                                    src="{{ $product->image_url }}"
                                    alt="{{ $product->title }}"
                                    style="width:60px;height:60px;object-fit:cover;border-radius:9px;background:#1a2942"
                                    onerror="this.style.display='none'"
                                >
                                <div>
                                    <strong>{{ $product->title }}</strong>
                                    <div style="color:#94a3b8;font-size:12px;margin-top:5px">
                                        {{ $product->rank_name }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952">
                            {{ $product->game }}
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952;white-space:nowrap">
                            Rp {{ number_format((float)$product->price, 0, ',', '.') }}
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952">
                            {{ $product->stock }}
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952">
                            ⭐ {{ $product->rating }}
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952;white-space:nowrap">
                            <a
                                href="{{ route('products.edit', $product->id) }}"
                                style="display:inline-block;background:#1d4ed8;padding:8px 11px;border-radius:6px;margin-right:5px"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                style="display:inline"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    style="background:#991b1b;color:white;border:0;padding:8px 11px;border-radius:6px;cursor:pointer"
                                >
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:30px;text-align:center;color:#94a3b8">
                            Belum ada produk.
                            <a href="{{ route('products.create') }}" style="color:#60a5fa">
                                Tambahkan produk pertama
                            </a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
