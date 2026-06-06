<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu &amp; Tag Harga – Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114">
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
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(116, 70, 34, .08), 0 1px 2px rgba(116, 70, 34, .06);
            --shadow-md: 0 4px 16px rgba(116, 70, 34, .10), 0 2px 6px rgba(116, 70, 34, .06);
            --radius-sm: 12px;
            --radius-md: 16px;
            --radius-lg: 20px;
            --radius-pill: 9999px;
            --transition: .25s cubic-bezier(.4, 0, .2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .dashboard-shell { display: flex; min-height: 100vh; }

        /* ─── Sidebar (kept in sync with dashboard-vendor.blade.php) ─── */
        .sidebar {
            width: 288px;
            flex-shrink: 0;
            background: var(--white);
            border-right: 1px solid var(--brown-10);
            display: flex;
            flex-direction: column;
            padding: 24px;
            gap: 48px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 2px 0 20px rgba(116, 70, 34, .04);
        }

        .sidebar-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }

        .logo-icon {
            width: 48px; height: 48px;
            background: var(--green);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(66, 118, 106, .35);
            transition: transform var(--transition);
        }

        .logo-icon:hover { transform: scale(1.07); }

        .logo-text-primary {
            font-size: 24px; font-weight: 700; color: var(--brown);
            letter-spacing: -.5px; line-height: 1.33;
        }

        .logo-text-secondary {
            font-size: 12px; font-weight: 500; color: var(--brown-60);
            letter-spacing: -.5px; line-height: 1.33;
        }

        .sidebar-nav { display: flex; flex-direction: column; gap: 8px; flex: 1; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 16px; font-weight: 500;
            color: var(--brown-70);
            transition: background var(--transition), color var(--transition), transform var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: ''; position: absolute; inset: 0;
            background: var(--green-10);
            opacity: 0; transition: opacity var(--transition);
            border-radius: inherit;
        }

        .nav-item:hover::before { opacity: 1; }
        .nav-item:hover { color: var(--green); transform: translateX(3px); }

        .nav-item.active {
            background: var(--green-10);
            color: var(--green);
            font-weight: 600;
        }

        .nav-item.active::after {
            content: ''; position: absolute;
            right: 0; top: 20%;
            height: 60%; width: 3px;
            background: var(--green);
            border-radius: 2px 0 0 2px;
        }

        .nav-icon {
            width: 20px; height: 20px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }

        .sidebar-footer { border-top: 1px solid var(--brown-10); padding-top: 24px; }

        .sidebar-user {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            transition: background var(--transition);
        }

        .sidebar-user:hover { background: var(--cream); }

        .user-avatar {
            width: 40px; height: 40px;
            border-radius: var(--radius-pill);
            object-fit: cover;
            border: 2px solid var(--brown-10);
        }

        .user-name {
            font-size: 14px; font-weight: 600; color: var(--brown);
            letter-spacing: -.5px;
        }

        .user-email {
            font-size: 12px; font-weight: 400; color: var(--brown-60);
            letter-spacing: -.5px;
        }

        .sidebar-logout-btn {
            margin-left: auto;
            border: none; background: transparent; padding: 0;
            display: inline-flex; align-items: center;
            cursor: pointer;
        }

        .sidebar-logout {
            width: 16px; height: 16px;
            opacity: .6; transition: opacity var(--transition);
        }

        .sidebar-user:hover .sidebar-logout { opacity: 1; }

        /* ─── Main ─── */
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

        /* ─── Section Card ─── */
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
            gap: 16px;
            flex-wrap: wrap;
        }

        .panel-title { font-size: 20px; font-weight: 700; color: var(--brown); letter-spacing: -.5px; }
        .panel-subtitle { font-size: 14px; color: var(--brown-60); margin-top: 4px; letter-spacing: -.5px; }
        .panel-count { font-size: 13px; color: var(--brown-60); }

        /* ─── Menu Table ─── */
        .menu-table-wrap { overflow-x: auto; }

        .menu-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .menu-table thead th {
            text-align: left;
            padding: 14px 20px;
            background: var(--cream);
            font-size: 12px;
            font-weight: 700;
            color: var(--brown-70);
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 1px solid var(--brown-10);
            white-space: nowrap;
        }

        .menu-table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--brown-10);
            vertical-align: middle;
        }

        .menu-table tbody tr:last-child td { border-bottom: none; }
        .menu-table tbody tr:hover { background: var(--cream); }

        .menu-thumb {
            width: 56px; height: 56px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            border: 1px solid var(--brown-10);
            background: var(--cream);
        }

        .menu-name { font-weight: 600; color: var(--brown); }
        .menu-desc {
            font-size: 12px;
            color: var(--brown-60);
            margin-top: 2px;
            max-width: 260px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .badge-kategori {
            display: inline-block;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            background: var(--brown-10);
            color: var(--brown);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: -.3px;
        }

        .id-barang-pill {
            display: inline-flex; align-items: center;
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            background: var(--green-10);
            color: var(--green);
            font-family: 'Menlo', 'Consolas', monospace;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .harga-cell {
            font-weight: 700;
            color: var(--green);
            white-space: nowrap;
        }

        .availability {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .availability-dot { width: 8px; height: 8px; border-radius: 50%; }
        .availability.is-on  { color: var(--green); }
        .availability.is-on  .availability-dot  { background: var(--green); }
        .availability.is-off { color: var(--brown-60); }
        .availability.is-off .availability-dot  { background: var(--brown-60); }

        .btn-cetak {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            background: var(--green);
            color: var(--white);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: -.3px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            white-space: nowrap;
        }

        .btn-cetak:hover {
            background: #355f55;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(66, 118, 106, .35);
        }

        .btn-cetak svg { flex-shrink: 0; }

        /* ─── Empty State ─── */
        .empty-state {
            padding: 64px 32px;
            text-align: center;
            color: var(--brown-60);
        }
        .empty-state-title { font-size: 18px; font-weight: 700; color: var(--brown); margin-bottom: 6px; }
        .empty-state-desc { font-size: 14px; }

        /* ─── Responsive ─── */
        @media (max-width: 900px) {
            .dashboard-shell { flex-direction: column; }
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                padding: 14px 16px 12px;
                gap: 14px;
                border-right: none;
                border-bottom: 1px solid var(--brown-10);
            }
            .sidebar-nav { flex-direction: row; overflow-x: auto; flex-wrap: nowrap; gap: 8px; padding-bottom: 4px; }
            .sidebar-nav::-webkit-scrollbar { display: none; }
            .nav-item { padding: 8px 12px; min-height: 36px; min-width: max-content; transform: none; }
            .nav-item::before, .nav-item.active::after { display: none; }
            .nav-item.active { background: rgba(66, 118, 106, .14); }
            .dashboard-body { padding: 20px; }
            .page-header { padding: 16px 20px; }
            .menu-table thead { display: none; }
            .menu-table, .menu-table tbody, .menu-table tr, .menu-table td { display: block; width: 100%; }
            .menu-table tbody tr {
                padding: 16px;
                border-bottom: 1px solid var(--brown-10);
                display: grid;
                grid-template-columns: 56px 1fr;
                gap: 8px 14px;
            }
            .menu-table tbody td { padding: 0; border: none; }
            .menu-table tbody td.cell-thumb { grid-row: span 5; }
            .menu-table tbody td.cell-action { grid-column: 1 / -1; margin-top: 8px; }
        }

        @media (max-width: 640px) {
            .header-title { font-size: 20px; }
            .header-username { display: none; }
        }
    </style>
</head>

<body>

    <div class="dashboard-shell">

        {{-- TODO: extract sidebar into resources/views/vendor/_sidebar.blade.php; currently duplicated with dashboard-vendor.blade.php --}}
        <aside class="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <div class="logo-icon">
                    <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                </div>
                <div>
                    <div class="logo-text-primary">Kantin Kita</div>
                    <div class="logo-text-secondary">Vendor Dashboard</div>
                </div>
            </a>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 2C2 1.44687 1.55313 1 1 1C0.446875 1 0 1.44687 0 2V12.5C0 13.8813 1.11875 15 2.5 15H15C15.5531 15 16 14.5531 16 14C16 13.4469 15.5531 13 15 13H2.5C2.225 13 2 12.775 2 12.5V2ZM14.7063 4.70625C15.0969 4.31563 15.0969 3.68125 14.7063 3.29063C14.3156 2.9 13.6812 2.9 13.2906 3.29063L10 6.58437L8.20625 4.79063C7.81563 4.4 7.18125 4.4 6.79063 4.79063L3.29063 8.29062C2.9 8.68125 2.9 9.31563 3.29063 9.70625C3.68125 10.0969 4.31563 10.0969 4.70625 9.70625L7.5 6.91563L9.29375 8.70938C9.68437 9.1 10.3188 9.1 10.7094 8.70938L14.7094 4.70937L14.7063 4.70625Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard.menu') }}" class="nav-item {{ request()->routeIs('dashboard.menu*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                            <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                            <path d="M3 17v2a2 2 0 0 0 2 2h2"/>
                            <path d="M17 21h2a2 2 0 0 0 2-2v-2"/>
                            <line x1="7" y1="8" x2="7" y2="16"/>
                            <line x1="10" y1="8" x2="10" y2="16"/>
                            <line x1="13" y1="8" x2="13" y2="16"/>
                            <line x1="16" y1="8" x2="16" y2="16"/>
                        </svg>
                    </span>
                    <span>Tag Harga</span>
                </a>
                <a href="{{ route('dashboard.customer.index') }}" class="nav-item {{ request()->routeIs('dashboard.customer.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <path d="M20 8v6"/>
                            <path d="M23 11h-6"/>
                        </svg>
                    </span>
                    <span>Customer</span>
                </a>
                <a href="{{ route('dashboard.kunjungan.index') }}" class="nav-item {{ request()->routeIs('dashboard.kunjungan.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </span>
                    <span>Kunjungan Toko</span>
                </a>
                <button type="button" class="nav-item" id="scanBarcodeBtn" style="border:none;background:none;width:100%;cursor:pointer;text-align:left;font:inherit;">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                            <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                            <path d="M3 17v2a2 2 0 0 0 2 2h2"/>
                            <path d="M17 21h2a2 2 0 0 0 2-2v-2"/>
                            <line x1="7" y1="11" x2="7" y2="14"/>
                            <line x1="11" y1="9" x2="11" y2="14"/>
                            <line x1="15" y1="7" x2="15" y2="14"/>
                        </svg>
                    </span>
                    <span>Scan Barcode</span>
                </button>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <img class="user-avatar" src="https://api.builder.io/api/v1/image/assets/TEMP/087ab2dd772577a5a55f3825b36f4260590b6776?width=80" alt="{{ $vendor->nama_vendor }}">
                    <div style="flex:1;min-width:0;">
                        <div class="user-name">{{ $vendor->nama_vendor }}</div>
                        <div class="user-email">{{ auth()->user()?->email ?? 'vendor@kantinkita.id' }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="sidebar-logout-btn" aria-label="Logout">
                            <svg class="sidebar-logout" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M11.8094 3.30938L15.6469 7.14687C15.8719 7.37187 16 7.68125 16 8C16 8.31875 15.8719 8.62812 15.6469 8.85312L11.8094 12.6906C11.6094 12.8906 11.3406 13 11.0594 13C10.475 13 10 12.525 10 11.9406V10H6C5.44688 10 5 9.55313 5 9V7C5 6.44688 5.44688 6 6 6H10V4.05937C10 3.475 10.475 3 11.0594 3C11.3406 3 11.6094 3.1125 11.8094 3.30938ZM5 3H3C2.44688 3 2 3.44688 2 4V12C2 12.5531 2.44688 13 3 13H5C5.55312 13 6 13.4469 6 14C6 14.5531 5.55312 15 5 15H3C1.34375 15 0 13.6562 0 12V4C0 2.34375 1.34375 1 3 1H5C5.55312 1 6 1.44687 6 2C6 2.55313 5.55312 3 5 3Z" fill="rgba(116,70,34,0.6)"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="main-content">

            <header class="page-header">
                <div>
                    <div class="header-title">Kelola Menu &mdash; Tag Harga</div>
                    <div class="header-subtitle">Cetak tag harga dengan barcode untuk setiap menu Anda</div>
                </div>
                <div class="header-user-chip">
                    <img class="header-avatar" src="https://api.builder.io/api/v1/image/assets/TEMP/d2809f4985ab877fe9cc63eb8ac265662cce04ff?width=64" alt="{{ $vendor->nama_vendor }}">
                    <span class="header-username">{{ $vendor->nama_vendor }}</span>
                </div>
            </header>

            <div class="dashboard-body">

                <section class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Daftar Menu</div>
                            <div class="panel-subtitle">Klik "Cetak Tag Harga" untuk mengunduh PDF tag dengan barcode</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:14px;">
                            <span class="panel-count">{{ $menus->count() }} menu</span>
                            <a href="{{ route('dashboard.menu.scan') }}" class="btn-cetak">📷 Scan Tag Harga</a>
                        </div>
                    </div>

                    @if ($menus->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-title">Belum ada menu</div>
                            <div class="empty-state-desc">Tambahkan menu terlebih dahulu untuk mencetak tag harga.</div>
                        </div>
                    @else
                        <div class="menu-table-wrap">
                            <table class="menu-table">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama Menu</th>
                                        <th>Kategori</th>
                                        <th>ID Barang</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th style="text-align:right;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td class="cell-thumb">
                                                <img class="menu-thumb"
                                                    src="{{ $menu->path_gambar ?: 'https://api.builder.io/api/v1/image/assets/TEMP/ba6382dc578b32751a4c6e03f2066fc64f93e8ce?width=128' }}"
                                                    alt="{{ $menu->nama_menu }}">
                                            </td>
                                            <td>
                                                <div class="menu-name">{{ $menu->nama_menu }}</div>
                                                @if ($menu->deskripsi)
                                                    <div class="menu-desc">{{ $menu->deskripsi }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge-kategori">
                                                    {{ $menu->kategoriMenu?->nama_kategori ?? '—' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="id-barang-pill">{{ $menu->id_barang }}</span>
                                            </td>
                                            <td class="harga-cell">
                                                Rp {{ number_format((int) $menu->harga, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if ($menu->is_available)
                                                    <span class="availability is-on">
                                                        <span class="availability-dot"></span> Tersedia
                                                    </span>
                                                @else
                                                    <span class="availability is-off">
                                                        <span class="availability-dot"></span> Habis
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="cell-action" style="text-align:right;">
                                                <a href="{{ route('menu.price-tag', $menu) }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="btn-cetak">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="6 9 6 2 18 2 18 9"/>
                                                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                                        <rect x="6" y="14" width="12" height="8"/>
                                                    </svg>
                                                    Cetak Tag Harga
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>

            </div>
        </div>
    </div>

@include('vendor.customer._scan_barcode_modal')

</body>

</html>
