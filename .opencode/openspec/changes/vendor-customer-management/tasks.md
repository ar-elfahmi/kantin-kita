## 1. Migration & Storage

- [x] 1.1 Create migration `database/migrations/2026_05_22_000001_create_customers_table.php` with all required columns and a foreign key on `vendor_id`
- [x] 1.2 In the same migration, after `Schema::create`, run `DB::statement('ALTER TABLE customers MODIFY foto_blob LONGBLOB NULL')` to upgrade BLOB → LONGBLOB. Guarded with `if (DB::getDriverName() === 'mysql')` so SQLite test environments don't crash.
- [x] 1.3 `php artisan migrate` — completed in 299ms
- [x] 1.4 `php artisan storage:link` — symlink created at `public/storage` → `storage/app/public/`

## 2. Model

- [x] 2.1 Created `app/Models/Customer.php` extending `Model`
- [x] 2.2 `$fillable` covers everything except `foto_blob`; `foto_blob` is added to `$hidden` so it doesn't accidentally serialize into JSON responses or query results; assignment is explicit via `$customer->foto_blob = $bytes; $customer->save();`
- [x] 2.3 `belongsTo(Vendor::class)` relation
- [x] 2.4 Helper methods `hasBlobPhoto()` / `hasPathPhoto()` for clean view conditionals

## 3. Controller

- [x] 3.1 Created `app/Http/Controllers/CustomerController.php`
- [x] 3.2 Private `guardVendor(): Vendor` method centralizes the auth-and-vendor-profile check; called at the top of every public method
- [x] 3.3 `index()` returns latest-first list of vendor's customers
- [x] 3.4 `createBlob()` returns the variant-1 form
- [x] 3.5 `storeBlob()` validates input + data URL regex, decodes base64, sets `foto_blob` directly on the model, saves
- [x] 3.6 `createPath()` returns the variant-2 form
- [x] 3.7 `storePath()` validates the same way, writes the decoded bytes to `storage/app/public/customers/{uuid}.png` via the `public` disk, stores the relative path
- [x] 3.8 `photoBlob(Customer)` enforces vendor ownership, then uses `DB::table('customers')->value('foto_blob')` to fetch raw bytes (bypassing the hidden attribute), returns `Content-Type: image/png` + `X-Content-Type-Options: nosniff` + a private cache header

## 4. Routes

- [x] 4.1 Added a `prefix('dashboard/customer')->name('dashboard.customer.')` group inside the existing `auth` middleware group. 6 routes registered, verified via `php artisan route:list --name=dashboard.customer`

## 5. Views

- [x] 5.1 `resources/views/vendor/customer/_camera_modal.blade.php` — self-contained partial: HTML + CSS + IIFE-scoped JS exposing `window.openCameraModal(callback)` and `window.closeCameraModal()`. Handles permission errors, multi-camera enumeration, snapshot capture, save/cancel.
- [x] 5.2 `resources/views/vendor/customer/_sidebar.blade.php` — extracted sidebar partial (HTML only; assumes parent page provides the sidebar CSS). Used by all three customer views.
- [x] 5.3 `resources/views/vendor/customer/index.blade.php` — table with foto thumbnail (polymorphic source: BLOB endpoint or storage URL), nama/alamat, kota, kecamatan, kodepos, storage-variant badge, created-at. Top-right buttons for both Tambah variants. Success-flash strip. Empty state.
- [x] 5.4 `resources/views/vendor/customer/create-blob.blade.php` — full form, "Ambil Foto" button wires up to camera modal, captured PNG data URL stored in hidden `foto_data_url`, preview thumbnail shown, "Simpan Data" disabled until a photo is captured.
- [x] 5.5 `resources/views/vendor/customer/create-path.blade.php` — identical to create-blob, only differs in `<form action>` and the info-strip wording

## 6. Sidebar nav updates

- [x] 6.1 `dashboard-vendor.blade.php`: inserted "Customer" nav-item after "Tag Harga", dynamic active via `request()->routeIs('dashboard.customer.*')`
- [x] 6.2 `vendor/manage-menu.blade.php`: same Customer nav-item added
- [x] 6.3 Customer views' own sidebar (via partial) handles dynamic active state

## 7. Verify

- [x] 7.1 `php artisan view:cache` compiles cleanly (no Blade syntax errors)
- [x] 7.2 `php artisan route:list --name=dashboard.customer` shows 6 routes
- [x] 7.3 `php -l` on `CustomerController.php` passes
- [x] 7.4 `SHOW COLUMNS FROM customers` confirms `foto_blob` is `longblob` (not the default 64KB-capped `blob`)
- [ ] 7.5 MANUAL (user): log in as vendor; visit `/dashboard/customer`; both Tambah variants complete a photo round-trip; rows show up in the list with thumbnails
- [ ] 7.6 MANUAL (user): confirm blob-stored photo renders via `/dashboard/customer/{id}/photo`; path-stored photo renders via `/storage/customers/{uuid}.png`
- [ ] 7.7 MANUAL (user): on a multi-camera device, "Pilihan Kamera" select actually switches the stream

## 8. Known minor issues / follow-ups

- Dashboard-vendor.blade.php has a **pre-existing** orphan `</nav>` tag at line 1610 (the Scan Barcode button sits outside the `<nav>` but has its own duplicate closing tag). Did NOT touch — out of scope. Browsers tolerate it; HTML5 parser auto-recovers.
- Sidebar HTML is still duplicated between `dashboard-vendor.blade.php` (inline), `vendor/manage-menu.blade.php` (inline), and the new partial `vendor/customer/_sidebar.blade.php`. The customer views use the partial; older views still inline their copy. Refactoring the older views to use the partial is the natural next cleanup step but was deferred to avoid touching shipped code mid-module.
- Camera permission must be granted before `enumerateDevices()` returns useful labels. The JS calls `getUserMedia` first (which prompts), then `enumerateDevices`. Documented in code comments. Works in Chrome/Firefox; Safari behavior may differ.
- Path-variant photos are on the public disk (web-served by URL) — vendor B could in theory access vendor A's photos if they guess the UUID-v4 path. Accepted academic trade-off (mitigated by UUID-v4 unguessability); production would serve through a controller with ownership check, the same way blob-variant photos are served today.
