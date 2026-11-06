
@extends('layouts.app')

@section('title', 'Pembayaran - GameStore')
@section('heading', 'Pembayaran')
@section('breadcrumb', 'Transaksi / Pembayaran')

@section('content')

<div style="margin-bottom:24px">
    <h1 style="margin:0 0 8px">Pembayaran 💳</h1>
    <p style="color:#94a3b8;margin:0">
        Pantau dan kelola status pembayaran pesanan pelanggan.
    </p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:16px;margin-bottom:22px">

    <div class="panel">
        <p style="color:#94a3b8;margin-top:0">Total Transaksi</p>
        <h2>{{ $totalTransactions }}</h2>
    </div>

    <div class="panel">
        <p style="color:#fbbf24;margin-top:0">Menunggu Pembayaran</p>
        <h2>{{ $pendingCount }}</h2>
    </div>

    <div class="panel">
        <p style="color:#86efac;margin-top:0">Pembayaran Lunas</p>
        <h2>{{ $paidCount }}</h2>
    </div>

    <div class="panel">
        <p style="color:#fca5a5;margin-top:0">Pembayaran Gagal</p>
        <h2>{{ $failedCount }}</h2>
    </div>

    <div class="panel">
        <p style="color:#94a3b8;margin-top:0">Total Pembayaran Lunas</p>
        <h2 style="font-size:22px">
            Rp {{ number_format((float)$paidTotal, 0, ',', '.') }}
        </h2>
    </div>

</div>

<div class="panel">

    <form method="GET" action="{{ route('payments.index') }}"
          style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:22px">

        <label for="status">Filter status:</label>

        <select id="status" name="status"
                style="padding:11px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px">
            <option value="" {{ $status === '' ? 'selected' : '' }}>
                Semua Status
            </option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>
                Pending
            </option>
            <option value="paid" {{ $status === 'paid' ? 'selected' : '' }}>
                Paid
            </option>
            <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>
                Failed
            </option>
        </select>

        <button type="submit" class="btn">Terapkan Filter</button>

        <a href="{{ route('payments.index') }}"
           class="btn" style="background:#334155">Reset</a>
    </form>

    @if ($errors->any())
        <div style="background:#451a1a;color:#fecaca;padding:12px;border-radius:8px;margin-bottom:18px">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div style="overflow-x:auto">
        <table style="width:100%;min-width:900px;border-collapse:collapse">
            <thead>
                <tr style="text-align:left;color:#94a3b8">
                    <th style="padding:13px">Kode Pesanan</th>
                    <th style="padding:13px">Pelanggan</th>
                    <th style="padding:13px">Total</th>
                    <th style="padding:13px">Metode</th>
                    <th style="padding:13px">Status</th>
                    <th style="padding:13px">Perbarui Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td style="padding:13px;border-top:1px solid #293952">
                            <strong>{{ $payment->order_code }}</strong>
                            <div style="font-size:12px;color:#94a3b8;margin-top:5px">
                                {{ $payment->created_at }}
                            </div>
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            {{ $payment->customer_name ?? 'Pengguna tidak ditemukan' }}
                            <div style="font-size:12px;color:#94a3b8;margin-top:5px">
                                {{ $payment->customer_email ?? '-' }}
                            </div>
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952;white-space:nowrap">
                            Rp {{ number_format((float)$payment->total, 0, ',', '.') }}
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            {{ $payment->payment_method }}
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            @if($payment->payment_status === 'paid')
                                <span style="color:#86efac">Paid</span>
                            @elseif($payment->payment_status === 'failed')
                                <span style="color:#fca5a5">Failed</span>
                            @else
                                <span style="color:#fbbf24">Pending</span>
                            @endif
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            <form action="{{ route('payments.update', $payment->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin memperbarui status pembayaran ini?')"
                                  style="display:flex;gap:7px;align-items:center">
                                @csrf
                                @method('PATCH')

                                <select name="payment_status"
                                        style="padding:8px;background:#0b1120;color:white;border:1px solid #293952;border-radius:6px">
                                    <option value="pending" {{ $payment->payment_status === 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="paid" {{ $payment->payment_status === 'paid' ? 'selected' : '' }}>
                                        Paid
                                    </option>
                                    <option value="failed" {{ $payment->payment_status === 'failed' ? 'selected' : '' }}>
                                        Failed
                                    </option>
                                </select>

                                <button type="submit"
                                        style="padding:8px 10px;background:#1d4ed8;color:white;border:0;border-radius:6px;cursor:pointer">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:25px;text-align:center;color:#94a3b8">
                            Belum ada transaksi untuk filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px">
        {{ $payments->links() }}
    </div>

</div>

@endsection
