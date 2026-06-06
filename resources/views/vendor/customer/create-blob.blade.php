<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Customer 1 (BLOB) – Kantin Kita</title>
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
        .header-title { font-size: 24px; font-weight: 700; color: var(--brown); }
        .header-subtitle { font-size: 14px; color: var(--brown-60); }
        .header-back { font-size: 14px; color: var(--brown-60); text-decoration: none; }
        .header-back:hover { color: var(--brown); }
        .dashboard-body { padding: 32px; display: flex; flex-direction: column; gap: 24px; max-width: 900px; }

        .panel { background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--brown-10); box-shadow: var(--shadow-sm); }
        .panel-header { padding: 20px 24px; border-bottom: 1px solid var(--brown-10); }
        .panel-title { font-size: 18px; font-weight: 700; color: var(--brown); }
        .panel-subtitle { font-size: 13px; color: var(--brown-60); margin-top: 4px; }
        .panel-body { padding: 24px; }

        .info-strip { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; background: var(--green-10); border-radius: 10px; color: var(--green); font-size: 13px; margin-bottom: 20px; }
        .info-strip strong { font-weight: 700; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid .full { grid-column: 1 / -1; }
        @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }

        .form-field { display: flex; flex-direction: column; gap: 6px; }
        .form-label { font-size: 13px; font-weight: 600; color: var(--brown-70); }
        .form-input, .form-textarea { padding: 10px 12px; border: 1px solid var(--brown-10); border-radius: 10px; font-family: inherit; font-size: 14px; background: #fff; color: var(--brown); transition: border-color var(--transition); }
        .form-input:focus, .form-textarea:focus { outline: none; border-color: var(--green); box-shadow: 0 0 0 3px var(--green-10); }
        .form-textarea { resize: vertical; min-height: 80px; }
        .form-error { font-size: 12px; color: #B91C1C; }

        .photo-block { display: flex; align-items: flex-start; gap: 18px; padding: 16px; border: 1px dashed var(--brown-20); border-radius: 12px; background: var(--cream); margin-top: 8px; }
        .photo-preview { width: 140px; height: 140px; border-radius: 10px; background: #fff; border: 1px solid var(--brown-10); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; color: var(--brown-60); font-size: 12px; text-align: center; padding: 8px; }
        .photo-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .photo-meta { flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .photo-status { font-size: 13px; color: var(--brown-70); }
        .photo-status.captured { color: var(--green); font-weight: 600; }

        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; transition: background var(--transition), transform var(--transition); font-family: inherit; }
        .btn-primary { background: var(--green); color: #fff; }
        .btn-primary:hover { background: #355f55; transform: translateY(-1px); }
        .btn-primary:disabled { opacity: .5; cursor: not-allowed; transform: none; }
        .btn-outline { background: #fff; color: var(--brown); border-color: var(--brown-10); }
        .btn-outline:hover { background: var(--cream); }

        .form-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 20px 24px; border-top: 1px solid var(--brown-10); }

        .alert-error { background: rgba(220, 38, 38, .1); color: #B91C1C; border: 1px solid rgba(220, 38, 38, .2); border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
        .alert-error ul { margin: 4px 0 0 18px; }

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
                <div class="header-title">Tambah Customer 1 (BLOB)</div>
                <div class="header-subtitle">Foto akan disimpan sebagai data BLOB di database</div>
            </div>
            <a href="{{ route('dashboard.customer.index') }}" class="header-back">&larr; Kembali</a>
        </header>

        <div class="dashboard-body">

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-title">Data Customer Baru</div>
                    <div class="panel-subtitle">Isi data customer dan ambil foto via kamera</div>
                </div>
                <form method="POST" action="{{ route('dashboard.customer.store-blob') }}" id="customerForm">
                    @csrf

                    <div class="panel-body">

                        <div class="info-strip">
                            <strong>Mode:</strong>&nbsp;Foto disimpan sebagai BLOB (Binary Large Object) langsung di kolom <code>foto_blob</code> tabel <code>customers</code>.
                        </div>

                        @if ($errors->any())
                            <div class="alert-error">
                                <strong>Form belum valid:</strong>
                                <ul>
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-grid">
                            <div class="form-field full">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-input" required value="{{ old('nama') }}" maxlength="255">
                            </div>
                            <div class="form-field full">
                                <label class="form-label" for="alamat">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-textarea" required maxlength="1000">{{ old('alamat') }}</textarea>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="provinsi">Provinsi</label>
                                <input type="text" id="provinsi" name="provinsi" class="form-input" required value="{{ old('provinsi') }}" maxlength="100">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="kota">Kota</label>
                                <input type="text" id="kota" name="kota" class="form-input" required value="{{ old('kota') }}" maxlength="100">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="kecamatan">Kecamatan</label>
                                <input type="text" id="kecamatan" name="kecamatan" class="form-input" required value="{{ old('kecamatan') }}" maxlength="100">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="kelurahan">Kelurahan</label>
                                <input type="text" id="kelurahan" name="kelurahan" class="form-input" required value="{{ old('kelurahan') }}" maxlength="100">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="kodepos">Kodepos</label>
                                <input type="text" id="kodepos" name="kodepos" class="form-input" required value="{{ old('kodepos') }}" maxlength="10" inputmode="numeric">
                            </div>
                        </div>

                        <div class="form-field full" style="margin-top: 20px;">
                            <label class="form-label">Foto Customer</label>
                            <div class="photo-block">
                                <div class="photo-preview" id="photoPreview">Belum ada foto</div>
                                <div class="photo-meta">
                                    <div class="photo-status" id="photoStatus">Klik "Ambil Foto" untuk membuka kamera</div>
                                    <button type="button" class="btn btn-outline" id="openCameraBtn" style="align-self: flex-start;">Ambil Foto</button>
                                </div>
                            </div>
                            <input type="hidden" name="foto_data_url" id="fotoDataUrl" value="">
                        </div>

                    </div>

                    <div class="form-footer">
                        <a href="{{ route('dashboard.customer.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Simpan Data</button>
                    </div>
                </form>
            </section>

        </div>
    </div>
</div>

@include('vendor.customer._camera_modal')

<script>
    (function() {
        const openBtn = document.getElementById('openCameraBtn');
        const fotoInput = document.getElementById('fotoDataUrl');
        const preview = document.getElementById('photoPreview');
        const status = document.getElementById('photoStatus');
        const submitBtn = document.getElementById('submitBtn');

        openBtn.addEventListener('click', function() {
            window.openCameraModal(function(dataUrl) {
                fotoInput.value = dataUrl;
                preview.innerHTML = '<img src="' + dataUrl + '" alt="Snapshot">';
                status.textContent = 'Foto siap disimpan';
                status.classList.add('captured');
                submitBtn.disabled = false;
            });
        });
    })();
</script>

</body>
</html>
