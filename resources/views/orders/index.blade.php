
@extends('layouts.app')

@section('title', 'Kelola Pesanan - GameStore')
@section('heading', 'Kelola Pesanan')
@section('breadcrumb', 'Transaksi / Pesanan')

@section('content')

<div style="margin-bottom:24px">
    <h1 style="margin:0 0 8px">Daftar Pesanan 🛒</h1>
    <p style="color:#94a3b8;margin:0">
        Pantau transaksi dan status pesanan pelanggan.
    </p>
</div>

<div class="panel">
    <div style="overflow-x:auto">
        <table style="width:100%;min-width:800px;border-collapse:collapse">
            <thead>
                <tr style="text-align:left;color:#94a3b8">
                    <th style="padding:14px">Kode Pesanan</th>
                    <th style="padding:14px">Pelanggan</th>
                    <th style="padding:14px">Total</th>
                    <th style="padding:14px">Pembayaran</th>
                    <th style="padding:14px">Status Pesanan</th>
                    <th style="padding:14px">Detail</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td style="padding:14px;border-top:1px solid #293952">
                            <strong>{{ $order->order_code }}</strong>
                            <div style="color:#94a3b8;font-size:12px;margin-top:5px">
                                {{ $order->created_at }}
                            </div>
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952">
                            {{ $order->customer_name ?? 'Pengguna tidak ditemukan' }}
                            <div style="color:#94a3b8;font-size:12px;margin-top:5px">
                                {{ $order->customer_email ?? '-' }}
                            </div>
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952;white-space:nowrap">
                            Rp {{ number_format((float)$order->total, 0, ',', '.') }}
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952">
                            {{ ucfirst($order->payment_status) }}
                            <div style="color:#94a3b8;font-size:12px;margin-top:5px">
                                {{ $order->payment_method }}
                            </div>
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952">
                            {{ ucfirst($order->order_status) }}
                        </td>

                        <td style="padding:14px;border-top:1px solid #293952">
                            <a href="{{ route('orders.show', $order->id) }}"
                               class="btn">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:30px;text-align:center;color:#94a3b8">
                            Belum ada pesanan di database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px">
        {{ $orders->links() }}
    </div>
</div>

@endsection
