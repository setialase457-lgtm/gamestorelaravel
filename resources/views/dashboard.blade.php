@extends('layouts.app')

@section('title', 'Dashboard - GameStore')
@section('heading', 'Dashboard')
@section('breadcrumb', 'Ringkasan')

@section('content')

<div style="margin-bottom:25px">
    <h1 style="margin:0 0 8px">
        Selamat Datang di GameStore 🎮
    </h1>
    <p style="color:#94a3b8;margin:0">
        Ringkasan toko game digital kamu.
    </p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:25px">

    <div class="panel">
        <p style="color:#94a3b8">Total Produk</p>
        <h2>{{ $totalProducts }}</h2>
        <a href="{{ route('products.index') }}" class="btn">
            Kelola Produk
        </a>
    </div>

    <div class="panel">
        <p style="color:#94a3b8">Total Pengguna</p>
        <h2>{{ $totalUsers }}</h2>
    </div>

    <div class="panel">
        <p style="color:#94a3b8">Total Pesanan</p>
        <h2>{{ $totalOrders }}</h2>
    </div>

</div>

<div class="panel">
    <h3>Produk Terbaru</h3>

    @if($products->isEmpty())
        <p style="color:#94a3b8">
            Belum ada produk.
            <a href="{{ route('products.create') }}" style="color:#60a5fa">
                Tambah produk pertama
            </a>
        </p>
    @else
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr>
                        <th style="text-align:left;padding:12px">Produk</th>
                        <th style="text-align:left;padding:12px">Game</th>
                        <th style="text-align:left;padding:12px">Harga</th>
                        <th style="text-align:left;padding:12px">Stok</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td style="padding:12px;border-top:1px solid #293952">
                                {{ $product->title }}
                            </td>
                            <td style="padding:12px;border-top:1px solid #293952">
                                {{ $product->game }}
                            </td>
                            <td style="padding:12px;border-top:1px solid #293952">
                                Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                            </td>
                            <td style="padding:12px;border-top:1px solid #293952">
                                {{ $product->stock }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection