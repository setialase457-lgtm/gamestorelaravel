<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminSettingsController extends Controller
{
    public function edit()
    {
        $admin = DB::table('users')
            ->where('id', session('admin_id'))
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return redirect()->route('login');
        }

        return view('admin.settings', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = DB::table('users')
            ->where('id', session('admin_id'))
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($admin->id),
            ],
            'current_password' => ['required', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email tersebut sudah digunakan akun lain.',
            'current_password.required' => 'Masukkan password lama untuk mengonfirmasi perubahan.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($validated['current_password'], $admin->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Password lama tidak benar.',
                ])
                ->withInput($request->only('name', 'email'));
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($validated['new_password']);
        }

        DB::table('users')
            ->where('id', $admin->id)
            ->update($data);

        $request->session()->put([
            'admin_name' => $validated['name'],
            'admin_email' => $validated['email'],
        ]);

        return redirect()
            ->route('admin.settings')
            ->with('success', 'Pengaturan akun berhasil diperbarui.');
    }
}
