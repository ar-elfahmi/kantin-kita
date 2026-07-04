# CONTEXT.md — Kantin Kita

## 2026-07-04: Hapus section artikel dari landing page

**Files touched:**
- `resources/views/welcome.blade.php` — hapus HTML section `.tentang-kami` (artikel grid + CTA) + hapus CSS `.tentang-kami*` desktop (13 rules) dan responsive (3 rules)
- `app/Http/Controllers/HomeController.php` — hapus query `$tentangKamiArticles` dan pass ke view (unused)



## 2026-06-09: Hapus button Detail dari card produk dashboard vendor

**Files touched:**
- `resources/views/dashboard-vendor.blade.php` — hapus `<button class="btn-detail">Detail</button>` dan CSS `.btn-detail` + `.btn-detail:hover`

## 2026-06-10: Fix broken menu images — add onerror fallback

**Files touched:**
- `resources/views/checkout.blade.php:2259` — tambah `onerror="this.onerror=null;this.src=DEFAULT_MENU_IMAGE"` di cart item `<img>` agar fallback ke default image saat path_gambar broken
- `resources/views/menu-vendor.blade.php:1482` — tambah `onerror` yang sama di menu card `<img>` (fallback ke `$defaultMenuImage`)

**Gotchas:**
- Cart menyimpan `path_gambar` dari `data-menu-image` (resolved URL) di localStorage; jika URL tersebut kemudian broken (misal file storage dihapus atau URL eksternal mati), gambar tidak tampil
- `onerror` dengan `this.onerror=null` mencegah infinite loop jika default image juga broken

## 2026-06-09: Fix broken images (builder.io → local/SVG) di vendor pages

**Files touched:**
- `resources/views/vendor/_sidebar.blade.php` — logo: builder.io img → inline SVG "KK" badge; avatar: builder.io img → `avatar-initial` div (huruf pertama vendor); CSS: tambah `.avatar-initial` flexbox styles
- `resources/views/dashboard-vendor.blade.php` — favicon builder.io → `{{ asset('favicon.ico') }}`; header avatar builder.io img → div with `.avatar-initial`; CSS: tambah `.avatar-initial`; fallback `$produkImgFallback` / `$orderThumbFallback` → SVG data URI cream rect
- `resources/views/vendor/manage-menu.blade.php` — favicon, header avatar, CSS `.avatar-initial`, `$defaultThumb` fallback
- `resources/views/vendor/manage-orders.blade.php` — favicon, header avatar, CSS `.avatar-initial`
- `resources/views/vendor/customer/{index,create-blob,create-path}.blade.php` — favicon
- `resources/views/vendor/scan-tag-harga.blade.php` — favicon
- `resources/views/vendor/kunjungan/{index,scan,toko-create}.blade.php` — favicon

