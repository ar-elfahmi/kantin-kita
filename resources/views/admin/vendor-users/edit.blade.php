@extends('admin.layouts.app')

@section('title', 'Edit Vendor User')

@section('content')
    <div class="card" style="max-width: 600px; margin-bottom: 16px;">
        <form method="POST" action="{{ route('admin.vendor-users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="form-row">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
            <hr style="margin: 16px 0; border: none; border-top: 1px solid var(--brown-10);">
            <h3 style="margin-bottom: 12px;">Profil Vendor</h3>
            <div class="form-row">
                <label>Nama Vendor</label>
                <input type="text" name="nama_vendor" value="{{ old('nama_vendor', $user->vendor?->nama_vendor) }}" required>
                @error('nama_vendor') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $user->vendor?->kategori) }}" placeholder="Contoh: Indonesia, Western, Minuman">
                @error('kategori') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $user->vendor?->lokasi) }}" placeholder="Contoh: Gedung A, Lantai 1">
                @error('lokasi') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Deskripsi</label>
                <textarea name="deskripsi" placeholder="Deskripsi vendor...">{{ old('deskripsi', $user->vendor?->deskripsi) }}</textarea>
                @error('deskripsi') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div style="display:flex; gap: 10px;">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn btn-secondary" href="{{ route('admin.vendor-users.index') }}">Batal</a>
            </div>
        </form>
    </div>

    <div class="card" style="max-width: 600px;">
        <h3 style="margin-bottom: 12px;">Reset Password</h3>
        <form method="POST" action="{{ route('admin.vendor-users.reset-password', $user->id) }}">
            @csrf
            <div class="form-row">
                <label>Password Baru</label>
                <input type="password" name="password" required minlength="8">
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>
            <button class="btn btn-danger" type="submit">Reset Password</button>
        </form>
    </div>
@endsection
