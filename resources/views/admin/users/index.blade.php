@extends('admin.layouts.app')

@section('title', 'Kelola User')

@section('content')
    <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form">
        <div style="flex: 1;">
            <label>Pencarian</label>
            <input type="text" name="q" value="{{ $search }}" placeholder="Nama atau email...">
        </div>
        <div>
            <label>Role</label>
            <select name="role">
                <option value="">Semua role</option>
                @foreach ($roles as $r)
                    <option value="{{ $r }}" @selected($roleFilter === $r)>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div style="margin-left: auto;">
            <a class="btn btn-primary" href="{{ route('admin.users.create') }}">+ Tambah User</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
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
                    <td><span class="badge badge-info">{{ $u->role }}</span></td>
                    <td>
                        @if ($u->trashed())
                            <span class="badge badge-danger">deleted</span>
                        @else
                            <span class="badge badge-success">active</span>
                        @endif
                    </td>
                    <td>{{ $u->created_at?->format('d M Y') }}</td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-sm" href="{{ route('admin.users.edit', $u->id) }}">Edit</a>
                        @if ($u->trashed())
                            <form method="POST" action="{{ route('admin.users.restore', $u->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                        @elseif ($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" style="display:inline;" onsubmit="return confirm('Hapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center; color: var(--brown-70);">Tidak ada user.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrapper">{{ $users->links() }}</div>
@endsection
