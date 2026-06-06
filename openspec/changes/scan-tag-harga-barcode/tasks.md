## 1. Controller methods (PriceTagController)

- [x] 1.1 `lookupByIdBarang(string $idBarang): JsonResponse` — vendor-scoped Menu lookup; 404 on unknown/foreign with generic message (no enumeration leak); 200 returns `id_barang`, `nama_menu`, `harga` (int), `kategori`, `deskripsi`, `path_gambar`, `is_available` (bool), `vendor_name`
- [x] 1.2 `scan()` — vendor-guarded; returns the new dedicated scanner view

## 2. Routes

- [x] 2.1 `Route::get('/dashboard/menu/scan', [PriceTagController::class, 'scan'])->name('dashboard.menu.scan');` inside the `auth` group, immediately after `dashboard.menu`
- [x] 2.2 `Route::get('/api/menu/by-id-barang/{idBarang}', [PriceTagController::class, 'lookupByIdBarang'])->name('api.menu.by-id-barang');`

## 3. View

- [x] 3.1 Created `resources/views/vendor/scan-tag-harga.blade.php` — two-column layout: left panel is the `html5-qrcode` scanner with Start/Stop button + manual-input fallback; right panel is the result card (empty state until a scan succeeds)
- [x] 3.2 Reuses the shared sidebar partial `@include('vendor.customer._sidebar', ['vendor' => $vendor])`
- [x] 3.3 Result card renders: optional `path_gambar` thumbnail, nama, vendor name, ID Barang (mono pill), kategori, harga (green-bold rupiah), availability badge (Tersedia/Habis), deskripsi (truncated)
- [x] 3.4 Manual input is auto-uppercased + length-capped at 8 chars; client validates `^[A-Z0-9]{8}$` before firing the HTTP call (gives instant error feedback for typos)
- [x] 3.5 Plays a short beep on successful scan + result render (same audio API trick as the order scanner)
- [x] 3.6 Self-contained IIFE for scanner JS; no global pollution beyond the page's own elements
- [x] 3.7 All server response strings are passed through a local `escapeHtml(s)` helper before injection

## 4. CTA placement & nav

- [x] 4.1 Added "📷 Scan Tag Harga" link in `vendor/manage-menu.blade.php` panel header (next to the menu count), reusing the existing `.btn-cetak` style (green primary)
- [x] 4.2 Updated the "Tag Harga" sidebar nav-item active-state check from `routeIs('dashboard.menu')` to `routeIs('dashboard.menu*')` in all three sidebar locations: `vendor/customer/_sidebar.blade.php` (shared partial), `dashboard-vendor.blade.php` (inline), `vendor/manage-menu.blade.php` (inline). Both the list page and the new scan page now keep the nav-item highlighted.

## 5. Revert previous approach

- [x] 5.1 `dashboard-vendor.blade.php` order-scanner modal restored to original state:
    - Modal title: "Scan Barcode Pesanan"
    - Manual toggle label: "Input Manual Order ID"
    - Manual input label: "Masukkan Order ID"
    - Manual input placeholder: `KK-123-1713100800`
    - `onScanSuccess(decodedText)` calls `lookupOrder(decodedText.trim())` (no dispatcher)
    - Manual lookup handler calls `lookupOrder(val)`
    - Removed `dispatchScan`, `lookupMenu`, `renderMenuResult`, `escapeHtml` functions from the IIFE

## 6. Verify

