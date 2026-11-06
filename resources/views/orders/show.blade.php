
@extends('layouts.app')

@section('title', 'Detail Pesanan - GameStore')
@section('heading', 'Detail Pesanan')
@section('breadcrumb', 'Transaksi / Detail Pesanan')

@section('content')

<div style="margin-bottom:20px">
    <a href="{{ route('orders.index') }}" style="color:#60a5fa">
        ← Kembali ke Daftar Pesanan
    </a>
</div>

<div class="panel" style="margin-bottom:22px">
    <h2 style="margin-top:0">
        Pesanan {{ $order->order_code }}
    </h2>

    <p>
        <span style="color:#94a3b8">Pelanggan:</span>
        {{ $order->customer_name ?? 'Pengguna tidak ditemukan' }}
    </p>

    <p>
        <span style="color:#94a3b8">Email:</span>
        {{ $order->customer_email ?? '-' }}
    </p>

    <p>
        <span style="color:#94a3b8">Tanggal:</span>
        {{ $order->created_at }}
    </p>

    <p>
        <span style="color:#94a3b8">Metode Pembayaran:</span>
        {{ $order->payment_method }}
    </p>

    <p>
        <span style="color:#94a3b8">Status Pembayaran:</span>
        {{ ucfirst($order->payment_status) }}
    </p>

    <h3>
        Total: Rp {{ number_format((float)$order->total, 0, ',', '.') }}
    </h3>
</div>

<div class="panel" style="margin-bottom:22px">
    <h3 style="margin-top:0">Barang yang Dipesan</h3>

    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="text-align:left;color:#94a3b8">
                    <th style="padding:12px">Nama Produk</th>
                    <th style="padding:12px">Harga Satuan</th>
                    <th style="padding:12px">Jumlah</th>
                    <th style="padding:12px">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td style="padding:12px;border-top:1px solid #293952">
                            {{ $item->product_title }}
                        </td>

                        <td style="padding:12px;border-top:1px solid #293952">
                            Rp {{ number_format((float)$item->unit_price, 0, ',', '.') }}
                        </td>

                        <td style="padding:12px;border-top:1px solid #293952">
                            {{ $item->quantity }}
                        </td>

                        <td style="padding:12px;border-top:1px solid #293952">
                            Rp {{ number_format((float)$item->unit_price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:20px;text-align:center;color:#94a3b8">
                            Belum ada rincian barang untuk pesanan ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="panel">
    <h3 style="margin-top:0">Ubah Status Pesanan</h3>

    <p style="color:#94a3b8">
        Status saat ini: {{ ucfirst($order->order_status) }}
    </p>

    <form
        action="{{ route('orders.update', $order->id) }}"
        method="POST"
        onsubmit="return confirm('Yakin ingin mengubah status pesanan ini?')"
    >
        @csrf
        @method('PATCH')

        <label for="order_status" style="display:block;margin-bottom:8px">
            Pilih status baru
        </label>

        <select
            id="order_status"
            name="order_status"
            required
            style="width:100%;max-width:350px;padding:12px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px"
        >
            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>
                Processing - Diproses
            </option>

            <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>
                Completed - Selesai
            </option>

            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>
                Cancelled - Dibatalkan
            </option>
        </select>

        <div style="margin-top:18px">
            <button type="submit" class="btn">
                Simpan Status
            </button>
        </div>
    </form>
</div>

@endsection
