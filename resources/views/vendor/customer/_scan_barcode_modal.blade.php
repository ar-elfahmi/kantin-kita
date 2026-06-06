{{--
    Scan Barcode (post-payment order QR) — drop-in partial.

    Provides: html5-qrcode CDN script, modal CSS, modal HTML, and the scanner IIFE.
    Wrapped in @once so it can be safely @include'd from any view (or partial) and only
    renders once per request even if multiple sidebars on the page reference it.

    Required: a button with id="scanBarcodeBtn" somewhere on the page (the trigger).
    Required: route /api/checkout/by-order-id/{orderId} (defined in routes/web.php).
--}}

@once
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

<style>
    .scan-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .6);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .scan-modal-overlay.active { display: flex; }
    .scan-modal {
        background: #fff;
        border-radius: 16px;
        max-width: 520px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
        animation: scanModalIn .25s ease;
    }
    @keyframes scanModalIn {
        from { transform: scale(.95); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }
    .scan-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--brown-10, rgba(116, 70, 34, .1));
    }
    .scan-modal-header h2 {
        font-size: 18px;
        font-weight: 600;
        color: var(--brown, #744622);
    }
    .scan-modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: var(--brown-60, rgba(116, 70, 34, .6));
        cursor: pointer;
        line-height: 1;
        padding: 0 4px;
    }
    .scan-modal-close:hover { color: var(--brown, #744622); }
    .scan-modal-body { padding: 24px; text-align: center; }
    .scan-modal-body video { border-radius: 10px; max-width: 100%; }
    .scan-result-card {
        text-align: left;
        background: var(--cream, #FBF5E8);
        border-radius: 12px;
        padding: 20px;
        margin-top: 16px;
    }
    .scan-result-card h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--brown, #744622);
    }
    .scan-result-item {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        font-size: 13px;
    }
    .scan-result-item .label { color: var(--brown-60, rgba(116, 70, 34, .6)); }
    .scan-result-item .value { font-weight: 500; }
    .scan-result-items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
        font-size: 13px;
    }
    .scan-result-items-table th {
        text-align: left;
        color: rgba(116, 70, 34, .5);
        font-size: 11px;
        text-transform: uppercase;
        padding: 6px 8px;
        border-bottom: 1px solid var(--brown-10, rgba(116, 70, 34, .1));
    }
    .scan-result-items-table td {
        padding: 6px 8px;
        border-bottom: 1px solid rgba(116, 70, 34, .05);
    }
    .scan-link-btn {
        background: none;
        border: none;
        color: var(--green, #42766A);
        font-family: inherit;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: underline;
        padding: 8px;
    }
    .scan-link-btn:hover { color: #1B5E20; }
    .scan-manual-toggle { margin-top: 16px; }
    .scan-loading { padding: 14px; color: var(--brown-60, rgba(116, 70, 34, .6)); font-size: 13px; }
    .scan-error {
        padding: 12px 14px;
        background: rgba(220, 38, 38, .1);
        color: #B91C1C;
        border-radius: 8px;
        font-size: 13px;
        margin-top: 12px;
    }
    .status-badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
    .status-badge.status-pending { background: #FEF3C7; color: #D97706; }
    .status-badge.status-process { background: #DBEAFE; color: #2563EB; }
    .status-badge.status-done    { background: rgba(66, 118, 106, .12); color: var(--green, #42766A); }
    #scannerContainer canvas { border-radius: 10px; }
</style>

<div id="scanModal" class="scan-modal-overlay" style="display:none;">
    <div class="scan-modal">
        <div class="scan-modal-header">
            <h2>Scan Barcode Pesanan</h2>
            <button type="button" id="scanModalClose" class="scan-modal-close">&times;</button>
        </div>
        <div class="scan-modal-body">
            <div id="scannerContainer" style="width:100%;max-width:400px;margin:0 auto;"></div>
            <div id="scanResult" style="display:none;"></div>
            <div class="scan-manual-toggle">
                <button type="button" id="manualToggle" class="scan-link-btn">Input Manual Order ID</button>
            </div>
            <div id="manualInput" style="display:none;margin-top:16px;">
                <label style="display:block;font-size:13px;margin-bottom:6px;color:var(--brown-70,rgba(116,70,34,.7));">Masukkan Order ID</label>
                <div style="display:flex;gap:8px;">
                    <input type="text" id="manualOrderId" placeholder="KK-123-1713100800" style="flex:1;padding:10px 14px;border:1px solid var(--brown-10,rgba(116,70,34,.1));border-radius:8px;font-family:inherit;font-size:14px;" />
                    <button type="button" id="manualLookupBtn" style="padding:10px 20px;background:var(--green,#42766A);color:#fff;border:none;border-radius:8px;cursor:pointer;font-family:inherit;font-weight:600;font-size:14px;">Cari</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const modal = document.getElementById('scanModal');
        const openBtn = document.getElementById('scanBarcodeBtn');
        const closeBtn = document.getElementById('scanModalClose');
        const scannerEl = document.getElementById('scannerContainer');
        const scanResultEl = document.getElementById('scanResult');
        const manualToggle = document.getElementById('manualToggle');
        const manualInputWrap = document.getElementById('manualInput');
        const manualOrderId = document.getElementById('manualOrderId');
        const manualLookupBtn = document.getElementById('manualLookupBtn');

        if (!modal || !openBtn) return; // partial included but no trigger button on the page

        let html5QrCode = null;
        let isScanning = false;

        function stopScanner() {
            if (html5QrCode && isScanning) {
                try {
                    html5QrCode.stop().then(() => {
                        html5QrCode.clear();
                        isScanning = false;
                    }).catch(() => {});
                } catch (e) {}
            }
        }

        function startScanner() {
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode('scannerContainer');
            }
            const config = { fps: 15, qrbox: { width: 250, height: 150 } };
            html5QrCode.start(
                { facingMode: 'environment' },
                config,
                onScanSuccess,
                function(err) { /* per-frame decode noise */ }
            ).then(() => { isScanning = true; })
              .catch(function() {
                  scannerEl.innerHTML = '<div class="scan-error">Kamera tidak tersedia atau izin ditolak.</div>';
              });
        }

        function playBeep() {
            try {
                var ctx = new (window.AudioContext || window.webkitAudioContext)();
                var osc = ctx.createOscillator();
                var gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                osc.type = 'sine'; osc.frequency.value = 880;
                gain.gain.value = 0.3;
                osc.start();
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.2);
                osc.stop(ctx.currentTime + 0.2);
            } catch (e) {}
        }

        function onScanSuccess(decodedText) {
            playBeep();
            stopScanner();
            lookupOrder(decodedText.trim());
        }

        function lookupOrder(orderId) {
            scanResultEl.style.display = 'block';
            scanResultEl.innerHTML = '<div class="scan-loading">Mencari pesanan...</div>';
            fetch('/api/checkout/by-order-id/' + encodeURIComponent(orderId))
                .then(function(r) {
                    if (!r.ok) {
                        return r.json().then(function(d) { throw new Error(d.message || 'Pesanan tidak ditemukan'); });
                    }
                    return r.json();
                })
                .then(renderScanResult)
                .catch(function(err) {
                    scanResultEl.innerHTML = '<div class="scan-error">' + err.message + '</div>';
                });
        }

        function renderScanResult(data) {
            var statusBadge = data.status_pesanan.charAt(0).toUpperCase() + data.status_pesanan.slice(1);
            var html = '<div class="scan-result-card">';
            html += '<h3>#' + data.pesanan_id + ' - ' + data.nama_customer + '</h3>';
            html += '<div class="scan-result-item"><span class="label">Vendor</span><span class="value">' + data.vendor_name + '</span></div>';
            html += '<div class="scan-result-item"><span class="label">Status</span><span class="value">' + statusBadge + '</span></div>';
            html += '<div class="scan-result-item"><span class="label">Total</span><span class="value">Rp ' + numberFormat(data.total) + '</span></div>';
            if (data.waktu_pengambilan) {
                html += '<div class="scan-result-item"><span class="label">Waktu Ambil</span><span class="value">' + data.waktu_pengambilan + '</span></div>';
            }
            if (data.items && data.items.length) {
                html += '<table class="scan-result-items-table"><thead><tr><th>Menu</th><th>Qty</th><th>Harga</th></tr></thead><tbody>';
                data.items.forEach(function(item) {
                    html += '<tr><td>' + item.nama_menu + '</td><td>' + item.jumlah + '</td><td>Rp ' + numberFormat(item.subtotal) + '</td></tr>';
                });
                html += '</tbody></table>';
            }
            html += '</div>';
            scanResultEl.innerHTML = html;
        }

        function numberFormat(n) {
            return Number(n || 0).toLocaleString('id-ID');
        }

        openBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
            scanResultEl.style.display = 'none';
            scanResultEl.innerHTML = '';
            manualInputWrap.style.display = 'none';
            manualOrderId.value = '';
            startScanner();
        });

        closeBtn.addEventListener('click', function() {
            stopScanner();
            modal.style.display = 'none';
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                stopScanner();
                modal.style.display = 'none';
            }
        });

        manualToggle.addEventListener('click', function() {
            var visible = manualInputWrap.style.display === 'block';
            manualInputWrap.style.display = visible ? 'none' : 'block';
            manualToggle.textContent = visible ? 'Input Manual Order ID' : 'Sembunyikan input manual';
            if (visible) { stopScanner(); startScanner(); } else { stopScanner(); }
        });

        manualLookupBtn.addEventListener('click', function() {
            var val = manualOrderId.value.trim();
            if (!val) return;
            stopScanner();
            lookupOrder(val);
        });

        manualOrderId.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') manualLookupBtn.click();
        });
    })();
</script>
@endonce
