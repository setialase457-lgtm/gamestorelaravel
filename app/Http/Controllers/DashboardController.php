<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Daftar produk terbaru
        $products = Product::orderByDesc('id')
            ->limit(12)
            ->get();

        // Ringkasan dashboard
        $totalProducts = Product::count();

        $totalUsers = DB::table('users')->count();

        $activeUsers = DB::table('users')
            ->where('is_active', 1)
            ->count();

        $totalOrders = DB::table('orders')->count();

        // Total transaksi yang sudah dibayar
        $totalSales = DB::table('orders')
            ->where('payment_status', 'paid')
            ->sum('total');

        // Jumlah pesanan berdasarkan status pembayaran
        $pendingPayments = DB::table('orders')
            ->where('payment_status', 'pending')
            ->count();

        $paidOrders = DB::table('orders')
            ->where('payment_status', 'paid')
            ->count();

        $failedPayments = DB::table('orders')
            ->where('payment_status', 'failed')
            ->count();

        // Laporan penjualan 12 bulan terakhir
        $monthlySales = DB::table('orders')
            ->selectRaw(
                "DATE_FORMAT(created_at, '%Y-%m') as month,
                 SUM(CASE WHEN payment_status = 'paid'
                     THEN total ELSE 0 END) as sales"
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Pesanan terbaru
        $recentOrders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.id',
                'orders.order_code',
                'orders.total',
                'orders.payment_status',
                'orders.order_status',
                'orders.created_at',
                'users.name as customer_name'
            )
            ->orderByDesc('orders.id')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'products',
            'totalProducts',
            'totalUsers',
            'activeUsers',
            'totalOrders',
            'totalSales',
            'pendingPayments',
            'paidOrders',
            'failedPayments',
            'monthlySales',
            'recentOrders'
        ));
    }
}
