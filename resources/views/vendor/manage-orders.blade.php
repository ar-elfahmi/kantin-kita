<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pesanan | Kantin Kita</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #FBF5E8;
            --brown: #744622;
            --brown-60: rgba(116, 70, 34, .6);
            --brown-70: rgba(116, 70, 34, .7);
            --brown-10: rgba(116, 70, 34, .1);
            --brown-20: rgba(116, 70, 34, .2);
            --green: #42766A;
            --green-10: rgba(66, 118, 106, .1);
            --green-20: rgba(66, 118, 106, .2);
            --amber: #B8860B;
            --amber-10: rgba(184, 134, 11, .12);
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(116, 70, 34, .08), 0 1px 2px rgba(116, 70, 34, .06);
            --shadow-md: 0 4px 16px rgba(116, 70, 34, .10), 0 2px 6px rgba(116, 70, 34, .06);
            --radius-sm: 12px;
            --radius-md: 16px;
            --radius-lg: 20px;
            --radius-pill: 9999px;
            --transition: .25s cubic-bezier(.4, 0, .2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .dashboard-shell { display: flex; min-height: 100vh; }



        .main-content { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .page-header {
            background: var(--white);
            border-bottom: 1px solid var(--brown-10);
            padding: 16px 32px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
            box-shadow: 0 1px 0 var(--brown-10);
        }
        .header-title { font-size: 24px; font-weight: 700; color: var(--brown); letter-spacing: -.5px; }
        .header-subtitle { font-size: 14px; font-weight: 400; color: var(--brown-60); letter-spacing: -.5px; }
        .header-user-chip {
            display: flex; align-items: center; gap: 12px;
            padding: 8px 16px;
            background: var(--cream);
            border-radius: var(--radius-md);
            border: 1px solid var(--brown-10);
        }
        .header-avatar { width: 32px; height: 32px; border-radius: var(--radius-pill); object-fit: cover; }
        .avatar-initial { display: flex; align-items: center; justify-content: center; background: var(--brown-10); color: var(--brown); font-weight: 700; font-size: 13px; text-transform: uppercase; }
        .header-username { font-size: 14px; font-weight: 600; color: var(--brown); letter-spacing: -.5px; }

        .dashboard-body {
            padding: 32px;
            display: flex; flex-direction: column;
            gap: 24px;
            animation: fade-in-up .5s ease both;
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── Flash banner ─── */
        .flash {
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 14px; font-weight: 500;
            display: flex; align-items: center; gap: 10px;
        }
        .flash.is-success { background: var(--green-10); color: var(--green); border: 1px solid var(--green-20); }
        .flash.is-error { background: rgba(192, 57, 43, .08); color: #c0392b; border: 1px solid rgba(192, 57, 43, .25); }

        /* ─── Panel ─── */
        .panel {
            background: var(--white);
            border-radius: var(--radius-md);
            border: 1px solid var(--brown-10);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .panel-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--brown-10);
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; flex-wrap: wrap;
        }
        .panel-title { font-size: 20px; font-weight: 700; color: var(--brown); letter-spacing: -.5px; }
        .panel-subtitle { font-size: 14px; color: var(--brown-60); margin-top: 4px; letter-spacing: -.5px; }

        /* ─── Filter tabs ─── */
        .filter-tabs {
            display: flex; gap: 8px;
            flex-wrap: wrap;
        }
        .filter-tab {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            background: var(--cream);
            color: var(--brown-70);
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            border: 1.5px solid transparent;
            transition: background var(--transition), color var(--transition), border-color var(--transition);
        }
        .filter-tab:hover { background: var(--brown-10); color: var(--brown); }
        .filter-tab.is-active {
            background: var(--green);
            color: var(--white);
            border-color: var(--green);
        }
        .filter-tab .count-pill {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 22px; height: 22px;
            padding: 0 7px;
            border-radius: var(--radius-pill);
            background: var(--white);
            color: var(--brown);
            font-size: 11px; font-weight: 700;
        }
        .filter-tab.is-active .count-pill { background: rgba(255, 255, 255, .25); color: var(--white); }

        /* ─── Orders Table ─── */
        .orders-table-wrap { overflow-x: auto; }
        .orders-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .orders-table thead th {
            text-align: left;
            padding: 14px 20px;
            background: var(--cream);
            font-size: 12px; font-weight: 700;
            color: var(--brown-70);
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 1px solid var(--brown-10);
            white-space: nowrap;
        }
        .orders-table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--brown-10);
            vertical-align: top;
        }
        .orders-table tbody tr:last-child td { border-bottom: none; }
        .orders-table tbody tr:hover { background: var(--cream); }

        .order-id {
            font-family: 'Menlo', 'Consolas', monospace;
            font-size: 12px;
            font-weight: 700;
            color: var(--green);
            background: var(--green-10);
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .customer-name { font-weight: 600; color: var(--brown); }
        .customer-meta { font-size: 12px; color: var(--brown-60); margin-top: 2px; }
        .items-list {
            list-style: none; padding: 0; margin: 0;
            display: flex; flex-direction: column; gap: 4px;
            max-width: 280px;
        }
        .items-list li {
            font-size: 13px;
            color: var(--brown);
            display: flex; gap: 6px;
        }
        .items-list .item-qty {
            font-weight: 700; color: var(--green);
            min-width: 28px;
        }
        .items-list .item-name {
            color: var(--brown);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .total-cell {
            font-weight: 700;
            color: var(--green);
            white-space: nowrap;
        }
        .pickup-cell {
            font-size: 13px;
            color: var(--brown-70);
            white-space: nowrap;
        }
        .pickup-cell .pickup-label { font-size: 11px; color: var(--brown-60); display: block; margin-bottom: 2px; text-transform: uppercase; letter-spacing: .3px; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px;
            border-radius: var(--radius-pill);
            font-size: 12px; font-weight: 700;
            letter-spacing: -.3px;
            text-transform: capitalize;
        }
        .status-badge::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%;
            background: currentColor;
        }
        .status-process { background: var(--amber-10); color: var(--amber); }
        .status-done { background: var(--green-10); color: var(--green); }
        .status-pending { background: var(--brown-10); color: var(--brown-70); }

        .btn-mark-done {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            background: var(--green);
            color: var(--white);
            font-size: 13px; font-weight: 600;
            letter-spacing: -.3px;
            border: none; cursor: pointer;
            text-decoration: none;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            white-space: nowrap;
            font-family: 'Poppins', sans-serif;
        }
        .btn-mark-done:hover { background: #355f55; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(66, 118, 106, .35); }
        .btn-mark-done:active { transform: translateY(0); }
        .order-done-form { margin: 0; }

        .done-indicator {
            font-size: 12px;
            color: var(--brown-60);
            font-style: italic;
        }

        /* ─── Empty State ─── */
        .empty-state { padding: 64px 32px; text-align: center; color: var(--brown-60); }
        .empty-state-icon {
            width: 64px; height: 64px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: var(--cream);
            display: flex; align-items: center; justify-content: center;
            color: var(--brown-60);
        }
        .empty-state-title { font-size: 18px; font-weight: 700; color: var(--brown); margin-bottom: 6px; }
        .empty-state-desc { font-size: 14px; max-width: 360px; margin: 0 auto; }

        /* ─── Pagination ─── */
        .pagination-wrap {
            padding: 16px 28px;
            border-top: 1px solid var(--brown-10);
            display: flex; justify-content: center;
        }
        .pagination-wrap nav { font-family: 'Poppins', sans-serif; }
        .pagination-wrap nav ul { display: flex; gap: 4px; list-style: none; padding: 0; margin: 0; }
        .pagination-wrap nav a,
        .pagination-wrap nav span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 36px; height: 36px;
            padding: 0 10px;
            border-radius: var(--radius-sm);
            font-size: 13px; font-weight: 600;
            color: var(--brown-70);
            text-decoration: none;
            background: var(--white);
            border: 1px solid var(--brown-10);
        }
        .pagination-wrap nav a:hover { background: var(--cream); color: var(--brown); }
        .pagination-wrap nav .active span { background: var(--green); color: var(--white); border-color: var(--green); }
        .pagination-wrap nav .disabled span { opacity: .5; }

        /* ─── Responsive ─── */
        @media (max-width: 900px) {
            .dashboard-body { padding: 20px; }
            .page-header { padding: 16px 20px; }

            .orders-table thead { display: none; }
            .orders-table, .orders-table tbody, .orders-table tr, .orders-table td { display: block; width: 100%; }
            .orders-table tbody tr {
                padding: 16px;
                border-bottom: 1px solid var(--brown-10);
                display: flex; flex-direction: column;
                gap: 8px;
            }
            .orders-table tbody td { padding: 0; border: none; }
            .orders-table tbody td::before {
                content: attr(data-label);
                display: block;
                font-size: 11px; font-weight: 700; color: var(--brown-60);
                text-transform: uppercase; letter-spacing: .4px;
                margin-bottom: 4px;
            }
            .items-list { max-width: none; }
        }

        @media (max-width: 640px) {
            .header-title { font-size: 20px; }
            .header-username { display: none; }
            .panel-header { padding: 20px; }
            .filter-tabs { width: 100%; }
            .filter-tab { flex: 1; justify-content: center; }
        }

        .toast {
            position: fixed; bottom: 24px; right: 24px;
            background: var(--green); color: var(--white);
            padding: 12px 18px; border-radius: var(--radius-md);
            box-shadow: 0 8px 24px rgba(66, 118, 106, .35);
            font-size: 14px; font-weight: 500;
            z-index: 2000;
            opacity: 0; transform: translateY(8px);
            transition: opacity var(--transition), transform var(--transition);
        }
        .toast.is-visible { opacity: 1; transform: translateY(0); }
        .toast.is-error { background: #c0392b; box-shadow: 0 8px 24px rgba(192, 57, 43, .35); }
    </style>
</head>

<body>

    <div class="dashboard-shell">

        {{-- Sidebar: extracted to vendor/_sidebar.blade.php (shared with dashboard-vendor & manage-menu) --}}
        @include('vendor._sidebar', ['vendor' => $vendor])

        <div class="main-content">

            <header class="page-header">
                <div>
                    <div class="header-title">Kelola Pesanan</div>
                    <div class="header-subtitle">Selesaikan pesanan yang sudah dibayar</div>
                </div>
                <div class="header-user-chip">
                    <div class="header-avatar avatar-initial">{{ strtoupper(substr($vendor->nama_vendor, 0, 1)) }}</div>
                    <span class="header-username">{{ $vendor->nama_vendor }}</span>
                </div>
            </header>

            <div class="dashboard-body">

                @if (session('orderSuccess'))
                    <div class="flash is-success">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        {{ session('orderSuccess') }}
                    </div>
                @endif
                @if (session('orderError'))
                    <div class="flash is-error">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        {{ session('orderError') }}
                    </div>
                @endif

                <section class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Daftar Pesanan</div>
                            <div class="panel-subtitle">Hanya pesanan yang sudah dibayar (settlement) yang tampil di sini</div>
                        </div>
                        <nav class="filter-tabs" aria-label="Filter status pesanan">
                            <a href="{{ route('dashboard.orders', ['status' => 'diproses']) }}"
                               class="filter-tab {{ $statusFilter === 'diproses' ? 'is-active' : '' }}">
                                Perlu Diselesaikan
                                <span class="count-pill">{{ $counts['diproses'] }}</span>
                            </a>
                            <a href="{{ route('dashboard.orders', ['status' => 'selesai']) }}"
                               class="filter-tab {{ $statusFilter === 'selesai' ? 'is-active' : '' }}">
                                Selesai
                                <span class="count-pill">{{ $counts['selesai'] }}</span>
                            </a>
                            <a href="{{ route('dashboard.orders', ['status' => 'semua']) }}"
                               class="filter-tab {{ $statusFilter === 'semua' ? 'is-active' : '' }}">
                                Semua
                                <span class="count-pill">{{ $counts['semua'] }}</span>
                            </a>
                        </nav>
                    </div>

                    @if ($pesanans->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                    <line x1="3" y1="6" x2="21" y2="6"/>
                                    <path d="M16 10a4 4 0 0 1-8 0"/>
                                </svg>
                            </div>
                            <div class="empty-state-title">
                                @if ($statusFilter === 'diproses')
                                    Tidak ada pesanan yang perlu diselesaikan
                                @elseif ($statusFilter === 'selesai')
                                    Belum ada pesanan yang diselesaikan
                                @else
                                    Belum ada pesanan masuk
                                @endif
                            </div>
                            <div class="empty-state-desc">
                                Pesanan yang sudah dibayar customer akan muncul di sini secara otomatis.
                            </div>
                        </div>
                    @else
                        <div class="orders-table-wrap">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Item Pesanan</th>
                                        <th>Total</th>
                                        <th>Waktu Pengambilan</th>
                                        <th>Status</th>
                                        <th style="text-align:right;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanans as $pesanan)
                                        @php
                                            $statusRaw = strtolower((string) $pesanan->status_pesanan);
                                            $statusClass = match ($statusRaw) {
                                                'diproses' => 'status-process',
                                                'selesai'  => 'status-done',
                                                default    => 'status-pending',
                                            };
                                            $totalItem = $pesanan->detailPesanans->sum('jumlah');
                                            $paidAt = $pesanan->payment?->paid_at;
                                        @endphp
                                        <tr>
                                            <td data-label="Order ID">
                                                <span class="order-id">#{{ $pesanan->id }}</span>
                                            </td>
                                            <td data-label="Customer">
                                                <div class="customer-name">{{ $pesanan->nama_customer }}</div>
                                                <div class="customer-meta">
                                                    {{ $totalItem }} item &bull;
                                                    {{ $pesanan->created_at?->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td data-label="Item Pesanan">
                                                <ul class="items-list">
                                                    @foreach ($pesanan->detailPesanans as $detail)
                                                        <li>
                                                            <span class="item-qty">{{ $detail->jumlah }}x</span>
                                                            <span class="item-name">{{ $detail->menu?->nama_menu ?? 'Menu dihapus' }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td data-label="Total" class="total-cell">
                                                Rp {{ number_format((int) $pesanan->total, 0, ',', '.') }}
                                            </td>
                                            <td data-label="Pengambilan" class="pickup-cell">
                                                <span class="pickup-label">Ambil</span>
                                                {{ $pesanan->waktu_pengambilan ?: '—' }}
                                            </td>
                                            <td data-label="Status">
                                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($statusRaw) }}</span>
                                            </td>
                                            <td data-label="Aksi" style="text-align:right;">
                                                @if ($statusRaw === 'diproses')
                                                    <form method="POST"
                                                          action="{{ route('dashboard.orders.complete', ['pesanan' => $pesanan->id]) }}"
                                                          class="order-done-form"
                                                          onsubmit="return confirm('Tandai pesanan #{{ $pesanan->id }} sebagai selesai?');">
                                                        @csrf
                                                        <button type="submit" class="btn-mark-done">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="20 6 9 17 4 12"/>
                                                            </svg>
                                                            Selesaikan
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="done-indicator">
                                                        @if ($paidAt)
                                                            Dibayar {{ $paidAt->diffForHumans() }}
                                                        @else
                                                            Sudah selesai
                                                        @endif
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($pesanans->hasPages())
                            <div class="pagination-wrap">
                                {{ $pesanans->links() }}
                            </div>
                        @endif
                    @endif
                </section>

            </div>
        </div>
    </div>

</body>
</html>
