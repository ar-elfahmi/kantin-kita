<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Customer – Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --white: #fff;
            --shadow-sm: 0 1px 3px rgba(116, 70, 34, .08);
            --radius-sm: 12px;
            --radius-md: 16px;
            --radius-pill: 9999px;
            --transition: .25s cubic-bezier(.4, 0, .2, 1);
        }
        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--cream); color: var(--brown); min-height: 100vh; }
        .dashboard-shell { display: flex; min-height: 100vh; }

        /* Sidebar (duplicated; TODO extract to partial) */
        .sidebar { width: 288px; flex-shrink: 0; background: var(--white); border-right: 1px solid var(--brown-10); display: flex; flex-direction: column; padding: 24px; gap: 48px; position: sticky; top: 0; height: 100vh; overflow-y: auto; z-index: 100; box-shadow: 2px 0 20px rgba(116, 70, 34, .04); }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-icon { width: 48px; height: 48px; background: var(--green); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(66, 118, 106, .35); }
        .logo-text-primary { font-size: 24px; font-weight: 700; color: var(--brown); letter-spacing: -.5px; }
        .logo-text-secondary { font-size: 12px; font-weight: 500; color: var(--brown-60); letter-spacing: -.5px; }
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

        /* Main */
        .main-content { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .page-header { background: var(--white); border-bottom: 1px solid var(--brown-10); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .header-title { font-size: 24px; font-weight: 700; color: var(--brown); }
        .header-subtitle { font-size: 14px; color: var(--brown-60); }
        .dashboard-body { padding: 32px; display: flex; flex-direction: column; gap: 24px; }

        .alert { border-radius: var(--radius-md); padding: 12px 16px; font-size: 14px; font-weight: 500; }
        .alert-success { background: var(--green-10); color: var(--green); border: 1px solid var(--green-20); }

        .panel { background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--brown-10); box-shadow: var(--shadow-sm); overflow: hidden; }
        .panel-header { padding: 20px 24px; border-bottom: 1px solid var(--brown-10); display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .panel-title { font-size: 18px; font-weight: 700; color: var(--brown); }
        .panel-subtitle { font-size: 13px; color: var(--brown-60); margin-top: 4px; }

        .btn-group { display: flex; gap: 10px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; transition: background var(--transition), transform var(--transition); }
        .btn-primary { background: var(--green); color: #fff; }
        .btn-primary:hover { background: #355f55; transform: translateY(-1px); }
        .btn-outline { background: #fff; color: var(--brown); border-color: var(--brown-10); }
        .btn-outline:hover { background: var(--cream); }

        .customer-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .customer-table thead th { background: var(--cream); text-align: left; padding: 14px 18px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: var(--brown-70); border-bottom: 1px solid var(--brown-10); }
        .customer-table tbody td { padding: 14px 18px; border-bottom: 1px solid var(--brown-10); vertical-align: middle; }
        .customer-table tbody tr:last-child td { border-bottom: none; }
        .customer-table tbody tr:hover { background: var(--cream); }
        .customer-photo { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; border: 1px solid var(--brown-10); background: var(--cream); }
        .customer-name { font-weight: 600; color: var(--brown); }
        .customer-addr { font-size: 12px; color: var(--brown-60); margin-top: 2px; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .storage-badge { display: inline-block; padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase; }
        .storage-badge.blob { background: rgba(66, 118, 106, .12); color: var(--green); }
        .storage-badge.path { background: rgba(116, 70, 34, .12); color: var(--brown); }
        .storage-badge.none { background: rgba(220, 38, 38, .1); color: #B91C1C; }

        .empty-state { padding: 56px 24px; text-align: center; color: var(--brown-60); }
        .empty-state-title { font-size: 17px; font-weight: 700; color: var(--brown); margin-bottom: 6px; }
        .empty-state-desc { font-size: 14px; }

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

    @include('vendor.customer._sidebar', ['active' => 'customer', 'vendor' => $vendor])

    <div class="main-content">

        <header class="page-header">
            <div>
                <div class="header-title">Data Customer</div>
                <div class="header-subtitle">Daftar pelanggan terdaftar untuk {{ $vendor->nama_vendor }}</div>
            </div>
        </header>

        <div class="dashboard-body">

            @if (session('customerSuccess'))
                <div class="alert alert-success">{{ session('customerSuccess') }}</div>
            @endif

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">Daftar Customer</div>
                        <div class="panel-subtitle">{{ $customers->count() }} customer terdaftar</div>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('dashboard.customer.create-blob') }}" class="btn btn-outline">+ Tambah Customer 1 (BLOB)</a>
                        <a href="{{ route('dashboard.customer.create-path') }}" class="btn btn-primary">+ Tambah Customer 2 (Path)</a>
                    </div>
                </div>

                @if ($customers->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-title">Belum ada customer</div>
                        <div class="empty-state-desc">Tambahkan customer pertama Anda via tombol di kanan atas.</div>
                    </div>
                @else
                    <table class="customer-table">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama &amp; Alamat</th>
                                <th>Kota</th>
                                <th>Kecamatan</th>
                                <th>Kodepos</th>
                                <th>Penyimpanan</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>
                                        @if ($customer->foto_path)
                                            <img class="customer-photo" src="{{ asset('storage/' . $customer->foto_path) }}" alt="Foto {{ $customer->nama }}">
                                        @elseif ($customer->hasBlobPhoto())
                                            <img class="customer-photo" src="{{ route('dashboard.customer.photo', $customer) }}" alt="Foto {{ $customer->nama }}">
                                        @else
                                            <div class="customer-photo" aria-label="Tidak ada foto"></div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="customer-name">{{ $customer->nama }}</div>
                                        <div class="customer-addr">{{ $customer->alamat }}, {{ $customer->kelurahan }}</div>
                                    </td>
                                    <td>{{ $customer->kota }}</td>
                                    <td>{{ $customer->kecamatan }}</td>
                                    <td>{{ $customer->kodepos }}</td>
                                    <td>
                                        @if ($customer->foto_path)
                                            <span class="storage-badge path">File Path</span>
                                        @elseif ($customer->hasBlobPhoto())
                                            <span class="storage-badge blob">BLOB</span>
                                        @else
                                            <span class="storage-badge none">None</span>
                                        @endif
                                    </td>
                                    <td>{{ $customer->created_at?->diffForHumans() }}</td>
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
