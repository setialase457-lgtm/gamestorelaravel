<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class CustomerAuthController extends Controller
{
    public function showRegister()
    {
        if (session()->has('customer_id')) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $id = DB::table('users')->insertGetId([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'is_active' => 1,
            'created_at' => now(),
        ]);

        $request->session()->regenerate();

        $request->session()->put([
            'customer_id' => $id,
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Pendaftaran berhasil. Selamat datang di GameStore!');
    }

    public function showLogin()
    {
        if (session()->has('customer_id')) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = DB::table('users')
            ->where('email', $data['email'])
            ->where('role', 'customer')
            ->first();

        if (!$user || (int) $user->is_active !== 1) {
            return back()->withErrors([
                'email' => 'Akun customer tidak ditemukan atau dinonaktifkan.',
            ])->onlyInput('email');
        }

        try {
            $validPassword = Hash::check($data['password'], $user->password);
        } catch (RuntimeException $e) {
            $validPassword = false;
        }

        if (!$validPassword) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $request->session()->put([
            'customer_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
        ]);

        return redirect()->route('customer.dashboard');
    }

    public function dashboard()
    {
        if (!session()->has('customer_id')) {
            return redirect()->route('customer.login');
        }

        $products = DB::table('products')
            ->orderByDesc('id')
            ->limit(12)
            ->get();

        return view('customer.dashboard', compact('products'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'customer_id',
            'customer_name',
            'customer_email',
        ]);

        $request->session()->regenerateToken();

        return redirect()->route('customer.login')
            ->with('success', 'Kamu berhasil logout.');
    }
}