@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="card" style="max-width: 600px; margin-bottom: 16px;">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
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
            <div class="form-row">
                <label>Role</label>
                <select name="role" required>
                    @foreach ($roles as $r)
                        <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
                @error('role') <div class="error">{{ $message }}</div> @enderror
                @if ($user->id === auth()->id())
                    <small style="color: var(--brown-70);">Anda tidak dapat menurunkan role akun sendiri.</small>
                @endif
            </div>
            <div style="display:flex; gap: 10px;">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Batal</a>
            </div>
        </form>
    </div>

    <div class="card" style="max-width: 600px;">
        <h3 style="margin-bottom: 12px;">Reset Password</h3>
        <form method="POST" action="{{ route('admin.users.reset-password', $user->id) }}">
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
