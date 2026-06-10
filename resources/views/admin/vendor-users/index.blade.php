@extends('admin.layouts.app')

@section('title', 'Kelola Vendor User')

@section('content')
    <form method="GET" action="{{ route('admin.vendor-users.index') }}" class="filter-form">
        <div style="flex: 1;">
            <label>Pencarian</label>
            <input type="text" name="q" value="{{ $search }}" placeholder="Nama atau email...">
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div style="margin-left: auto;">
            <a class="btn btn-primary" href="{{ route('admin.vendor-users.create') }}">+ Tambah Vendor</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Nama Vendor</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->vendor?->nama_vendor ?: '-' }}</td>
                    <td>
                        @if ($u->vendor?->kategori)
                            <span class="badge badge-info">{{ $u->vendor->kategori }}</span>
                        @else
                            <span class="badge badge-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if ($u->trashed())
                            <span class="badge badge-danger">deleted</span>
                        @else
                            <span class="badge badge-success">active</span>
                        @endif
                    </td>
                    <td>{{ $u->created_at?->format('d M Y') }}</td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-sm" href="{{ route('admin.vendor-users.edit', $u->id) }}">Edit</a>
                        @if ($u->trashed())
                            <form method="POST" action="{{ route('admin.vendor-users.restore', $u->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.vendor-users.destroy', $u->id) }}" style="display:inline;" onsubmit="return confirm('Hapus vendor user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center; color: var(--brown-70);">Tidak ada vendor user.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrapper">{{ $users->links() }}</div>
@endsection
