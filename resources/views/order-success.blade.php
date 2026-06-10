<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Pesanan Berhasil | Kantin Kita</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --cream: #FBF5E8;
            --cream-mid: #F5EDD8;
            --brown: #744622;
            --brown-70: rgba(116, 70, 34, .70);
            --brown-60: rgba(116, 70, 34, .60);
            --brown-50: rgba(116, 70, 34, .50);
            --brown-10: rgba(116, 70, 34, .10);
            --brown-5: rgba(116, 70, 34, .05);
            --green: #2E7D32;
            --green-light: #E8F5E9;
            --red: #C62828;
            --gray: #6B7280;
            --gray-light: #F3F4F6;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, .08);
            --shadow-md: 0 4px 16px rgba(116, 70, 34, .10);
            --radius: 12px;
            --radius-sm: 8px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            margin-top: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            overflow: hidden;
            background: var(--cream-mid);
        }

        .brand-name {
            font-weight: 700;
            font-size: 16px;
            color: var(--brown);
            line-height: 1.2;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--brown-60);
            line-height: 1.2;
        }

        .nav-links {
            display: flex;
            gap: 24px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--brown-60);
            font-size: 14px;
            font-weight: 500;
            transition: color .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--brown);
        }

        .main-content {
            flex: 1;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 24px;
            width: 100%;
        }

        .success-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            padding: 40px;
            text-align: center;
        }

        .success-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--green-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-icon svg {
            width: 36px;
            height: 36px;
        }

        .success-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--green);
            margin-bottom: 8px;
        }

        .success-subtitle {
            font-size: 14px;
            color: var(--brown-60);
            margin-bottom: 32px;
        }

        .qr-section {
            background: #fff;
            border: 2px dashed var(--brown-10);
            border-radius: var(--radius);
            padding: 32px;
            margin-bottom: 32px;
            display: inline-block;
        }

        .qr-label {
            font-size: 13px;
            color: var(--brown-60);
            margin-bottom: 16px;
            font-weight: 500;
        }

        #qrcode {
            display: inline-block;
            padding: 12px;
            background: #fff;
            border-radius: var(--radius-sm);
        }

        .qr-hint {
            font-size: 12px;
            color: var(--brown-50);
            margin-top: 12px;
        }

        .order-summary {
            text-align: left;
            margin-top: 32px;
        }

        .summary-header {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--brown-10);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .summary-label {
            color: var(--brown-60);
        }

        .summary-value {
            font-weight: 500;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .items-table th {
            text-align: left;
            font-size: 12px;
            color: var(--brown-50);
            text-transform: uppercase;
            padding: 8px 12px;
            border-bottom: 1px solid var(--brown-10);
        }

        .items-table td {
            padding: 10px 12px;
            font-size: 14px;
            border-bottom: 1px solid var(--brown-5);
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .total-row td {
            font-weight: 700;
            font-size: 15px;
            padding-top: 12px;
            border-top: 2px solid var(--brown-10);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.settlement,
        .status-badge.diproses {
            background: var(--green-light);
            color: var(--green);
        }

        .status-badge.pending {
            background: #FFF3E0;
            color: #E65100;
        }

        .status-badge.dibatalkan,
        .status-badge.cancel,
        .status-badge.expire {
            background: #FFEBEE;
            color: var(--red);
        }

        .back-link {
            display: inline-block;
            margin-top: 24px;
            color: var(--brown-60);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color .2s;
        }

        .back-link:hover {
            color: var(--brown);
        }

        .footer {
            text-align: center;
            padding: 24px;
            color: var(--brown-50);
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .success-card {
                padding: 24px;
            }
            .qr-section {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar-inner">
        <a href="/" class="brand">
            <div class="brand-icon">
                <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
            </div>
            <div>
                <div class="brand-name">Kantin Kita</div>
                <div class="brand-sub">Campus Canteen</div>
            </div>
        </a>
        <div class="nav-links">
            <a href="/" class="nav-link">Home</a>
            <a href="{{ route('vendor') }}" class="nav-link">Menu</a>
            <a href="{{ route('login') }}" class="nav-link">Orders</a>
        </div>
    </nav>

    <div class="main-content">
        <div class="success-card">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#2E7D32" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
            </div>
            <div class="success-title">Pesanan Berhasil!</div>
            <div class="success-subtitle">Tunjukkan QR code ini ke vendor saat mengambil pesanan</div>

            <div class="qr-section">
                <div class="qr-label">Scan untuk verifikasi pesanan</div>
                <img src="{{ $qrDataUri }}" alt="QR pesanan {{ $orderId }}" style="display:block;margin:0 auto;width:180px;height:180px;">
                <div class="qr-hint">QR Code — {{ $orderId }}</div>
            </div>

            <div class="order-summary">
                <div class="summary-header">Ringkasan Pesanan</div>

                <div class="summary-row">
                    <span class="summary-label">Vendor</span>
                    <span class="summary-value">{{ $pesanan->vendor->nama_vendor }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Nama Pemesan</span>
                    <span class="summary-value">{{ $pesanan->nama_customer }}</span>
                </div>
                @if ($pesanan->waktu_pengambilan)
                <div class="summary-row">
                    <span class="summary-label">Waktu Pengambilan</span>
                    <span class="summary-value">{{ $pesanan->waktu_pengambilan }}</span>
                </div>
                @endif
                <div class="summary-row">
                    <span class="summary-label">Status</span>
                    <span class="summary-value">
                        <span class="status-badge {{ $pesanan->status_pesanan }}">{{ $pesanan->status_pesanan }}</span>
                    </span>
                </div>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan->detailPesanans as $detail)
                        <tr>
                            <td>{{ $detail->menu->nama_menu }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if ($detail->catatan)
                        <tr>
                            <td colspan="4" style="font-size:12px;color:var(--brown-50);padding-top:0;">
                                Catatan: {{ $detail->catatan }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3">Total</td>
                            <td>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a href="{{ route('vendor') }}" class="back-link">← Pesan Lagi</a>
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Kantin Kita. All rights reserved.
    </div>
</body>

</html>