- [x] 6.1 `php artisan view:cache` compiles cleanly
- [x] 6.2 `php artisan route:list --name=dashboard.menu` shows 2 routes (`dashboard.menu`, `dashboard.menu.scan`)
- [x] 6.3 `php artisan route:list --name=api.menu` shows the lookup endpoint
- [x] 6.4 `php -l` on `PriceTagController.php` clean
- [ ] 6.5 MANUAL: from a vendor account, navigate `/dashboard/menu` → click "📷 Scan Tag Harga" CTA → scanner page loads → "Mulai Scan" opens camera → point at a printed tag harga → menu detail card appears
- [ ] 6.6 MANUAL: navigate `/dashboard` → click sidebar Scan Barcode → modal still labeled "Scan Barcode Pesanan" and ONLY handles order QRs (regression check)
- [ ] 6.7 MANUAL: on the scan-tag-harga page, type "abc12345" (lowercase) in manual input → auto-uppercased → lookup fires → 404 if unknown, menu if exists
- [ ] 6.8 MANUAL: type "abc" (too short) → instant "Format ID Barang tidak valid" feedback without HTTP call
- [ ] 6.9 MANUAL: vendor B logs in, types vendor A's id_barang → 404 generic "Menu tidak ditemukan"
- [ ] 6.10 MANUAL: verify sidebar "Tag Harga" stays highlighted on both `/dashboard/menu` and `/dashboard/menu/scan`

## 7. Notes

- The scan page lives at `/dashboard/menu/scan` rather than `/scan-tag-harga` because it's conceptually a sub-action of menu management. The URL hierarchy mirrors the navigation hierarchy.
- The CTA placement (next to the menu count, top-right of the panel header) puts it within the natural workflow: vendor opens Tag Harga page to manage tags → sees the scan button as the inverse action → clicks to verify a printed tag scans correctly.
- The order scanner stays in the sidebar because it's always available across all vendor dashboard pages (vendor might want to verify an order at any moment). The tag scanner lives under "Tag Harga" because it's a less-frequent action tied to that specific feature.
- Manual input uppercases on each keystroke (CSS `text-transform: uppercase`) for visual feedback that the canonical id_barang format is uppercase.
- The lookup endpoint is shared between this scanner and any future tag-scan use case (e.g., a future POS feature that scans tags to add items to an order).

## 8. Follow-up fix: scanner config for 1D Code128 barcodes

User report: the initial scanner detected square QR codes (order receipts) but the result was silently rejected by the client-side `^[A-Z0-9]{8}$` regex; meanwhile, the actual horizontal Code128 barcodes printed on tag harga PDFs were not being detected at all.

Root cause: `html5-qrcode` defaults to scanning every supported format with a single square `qrbox`. The square viewfinder and "any format" decoder are biased toward 2D codes (QR, DataMatrix). A 1D barcode that's wider than the qrbox won't decode reliably.

Fix applied in `vendor/scan-tag-harga.blade.php`:

- [x] 8.1 `formatsToSupport: [Html5QrcodeSupportedFormats.CODE_128]` — the scanner now only attempts Code128 decoding. QR codes are ignored entirely (no more silent rejection), and the engine spends all its time looking for the right format.
- [x] 8.2 `qrbox` changed from a fixed 260×160 square-ish box to a **function** that returns a wide-short rectangle sized to the viewfinder (`min(viewW × 0.85, 360)` × `min(viewH × 0.40, 140)`). Matches the aspect ratio of a horizontal Code128.
- [x] 8.3 `experimentalFeatures: { useBarCodeDetectorIfSupported: true }` — enables the native `BarcodeDetector` Web API where supported (Chrome on Android). Pure-JS ZXing fallback is much slower and less reliable for 1D barcodes.
- [x] 8.4 Panel subtitle updated from "Format: Code128 atau 8-character alphanumeric" → "Barcode horizontal Code128 dari PDF tag harga — 8 karakter A-Z 0-9" so users know what shape to point at.
- [x] 8.5 Added a small `.scan-hint` block above the Start button: "Tip: posisikan barcode horizontal di dalam kotak hijau. Jaga jarak ~15-25 cm dan pastikan pencahayaan cukup."
- [x] 8.6 Status text updated from "Arahkan kamera ke barcode tag harga…" → "Arahkan barcode horizontal tag harga ke dalam kotak…" for sharper alignment cue.
