<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = DB::table('users')
            ->where('email', $credentials['email'])
            ->first();

        if (!$user || (int) $user->is_active !== 1) {
            return back()
                ->withErrors([
                    'email' => 'Akun tidak ditemukan atau telah dinonaktifkan.',
                ])
                ->onlyInput('email');
        }

        // Login khusus Admin
        if ($user->role !== 'admin') {
            return back()
                ->withErrors([
                    'email' => 'Akun ini bukan akun Admin.',
                ])
                ->onlyInput('email');
        }

        try {
            $validPassword = Hash::check(
                $credentials['password'],
                $user->password
            );
        } catch (RuntimeException $e) {
            $validPassword = false;
        }

        if (!$validPassword) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ])
                ->onlyInput('email');
        }

        // Buat session Admin
        $request->session()->regenerate();

        $request->session()->put([
            'admin_id' => $user->id,
            'admin_name' => $user->name,
            'admin_email' => $user->email,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'admin_id',
            'admin_name',
            'admin_email',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
