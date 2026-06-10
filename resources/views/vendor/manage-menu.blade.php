<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Produk | Kantin Kita</title>
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

        .btn-edit, .btn-delete, .btn-cetak {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: -.3px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            white-space: nowrap;
        }

        .btn-edit { background: var(--brown-10); color: var(--brown); }
        .btn-edit:hover { background: var(--brown-20); transform: translateY(-1px); }

        .btn-delete { background: #fde8e8; color: #c0392b; }
        .btn-delete:hover { background: #f5c6c6; transform: translateY(-1px); }

        .btn-cetak {
            padding: 8px 16px;
            background: var(--green);
            color: var(--white);
        }

        .btn-cetak:hover {
            background: #355f55;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(66, 118, 106, .35);
        }

        .btn-cetak svg { flex-shrink: 0; }
        .cell-action { text-align: right; white-space: nowrap; }
        .cell-action .btn-edit, .cell-action .btn-delete, .cell-action .btn-cetak { display: inline-flex; vertical-align: middle; }

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

        /* ─── Add Product: button & modal ─── */
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 4px;
            padding: 10px 18px;
            background: var(--green);
            color: var(--white);
            border: none;
            border-radius: var(--radius-pill);
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 600;
            letter-spacing: -.2px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(66, 118, 106, .25);
            transition: transform var(--transition), box-shadow var(--transition), background var(--transition);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(66, 118, 106, .32);
            background: #36655b;
        }
        .btn-primary:disabled {
            opacity: .6; cursor: not-allowed; transform: none; box-shadow: none;
        }

        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(116, 70, 34, .45);
            backdrop-filter: blur(2px);
            display: flex; align-items: center; justify-content: center;
            padding: 24px;
            z-index: 1000;
            opacity: 0; visibility: hidden;
            transition: opacity var(--transition), visibility var(--transition);
        }
        .modal-overlay.is-open { opacity: 1; visibility: visible; }

        .modal-card {
            background: var(--white);
            width: 100%;
            max-width: 520px;
            max-height: calc(100vh - 48px);
            overflow-y: auto;
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: 0 20px 60px rgba(116, 70, 34, .25);
            transform: scale(.96);
            transition: transform var(--transition);
        }
        .modal-overlay.is-open .modal-card { transform: scale(1); }

        .modal-head {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; margin-bottom: 20px;
        }
        .modal-title { font-size: 20px; font-weight: 700; color: var(--brown); letter-spacing: -.5px; }
        .modal-close {
            border: none; background: transparent; cursor: pointer;
            padding: 6px; border-radius: 8px; color: var(--brown-60);
            transition: background var(--transition), color var(--transition);
        }
        .modal-close:hover { background: var(--brown-10); color: var(--brown); }

        .form-grid { display: flex; flex-direction: column; gap: 14px; }
        .form-row { display: flex; flex-direction: column; gap: 6px; }
        .form-row.is-inline { flex-direction: row; align-items: center; gap: 10px; }
        .form-label { font-size: 13px; font-weight: 600; color: var(--brown); letter-spacing: -.2px; }
        .form-required { color: #c0392b; margin-left: 2px; }
        .form-input, .form-select, .form-textarea {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--brown);
            background: var(--white);
            border: 1.5px solid var(--brown-20);
            border-radius: var(--radius-sm);
            padding: 10px 12px;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
            width: 100%;
        }
        .form-textarea { resize: vertical; min-height: 80px; }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px var(--green-10);
        }
        .form-file { font-size: 13px; color: var(--brown-70); }
        .form-hint { font-size: 12px; color: var(--brown-60); }
        .form-error {
            font-size: 12px; color: #c0392b; min-height: 0; display: none;
        }
        .form-error.is-visible { display: block; }
        .form-row.has-error .form-input,
        .form-row.has-error .form-select,
        .form-row.has-error .form-textarea {
            border-color: #c0392b;
        }

        .form-checkbox { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .form-checkbox input { width: 16px; height: 16px; accent-color: var(--green); }

        .modal-actions {
            display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;
        }
        .btn-secondary {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 10px 18px;
            background: var(--white);
            color: var(--brown);
            border: 1.5px solid var(--brown-20);
            border-radius: var(--radius-pill);
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 600;
            cursor: pointer;
            transition: background var(--transition), border-color var(--transition);
        }
        .btn-secondary:hover { background: var(--brown-10); border-color: var(--brown-60); }

        .btn-spinner {
            display: inline-block; width: 14px; height: 14px;
            border: 2px solid rgba(255, 255, 255, .35);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: btn-spin .7s linear infinite;
            margin-right: 8px; vertical-align: -2px;
        }
        @keyframes btn-spin { to { transform: rotate(360deg); } }

        .modal-confirm-text { font-size: 15px; color: var(--brown); line-height: 1.6; margin-bottom: 24px; text-align: center; }
        .modal-confirm-name { font-weight: 700; color: #c0392b; }
        .modal-actions-confirm { display: flex; justify-content: center; gap: 12px; }
        .btn-danger {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 10px 24px;
            background: #c0392b;
            color: var(--white);
            border: none;
            border-radius: var(--radius-pill);
            font-family: 'Poppins', sans-serif;
            font-size: 14px; font-weight: 600;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
        }
        .btn-danger:hover { background: #a93226; transform: translateY(-1px); }

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

        @media (max-width: 640px) {
            .modal-overlay { padding: 16px; }
            .modal-card { padding: 18px; border-radius: var(--radius-md); }
            .modal-actions { flex-direction: column-reverse; }
            .modal-actions .btn-primary, .modal-actions .btn-secondary { width: 100%; }
            .toast { left: 16px; right: 16px; bottom: 16px; text-align: center; }
        }
    </style>
</head>

<body>

    <div class="dashboard-shell">

        {{-- Sidebar: extracted to vendor/_sidebar.blade.php (shared with dashboard-vendor & manage-orders) --}}
        @include('vendor._sidebar', ['vendor' => $vendor])

        <div class="main-content">

            <header class="page-header">
                <div>
                    <div class="header-title">Kelola Produk</div>
                    <div class="header-subtitle">Atur, edit, dan cetak tag harga untuk setiap produk Anda</div>
                </div>
                <div class="header-user-chip">
                    <div class="header-avatar avatar-initial">{{ strtoupper(substr($vendor->nama_vendor, 0, 1)) }}</div>
                    <span class="header-username">{{ $vendor->nama_vendor }}</span>
                </div>
            </header>

            <div class="dashboard-body">

                <section class="panel">
                    <div class="panel-header">
                        <div>
                            <div class="panel-title">Daftar Produk</div>
                            <div class="panel-subtitle">Kelola, edit, atau hapus produk Anda</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:14px;">
                            <span class="panel-count">{{ $menus->count() }} menu</span>
                            <button type="button" id="btn-open-add-product" class="btn-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:-3px;">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Tambah Produk
                            </button>
                            <a href="{{ route('dashboard.menu.scan') }}" class="btn-primary" style="text-decoration:none;box-shadow:none;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:-3px;">
                                    <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                                    <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                                    <path d="M3 17v2a2 2 0 0 0 2 2h2"/>
                                    <path d="M17 21h2a2 2 0 0 0 2-2v-2"/>
                                    <line x1="7" y1="11" x2="7" y2="14"/>
                                    <line x1="11" y1="9" x2="11" y2="14"/>
                                    <line x1="15" y1="7" x2="15" y2="14"/>
                                </svg>
                                Scan Tag Harga
                            </a>
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
                                        <th style="text-align:right;min-width:200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td class="cell-thumb">
                                                @php
                                                    $defaultThumb = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='128' height='128'%3E%3Crect width='128' height='128' fill='%23FBF5E8'/%3E%3C/svg%3E";
                                                    $thumbSrc = $menu->path_gambar
                                                        ? (\Illuminate\Support\Str::startsWith($menu->path_gambar, ['http://', 'https://', '/'])
                                                            ? $menu->path_gambar
                                                            : asset('storage/' . $menu->path_gambar))
                                                        : $defaultThumb;
                                                @endphp
                                                <img class="menu-thumb"
                                                    src="{{ $thumbSrc }}"
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
                                                <button type="button" class="btn-edit" data-edit-menu="{{ $menu->id }}"
                                                    data-nama="{{ $menu->nama_menu }}"
                                                    data-harga="{{ $menu->harga }}"
                                                    data-deskripsi="{{ $menu->deskripsi ?? '' }}"
                                                    data-kategori="{{ $menu->kategori_menu_id ?? '' }}"
                                                    data-available="{{ $menu->is_available ? '1' : '0' }}"
                                                    data-gambar="{{ $menu->path_gambar }}">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                    </svg>
                                                    Edit
                                                </button>
                                                <button type="button" class="btn-delete" data-delete-menu="{{ $menu->id }}" data-nama="{{ $menu->nama_menu }}">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"/>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                    </svg>
                                                    Hapus
                                                </button>
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

    {{-- ─── Add Product Modal ─── --}}
    <div class="modal-overlay" id="modal-add-product" role="dialog" aria-modal="true" aria-labelledby="modal-add-product-title" hidden>
        <div class="modal-card" role="document">
            <div class="modal-head">
                <div class="modal-title" id="modal-add-product-title">Tambah Produk</div>
                <button type="button" class="modal-close" data-modal-close aria-label="Tutup">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="form-add-product" enctype="multipart/form-data" novalidate data-field-prefix="">
                @csrf
                <div class="form-grid">
                    <div class="form-row" data-field="nama_menu">
                        <label class="form-label" for="add-nama-menu">Nama Menu<span class="form-required">*</span></label>
                        <input class="form-input" type="text" id="add-nama-menu" name="nama_menu" maxlength="255" required>
                        <div class="form-error" data-error-for="nama_menu"></div>
                    </div>

                    <div class="form-row" data-field="kategori_menu_id">
                        <label class="form-label" for="add-kategori">Kategori</label>
                        <select class="form-select" id="add-kategori" name="kategori_menu_id">
                            @if ($kategoriMenus->isEmpty())
                                <option value="">Tidak ada kategori</option>
                            @else
                                <option value="">— Tanpa kategori —</option>
                                @foreach ($kategoriMenus as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="form-error" data-error-for="kategori_menu_id"></div>
                    </div>

                    <div class="form-row" data-field="harga">
                        <label class="form-label" for="add-harga">Harga (Rp)<span class="form-required">*</span></label>
                        <input class="form-input" type="number" id="add-harga" name="harga" min="0" step="1" required>
                        <div class="form-error" data-error-for="harga"></div>
                    </div>

                    <div class="form-row" data-field="deskripsi">
                        <label class="form-label" for="add-deskripsi">Deskripsi</label>
                        <textarea class="form-textarea" id="add-deskripsi" name="deskripsi" maxlength="1000" rows="3" placeholder="Opsional, maks. 1000 karakter"></textarea>
                        <div class="form-error" data-error-for="deskripsi"></div>
                    </div>

                    <div class="form-row" data-field="path_gambar">
                        <label class="form-label" for="add-gambar">Gambar produk</label>
                        <input class="form-file" type="file" id="add-gambar" name="path_gambar" accept="image/*">
                        <div class="form-hint">Format gambar, maks. 2 MB.</div>
                        <div class="form-error" data-error-for="path_gambar"></div>
                    </div>

                    <div class="form-row is-inline" data-field="is_available">
                        <label class="form-checkbox">
                            <input type="checkbox" id="add-available" name="is_available" value="1" checked>
                            <span class="form-label" style="margin:0;">Tersedia untuk dijual</span>
                        </label>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" data-modal-close>Batal</button>
                    <button type="submit" class="btn-primary" id="btn-submit-add-product">
                        <span class="btn-label">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── Edit Product Modal ─── --}}
    <div class="modal-overlay" id="modal-edit-product" role="dialog" aria-modal="true" aria-labelledby="modal-edit-product-title" hidden>
        <div class="modal-card" role="document">
            <div class="modal-head">
                <div class="modal-title" id="modal-edit-product-title">Edit Produk</div>
                <button type="button" class="modal-close" data-modal-close-edit aria-label="Tutup">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="form-edit-product" enctype="multipart/form-data" novalidate data-field-prefix="edit-">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-menu-id" name="menu_id" value="">
                <div class="form-grid">
                    <div class="form-row" data-field="edit-nama_menu">
                        <label class="form-label" for="edit-nama-menu">Nama Menu<span class="form-required">*</span></label>
                        <input class="form-input" type="text" id="edit-nama-menu" name="nama_menu" maxlength="255" required>
                        <div class="form-error" data-error-for="edit-nama_menu"></div>
                    </div>

                    <div class="form-row" data-field="edit-kategori_menu_id">
                        <label class="form-label" for="edit-kategori">Kategori</label>
                        <select class="form-select" id="edit-kategori" name="kategori_menu_id">
                            @if ($kategoriMenus->isEmpty())
                                <option value="">Tidak ada kategori</option>
                            @else
                                <option value="">— Tanpa kategori —</option>
                                @foreach ($kategoriMenus as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="form-error" data-error-for="edit-kategori_menu_id"></div>
                    </div>

                    <div class="form-row" data-field="edit-harga">
                        <label class="form-label" for="edit-harga">Harga (Rp)<span class="form-required">*</span></label>
                        <input class="form-input" type="number" id="edit-harga" name="harga" min="0" step="1" required>
                        <div class="form-error" data-error-for="edit-harga"></div>
                    </div>

                    <div class="form-row" data-field="edit-deskripsi">
                        <label class="form-label" for="edit-deskripsi">Deskripsi</label>
                        <textarea class="form-textarea" id="edit-deskripsi" name="deskripsi" maxlength="1000" rows="3" placeholder="Opsional, maks. 1000 karakter"></textarea>
                        <div class="form-error" data-error-for="edit-deskripsi"></div>
                    </div>

                    <div class="form-row" data-field="edit-path_gambar">
                        <label class="form-label" for="edit-gambar">Gambar produk</label>
                        <input class="form-file" type="file" id="edit-gambar" name="path_gambar" accept="image/*">
                        <div class="form-hint">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                        <div class="form-error" data-error-for="edit-path_gambar"></div>
                    </div>

                    <div class="form-row is-inline" data-field="edit-is_available">
                        <label class="form-checkbox">
                            <input type="checkbox" id="edit-available" name="is_available" value="1" checked>
                            <span class="form-label" style="margin:0;">Tersedia untuk dijual</span>
                        </label>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" data-modal-close-edit>Batal</button>
                    <button type="submit" class="btn-primary" id="btn-submit-edit-product">
                        <span class="btn-label">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── Delete Confirmation Modal ─── --}}
    <div class="modal-overlay" id="modal-delete-product" role="dialog" aria-modal="true" aria-labelledby="modal-delete-product-title" hidden>
        <div class="modal-card" role="document" style="max-width:400px;">
            <div class="modal-head">
                <div class="modal-title" id="modal-delete-product-title">Hapus Produk</div>
                <button type="button" class="modal-close" data-modal-close-delete aria-label="Tutup">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <input type="hidden" id="delete-menu-id" value="">
            <div class="modal-confirm-text">
                Yakin ingin menghapus <span class="modal-confirm-name" id="delete-menu-name"></span>?
                <br>Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-actions-confirm">
                <button type="button" class="btn-secondary" data-modal-close-delete>Batal</button>
                <button type="button" class="btn-danger" id="btn-confirm-delete">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast-notify" role="status" aria-live="polite"></div>

    <script>
        (function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const MAX_IMAGE_BYTES = 2 * 1024 * 1024;
            const storeUrl = @json(route('dashboard.menu.store'));
            let toastTimer = null;

            const toast = document.getElementById('toast-notify');

            function showToast(message, type) {
                toast.textContent = message;
                toast.classList.toggle('is-error', type === 'error');
                toast.classList.add('is-visible');
                if (toastTimer) clearTimeout(toastTimer);
                toastTimer = setTimeout(() => toast.classList.remove('is-visible'), 2200);
            }

            function clearErrors(container) {
                container.querySelectorAll('.form-row').forEach(row => row.classList.remove('has-error'));
                container.querySelectorAll('.form-error').forEach(el => {
                    el.textContent = '';
                    el.classList.remove('is-visible');
                });
            }

            function setFieldError(container, field, message) {
                const row = container.querySelector(`.form-row[data-field="${field}"]`);
                const errEl = container.querySelector(`.form-error[data-error-for="${field}"]`);
                if (row) row.classList.add('has-error');
                if (errEl) {
                    errEl.textContent = message;
                    errEl.classList.add('is-visible');
                }
            }

            function setupModal(modalId, openBtnId, closeAttr) {
                const modal = document.getElementById(modalId);
                const openBtn = document.getElementById(openBtnId);
                if (!modal) return { modal: null, open: () => {} };

                function open() {
                    modal.hidden = false;
                    requestAnimationFrame(() => modal.classList.add('is-open'));
                }

                function close() {
                    modal.classList.remove('is-open');
                    setTimeout(() => { modal.hidden = true; }, 250);
                }

                openBtn?.addEventListener('click', open);
                modal.addEventListener('click', (e) => { if (e.target === modal) close(); });
                modal.querySelectorAll(`[data-modal-close]`).forEach(btn => btn.addEventListener('click', close));
                modal.querySelectorAll(`[${closeAttr}]`).forEach(btn => btn.addEventListener('click', close));
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && modal.classList.contains('is-open')) close();
                });

                return { modal, open, close };
            }

            function validateForm(form) {
                clearErrors(form);
                let ok = true;

                const nama = form.nama_menu?.value?.trim();
                if (!nama) { setFieldError(form, form.dataset.fieldPrefix + 'nama_menu', 'Nama menu wajib diisi.'); ok = false; }

                const hargaRaw = form.harga?.value;
                const hargaNum = Number(hargaRaw);
                if (hargaRaw === '' || Number.isNaN(hargaNum) || hargaNum < 0) {
                    setFieldError(form, form.dataset.fieldPrefix + 'harga', 'Harga harus berupa angka ≥ 0.');
                    ok = false;
                }

                const file = form.path_gambar?.files?.[0];
                if (file) {
                    if (!file.type.startsWith('image/')) {
                        setFieldError(form, form.dataset.fieldPrefix + 'path_gambar', 'File harus berupa gambar.');
                        ok = false;
                    } else if (file.size > MAX_IMAGE_BYTES) {
                        setFieldError(form, form.dataset.fieldPrefix + 'path_gambar', 'Ukuran gambar maksimal 2 MB.');
                        ok = false;
                    }
                }

                return ok;
            }

            function setSubmitting(btn, label, isSubmitting, text) {
                btn.disabled = isSubmitting;
                if (isSubmitting) {
                    label.innerHTML = '<span class="btn-spinner"></span>Menyimpan…';
                } else {
                    label.textContent = text;
                }
            }

            /* ── Add Product ── */
            const addModal = document.getElementById('modal-add-product');
            const addForm = document.getElementById('form-add-product');
            const addSubmitBtn = document.getElementById('btn-submit-add-product');
            const addSubmitLabel = addSubmitBtn?.querySelector('.btn-label');

            const addControls = setupModal('modal-add-product', 'btn-open-add-product', 'data-modal-close');

            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (!validateForm(addForm)) return;

                setSubmitting(addSubmitBtn, addSubmitLabel, true, 'Simpan');
                try {
                    const formData = new FormData(addForm);
                    if (!addForm.is_available.checked) formData.set('is_available', '0');

                    const res = await fetch(storeUrl, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                    });

                    if (res.ok) {
                        const data = await res.json().catch(() => ({}));
                        showToast(data.message || 'Menu berhasil ditambahkan.');
                        setTimeout(() => window.location.reload(), 700);
                        return;
                    }

                    if (res.status === 422) {
                        const payload = await res.json().catch(() => ({}));
                        const errors = payload.errors || {};
                        Object.keys(errors).forEach(field => {
                            const msgs = errors[field];
                            setFieldError(addForm, field, Array.isArray(msgs) ? msgs[0] : String(msgs));
                        });
                        showToast(payload.message || 'Periksa kembali isian Anda.', 'error');
                    } else {
                        showToast('Gagal menyimpan menu. Coba lagi.', 'error');
                    }
                } catch (err) {
                    showToast('Terjadi kesalahan jaringan.', 'error');
                } finally {
                    setSubmitting(addSubmitBtn, addSubmitLabel, false, 'Simpan');
                }
            });

            /* ── Edit Product ── */
            const editModal = document.getElementById('modal-edit-product');
            const editForm = document.getElementById('form-edit-product');
            const editSubmitBtn = document.getElementById('btn-submit-edit-product');
            const editSubmitLabel = editSubmitBtn?.querySelector('.btn-label');

            const editControls = setupModal('modal-edit-product', null, 'data-modal-close-edit');

            document.querySelectorAll('[data-edit-menu]').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.editMenu;
                    document.getElementById('edit-menu-id').value = id;
                    document.getElementById('edit-nama-menu').value = this.dataset.nama;
                    document.getElementById('edit-harga').value = this.dataset.harga;
                    document.getElementById('edit-deskripsi').value = this.dataset.deskripsi;
                    document.getElementById('edit-kategori').value = this.dataset.kategori;
                    document.getElementById('edit-available').checked = this.dataset.available === '1';

                    clearErrors(editForm);
                    editControls.open();
                    setTimeout(() => document.getElementById('edit-nama-menu')?.focus(), 120);
                });
            });

            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (!validateForm(editForm)) return;

                setSubmitting(editSubmitBtn, editSubmitLabel, true, 'Simpan Perubahan');
                try {
                    const menuId = document.getElementById('edit-menu-id').value;
                    const formData = new FormData(editForm);
                    formData.set('_method', 'PUT');
                    if (!editForm.is_available.checked) formData.set('is_available', '0');

                    const res = await fetch(`/dashboard/menu/${menuId}`, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                    });

                    if (res.ok) {
                        const data = await res.json().catch(() => ({}));
                        showToast(data.message || 'Menu berhasil diperbarui.');
                        setTimeout(() => window.location.reload(), 700);
                        return;
                    }

                    if (res.status === 422) {
                        const payload = await res.json().catch(() => ({}));
                        const errors = payload.errors || {};
                        Object.keys(errors).forEach(field => {
                            const msgs = errors[field];
                            setFieldError(editForm, field, Array.isArray(msgs) ? msgs[0] : String(msgs));
                        });
                        showToast(payload.message || 'Periksa kembali isian Anda.', 'error');
                    } else if (res.status === 403) {
                        showToast('Anda tidak memiliki akses ke menu ini.', 'error');
                    } else {
                        showToast('Gagal memperbarui menu. Coba lagi.', 'error');
                    }
                } catch (err) {
                    showToast('Terjadi kesalahan jaringan.', 'error');
                } finally {
                    setSubmitting(editSubmitBtn, editSubmitLabel, false, 'Simpan Perubahan');
                }
            });

            /* ── Delete Product ── */
            const deleteModal = document.getElementById('modal-delete-product');
            const deleteControls = setupModal('modal-delete-product', null, 'data-modal-close-delete');

            document.querySelectorAll('[data-delete-menu]').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.getElementById('delete-menu-id').value = this.dataset.deleteMenu;
                    document.getElementById('delete-menu-name').textContent = this.dataset.nama;
                    deleteControls.open();
                });
            });

            document.getElementById('btn-confirm-delete')?.addEventListener('click', async function () {
                const menuId = document.getElementById('delete-menu-id').value;
                if (!menuId) return;

                this.disabled = true;
                this.textContent = 'Menghapus…';

                try {
                    const res = await fetch(`/dashboard/menu/${menuId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: new URLSearchParams({ _method: 'DELETE' }),
                        credentials: 'same-origin',
                    });

                    if (res.ok) {
                        const data = await res.json().catch(() => ({}));
                        showToast(data.message || 'Menu berhasil dihapus.');
                        setTimeout(() => window.location.reload(), 700);
                    } else {
                        showToast('Gagal menghapus menu. Coba lagi.', 'error');
                        this.disabled = false;
                        this.textContent = 'Ya, Hapus';
                    }
                } catch (err) {
                    showToast('Terjadi kesalahan jaringan.', 'error');
                    this.disabled = false;
                    this.textContent = 'Ya, Hapus';
                }
            });
        })();
    </script>

</body>

</html>
