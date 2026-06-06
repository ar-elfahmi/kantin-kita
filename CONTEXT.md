# CONTEXT.md — Kantin Kita

## 2026-05-16: Initial Project Setup & Onboarding

**Files touched:**
- `routes/web.php` — 7 routes: home, about, vendor, menu, checkout, login, dashboard
- `routes/api.php` — 3 routes: /api/checkout, /api/checkout/update-status, /api/midtrans/notification, /api/chatbot/respond
- `app/Http/Controllers/CheckoutController.php` — Full Midtrans integration: store (guest user + pesanan + snap token), updateStatus, notification handler with signature validation
- `app/Http/Controllers/DashboardController.php` — Vendor dashboard: pesanan sudahDibayar(), stats (hari/minggu/bulan), markAsDone
- `app/Http/Controllers/AuthController.php` — Login/logout vendor
- `app/Http/Controllers/VendorController.php` — List open vendors, show menu by vendor
- `app/Http/Controllers/HomeController.php` — Welcome page
- `app/Models/User.php` — Has role, isVendor/isAdmin/isGuest helpers, hasOne vendor, hasMany pesanans
- `app/Models/Vendor.php` — belongsTo user, hasMany menus + pesanans
- `app/Models/Menu.php` — belongsTo vendor + kategoriMenu, hasMany detailPesanans
- `app/Models/Pesanan.php` — hasMany detailPesanans, hasOne payment, scopeSudahDibayar()
- `app/Models/DetailPesanan.php` — belongsTo pesanan + menu
- `app/Models/Payment.php` — belongsTo pesanan, casts paid_at→datetime, midtrans_response→array
- `app/Models/KategoriMenu.php` — hasMany menus, table: kategori_menus
- `tests/Feature/KantinFlowTest.php` — 12 tests covering auth, vendor listing, dashboard, checkout, midtrans notification, order flow
- `implementation_plan.md` — Complete schema, controller, route architecture (1398 lines)
- `task.md` — 49-step checklist from Fase 1-9

**Decisions:**
- AGENTS.md already exists with domain conventions, testing instructions, and change rules
- CONTEXT.md created per §6 format for persistent knowledge
- Recommend Graphify build since project >10K LOC (22 source files, 2 plan docs)

**Architecture:**
- Laravel 13 + Blade frontend + Tailwind CSS 4 + Vite 8
- MySQL local runtime, SQLite in-memory for tests
- Midtrans Snap (popup QRIS) for payments — frontend-driven update status (no webhook)
- Guest checkout auto-creates User with role=guest
- Vendor dashboard only shows orders with payment.status=settlement (scopeSudahDibayar)
- Order status flow: pending → diproses → selesai (vendor marks done)
- Payment status flow: pending → settlement/expire/cancel/deny

## 2026-05-17: Vendor Scan Barcode Feature

**Files touched:**
- `resources/views/dashboard-vendor.blade.php` — Added:
  - "Scan Barcode" nav button in sidebar with barcode icon SVG
  - Scan modal overlay (hidden by default) with scanner container, result area, manual input fallback
  - Modal CSS (overlay, animation, scan-result-card, items table, error/loading states)
  - html5-qrcode CDN script tag (v2.3.8)
  - Scan JS: Html5Qrcode camera init, decode handler, API lookup via existing `GET /api/checkout/by-order-id/{orderId}`, result renderer, manual input toggle, close/stop cleanup

**Decisions:**
- Used existing `GET /api/checkout/by-order-id/{orderId}` endpoint (was already in `routes/api.php` with `auth` middleware) instead of creating a new POST route — less code, authentication already handled
- html5-qrcode library from CDN for zero-build barcode scanning (no npm dependency)
- Manual input fallback (toggle) for when camera isn't available or barcode won't scan
- On modal close: stops camera and clears scanner to free camera resource

**Gotchas:**
- html5-qrcode requires `https` or `localhost` for camera access; must be served over secure context
- Existing `lookupByOrderId` returns 422/404 on error, not `{success:false}` — JS adapted to check `r.ok` and parse error message from response body

## 2026-05-17: Comprehensive Feature Test Expansion

**Files touched:**
- `tests/Feature/KantinFlowTest.php` — Expanded from 12 tests to 54 tests (141 assertions), covering all controllers:
  - **AuthController (5 tests):** login page renders for guest, login redirects authenticated, login fails invalid credentials, login fails non-vendor role, logout clears session
  - **HomeController (1):** home page loads successfully
  - **VendorController (2):** empty state (no open vendors), 404 for nonexistent vendor
  - **CheckoutController (17):** checkout page with/without vendor_id, order success page loads, store fails without midtrans config, store success/validation errors, update-status success/invalid status/nonexistent pesanan, notification handler valid/invalid signature, lookupByOrderId success/format/notfound/auth/mismatch
  - **DashboardController (8):** page loads with orders, empty state (no orders), 403 for non-vendor, stats calculation, mark as done success/notfound/wrong-vendor
  - **ChatbotController (10):** 422 empty/too-long prompt, greeting, top menu with/without orders, affordable menu with/without data, spicy menu with/without data, operational info with/without open vendors, order instructions, payment info, fallback

**Decisions:**
- Used PHP feature tests (Laravel `TestCase`) instead of E2E Playwright/Cypress — faster CI, no browser dependency, already have SQLite in-memory setup
- Wildcard `assertJson(['result' => '*'])` not supported by PHPUnit — replaced with `assertArrayHasKey('result', ...)` for structure checks
- Nonexistent pesanan in updateStatus returns 422 (FormRequest validation fires before controller) not 404 — test adjusted