**Decisions:**
- Logo sidebar: inline SVG "KK" badge (Poppins 800, white on green #42766A, rounded 12px, 48x48) — zero network dependency
- Avatar: CSS `avatar-initial` class — first letter of vendor name, brown-10 bg, brown text, flex centered, uppercase
- Fallback thumbnails: SVG data URI (cream #FBF5E8 rect) — no external dependency
- `favicon.ico` already existed in `public/` — just needed asset() path

## 2026-06-07: Samakan navbar alur pesan (/vendor, /vendor/{id}/menu, /checkout)

**Files touched:**
- `resources/views/select-vendor.blade.php` — nav-links: Home · Vendors · Cart (hapus My Orders/Profile); hapus `.header-actions` (notif + avatar); cleanup CSS `.notif-btn`, `.notif-badge`, `.avatar-wrap`, `.avatar-img`, `.header-actions`
- `resources/views/menu-vendor.blade.php` — hapus `.user-avatar` di navbar-actions (cart-btn dipertahankan); cleanup CSS `.user-avatar*`
- `resources/views/checkout.blade.php` — nav-links: Home · Vendors · Cart (hapus Orders, ganti "Menu" → "Vendors"); hapus `.nav-actions` (notif + avatar); cleanup CSS `.notif-wrapper`, `.notif-badge`, `.avatar`, `.nav-actions`
- `openspec/changes/consistent-order-flow-navbar/` — proposal, design, specs (`order-flow-navbar`), tasks

**Catatan:** footer di select-vendor & checkout sengaja TIDAK diubah (user spesifik minta navbar). Active state pakai `request()->routeIs()`.

## 2026-06-07: Samakan dimensi & buat seluruh card clickable di /vendor & /vendor/{id}/menu

**Files touched:**
- `resources/views/select-vendor.blade.php` — vendor card adopt canonical tokens (radius 20px, image 208px, padding 20px), grid 4→3→horizontal di breakpoint 1024/768, `<article role="link" tabindex="0" data-href aria-label>`, JS click+keydown delegation di `#vendorsGrid`, focus-visible outline sage
- `resources/views/menu-vendor.blade.php` — `<article role="button" tabindex="0" aria-label>` di menu card, JS dispatch `CustomEvent('menu-card:open')` di `#menuGrid` dengan fallback handler memanggil `openMenuDetailModal(card)`, focus-visible outline sage. Token canonical card di `:root` selaras dengan select-vendor
- `tests/Feature/KantinFlowTest.php` — 2 test baru memverifikasi atribut a11y/data-href di kedua halaman
- `openspec/changes/align-vendor-card-clickable/` — proposal, design, specs (`vendor-card-presentation`), tasks

**Konvensi card-as-interactive:** klik area kosong card memicu aksi utama; sub-elemen interaktif (a/button/input/textarea/select/[data-menu-controls]) di-skip via `e.target.closest(...)` di delegated handler — tidak perlu `stopPropagation` ad-hoc per tombol. Keyboard Enter (link/button) dan Space (button) memicu aksi yang sama.

## 2026-06-07: Tambah fitur "Tambah Produk" di /dashboard/menu

**Files touched:**
- `app/Http/Controllers/DashboardController.php` — `menuList()` kini mengirim `kategoriMenus` ke view supaya dropdown kategori terisi
- `resources/views/vendor/manage-menu.blade.php` — tombol "Tambah Produk", modal form, CSS, dan JS submit (fetch ke `dashboard.menu.store`) + toast feedback
- `openspec/changes/add-product-feature-menu/` — proposal, design, specs (`vendor-menu-management`), tasks

**Endpoint:** `POST /dashboard/menu/store` (sudah ada, JSON response). Validasi server tetap otoritatif; klien validasi awal (nama, harga, gambar ≤ 2MB).

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

## 2026-06-09: Unifikasi vendor sidebar — partial tunggal + CSS terpusat

**Files touched:**
- `resources/views/vendor/_sidebar.blade.php` — Di-rewrite: embed seluruh sidebar CSS (desktop + responsive breakpoints), Scan Barcode button selalu tampil (tidak kondisional), sertakan `@include('vendor.customer._scan_barcode_modal')` di akhir
- `resources/views/dashboard-vendor.blade.php` — Hapus sidebar CSS + scan modal CSS duplikat + script tag html5-qrcode (sekarang dari partial/@once), update `@include` passing `$vendor`
- `resources/views/vendor/manage-orders.blade.php` — Hapus sidebar CSS + responsive sidebar
- `resources/views/vendor/manage-menu.blade.php` — Hapus sidebar CSS + responsive sidebar, hapus standalone `@include('vendor.customer._scan_barcode_modal')`, hapus `showScanBarcode` dari include
- `resources/views/vendor/customer/index.blade.php` — Hapus sidebar CSS, switch `vendor.customer._sidebar` → `vendor._sidebar`
- `resources/views/vendor/customer/create-blob.blade.php` — Sama
- `resources/views/vendor/customer/create-path.blade.php` — Sama
- `resources/views/vendor/scan-tag-harga.blade.php` — Sama
- `resources/views/vendor/kunjungan/index.blade.php` — Sama
- `resources/views/vendor/kunjungan/scan.blade.php` — Sama
- `resources/views/vendor/kunjungan/toko-create.blade.php` — Sama
- `resources/views/vendor/customer/_sidebar.blade.php` — Ditandai deprecated (tidak ada lagi `@include` yang merujuk)

**Decisions:**
- Sidebar CSS dipindah ke partial (`<style>` dalam `<body>`) — HTML5 valid, tradeoff minor untuk eliminasi duplikasi di 10 file
- `@once` di scan modal mencegah duplikasi CSS/JS jika partial di-include dari konteks berbeda
- `vendor.customer._sidebar` dipertahankan sebagai file (tidak dihapus) untuk referensi, tapi dideprekasi — semua halaman sudah pakai `vendor._sidebar`

**Gotchas:**
- `dashboard-vendor.blade.php` punya `</style>` duplikat di baris 1560 — ikut dihapus saat bersihkan scan modal CSS
- `manage-menu.blade.php` pass `showScanBarcode=true` — parameter ini tidak lagi dibutuhkan karena scan button selalu tampil
- Semua halaman butuh `$vendor` di view context — dicek via controller bahwa semua route vendor menyediakannya

**Tests:** 110 passed, 281 assertions.

## 2026-06-10: Admin filter form styling + Vendor user creation bug

**Files touched:**
- `resources/views/admin/layouts/app.blade.php` — tambah CSS `.filter-form input`, `.filter-form select`, `:focus`, `.filter-form label weight`, `.filter-form .btn align`, `.filter-form > div flex: 1` — semua halaman admin filter jadi ter-style konsisten
- `app/Http/Controllers/Admin/VendorUserController.php` — `store()`: validasi + buat `Vendor` record setelah User; `update()`: `Vendor::updateOrCreate` sinkron profil; `edit()`: `$user->load('vendor')`
- `resources/views/admin/vendor-users/create.blade.php` — tambah field Nama Vendor, Kategori, Lokasi, Deskripsi
- `resources/views/admin/vendor-users/edit.blade.php` — tambah field yang sama, pre-fill dari `$user->vendor`
- `routes/web.php:37` — pindah `POST /logout` ke luar grup middleware `auth` supaya bisa diakses saat error 403

**Decisions:**
- Vendor profile auto-created via `Vendor::create()` di `store()` — pengguna tidak lagi terjebak 403 setelah login
- `Vendor::updateOrCreate` di `update()` — handle kasus vendor user lama yg belum punya Vendor record
- Logout route di luar middleware `auth` — `Auth::logout()` aman dipanggil tanpa autentikasi, jadi semua pengguna bisa logout dari halaman error

**Gotchas:**
- Vendor seeder `VendorsSeeder.php` memisahkan pembuatan User dan Vendor — tidak terpengaruh oleh perubahan controller (seed tetap work)
- CSS `flex: 1` di `.filter-form > div` membuat tombol Filter/Reset di transaksi melebar — ditambal dengan `.filter-form .btn { align-self: flex-end }`

## 2026-06-10: Dashboard vendor — hapus Tambah Produk + ganti quarter-circle stat card

**Files touched:**
- `resources/views/dashboard-vendor.blade.php` — hapus `<button class="btn-primary">Tambah Produk</button>` (lines 1267-1272); ganti `.stat-card::before` dari quarter-circle blob (120px circle, top -40% right -20%) ke subtle green dot decor (40px, top -10px right -10px, opacity 0 → .08 on hover)

**Decisions:**
- Quarter-circle (`top: -40%; right: -20%`) diganti dengan decorative dot subtle (`top: -10px; right: -10px; width: 40px; height: 40px; opacity: .08`) yang lebih profesional dan intentional. Hover hanya tampilkan dot (dari opacity 0 → .08), tanpa scale animation.
- Tombol "Tambah Produk" dihapus karena fungsi tambah produk sudah ada di halaman manage-menu (sidebar).

## 2026-06-10: Favicon pindah dari public/favicon/ ke public/ root (Vercel compat)

**Files touched:**
- `public/favicon/*` (8 files) → dipindah ke `public/` root, `public/favicon/` dihapus
- 20 blade files — ganti `{{ asset('favicon/favicon.ico') }}` → `{{ asset('favicon.ico') }}`, dll (semua `favicon/` prefix dihapus)
- `vercel.json` — tambah route `"src": "/(.*\\.(?:ico|png|webmanifest))"` sebelum catch-all PHP agar favicon files disajikan sebagai static files, bukan lewat Laravel

**Decisions:**
- Root-level favicon (`/favicon.ico`) = standar web, browser auto-discover
- Route regex `.*\.(?:ico|png|webmanifest)` catch semua static file extensions — future-proof untuk file static lain
- Tests: 67 passed

## 2026-06-10: Title separator konsistensi + favicon about/artikel

**Files touched:**
- Semua `<title>` — ganti separator dari campuran `–` (en dash), `-` (hyphen), `—` (em dash) menjadi `|` (pipe) konsisten di 21 blade files
- `resources/views/about.blade.php:8` — tambah `<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">`
- `resources/views/artikel/index.blade.php:8` — sama
- `resources/views/artikel/show.blade.php:8` — sama

**Decisions:**
- `|` (pipe) dipilih sebagai separator title karena lebih profesional dan tidak terlihat "AI generic" seperti em dash
- Favicon standard set dari `public/favicon/` dipasang di semua halaman: `favicon.ico`, `favicon-32x32.png`, `favicon-16x16.png`, `apple-touch-icon.png`
- Semua halaman (20 file) sekarang konsisten pakai favicon dari folder `public/favicon/` — menggantikan `favicon.svg` (buatan sendiri) dan builder.io PNG URL
