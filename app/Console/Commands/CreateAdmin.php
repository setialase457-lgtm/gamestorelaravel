<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'gamestore:create-admin';

    protected $description = 'Membuat akun administrator GameStore';

    public function handle(): int
    {
        $name = $this->ask('Nama admin');
        $email = $this->ask('Email admin');
        $password = $this->secret('Password admin');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return self::FAILURE;
        }

        if (DB::table('users')->where('email', $email)->exists()) {
            $this->error('Email tersebut sudah terdaftar. Gunakan email lain.');
            return self::FAILURE;
        }

        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'created_at' => now(),
        ]);

        $this->info('Akun admin GameStore berhasil dibuat!');
        $this->line('Email: ' . $email);
        $this->info('Silakan login melalui browser.');

        return self::SUCCESS;
    }
}
