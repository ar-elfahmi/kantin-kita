<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Toko - {{ $toko->nama_toko }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #FBF5E8; --brown: #744622;
            --brown-60: rgba(116, 70, 34, .6);
            --brown-10: rgba(116, 70, 34, .1);
            --green: #42766A;
        }
        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--cream); color: var(--brown); min-height: 100vh; padding: 40px 24px; }
        .page { max-width: 480px; margin: 0 auto; }
        .controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 12px; font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; font-family: inherit; }
        .btn-primary { background: var(--green); color: #fff; }
        .btn-outline { background: #fff; color: var(--brown); border-color: var(--brown-10); }
        .qr-card { background: #fff; border: 2px solid var(--brown-10); border-radius: 16px; padding: 32px; text-align: center; box-shadow: 0 4px 16px rgba(116, 70, 34, .1); }
        .qr-title { font-size: 20px; font-weight: 700; margin-bottom: 4px; }
        .qr-sub { font-size: 12px; color: var(--brown-60); margin-bottom: 24px; letter-spacing: .5px; text-transform: uppercase; }
        .qr-img { display: block; margin: 0 auto; width: 300px; height: 300px; }
        .qr-barcode { font-family: 'Menlo', 'Consolas', monospace; font-size: 22px; font-weight: 700; letter-spacing: 4px; margin-top: 16px; color: var(--brown); }
        .qr-meta { margin-top: 16px; font-size: 12px; color: var(--brown-60); }
        .qr-hint { margin-top: 24px; padding: 14px; background: var(--cream); border-radius: 10px; font-size: 12px; color: var(--brown-60); }
        @media print {
            body { background: #fff; padding: 0; }
            .controls { display: none; }
            .qr-card { border: 1px solid #000; box-shadow: none; }
        }
    </style>
</head>

<body>

<div class="page">

    <div class="controls">
        <a href="{{ route('dashboard.kunjungan.index') }}" class="btn btn-outline">&larr; Kembali</a>
        <button type="button" class="btn btn-primary" onclick="window.print()">🖨 Cetak</button>
    </div>

    <div class="qr-card">
        <div class="qr-title">{{ $toko->nama_toko }}</div>
        <div class="qr-sub">QR Toko · Kantin Kita</div>
        <img src="{{ $qrDataUri }}" alt="QR barcode {{ $toko->barcode }}" class="qr-img">
        <div class="qr-barcode">{{ $toko->barcode }}</div>
        <div class="qr-meta">
            {{ number_format($toko->latitude, 6) }}, {{ number_format($toko->longitude, 6) }}
            &nbsp;·&nbsp; akurasi ±{{ number_format($toko->accuracy, 1) }} m
        </div>
        <div class="qr-hint">
            Tempel QR ini di lokasi toko. Sales memindainya melalui menu <strong>Scan &amp; Kunjungi</strong> untuk mencatat kunjungan.
        </div>
    </div>

</div>

</body>
</html>
