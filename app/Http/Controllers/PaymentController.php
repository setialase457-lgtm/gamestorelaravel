<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', '');

        $payments = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.name as customer_name',
                'users.email as customer_email'
            )
            ->when(
                in_array($status, ['pending', 'paid', 'failed'], true),
                function ($query) use ($status) {
                    $query->where('orders.payment_status', $status);
                }
            )
            ->orderByDesc('orders.id')
            ->paginate(15)
            ->withQueryString();

        $totalTransactions = DB::table('orders')->count();

        $pendingCount = DB::table('orders')
            ->where('payment_status', 'pending')
            ->count();

        $paidCount = DB::table('orders')
            ->where('payment_status', 'paid')
            ->count();

        $failedCount = DB::table('orders')
            ->where('payment_status', 'failed')
            ->count();

        $paidTotal = DB::table('orders')
            ->where('payment_status', 'paid')
            ->sum('total');

        return view('payments.index', compact(
            'payments',
            'status',
            'totalTransactions',
            'pendingCount',
            'paidCount',
            'failedCount',
            'paidTotal'
        ));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'payment_status' => [
                'required',
                Rule::in(['pending', 'paid', 'failed']),
            ],
        ]);

        $exists = DB::table('orders')
            ->where('id', $id)
            ->exists();

        if (!$exists) {
            abort(404);
        }

        DB::table('orders')
            ->where('id', $id)
            ->update([
                'payment_status' => $validated['payment_status'],
            ]);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
