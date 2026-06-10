<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Tag Harga | Kantin Kita</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
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


        .main-content { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .page-header { background: var(--white); border-bottom: 1px solid var(--brown-10); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .header-title { font-size: 24px; font-weight: 700; }
        .header-subtitle { font-size: 14px; color: var(--brown-60); }
        .header-back { font-size: 14px; color: var(--brown-60); text-decoration: none; }
        .header-back:hover { color: var(--brown); }
        .dashboard-body { padding: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; max-width: 1080px; }
        @media (max-width: 900px) { .dashboard-body { grid-template-columns: 1fr; } }

        .panel { background: var(--white); border-radius: var(--radius-md); border: 1px solid var(--brown-10); box-shadow: var(--shadow-sm); }
        .panel-header { padding: 18px 22px; border-bottom: 1px solid var(--brown-10); }
        .panel-title { font-size: 16px; font-weight: 700; }
        .panel-subtitle { font-size: 12px; color: var(--brown-60); margin-top: 4px; }
        .panel-body { padding: 22px; }

        #tagHargaScannerContainer { width: 100%; max-width: 360px; margin: 0 auto; }
        #tagHargaScannerContainer canvas, #tagHargaScannerContainer video { border-radius: 10px; }

        .status-msg { font-size: 13px; color: var(--brown-70); margin: 12px 0; }
        .status-msg.captured { color: var(--green); font-weight: 600; }
        .status-msg.error { color: var(--red); }

        .scan-hint { font-size: 12px; color: var(--brown-60); background: var(--cream); border-radius: 8px; padding: 8px 12px; margin: 8px 0 14px; line-height: 1.5; }

        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none; border: 1px solid transparent; cursor: pointer; transition: background var(--transition), transform var(--transition); font-family: inherit; }
        .btn:disabled { opacity: .5; cursor: not-allowed; }
        .btn-primary { background: var(--green); color: #fff; }
        .btn-primary:hover:not(:disabled) { background: #355f55; transform: translateY(-1px); }
        .btn-outline { background: #fff; color: var(--brown); border-color: var(--brown-10); }
        .btn-outline:hover { background: var(--cream); }
        .btn-full { width: 100%; justify-content: center; }

        .manual-block { display: flex; gap: 8px; margin-top: 12px; }
        .manual-block input { flex: 1; padding: 10px 14px; border: 1px solid var(--brown-10); border-radius: 10px; font-family: 'Menlo', 'Consolas', monospace; font-size: 14px; letter-spacing: .8px; text-transform: uppercase; }
        .manual-block input:focus { outline: none; border-color: var(--green); box-shadow: 0 0 0 3px var(--green-10); }
        .manual-link { background: none; border: none; color: var(--green); font-family: inherit; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: underline; padding: 8px 0 0 0; }

        .result-card { padding: 20px; border-radius: 14px; background: var(--cream); border: 1px solid var(--brown-10); }
        .result-img { width: 100%; max-width: 200px; height: 150px; object-fit: cover; border-radius: 10px; margin-bottom: 14px; display: block; }
        .result-nama { font-size: 18px; font-weight: 700; color: var(--brown); margin-bottom: 4px; }
        .result-vendor { font-size: 12px; color: var(--brown-60); margin-bottom: 14px; }
        .result-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px dashed var(--brown-10); font-size: 13px; }
        .result-row:last-of-type { border-bottom: none; }
        .result-row .label { color: var(--brown-60); }
        .result-row .value { font-weight: 600; color: var(--brown); }
        .result-row .value.harga { color: var(--green); font-size: 16px; font-weight: 700; }
        .result-row .value.id-barang { font-family: 'Menlo', 'Consolas', monospace; letter-spacing: .6px; background: var(--green-10); color: var(--green); padding: 2px 10px; border-radius: var(--radius-pill); font-weight: 700; }
        .result-deskripsi { margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--brown-10); font-size: 13px; color: var(--brown-70); line-height: 1.55; }
        .badge-tersedia { display: inline-block; padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700; background: var(--green-10); color: var(--green); }
        .badge-habis    { display: inline-block; padding: 3px 10px; border-radius: var(--radius-pill); font-size: 11px; font-weight: 700; background: var(--red-10); color: var(--red); }

        .empty-result { text-align: center; padding: 40px 20px; color: var(--brown-60); font-size: 14px; }
        .empty-result svg { margin-bottom: 12px; opacity: .5; }

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
                <div class="header-title">Scan Tag Harga</div>
                <div class="header-subtitle">Arahkan kamera ke barcode tag harga untuk melihat detail menu</div>
            </div>
            <a href="{{ route('dashboard.menu') }}" class="header-back">&larr; Kembali ke Tag Harga</a>
        </header>

        <div class="dashboard-body">

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-title">📷 Scanner Barcode</div>
                    <div class="panel-subtitle">Barcode horizontal Code128 dari PDF tag harga &mdash; 8 karakter A-Z 0-9</div>
                </div>
                <div class="panel-body">
                    <div id="tagHargaScannerContainer"></div>
                    <div class="status-msg" id="scanStatus">Klik "Mulai Scan" untuk membuka kamera.</div>
                    <div class="scan-hint">
                        💡 Tip: posisikan barcode horizontal di dalam kotak hijau. Jaga jarak ~15-25 cm dan pastikan pencahayaan cukup.
                    </div>
                    <button type="button" class="btn btn-primary btn-full" id="startScanBtn">📷 Mulai Scan</button>
                    <button type="button" class="manual-link" id="mirrorToggleBtn" style="margin-top:10px;">🔄 Cermin Kamera: ON</button>

                    <button type="button" class="manual-link" id="toggleManualBtn">Atau ketik ID Barang manual</button>
                    <div id="manualWrap" style="display:none;">
                        <div class="manual-block">
                            <input type="text" id="manualInput" placeholder="ABC12345" maxlength="8" autocomplete="off">
                            <button type="button" class="btn btn-primary" id="manualLookupBtn">Cari</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-title">📋 Detail Menu</div>
                    <div class="panel-subtitle">Hasil pemindaian akan muncul di sini</div>
                </div>
                <div class="panel-body">
                    <div id="resultBox">
                        <div class="empty-result">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <line x1="7" y1="7" x2="7" y2="17"/>
                                <line x1="10" y1="7" x2="10" y2="17"/>
                                <line x1="13" y1="7" x2="13" y2="17"/>
                                <line x1="17" y1="7" x2="17" y2="17"/>
                            </svg>
                            <div>Belum ada barcode dipindai.</div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<script>
    (function() {
        const startBtn = document.getElementById('startScanBtn');
        const mirrorToggleBtn = document.getElementById('mirrorToggleBtn');
        const scanStatus = document.getElementById('scanStatus');
        const toggleManualBtn = document.getElementById('toggleManualBtn');
        const manualWrap = document.getElementById('manualWrap');
        const manualInput = document.getElementById('manualInput');
        const manualLookupBtn = document.getElementById('manualLookupBtn');
        const resultBox = document.getElementById('resultBox');

        let qrScanner = null;
        let scanning = false;
        let mirror = false;

        // CSS-only mirror: html5-qrcode's decoder reads frames from the underlying
        // media stream, not the rendered video, so flipping with CSS is purely
        // cosmetic and safe — it never breaks decoding or the camera preview.
        function applyMirrorCss() {
            const video = document.querySelector('#tagHargaScannerContainer video');
            if (video) {
                video.style.transform = mirror ? 'scaleX(-1)' : '';
                video.style.transformOrigin = 'center center';
            }
        }

        // ── Helpers ────────────────────────────────────────────────────────────────
        function escapeHtml(s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        function numberFormat(n) {
            return Number(n || 0).toLocaleString('id-ID');
        }

        function playBeep() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                osc.type = 'sine'; osc.frequency.value = 880;
                gain.gain.value = 0.3;
                osc.start();
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.2);
                osc.stop(ctx.currentTime + 0.2);
            } catch (e) {}
        }

        function showError(msg) {
            resultBox.innerHTML = '<div class="empty-result" style="color:var(--red);">' + escapeHtml(msg) + '</div>';
        }

        function showLoading() {
            resultBox.innerHTML = '<div class="empty-result">Mencari menu...</div>';
        }

        function renderMenu(data) {
            const img = data.path_gambar
                ? '<img class="result-img" src="' + escapeHtml(data.path_gambar) + '" alt="' + escapeHtml(data.nama_menu) + '">'
                : '';
            const desk = data.deskripsi
                ? '<div class="result-deskripsi">' + escapeHtml(data.deskripsi) + '</div>'
                : '';
            const kat = data.kategori
                ? '<div class="result-row"><span class="label">Kategori</span><span class="value">' + escapeHtml(data.kategori) + '</span></div>'
                : '';
            const avail = data.is_available
                ? '<span class="badge-tersedia">Tersedia</span>'
                : '<span class="badge-habis">Habis</span>';

            resultBox.innerHTML =
                '<div class="result-card">' +
                    img +
                    '<div class="result-nama">' + escapeHtml(data.nama_menu) + '</div>' +
                    '<div class="result-vendor">Vendor: ' + escapeHtml(data.vendor_name) + '</div>' +
                    '<div class="result-row"><span class="label">ID Barang</span><span class="value id-barang">' + escapeHtml(data.id_barang) + '</span></div>' +
                    kat +
                    '<div class="result-row"><span class="label">Harga</span><span class="value harga">Rp ' + numberFormat(data.harga) + '</span></div>' +
                    '<div class="result-row"><span class="label">Status</span><span class="value">' + avail + '</span></div>' +
                    desk +
                '</div>';
        }

        async function lookupMenu(idBarang) {
            const normalized = (idBarang || '').trim().toUpperCase();
            if (!/^[A-Z0-9]{8}$/.test(normalized)) {
                showError('Format ID Barang tidak valid (harus 8 karakter alfanumerik).');
                return;
            }
            showLoading();
            try {
                const r = await fetch('/api/menu/by-id-barang/' + encodeURIComponent(normalized));
                if (!r.ok) {
                    const body = await r.json().catch(() => ({}));
                    throw new Error(body.message || 'Menu tidak ditemukan');
                }
                const data = await r.json();
                playBeep();
                renderMenu(data);
            } catch (err) {
                showError(err.message || 'Gagal memuat menu');
            }
        }

        function updateMirrorButton() {
            if (mirrorToggleBtn) {
                mirrorToggleBtn.textContent = '🔄 Cermin Kamera: ' + (mirror ? 'ON' : 'OFF');
            }
        }

        // ── Scanner control ────────────────────────────────────────────────────────
        async function startScanner() {
            scanStatus.classList.remove('captured', 'error');
            scanStatus.textContent = 'Membuka kamera…';

            // Always destroy previous instance to avoid stale state
            if (qrScanner) {
                try { await qrScanner.stop(); } catch (e) {}
                qrScanner.clear();
                qrScanner = null;
            }

            try {
                qrScanner = new Html5Qrcode('tagHargaScannerContainer');

                const config = {
                    fps: 15,
                    qrbox: { width: 320, height: 120 }
                };
                if (typeof Html5QrcodeSupportedFormats !== 'undefined') {
                    config.formatsToSupport = [Html5QrcodeSupportedFormats.CODE_128];
                }

                await qrScanner.start(
                    { facingMode: 'environment' },
                    config,
                    function(decoded) {
                        stopScanner();
                        scanStatus.textContent = 'Barcode terdeteksi: ' + decoded;
                        scanStatus.classList.add('captured');
                        lookupMenu(decoded);
                    },
                    function() { /* per-frame decode noise */ }
                );
                scanning = true;
                applyMirrorCss();
                scanStatus.textContent = 'Arahkan barcode horizontal tag harga ke dalam kotak…';
                startBtn.textContent = '⏹ Stop Scan';
            } catch (err) {
                scanStatus.textContent = 'Kamera tidak tersedia: ' + (err.message || err.name || err);
                scanStatus.classList.add('error');
                scanning = false;
                startBtn.textContent = '📷 Mulai Scan';
            }
        }

        async function stopScanner() {
            if (qrScanner && scanning) {
                try { await qrScanner.stop(); qrScanner.clear(); } catch (e) {}
                qrScanner = null;
            }
            scanning = false;
            startBtn.textContent = '📷 Mulai Scan';
        }

        // ── Event listeners ───────────────────────────────────────────────────────
        startBtn.addEventListener('click', async function() {
            if (scanning) {
                await stopScanner();
                scanStatus.textContent = 'Scanner dihentikan.';
                scanStatus.classList.remove('captured', 'error');
            } else {
                await startScanner();
            }
        });

        if (mirrorToggleBtn) {
            mirrorToggleBtn.addEventListener('click', function() {
                mirror = !mirror;
                updateMirrorButton();
                applyMirrorCss();
            });
        }

        toggleManualBtn.addEventListener('click', function() {
            const visible = manualWrap.style.display === 'block';
            manualWrap.style.display = visible ? 'none' : 'block';
            toggleManualBtn.textContent = visible
                ? 'Atau ketik ID Barang manual'
                : 'Sembunyikan input manual';
            if (!visible) setTimeout(function() { manualInput.focus(); }, 50);
        });

        manualLookupBtn.addEventListener('click', async function() {
            const val = manualInput.value.trim();
            if (!val) return;
            await stopScanner();
            lookupMenu(val);
        });

        manualInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') manualLookupBtn.click();
        });

        // Initial UI state
        updateMirrorButton();
    })();
</script>

</body>
</html>
