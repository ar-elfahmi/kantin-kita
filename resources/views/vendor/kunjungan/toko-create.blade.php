<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Toko | Kunjungan Toko | Kantin Kita</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
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


        .main-content { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .page-header { background: var(--white); border-bottom: 1px solid var(--brown-10); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .header-title { font-size: 24px; font-weight: 700; }
        .header-subtitle { font-size: 14px; color: var(--brown-60); }
        .header-back { font-size: 14px; color: var(--brown-60); text-decoration: none; }
        .dashboard-body { padding: 32px; display: flex; flex-direction: column; gap: 24px; max-width: 760px; }

        .panel { background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--brown-10); box-shadow: var(--shadow-sm); }
        .panel-header { padding: 20px 24px; border-bottom: 1px solid var(--brown-10); }
        .panel-title { font-size: 18px; font-weight: 700; }
        .panel-subtitle { font-size: 13px; color: var(--brown-60); margin-top: 4px; }
        .panel-body { padding: 24px; }

        .form-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
        .form-label { font-size: 13px; font-weight: 600; color: var(--brown-70); }
        .form-input { padding: 10px 12px; border: 1px solid var(--brown-10); border-radius: 10px; font-family: inherit; font-size: 14px; background: #fff; color: var(--brown); }
        .form-input:focus { outline: none; border-color: var(--green); box-shadow: 0 0 0 3px var(--green-10); }

        .geo-block { padding: 16px; border: 1px dashed var(--brown-20); border-radius: 12px; background: var(--cream); }
        .geo-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
        .geo-status { font-size: 13px; color: var(--brown-70); }
        .geo-status.captured { color: var(--green); font-weight: 600; }
        .geo-coords { font-family: 'Menlo', 'Consolas', monospace; font-size: 13px; color: var(--brown); margin-top: 10px; }
        .geo-accuracy { display: inline-block; padding: 2px 10px; border-radius: var(--radius-pill); background: var(--green-10); color: var(--green); font-size: 11px; font-weight: 700; }
        .geo-accuracy.poor { background: rgba(217, 119, 6, .15); color: #D97706; }
        .geo-accuracy.bad  { background: var(--red-10); color: var(--red); }
        .geo-help { font-size: 12px; color: var(--brown-60); margin-top: 8px; }

        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; transition: background var(--transition), transform var(--transition); font-family: inherit; }
        .btn-primary { background: var(--green); color: #fff; }
        .btn-primary:hover:not(:disabled) { background: #355f55; transform: translateY(-1px); }
        .btn-primary:disabled { opacity: .5; cursor: not-allowed; }
        .btn-outline { background: #fff; color: var(--brown); border-color: var(--brown-10); }
        .btn-outline:hover { background: var(--cream); }

        .form-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 20px 24px; border-top: 1px solid var(--brown-10); }
        .alert-error { background: var(--red-10); color: var(--red); border: 1px solid rgba(220, 38, 38, .2); border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
        .alert-error ul { margin: 4px 0 0 18px; }

        @media (max-width: 900px) {
            .dashboard-body { padding: 20px; }
            .page-header { padding: 16px 20px; }
        }
    </style>
</head>

<body>

<div class="dashboard-shell">

    @include('vendor._sidebar', ['vendor' => $vendor])

    <div class="main-content">

        <header class="page-header">
            <div>
                <div class="header-title">Tambah Toko</div>
                <div class="header-subtitle">Catat lokasi toko dengan akurasi geolocation terbaik</div>
            </div>
            <a href="{{ route('dashboard.kunjungan.index') }}" class="header-back">&larr; Kembali</a>
        </header>

        <div class="dashboard-body">

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-title">Data Toko Baru</div>
                    <div class="panel-subtitle">Sebaiknya dilakukan saat Anda berada di lokasi toko tersebut</div>
                </div>

                <form method="POST" action="{{ route('dashboard.kunjungan.toko.store') }}" id="tokoForm">
                    @csrf

                    <div class="panel-body">

                        @if ($errors->any())
                            <div class="alert-error">
                                <strong>Form belum valid:</strong>
                                <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <div class="form-field">
                            <label class="form-label" for="nama_toko">Nama Toko</label>
                            <input type="text" id="nama_toko" name="nama_toko" class="form-input" required maxlength="50" value="{{ old('nama_toko') }}" placeholder="Contoh: Toko Sumber Rejeki">
                        </div>

                        <div class="form-field">
                            <label class="form-label">Lokasi Toko (GPS)</label>
                            <div class="geo-block">
                                <div class="geo-row">
                                    <div class="geo-status" id="geoStatus">Belum diambil &mdash; klik tombol di samping untuk memulai.</div>
                                    <button type="button" class="btn btn-primary" id="captureBtn">📍 Ambil Lokasi Toko</button>
                                </div>
                                <div class="geo-coords" id="geoCoords" style="display:none;"></div>
                                <div class="geo-help">
                                    Fungsi ini menggunakan <code>watchPosition</code> dengan <code>enableHighAccuracy:true</code> dan akan terus mencari posisi dengan akurasi paling baik selama max 20 detik (atau berhenti lebih cepat jika sudah mencapai akurasi ≤ 50m).
                                </div>
                            </div>
                            <input type="hidden" name="latitude" id="latInput">
                            <input type="hidden" name="longitude" id="lngInput">
                            <input type="hidden" name="accuracy" id="accInput">
                        </div>

                    </div>

                    <div class="form-footer">
                        <a href="{{ route('dashboard.kunjungan.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Simpan Toko</button>
                    </div>
                </form>
            </section>

        </div>
    </div>
</div>

<script>
    // From Modul Lampiran 1
    function getAccuratePosition(targetAccuracy = 50, maxWait = 20000, onProgress = null) {
        return new Promise((resolve, reject) => {
            let bestResult = null;
            const startTime = Date.now();

            const watchId = navigator.geolocation.watchPosition(
                (position) => {
                    const acc = position.coords.accuracy;
                    if (!bestResult || acc < bestResult.coords.accuracy) {
                        bestResult = position;
                        if (typeof onProgress === 'function') {
                            onProgress(position, Date.now() - startTime);
                        }
                    }
                    if (acc <= targetAccuracy) {
                        navigator.geolocation.clearWatch(watchId);
                        resolve(bestResult);
                    }
                },
                (error) => {
                    navigator.geolocation.clearWatch(watchId);
                    reject(error);
                },
                { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait }
            );

            // Hard timeout fallback: stop watching after maxWait and resolve with whatever we have
            setTimeout(() => {
                navigator.geolocation.clearWatch(watchId);
                if (bestResult) resolve(bestResult);
                else reject(new Error('Timeout: belum dapat posisi dalam ' + maxWait + 'ms'));
            }, maxWait + 200);
        });
    }

    (function() {
        const btn = document.getElementById('captureBtn');
        const status = document.getElementById('geoStatus');
        const coords = document.getElementById('geoCoords');
        const submitBtn = document.getElementById('submitBtn');
        const latIn = document.getElementById('latInput');
        const lngIn = document.getElementById('lngInput');
        const accIn = document.getElementById('accInput');

        function accuracyClass(acc) {
            if (acc <= 30) return '';
            if (acc <= 100) return 'poor';
            return 'bad';
        }

        function render(position, isFinal) {
            const { latitude, longitude, accuracy } = position.coords;
            latIn.value = latitude;
            lngIn.value = longitude;
            accIn.value = accuracy;
            coords.style.display = 'block';
            coords.innerHTML =
                '<strong>Lat:</strong> ' + latitude.toFixed(6) + ' &nbsp; ' +
                '<strong>Lng:</strong> ' + longitude.toFixed(6) + ' &nbsp; ' +
                '<span class="geo-accuracy ' + accuracyClass(accuracy) + '">±' + accuracy.toFixed(1) + ' m</span>';
            if (isFinal) {
                status.textContent = 'Lokasi siap disimpan';
                status.classList.add('captured');
                submitBtn.disabled = false;
                btn.textContent = '🔄 Ambil Ulang';
            } else {
                status.textContent = 'Mencari akurasi terbaik… (akurasi sementara ±' + accuracy.toFixed(1) + ' m)';
            }
        }

        btn.addEventListener('click', async function() {
            if (!('geolocation' in navigator)) {
                status.textContent = 'Browser tidak mendukung Geolocation API.';
                return;
            }
            status.textContent = 'Meminta izin lokasi…';
            submitBtn.disabled = true;
            btn.disabled = true;
            try {
                const pos = await getAccuratePosition(50, 20000, (p) => render(p, false));
                render(pos, true);
            } catch (err) {
                status.textContent = 'Gagal mendapatkan lokasi: ' + (err.message || err);
            } finally {
                btn.disabled = false;
            }
        });
    })();
</script>

</body>
</html>
