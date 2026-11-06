
@extends('layouts.app')

@section('title', 'Kelola Pengguna - GameStore')
@section('heading', 'Kelola Pengguna')
@section('breadcrumb', 'Manajemen / Pengguna')

@section('content')

<div style="margin-bottom:24px">
    <h1 style="margin:0 0 8px">Kelola Pengguna 👥</h1>
    <p style="color:#94a3b8;margin:0">
        Lihat dan kelola akun admin serta pelanggan GameStore.
    </p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:16px;margin-bottom:22px">
    <div class="panel">
        <p style="color:#94a3b8;margin-top:0">Total Pengguna</p>
        <h2>{{ $totalUsers }}</h2>
    </div>
    <div class="panel">
        <p style="color:#94a3b8;margin-top:0">Administrator</p>
        <h2>{{ $totalAdmins }}</h2>
    </div>
    <div class="panel">
        <p style="color:#94a3b8;margin-top:0">Pelanggan</p>
        <h2>{{ $totalCustomers }}</h2>
    </div>
</div>

<div class="panel">
    <form method="GET" action="{{ route('users.index') }}"
          style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:22px">
        <input
            type="search"
            name="search"
            value="{{ $search }}"
            placeholder="Cari nama atau email..."
            style="flex:1;min-width:200px;padding:12px;background:#0b1120;color:white;border:1px solid #293952;border-radius:8px"
        >
        <button type="submit" class="btn">Cari</button>
        <a href="{{ route('users.index') }}"
           class="btn" style="background:#334155">Reset</a>
    </form>

    @if ($errors->any())
        <div style="background:#451a1a;color:#fecaca;padding:12px;border-radius:8px;margin-bottom:18px">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div style="overflow-x:auto">
        <table style="width:100%;min-width:760px;border-collapse:collapse">
            <thead>
                <tr style="text-align:left;color:#94a3b8">
                    <th style="padding:13px">Pengguna</th>
                    <th style="padding:13px">Role</th>
                    <th style="padding:13px">Terdaftar</th>
                    <th style="padding:13px">Ubah Role</th>
                    <th style="padding:13px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="padding:13px;border-top:1px solid #293952">
                            <strong>{{ $user->name }}</strong>
                            <div style="color:#94a3b8;font-size:12px;margin-top:5px">
                                {{ $user->email }}
                            </div>
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            @if($user->role === 'admin')
                                <span style="color:#93c5fd">Administrator</span>
                            @else
                                <span style="color:#86efac">Pelanggan</span>
                            @endif
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            {{ $user->created_at ?? '-' }}
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            @if((int)$user->id !== (int)session('admin_id'))
                                <form action="{{ route('users.role', $user->id) }}"
                                      method="POST"
                                      style="display:flex;gap:7px;align-items:center">
                                    @csrf
                                    @method('PATCH')

                                    <select name="role"
                                            style="padding:8px;background:#0b1120;color:white;border:1px solid #293952;border-radius:6px">
                                        <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>
                                            Pelanggan
                                        </option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                    </select>

                                    <button type="submit"
                                            style="padding:8px;background:#1d4ed8;color:white;border:0;border-radius:6px;cursor:pointer">
                                        Simpan
                                    </button>
                                </form>
                            @else
                                <span style="color:#94a3b8">Akun kamu</span>
                            @endif
                        </td>

                        <td style="padding:13px;border-top:1px solid #293952">
                            @if($user->role === 'customer')
                                <form action="{{ route('users.destroy', $user->id) }}"
                                 method="POST"
                             onsubmit="return confirm('Yakin ingin menonaktifkan akun ini? Riwayat pesanan akan tetap disimpan.')">
                             @csrf
                            @method('DELETE')

                            <button type="submit">
                             Nonaktifkan Akun
                                </button>
                                <td>
                            @if (($user->is_active ?? 1) == 1)
                            <span>Aktif</span>
                            @else
                             <span>Nonaktif</span>
                             @endif
                                </td>
                         </form>
                            @else
                                <span style="color:#64748b">Dilindungi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:25px;text-align:center;color:#94a3b8">
                            Tidak ada pengguna yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px">
        {{ $users->links() }}
    </div>
</div>

@endsection
