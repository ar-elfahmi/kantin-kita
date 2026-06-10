@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
    <div class="card" style="max-width: 900px;">
        <form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required>
                @error('judul') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', 'tentang-kami') }}" required>
                <small style="color: var(--brown-70);">Gunakan <code>tentang-kami</code> agar muncul di landing page.</small>
                @error('kategori') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Status</label>
                <select name="status" required>
                    @foreach ($statuses as $s)
                        <option value="{{ $s }}" @selected(old('status', 'draft') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Ringkasan (max 500 karakter)</label>
                <textarea name="ringkasan" maxlength="500">{{ old('ringkasan') }}</textarea>
                @error('ringkasan') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Konten</label>
                <textarea name="konten" required style="min-height: 240px;">{{ old('konten') }}</textarea>
                @error('konten') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Gambar Sampul (opsional, max 2MB)</label>
                <input type="file" name="gambar_sampul" accept="image/*">
                @error('gambar_sampul') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div style="display:flex; gap: 10px;">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a class="btn btn-secondary" href="{{ route('admin.artikel.index') }}">Batal</a>
            </div>
        </form>
    </div>
@endsection
