@extends('admin.layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="card" style="max-width: 600px;">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-row">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Role</label>
                <select name="role" required>
                    @foreach ($roles as $r)
                        <option value="{{ $r }}" @selected(old('role') === $r)>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
                @error('role') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Password (min 8 karakter)</label>
                <input type="password" name="password" required minlength="8">
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div style="display:flex; gap: 10px;">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Batal</a>
            </div>
        </form>
    </div>
@endsection
