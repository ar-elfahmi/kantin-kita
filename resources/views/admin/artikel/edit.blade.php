@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
    <div class="card" style="max-width: 900px;">
        <form method="POST" action="{{ route('admin.artikel.update', $artikel->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" required>
                @error('judul') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $artikel->slug) }}">
                @error('slug') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $artikel->kategori) }}" required>
                @error('kategori') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Status</label>
                <select name="status" required>
                    @foreach ($statuses as $s)
                        <option value="{{ $s }}" @selected(old('status', $artikel->status) === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                @error('status') <div class="error">{{ $message }}</div> @enderror
                @if ($artikel->published_at)
                    <small style="color: var(--brown-70);">Dipublikasikan pada {{ $artikel->published_at->format('d M Y H:i') }}</small>
                @endif
            </div>
            <div class="form-row">
                <label>Ringkasan</label>
                <textarea name="ringkasan" maxlength="500">{{ old('ringkasan', $artikel->ringkasan) }}</textarea>
                @error('ringkasan') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Konten</label>
                <textarea name="konten" required style="min-height: 240px;">{{ old('konten', $artikel->konten) }}</textarea>
                @error('konten') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <label>Gambar Sampul (opsional, max 2MB)</label>
                @if ($artikel->gambar_sampul)
                    <div style="margin-bottom: 8px;"><img src="{{ asset('storage/' . $artikel->gambar_sampul) }}" alt="" style="max-width: 240px; border-radius: 10px;"></div>
                @endif
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
