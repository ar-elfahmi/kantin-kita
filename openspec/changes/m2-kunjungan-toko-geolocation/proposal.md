## Why

Module 2 (`Modul_geolocation.md`) is a continuation of Module 1: it explicitly relies on the QR scanner built in M1 (*"Pada modul selanjutnya anda akan membuat sebuah QR Code scanner"*). The studi kasus is a distributor app where sales staff need to prove they visited assigned stores — solved by combining barcode/QR scanning with browser geolocation and the Haversine distance formula.

Implemented in kantin-kita as a **"Kunjungan Toko"** vendor-dashboard feature: each vendor maintains a list of stores in their working area, each with captured GPS coordinates, and can validate visits by scanning the store's QR and comparing positions in real time.

## What Changes

- New migration creating two tables:
  - `lokasi_toko` — per the modul spec (barcode VARCHAR(8) PK, nama_toko VARCHAR(50), latitude DOUBLE, longitude DOUBLE, accuracy DOUBLE) plus `vendor_id` for tenant scoping and timestamps
  - `kunjungan_toko` — visit log (id, vendor_id, user_id, lokasi_toko_barcode FK, sales_lat/lng/accuracy, jarak_meter, threshold_efektif, status enum, timestamps)
- New Eloquent models: `LokasiToko` (string PK on `barcode`, non-incrementing), `KunjunganToko`
- New `KunjunganTokoController` with: `index`, `tokoCreate`, `tokoStore`, `tokoQr` (Endroid PNG inline), `scan`, `lookupToko` (JSON AJAX), `visitStore`
- New routes prefixed `/dashboard/kunjungan/*` inside the existing `auth` middleware group
- New Blade views under `resources/views/vendor/kunjungan/`: `index`, `toko-create`, `scan` (sidebar reused via the existing `vendor.customer._sidebar` partial — promoting it from "customer-specific" to "shared dashboard sidebar")
- Server-side Haversine implementation in the controller (no new dependency)
- Client-side `getAccuratePosition()` JS (from modul Lampiran 1) reused in both `toko-create` and `scan` views
- "Kunjungan Toko" nav-item added in three places: `dashboard-vendor.blade.php`, `vendor/manage-menu.blade.php`, `vendor/customer/_sidebar.blade.php`

## Capabilities

### New Capabilities
- `kunjungan-toko`: Vendor can register stores with GPS coordinates, generate scannable QRs, and validate visits by computing Haversine distance against the recorded store position

### Modified Capabilities
- (none)

## Impact

- Two new DB tables, both vendor-scoped via `vendor_id` FK
- One new PHP controller (~200 LOC), two new models, three new views
- No new Composer dependencies (Endroid already installed for SK2; html5-qrcode already CDN-loaded by dashboard-vendor)
- Sidebar partial `vendor/customer/_sidebar.blade.php` semantically widened to "shared vendor sidebar" (filename stays for now to avoid touching the 3 customer views that import it; rename is a follow-up cleanup)
- Threshold radius defaults to 300m; configurable per-vendor in a future iteration
