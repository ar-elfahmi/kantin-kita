@extends('admin.layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
    <form method="GET" action="{{ route('admin.artikel.index') }}" class="filter-form">
        <div>
            <label>Status</label>
            <select name="status">
                <option value="all" @selected($statusFilter === 'all')>Semua</option>
                @foreach ($statuses as $s)
                    <option value="{{ $s }}" @selected($statusFilter === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div style="margin-left: auto;">
            <a class="btn btn-primary" href="{{ route('admin.artikel.create') }}">+ Tambah Artikel</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Published</th>
                <th>Author</th>
                <th>Updated</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($artikels as $a)
                <tr>
                    <td>{{ $a->judul }}</td>
                    <td>{{ $a->kategori }}</td>
                    <td>
                        @php
                            $cls = ['draft' => 'badge-muted', 'published' => 'badge-success', 'archived' => 'badge-warning'][$a->status] ?? 'badge-muted';
                        @endphp
                        <span class="badge {{ $cls }}">{{ $a->status }}</span>
                    </td>
                    <td>{{ $a->published_at?->format('d M Y') ?? '—' }}</td>
                    <td>{{ optional($a->author)->name ?? '—' }}</td>
                    <td>{{ $a->updated_at->format('d M Y') }}</td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-sm" href="{{ route('admin.artikel.edit', $a->id) }}">Edit</a>
                        @if ($a->status !== 'archived')
                            <form method="POST" action="{{ route('admin.artikel.archive', $a->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Arsipkan</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.artikel.destroy', $a->id) }}" style="display:inline;" onsubmit="return confirm('Hapus artikel ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center; color: var(--brown-70);">Belum ada artikel.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrapper">{{ $artikels->links() }}</div>
@endsection
