<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $users = DB::table('users')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $totalUsers = DB::table('users')->count();
        $totalAdmins = DB::table('users')->where('role', 'admin')->count();
        $totalCustomers = DB::table('users')->where('role', 'customer')->count();

        return view('users.index', compact(
            'users',
            'search',
            'totalUsers',
            'totalAdmins',
            'totalCustomers'
        ));
    }

    public function updateRole(Request $request, int $id)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['admin', 'customer'])],
        ]);

        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            abort(404);
        }

        if ((int) $user->id === (int) session('admin_id')) {
            return back()->withErrors([
                'role' => 'Role akun yang sedang kamu gunakan tidak dapat diubah.',
            ]);
        }

        if (
            $user->role === 'admin' &&
            $validated['role'] !== 'admin' &&
            DB::table('users')->where('role', 'admin')->count() <= 1
        ) {
            return back()->withErrors([
                'role' => 'Role admin terakhir tidak dapat diubah.',
            ]);
        }

        DB::table('users')->where('id', $id)->update([
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Role pengguna berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            abort(404);
        }

        if ((int) $user->id === (int) session('admin_id')) {
            return back()->withErrors([
                'user' => 'Kamu tidak dapat menghapus akun yang sedang digunakan.',
            ]);
        }

        if ($user->role === 'admin') {
            return back()->withErrors([
                'user' => 'Akun admin tidak dapat dihapus melalui halaman ini.',
            ]);
        }

        if (DB::table('orders')->where('user_id', $id)->exists()) {
            return back()->withErrors([
                'user' => 'Akun ini memiliki riwayat pesanan dan tidak dapat dihapus.',
            ]);
        }

        DB::table('users')->where('id', $id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
