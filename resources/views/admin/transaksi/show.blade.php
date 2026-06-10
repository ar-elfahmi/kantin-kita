@extends('admin.layouts.app')

@section('title', 'Detail Transaksi #' . $pesanan->id)

@section('content')
    <a class="btn btn-secondary btn-sm" href="{{ route('admin.transaksi.index') }}">← Kembali</a>

    <div class="grid" style="grid-template-columns: 1fr 1fr; margin-top: 16px;">
        <div class="card">
            <h3 style="margin-bottom: 8px;">Pesanan</h3>
            <p><strong>ID:</strong> #{{ $pesanan->id }}</p>
            <p><strong>Vendor:</strong> {{ optional($pesanan->vendor)->nama_vendor ?? '-' }}</p>
            <p><strong>Customer:</strong> {{ $pesanan->nama_customer }}</p>
            <p><strong>Status:</strong> {{ $pesanan->status_pesanan }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>
            <p><strong>Waktu Pengambilan:</strong> {{ $pesanan->waktu_pengambilan ?? '-' }}</p>
            <p><strong>Catatan:</strong> {{ $pesanan->catatan ?? '—' }}</p>
            <p><strong>Dibuat:</strong> {{ $pesanan->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="card">
            <h3 style="margin-bottom: 8px;">Pembayaran</h3>
            @if ($pesanan->payment)
                <p><strong>Status:</strong> {{ $pesanan->payment->status }}</p>
                <p><strong>Jumlah:</strong> Rp {{ number_format($pesanan->payment->gross_amount, 0, ',', '.') }}</p>
                <p><strong>Tipe:</strong> {{ $pesanan->payment->payment_type ?? '-' }}</p>
                <p><strong>Transaction ID:</strong> {{ $pesanan->payment->transaction_id ?? '—' }}</p>
                <p><strong>Dibayar pada:</strong> {{ optional($pesanan->payment->paid_at)->format('d M Y H:i') ?? '—' }}</p>
            @else
                <p style="color: var(--brown-70);">Belum ada pembayaran.</p>
            @endif
        </div>
    </div>

    <h3 style="margin: 24px 0 12px;">Item Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan->detailPesanans as $d)
                <tr>
                    <td>{{ optional($d->menu)->nama_menu ?? '(menu dihapus)' }}</td>
                    <td>{{ $d->jumlah }}</td>
                    <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center; color: var(--brown-70);">Tidak ada item.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