**Gotchas:**
- `assertJson(['key' => '*'])` is NOT supported by PHPUnit (unlike Pest); use `assertArrayHasKey` + `assertIsString` instead
- FormRequest validation runs before controller for POST/PUT routes — nonexistent IDs hit validation first, not controller's 404 logic
- `$user = User::factory()->asVendor()->create()` works via `afterMaking` state callback
- `actingAs($user)->get(...)` on protected pages with auth middleware returns 302 redirect when not logged in
- Status transitions in `updateStatus`: only `diproses→selesai` allowed — any other transition returns error
- Payment `order_id` must be unique per Midtrans requirement — duplicating in tests caused FK constraint failures

## 2026-05-17: Fix Scan Barcode — Session Auth

**Files touched:**
- Route moved: `GET /api/checkout/by-order-id/{orderId}` from `routes/api.php` (line 11) to `routes/web.php` (inside `auth` middleware group)

**Problem:** Route `GET /api/checkout/by-order-id/{orderId}` used `->middleware('auth')` in `routes/api.php`. Laravel's API middleware group doesn't include `StartSession` middleware → session cookie from web login invisible → auth middleware redirects to `/login` (HTML) → JS fetch got HTML instead of JSON → `Unexpected token '<'`

**Fix:** Moved route to `routes/web.php` inside existing `Route::middleware('auth')` group. URL unchanged (`/api/checkout/by-order-id/{orderId}`). Web middleware group handles session auth correctly.

## 2026-05-17: Generate Barcode Price Tag

**Files touched:**
- `app/Http/Controllers/PriceTagController.php` — Created. `generate(Menu $menu)` with vendor ownership check (403 if not vendor/wrong vendor), generates Code128 barcode via Picqer, converts to base64 PNG, renders DomPDF.
- `resources/views/vendor/price-tag.blade.php` — Created. PDF view: DejaVu Sans font, centered layout, barcode image, id_barang, nama_menu, harga (Rp), vendor name. Custom size 283.46x425.2pt (10x15cm).
- `routes/web.php` — Added `Route::get('/menu/{menu}/price-tag', [PriceTagController::class, 'generate'])->name('menu.price-tag')` inside `auth` middleware group.
- `resources/views/dashboard-vendor.blade.php` — Added `btn-cetak` CSS class and "Cetak Tag Harga" anchor in each product card's `.product-actions`.
- `tests/Feature/KantinFlowTest.php` — 7 new tests: 200 own menu, 403 non-vendor, 403 other vendor, 404 nonexistent, PDF content-type, id_barang auto-generate, barcode image in filename.
- `database/migrations/2026_05_17_000001_add_id_barang_to_menus_table.php` — Added `id_barang` varchar(16) unique column after `vendor_id`.
- `app/Models/Menu.php` — Added `id_barang` to `$fillable`, added `booted()` to auto-generate 8-char uppercase alphanumeric id_barang on creating.

**Decisions:**
- Picqer/php-barcode-generator over BaconQR code — Code128 better for alphanumeric id_barang, simpler API, lighter dependency.
- barryvdh/laravel-dompdf for PDF rendering — lightweight, no headless browser needed, custom page size supported.
- id_barang auto-generated 8-char uppercase on create — no manual entry, no duplicates via DB unique constraint.
- Ownership check in controller — 403 with message, consistent with dashboard mbak pattern.
- btn-cetak styling follows existing btn-edit/btn-detail pattern (brown theme, inline-flex).
- npm build skipped as execution policy blocked on host and no Vite assets modified.
- Per-menu download (not batch) — simpler, leverages existing `$produk` loop in dashboard.

**Gotchas:**
- DomPDF `$paper->setPaper('custom', ...)` must pass valid point values — 283.46×425.2pt = 10×15cm.
- Picqer `getBarcodePNG()` outputs raw image data (no mime prefix) — prepend `data:image/png;base64,` for base64 `<img src>`.
- Own menu check uses `$menu->vendor_id !== auth()->user()->vendor->id` — works because vendor relation always exists for vendor-role users (authenticated vendor guaranteed).
- Migration `2026_05_17_000001_add_id_barang_to_menus_table.php` was created in an earlier session (before task 2.1) — checked migration listing to avoid duplicate.

## 2026-05-17: Backfill id_barang for Existing Menu Records

**Problem:** Existing menus (seeded before `id_barang` migration) have `id_barang = null`. `PriceTagController::generate()` passes `$menu->id_barang` to `getBarcode()` → TypeError on null.

**Files touched:**
- `database/migrations/2026_05_17_000002_backfill_and_enforce_id_barang.php` — Created. Backfills null `id_barang` for all existing menus (8-char uppercase alphanumeric via `Str::random(8)` + uniqueness loop matching `booted()` logic), then changes column to `nullable(false)`.
- `tests/Feature/KantinFlowTest.php` — Added `test_id_barang_column_is_non_nullable_after_backfill` (asserts direct insert without id_barang throws QueryException)

**Decisions:**
- Single migration for backfill + schema change ensures consistency — no window where column is non-nullable with null data.
- Backfill logic mirrors `booted()` model logic exactly (`Str::upper(Str::random(8))` + uniqueness check) — same id_barang format, no mismatch.
- Test uses `Schema::getColumnListing` + explicit `DB::insert` to bypass model auto-generation — proves column constraint independently.

**Tests:** 62 passed, 153 assertions.
