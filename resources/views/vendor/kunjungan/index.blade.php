<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kunjungan Toko – Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #FBF5E8; --brown: #744622;
            --brown-60: rgba(116, 70, 34, .6); --brown-70: rgba(116, 70, 34, .7);
            --brown-10: rgba(116, 70, 34, .1); --brown-20: rgba(116, 70, 34, .2);
            --green: #42766A; --green-10: rgba(66, 118, 106, .1); --green-20: rgba(66, 118, 106, .2);
            --red: #B91C1C; --red-10: rgba(220, 38, 38, .1);
            --white: #fff;
            --shadow-sm: 0 1px 3px rgba(116, 70, 34, .08);
            --radius-sm: 12px; --radius-md: 16px; --radius-pill: 9999px;
            --transition: .25s cubic-bezier(.4, 0, .2, 1);
        }
        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--cream); color: var(--brown); min-height: 100vh; }
        .dashboard-shell { display: flex; min-height: 100vh; }
        .sidebar { width: 288px; flex-shrink: 0; background: var(--white); border-right: 1px solid var(--brown-10); display: flex; flex-direction: column; padding: 24px; gap: 48px; position: sticky; top: 0; height: 100vh; overflow-y: auto; z-index: 100; box-shadow: 2px 0 20px rgba(116, 70, 34, .04); }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-icon { width: 48px; height: 48px; background: var(--green); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; }
        .logo-text-primary { font-size: 24px; font-weight: 700; color: var(--brown); }
        .logo-text-secondary { font-size: 12px; color: var(--brown-60); }
        .sidebar-nav { display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--radius-md); text-decoration: none; font-size: 16px; font-weight: 500; color: var(--brown-70); transition: background var(--transition), color var(--transition), transform var(--transition); position: relative; overflow: hidden; }
        .nav-item::before { content: ''; position: absolute; inset: 0; background: var(--green-10); opacity: 0; transition: opacity var(--transition); border-radius: inherit; }
        .nav-item:hover::before { opacity: 1; }
        .nav-item:hover { color: var(--green); transform: translateX(3px); }
        .nav-item.active { background: var(--green-10); color: var(--green); font-weight: 600; }
        .nav-item.active::after { content: ''; position: absolute; right: 0; top: 20%; height: 60%; width: 3px; background: var(--green); border-radius: 2px 0 0 2px; }
        .nav-icon { width: 20px; height: 20px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .sidebar-footer { border-top: 1px solid var(--brown-10); padding-top: 24px; }
        .sidebar-user { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--radius-md); }
        .user-avatar { width: 40px; height: 40px; border-radius: var(--radius-pill); object-fit: cover; border: 2px solid var(--brown-10); }
        .user-name { font-size: 14px; font-weight: 600; color: var(--brown); }
        .user-email { font-size: 12px; color: var(--brown-60); }
        .sidebar-logout-btn { margin-left: auto; border: none; background: transparent; cursor: pointer; padding: 0; }

        .main-content { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .page-header { background: var(--white); border-bottom: 1px solid var(--brown-10); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .header-title { font-size: 24px; font-weight: 700; }
        .header-subtitle { font-size: 14px; color: var(--brown-60); }
        .dashboard-body { padding: 32px; display: flex; flex-direction: column; gap: 24px; }

        .alert { border-radius: var(--radius-md); padding: 12px 16px; font-size: 14px; font-weight: 500; }
        .alert-success { background: var(--green-10); color: var(--green); border: 1px solid var(--green-20); }

        .panel { background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--brown-10); box-shadow: var(--shadow-sm); overflow: hidden; }
        .panel-header { padding: 20px 24px; border-bottom: 1px solid var(--brown-10); display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .panel-title { font-size: 18px; font-weight: 700; color: var(--brown); }
        .panel-subtitle { font-size: 13px; color: var(--brown-60); margin-top: 4px; }

        .btn-group { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; transition: background var(--transition), transform var(--transition); font-family: inherit; }
        .btn-primary { background: var(--green); color: #fff; }
        .btn-primary:hover { background: #355f55; transform: translateY(-1px); }
        .btn-outline { background: #fff; color: var(--brown); border-color: var(--brown-10); }
        .btn-outline:hover { background: var(--cream); }

        table.data-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        table.data-table thead th { background: var(--cream); text-align: left; padding: 12px 18px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: var(--brown-70); border-bottom: 1px solid var(--brown-10); }
        table.data-table tbody td { padding: 12px 18px; border-bottom: 1px solid var(--brown-10); vertical-align: middle; }
        table.data-table tbody tr:last-child td { border-bottom: none; }
        table.data-table tbody tr:hover { background: var(--cream); }

        .pill { display: inline-block; padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase; }
        .pill-mono { font-family: 'Menlo', 'Consolas', monospace; background: var(--green-10); color: var(--green); letter-spacing: .6px; }
        .pill-accepted { background: var(--green-10); color: var(--green); }
        .pill-rejected { background: var(--red-10); color: var(--red); }
        .coords { font-family: 'Menlo', 'Consolas', monospace; font-size: 12px; color: var(--brown-70); }
        .accuracy-note { font-size: 11px; color: var(--brown-60); }

        .empty-state { padding: 56px 24px; text-align: center; color: var(--brown-60); }
        .empty-state-title { font-size: 17px; font-weight: 700; color: var(--brown); margin-bottom: 6px; }
        .empty-state-desc { font-size: 14px; }

        .nowrap { white-space: nowrap; }

        @media (max-width: 900px) {
            .dashboard-shell { flex-direction: column; }
            .sidebar { width: 100%; height: auto; position: static; padding: 14px 16px; gap: 14px; border-right: none; border-bottom: 1px solid var(--brown-10); }
            .sidebar-nav { flex-direction: row; overflow-x: auto; flex-wrap: nowrap; gap: 8px; }
            .sidebar-nav::-webkit-scrollbar { display: none; }
            .nav-item { padding: 8px 12px; min-width: max-content; }
            .nav-item::before, .nav-item.active::after { display: none; }
            .nav-item.active { background: rgba(66, 118, 106, .14); }
            .dashboard-body { padding: 20px; }
            .page-header { padding: 16px 20px; }
        }
    </style>
</head>

<body>

<div class="dashboard-shell">

    @include('vendor.customer._sidebar', ['vendor' => $vendor])

    <div class="main-content">

        <header class="page-header">
            <div>
                <div class="header-title">Kunjungan Toko</div>
                <div class="header-subtitle">Kelola daftar toko dan validasi kunjungan via geolocation</div>
            </div>
        </header>

        <div class="dashboard-body">

            @if (session('kunjunganSuccess'))
                <div class="alert alert-success">{{ session('kunjunganSuccess') }}</div>
            @endif

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Daftar Toko</div>
                        <div class="panel-subtitle">{{ $tokos->count() }} toko terdaftar &mdash; threshold default {{ $threshold }}m</div>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('dashboard.kunjungan.scan') }}" class="btn btn-outline">📷 Scan &amp; Kunjungi</a>
                        <a href="{{ route('dashboard.kunjungan.toko.create') }}" class="btn btn-primary">+ Tambah Toko</a>
                    </div>
                </div>

                @if ($tokos->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-title">Belum ada toko</div>
                        <div class="empty-state-desc">Klik "Tambah Toko" untuk merekam lokasi toko pertama Anda.</div>
                    </div>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Toko</th>
                                <th>Barcode</th>
                                <th>Koordinat</th>
                                <th>Akurasi</th>
                                <th>Terdaftar</th>
                                <th style="text-align:right;">QR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tokos as $toko)
                                <tr>
                                    <td><strong>{{ $toko->nama_toko }}</strong></td>
                                    <td><span class="pill pill-mono">{{ $toko->barcode }}</span></td>
                                    <td class="coords">{{ number_format($toko->latitude, 6) }}, {{ number_format($toko->longitude, 6) }}</td>
                                    <td class="nowrap">{{ number_format($toko->accuracy, 1) }} m</td>
                                    <td class="nowrap">{{ $toko->created_at?->diffForHumans() }}</td>
                                    <td style="text-align:right;">
                                        <a href="{{ route('dashboard.kunjungan.toko.qr', $toko) }}" target="_blank" rel="noopener" class="btn btn-outline" style="padding:6px 12px;font-size:12px;">Cetak QR</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Riwayat Kunjungan</div>
                        <div class="panel-subtitle">{{ $kunjungans->count() }} laporan terbaru</div>
                    </div>
                </div>

                @if ($kunjungans->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-title">Belum ada kunjungan</div>
                        <div class="empty-state-desc">Gunakan "Scan &amp; Kunjungi" untuk mencatat kunjungan toko.</div>
                    </div>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Toko</th>
                                <th>Status</th>
                                <th>Jarak</th>
                                <th>Threshold Efektif</th>
                                <th>Posisi Sales</th>
                                <th>Akurasi Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kunjungans as $k)
                                <tr>
                                    <td class="nowrap">{{ $k->created_at?->format('d M H:i') }}</td>
                                    <td>
                                        @if ($k->lokasiToko)
                                            <strong>{{ $k->lokasiToko->nama_toko }}</strong>
                                            <div class="accuracy-note">{{ $k->lokasi_toko_barcode }}</div>
                                        @else
                                            <em>(dihapus)</em>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($k->status === 'accepted')
                                            <span class="pill pill-accepted">Accepted</span>
                                        @else
                                            <span class="pill pill-rejected">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="nowrap">{{ number_format($k->jarak_meter, 1) }} m</td>
                                    <td class="nowrap">{{ number_format($k->threshold_efektif, 1) }} m</td>
                                    <td class="coords">{{ number_format($k->sales_latitude, 6) }}, {{ number_format($k->sales_longitude, 6) }}</td>
                                    <td class="nowrap">{{ number_format($k->sales_accuracy, 1) }} m</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>

        </div>
    </div>
</div>

</body>
</html>
