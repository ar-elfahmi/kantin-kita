@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-4">
        <div class="card kpi">
            <div class="label">Admin</div>
            <div class="value">{{ number_format($userCountsByRole['admin'] ?? 0) }}</div>
        </div>
        <div class="card kpi">
            <div class="label">Vendor</div>
            <div class="value">{{ number_format($userCountsByRole['vendor'] ?? 0) }}</div>
        </div>
        <div class="card kpi">
            <div class="label">Customer</div>
            <div class="value">{{ number_format($userCountsByRole['customer'] ?? 0) }}</div>
        </div>
        <div class="card kpi">
            <div class="label">Guest</div>
            <div class="value">{{ number_format($userCountsByRole['guest'] ?? 0) }}</div>
        </div>
    </div>

    <div class="grid grid-4" style="margin-top: 16px;">
        <div class="card kpi">
            <div class="label">Total Vendor (profil)</div>
            <div class="value">{{ number_format($vendorCount) }}</div>
        </div>
        <div class="card kpi">
            <div class="label">Total Pesanan</div>
            <div class="value">{{ number_format($totalPesanan) }}</div>
        </div>
        <div class="card kpi" style="grid-column: span 2;">
            <div class="label">GMV (Settlement)</div>
            <div class="value">Rp {{ number_format($gmv, 0, ',', '.') }}</div>
        </div>
    </div>

    <h2 style="margin: 28px 0 14px; font-size: 1.15rem;">Transaksi Settlement Terbaru</h2>
    <table>
        <thead>
            <tr>
                <th>Pesanan</th>
                <th>Vendor</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentTransactions as $tx)
                <tr>
                    <td>#{{ $tx->id }}</td>
                    <td>{{ optional($tx->vendor)->nama_vendor ?? '-' }}</td>
                    <td>{{ $tx->nama_customer }}</td>
                    <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td>{{ $tx->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center; color: var(--brown-70);">Belum ada transaksi settlement.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
