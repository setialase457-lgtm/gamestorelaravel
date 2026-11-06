<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.name as customer_name',
                'users.email as customer_email'
            )
            ->orderByDesc('orders.id')
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.name as customer_name',
                'users.email as customer_email'
            )
            ->where('orders.id', $id)
            ->first();

        abort_if(!$order, 404);

        $items = DB::table('order_items')
            ->where('order_id', $order->id)
            ->get();

        return view('orders.show', compact('order', 'items'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'order_status' => [
                'required',
                Rule::in(['processing', 'completed', 'cancelled']),
            ],
        ]);

        $updated = DB::table('orders')
            ->where('id', $id)
            ->update([
                'order_status' => $validated['order_status'],
            ]);

        if (!$updated && !DB::table('orders')->where('id', $id)->exists()) {
            abort(404);
        }

        return redirect()
            ->route('orders.show', $id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
