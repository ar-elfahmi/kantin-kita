@extends('admin.layouts.app')

@section('title', 'Pantau Transaksi')

@section('content')
    <form method="GET" action="{{ route('admin.transaksi.index') }}" class="filter-form">
        <div>
            <label>Vendor</label>
            <select name="vendor_id">
                <option value="">Semua vendor</option>
                @foreach ($vendors as $v)
                    <option value="{{ $v->id }}" @selected((string) $filters['vendor_id'] === (string) $v->id)>{{ $v->nama_vendor }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Payment Status</label>
            <select name="payment_status">
                <option value="">Semua</option>
                @foreach ($paymentStatuses as $ps)
                    <option value="{{ $ps }}" @selected($filters['payment_status'] === $ps)>{{ $ps }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Order Status</label>
            <select name="order_status">
                <option value="">Semua</option>
                @foreach ($orderStatuses as $os)
                    <option value="{{ $os }}" @selected($filters['order_status'] === $os)>{{ $os }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ $filters['start_date'] }}">
        </div>
        <div>
            <label>Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ $filters['end_date'] }}">
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div>
            <a class="btn btn-secondary" href="{{ route('admin.transaksi.index') }}">Reset</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Vendor</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Order</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $p)
                @php
                    $paymentStatus = optional($p->payment)->status ?? 'no-payment';
                    $payCls = ['settlement' => 'badge-success', 'pending' => 'badge-warning', 'expire' => 'badge-muted', 'cancel' => 'badge-danger', 'deny' => 'badge-danger'][$paymentStatus] ?? 'badge-muted';
                    $orderCls = ['selesai' => 'badge-success', 'diproses' => 'badge-info', 'pending' => 'badge-warning', 'dibatalkan' => 'badge-danger'][$p->status_pesanan] ?? 'badge-muted';
                @endphp
                <tr>
                    <td>#{{ $p->id }}</td>
                    <td>{{ optional($p->vendor)->nama_vendor ?? '-' }}</td>
                    <td>{{ $p->nama_customer }}</td>
                    <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                    <td><span class="badge {{ $payCls }}">{{ $paymentStatus }}</span></td>
                    <td><span class="badge {{ $orderCls }}">{{ $p->status_pesanan }}</span></td>
                    <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                    <td><a class="btn btn-secondary btn-sm" href="{{ route('admin.transaksi.show', $p->id) }}">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center; color: var(--brown-70);">Tidak ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrapper">{{ $transaksi->links() }}</div>
@endsection
