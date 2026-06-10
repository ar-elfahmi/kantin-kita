<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <title>@yield('title', 'Admin') | Kantin Kita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cream: #FBF5E8;
            --brown: #744622;
            --brown-70: rgba(116, 70, 34, 0.70);
            --brown-10: rgba(116, 70, 34, 0.10);
            --sage: #42766A;
            --sage-dark: #325c52;
            --white: #FFFFFF;
            --danger: #c1432f;
        }
        html, body { height: 100%; font-family: 'Poppins', sans-serif; background: var(--cream); color: var(--brown); }
        a { color: var(--sage); }
        .admin-shell { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; }
        .admin-sidebar { background: var(--sage-dark); color: #fff; padding: 24px 16px; display: flex; flex-direction: column; gap: 8px; }
        .admin-brand { font-weight: 800; font-size: 1.2rem; padding: 8px 12px 20px; border-bottom: 1px solid rgba(255,255,255,.15); margin-bottom: 12px; }
        .admin-nav a { color: rgba(255,255,255,.85); text-decoration: none; display: block; padding: 10px 14px; border-radius: 10px; font-weight: 500; margin-bottom: 4px; }
        .admin-nav a:hover { background: rgba(255,255,255,.08); }
        .admin-nav a.active { background: rgba(255,255,255,.16); color: #fff; }
        .admin-logout { margin-top: auto; }
        .admin-logout button { width: 100%; background: transparent; border: 1px solid rgba(255,255,255,.3); color: #fff; padding: 10px 14px; border-radius: 10px; cursor: pointer; font: inherit; }
        .admin-main { padding: 32px 40px; overflow-x: auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 24px; }
        .admin-header h1 { font-size: 1.6rem; font-weight: 700; }
        .admin-header .meta { color: var(--brown-70); font-size: .9rem; }
        .flash-success { background: #e8f4ec; color: var(--sage-dark); padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; border: 1px solid var(--sage); }
        .card { background: var(--white); border-radius: 16px; padding: 20px; box-shadow: 0 1px 3px var(--brown-10); }
        .grid { display: grid; gap: 16px; }
        .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .kpi { padding: 18px; }
        .kpi .label { font-size: .85rem; color: var(--brown-70); margin-bottom: 4px; }
        .kpi .value { font-size: 1.7rem; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; background: var(--white); border-radius: 14px; overflow: hidden; }
        thead { background: var(--brown-10); }
        th, td { padding: 12px 14px; text-align: left; font-size: .92rem; border-bottom: 1px solid var(--brown-10); }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: .75rem; font-weight: 600; }
        .badge-success { background: #e8f4ec; color: var(--sage-dark); }
        .badge-warning { background: #fdf3e1; color: #946307; }
        .badge-danger { background: #f9e3df; color: var(--danger); }
        .badge-info { background: #e6eef5; color: #1f4f7a; }
        .badge-muted { background: var(--brown-10); color: var(--brown-70); }
        .form-row { margin-bottom: 16px; }
        .form-row label { display: block; font-weight: 500; margin-bottom: 6px; }
        .form-row input, .form-row select, .form-row textarea { width: 100%; padding: 10px 12px; border: 1px solid var(--brown-10); border-radius: 10px; font: inherit; background: #fff; }
        .form-row textarea { min-height: 120px; }
        .form-row .error { color: var(--danger); font-size: .85rem; margin-top: 4px; }
        .btn { display: inline-block; padding: 10px 16px; border-radius: 12px; border: none; font: inherit; cursor: pointer; text-decoration: none; font-weight: 600; }
        .btn-primary { background: var(--sage); color: #fff; }
        .btn-secondary { background: var(--brown-10); color: var(--brown); }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-sm { padding: 6px 10px; font-size: .85rem; }
        .filter-form { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; margin-bottom: 18px; background: var(--white); padding: 16px; border-radius: 14px; }
        .filter-form > div { min-width: 160px; flex: 1; }
        .filter-form label { font-size: .8rem; color: var(--brown-70); display: block; margin-bottom: 4px; font-weight: 500; }
        .filter-form input, .filter-form select { width: 100%; padding: 10px 12px; border: 1px solid var(--brown-10); border-radius: 10px; font: inherit; background: #fff; color: var(--brown); font-size: .9rem; }
        .filter-form input:focus, .filter-form select:focus { outline: none; border-color: var(--sage); box-shadow: 0 0 0 3px rgba(66, 118, 106, 0.15); }
        .filter-form .btn { align-self: flex-end; }
        .actions { display: flex; gap: 6px; flex-wrap: wrap; }
        .pagination-wrapper { margin-top: 16px; }
        @media (max-width: 900px) {
            .admin-shell { grid-template-columns: 1fr; }
            .admin-sidebar { flex-direction: row; flex-wrap: wrap; }
            .grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">Kantin Kita · Admin</div>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Kelola User</a>
                <a href="{{ route('admin.vendor-users.index') }}" class="{{ request()->routeIs('admin.vendor-users.*') ? 'active' : '' }}">Kelola Vendor</a>
                <a href="{{ route('admin.artikel.index') }}" class="{{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">Kelola Artikel</a>
                <a href="{{ route('admin.transaksi.index') }}" class="{{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">Pantau Transaksi</a>
            </nav>
            <form class="admin-logout" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </aside>
        <main class="admin-main">
            <div class="admin-header">
                <h1>@yield('title')</h1>
                <div class="meta">{{ auth()->user()->name }} · {{ now()->format('d M Y') }}</div>
            </div>
            @if (session('status'))
                <div class="flash-success">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>

</html>
