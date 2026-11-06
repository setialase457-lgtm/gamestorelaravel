
@extends('layouts.app')

@section('title', 'Pengaturan Akun - GameStore')
@section('heading', 'Pengaturan Akun')
@section('breadcrumb', 'Pengaturan Akun')

@section('content')

<div style="margin-bottom:24px">
    <h1 style="margin:0 0 8px">Pengaturan Akun Admin</h1>
    <p style="color:#94a3b8;margin:0">
        Ubah nama, email, dan password akun administrator.
    </p>
</div>

<div class="panel" style="max-width:750px">

    @if ($errors->any())
        <div style="padding:14px;background:#451a1a;color:#fecaca;border-radius:8px;margin-bottom:18px">
            <ul style="margin:0;padding-left:20px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:20px">
            <label for="name" style="display:block;margin-bottom:8px">
                Nama Admin
            </label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $admin->name) }}"
                required
                maxlength="100"
                style="width:100%;padding:12px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px"
            >
        </div>

        <div style="margin-bottom:20px">
            <label for="email" style="display:block;margin-bottom:8px">
                Email Admin
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $admin->email) }}"
                required
                maxlength="150"
                style="width:100%;padding:12px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px"
            >
        </div>

        <hr style="border:0;border-top:1px solid #293952;margin:26px 0">

        <h3>Ganti Password</h3>
        <p style="color:#94a3b8;font-size:13px">
            Biarkan password baru kosong jika tidak ingin menggantinya.
        </p>

        <div style="margin-bottom:20px">
            <label for="current_password" style="display:block;margin-bottom:8px">
                Password Lama
            </label>
            <input
                id="current_password"
                name="current_password"
                type="password"
                required
                autocomplete="current-password"
                style="width:100%;padding:12px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px"
            >
        </div>

        <div style="margin-bottom:20px">
            <label for="new_password" style="display:block;margin-bottom:8px">
                Password Baru
            </label>
            <input
                id="new_password"
                name="new_password"
                type="password"
                minlength="8"
                autocomplete="new-password"
                style="width:100%;padding:12px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px"
            >
        </div>

        <div style="margin-bottom:24px">
            <label for="new_password_confirmation" style="display:block;margin-bottom:8px">
                Konfirmasi Password Baru
            </label>
            <input
                id="new_password_confirmation"
                name="new_password_confirmation"
                type="password"
                minlength="8"
                autocomplete="new-password"
                style="width:100%;padding:12px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px"
            >
        </div>

        <button type="submit" class="btn">
            Simpan Perubahan
        </button>
    </form>
</div>

@endsection
