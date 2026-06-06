<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan &amp; Kunjungi Toko – Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <style>
        :root {
            --cream: #FBF5E8; --brown: #744622;
            --brown-60: rgba(116, 70, 34, .6); --brown-70: rgba(116, 70, 34, .7);
            --brown-10: rgba(116, 70, 34, .1); --brown-20: rgba(116, 70, 34, .2);
            --green: #42766A; --green-10: rgba(66, 118, 106, .1); --green-20: rgba(66, 118, 106, .2);
            --red: #B91C1C; --red-10: rgba(220, 38, 38, .1);
            --yellow-bg: #FEF3C7; --yellow-fg: #D97706;
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
        .header-back { font-size: 14px; color: var(--brown-60); text-decoration: none; }
        .dashboard-body { padding: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; max-width: 1080px; }
        @media (max-width: 900px) { .dashboard-body { grid-template-columns: 1fr; } }

        .panel { background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--brown-10); box-shadow: var(--shadow-sm); }
        .panel-header { padding: 18px 22px; border-bottom: 1px solid var(--brown-10); }
        .panel-title { font-size: 16px; font-weight: 700; }
        .panel-subtitle { font-size: 12px; color: var(--brown-60); margin-top: 4px; }
        .panel-body { padding: 22px; }

        .step-num { display: inline-flex; width: 22px; height: 22px; align-items: center; justify-content: center; background: var(--green); color: #fff; border-radius: 50%; font-size: 12px; font-weight: 700; margin-right: 8px; }

        #kunjunganScannerContainer { width: 100%; max-width: 360px; margin: 0 auto; }
        #kunjunganScannerContainer canvas, #kunjunganScannerContainer video { border-radius: 10px; }

        .info-card { background: var(--cream); border-radius: 10px; padding: 14px 16px; font-size: 13px; }
        .info-card strong { font-weight: 700; }
        .info-card .label { color: var(--brown-60); margin-right: 6px; }
        .info-card .value { font-family: 'Menlo', 'Consolas', monospace; }
        .sales-badge { display: flex; align-items: center; gap: 10px; background: var(--green-10); border-radius: 10px; padding: 10px 14px; font-size: 13px; margin-bottom: 14px; }
        .sales-badge .sales-icon { width: 32px; height: 32px; border-radius: 50%; background: var(--green); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; }
        .sales-badge .sales-name { font-weight: 600; color: var(--brown); }
        .sales-badge .sales-detail { font-size: 11px; color: var(--brown-60); }

        .status-msg { font-size: 13px; color: var(--brown-70); margin: 10px 0; }
        .status-msg.captured { color: var(--green); font-weight: 600; }
        .status-msg.error { color: var(--red); }

        .geo-accuracy { display: inline-block; padding: 2px 10px; border-radius: var(--radius-pill); background: var(--green-10); color: var(--green); font-size: 11px; font-weight: 700; margin-left: 6px; }
        .geo-accuracy.poor { background: rgba(217, 119, 6, .15); color: var(--yellow-fg); }
        .geo-accuracy.bad  { background: var(--red-10); color: var(--red); }

        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; transition: background var(--transition), transform var(--transition); font-family: inherit; }
        .btn:disabled { opacity: .5; cursor: not-allowed; }
        .btn-primary { background: var(--green); color: #fff; }
        .btn-primary:hover:not(:disabled) { background: #355f55; transform: translateY(-1px); }
        .btn-outline { background: #fff; color: var(--brown); border-color: var(--brown-10); }
        .btn-outline:hover { background: var(--cream); }
        .btn-full { width: 100%; justify-content: center; }

        .result-card { padding: 24px; border-radius: 12px; }
        .result-card.accepted { background: var(--green-10); border: 1px solid var(--green-20); color: var(--green); }
        .result-card.rejected { background: var(--red-10); border: 1px solid rgba(220, 38, 38, .2); color: var(--red); }
        .result-title { font-size: 20px; font-weight: 700; margin-bottom: 6px; }
        .result-message { font-size: 14px; }
        .result-detail { margin-top: 14px; font-size: 13px; display: grid; grid-template-columns: auto 1fr; gap: 4px 14px; }
        .result-detail dt { color: var(--brown-60); }

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
                <div class="header-title">Scan &amp; Kunjungi Toko <span style="font-size:10px;color:var(--brown-60);">v2</span></div>
                <div class="header-subtitle">Threshold default {{ $threshold }}m + akurasi toko + akurasi sales</div>
            </div>
            <a href="{{ route('dashboard.kunjungan.index') }}" class="header-back">&larr; Kembali</a>
        </header>

        <div class="dashboard-body">

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-title"><span class="step-num">1</span> Scan QR Toko</div>
                    <div class="panel-subtitle">Arahkan kamera ke QR code di lokasi toko</div>
                </div>
                <div class="panel-body">
                    <div id="kunjunganScannerContainer"></div>
                    <div class="status-msg" id="scanStatus">Klik "Mulai Scan" untuk membuka kamera.</div>
                    <button type="button" class="btn btn-outline btn-full" id="startScanBtn">📷 Mulai Scan</button>
                    <div id="tokoInfo" style="display:none;margin-top:16px;">
                        <div class="info-card">
                            <div><span class="label">Toko:</span><strong id="tokoNama"></strong></div>
                            <div style="margin-top:4px;"><span class="label">Barcode:</span><span class="value" id="tokoBarcode"></span></div>
                            <div style="margin-top:4px;"><span class="label">Posisi:</span><span class="value" id="tokoCoords"></span></div>
                            <div style="margin-top:4px;"><span class="label">Akurasi tersimpan:</span><span class="value" id="tokoAccuracy"></span></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-title"><span class="step-num">2</span> Ambil Lokasi Saya</div>
                    <div class="panel-subtitle">Dapatkan posisi GPS Anda dengan akurasi terbaik</div>
                </div>
                <div class="panel-body">
                    <div class="sales-badge">
                        <div class="sales-icon">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div class="sales-name">{{ $user->name ?? 'User' }}</div>
                            <div class="sales-detail">{{ $user->email ?? '' }}</div>
                        </div>
                    </div>
                    <div class="status-msg" id="geoStatus">Scan QR toko dulu sebelum mengambil lokasi.</div>
                    <div id="salesCoords" style="display:none;margin-bottom:12px;font-family:'Menlo','Consolas',monospace;font-size:13px;"></div>
                    <button type="button" class="btn btn-primary btn-full" id="captureBtn" disabled>📍 Ambil Lokasi Saya</button>
                </div>
                <div class="panel-header" style="border-top:1px solid var(--brown-10);border-bottom:none;">
                    <div class="panel-title"><span class="step-num">3</span> Submit Kunjungan</div>
                    <div class="panel-subtitle">Sistem akan menghitung jarak (Haversine) dan validasi threshold efektif</div>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-primary btn-full" id="submitBtn" disabled>📤 Submit Kunjungan</button>
                    <div id="resultBox" style="margin-top:18px;"></div>
                </div>
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
                        if (typeof onProgress === 'function') onProgress(position, Date.now() - startTime);
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

            setTimeout(() => {
                navigator.geolocation.clearWatch(watchId);
                if (bestResult) resolve(bestResult);
                else reject(new Error('Timeout: belum dapat posisi dalam ' + maxWait + 'ms'));
            }, maxWait + 200);
        });
    }

    function accuracyClass(acc) {
        if (acc <= 30) return '';
        if (acc <= 100) return 'poor';
        return 'bad';
    }

    (function() {
        const startBtn = document.getElementById('startScanBtn');
        const scanStatus = document.getElementById('scanStatus');
        const tokoInfo = document.getElementById('tokoInfo');
        const tokoNama = document.getElementById('tokoNama');
        const tokoBarcode = document.getElementById('tokoBarcode');
        const tokoCoords = document.getElementById('tokoCoords');
        const tokoAccuracy = document.getElementById('tokoAccuracy');
        const geoStatus = document.getElementById('geoStatus');
        const salesCoords = document.getElementById('salesCoords');
        const captureBtn = document.getElementById('captureBtn');
        const submitBtn = document.getElementById('submitBtn');
        const resultBox = document.getElementById('resultBox');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        let qrScanner = null;
        let scanning = false;
        let tokoData = null;
        let salesData = null;

        function stopScanner() {
            if (qrScanner && scanning) {
                try {
                    qrScanner.stop().then(() => { qrScanner.clear(); scanning = false; }).catch(() => {});
                } catch (e) {}
            }
        }

        async function lookupToko(barcode) {
            scanStatus.textContent = 'Mencari toko…';
            try {
                const r = await fetch('/dashboard/kunjungan/api/toko/' + encodeURIComponent(barcode));
                if (!r.ok) {
                    const body = await r.json().catch(() => ({}));
                    throw new Error(body.message || 'Toko tidak ditemukan');
                }
                return await r.json();
            } catch (err) {
                throw err;
            }
        }

        function renderToko(data) {
            tokoData = data;
            tokoInfo.style.display = 'block';
            tokoNama.textContent = data.nama_toko;
            tokoBarcode.textContent = data.barcode;
            tokoCoords.textContent = data.latitude.toFixed(6) + ', ' + data.longitude.toFixed(6);
            tokoAccuracy.innerHTML = '±' + data.accuracy.toFixed(1) + ' m';
            scanStatus.textContent = 'Toko terdeteksi. Lanjut ke step 2.';
            scanStatus.classList.add('captured');
            geoStatus.textContent = 'Klik tombol untuk mengambil GPS Anda.';
            captureBtn.disabled = false;
        }

        function renderResult(payload) {
            const accepted = payload.status === 'accepted';
            resultBox.innerHTML =
                '<div class="result-card ' + payload.status + '">' +
                    '<div class="result-title">' + (accepted ? '✓ Diterima' : '✗ Ditolak') + '</div>' +
                    '<div class="result-message">' + payload.message + '</div>' +
                    '<dl class="result-detail">' +
                        '<dt>Toko</dt><dd>' + payload.nama_toko + '</dd>' +
                        '<dt>Jarak aktual</dt><dd>' + payload.jarak_meter.toFixed(2) + ' m</dd>' +
                        '<dt>Threshold dasar</dt><dd>' + payload.threshold_meter + ' m</dd>' +
                        '<dt>Threshold efektif</dt><dd>' + payload.threshold_efektif.toFixed(2) + ' m (= ' + payload.threshold_meter + ' + ' + payload.toko_accuracy.toFixed(1) + ' + ' + payload.sales_accuracy.toFixed(1) + ')</dd>' +
                    '</dl>' +
                '</div>';
        }

        startBtn.addEventListener('click', function() {
            if (scanning) { stopScanner(); startBtn.textContent = '📷 Mulai Scan'; return; }

            // Always fresh instance
            if (qrScanner) {
                try { qrScanner.stop().then(() => qrScanner.clear()).catch(() => {}); } catch(e) {}
                qrScanner = null;
            }
            qrScanner = new Html5Qrcode('kunjunganScannerContainer');
            scanStatus.textContent = 'Membuka kamera…';
            qrScanner.start(
                { facingMode: 'environment' },
                { fps: 15, qrbox: { width: 240, height: 240 } },
                async function(decoded) {
                    stopScanner();
                    startBtn.textContent = '📷 Mulai Scan';
                    try {
                        const data = await lookupToko(decoded.trim());
                        renderToko(data);
                    } catch (err) {
                        scanStatus.textContent = err.message || 'Gagal memuat toko';
                        scanStatus.classList.add('error');
                    }
                },
                function() { /* swallow per-frame decode noise */ }
            ).then(() => {
                scanning = true;
                scanStatus.textContent = 'Arahkan kamera ke QR toko…';
                startBtn.textContent = '⏹ Stop Scan';
            }).catch((err) => {
                scanStatus.textContent = 'Kamera tidak tersedia: ' + (err.message || err);
                scanStatus.classList.add('error');
            });
        });

        captureBtn.addEventListener('click', async function() {
            if (!('geolocation' in navigator)) {
                geoStatus.textContent = 'Browser tidak mendukung Geolocation API.';
                return;
            }
            captureBtn.disabled = true;
            geoStatus.textContent = 'Meminta izin lokasi…';
            geoStatus.classList.remove('captured', 'error');
            try {
                const pos = await getAccuratePosition(50, 20000, (p) => {
                    geoStatus.textContent = 'Mencari akurasi terbaik… (±' + p.coords.accuracy.toFixed(1) + ' m)';
                });
                salesData = {
                    sales_latitude: pos.coords.latitude,
                    sales_longitude: pos.coords.longitude,
                    sales_accuracy: pos.coords.accuracy,
                };
                salesCoords.style.display = 'block';
                salesCoords.innerHTML =
                    'Lat: ' + pos.coords.latitude.toFixed(6) + ' &nbsp; ' +
                    'Lng: ' + pos.coords.longitude.toFixed(6) +
                    '<span class="geo-accuracy ' + accuracyClass(pos.coords.accuracy) + '">±' + pos.coords.accuracy.toFixed(1) + ' m</span>';
                geoStatus.textContent = 'Lokasi sales tercatat. Klik Submit untuk mengirim laporan.';
                geoStatus.classList.add('captured');
                submitBtn.disabled = false;
            } catch (err) {
                geoStatus.textContent = 'Gagal mendapatkan lokasi: ' + (err.message || err);
                geoStatus.classList.add('error');
            } finally {
                captureBtn.disabled = false;
                captureBtn.textContent = '🔄 Ambil Ulang Lokasi';
            }
        });

        submitBtn.addEventListener('click', async function() {
            if (!tokoData || !salesData) return;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim…';
            try {
                const r = await fetch('/dashboard/kunjungan/visit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        barcode: tokoData.barcode,
                        ...salesData,
                    }),
                });
                const data = await r.json();
                if (!r.ok) throw new Error(data.message || 'Gagal mengirim laporan');
                renderResult(data);
            } catch (err) {
                resultBox.innerHTML = '<div class="result-card rejected"><div class="result-title">Error</div><div class="result-message">' + (err.message || err) + '</div></div>';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = '📤 Submit Kunjungan';
            }
        });
    })();
</script>

</body>
</html>
