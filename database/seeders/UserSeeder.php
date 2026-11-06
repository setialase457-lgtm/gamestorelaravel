<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminPassword = env('GAMESTORE_ADMIN_PASSWORD');
        $customerPassword = env('GAMESTORE_CUSTOMER_PASSWORD');

        if (!$adminPassword || !$customerPassword) {
            throw new \RuntimeException(
                'Password Admin dan Customer belum diatur.'
            );
        }

        // Akun Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'setialase@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'is_active' => 1,
                'email_verified_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Akun Customer
        DB::table('users')->updateOrInsert(
            ['email' => 'kawanlama@gmail.com'],
            [
                'name' => 'Customer GameStore',
                'password' => Hash::make($customerPassword),
                'role' => 'customer',
                'is_active' => 1,
                'email_verified_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
