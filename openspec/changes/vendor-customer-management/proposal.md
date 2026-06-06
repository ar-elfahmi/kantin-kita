## Why

Module 1 Studi Kasus 3 (`Modul_barcode, qr code, akses kamera.md`) requires a "Customer" menu in the main project with three submenus:
1. **Data Customer** — a table listing all customers
2. **Tambah Customer 1** — capture a photo via webcam and store the image as a BLOB inside the database
3. **Tambah Customer 2** — capture a photo via webcam, save the file to disk, and store the path in the database

The studi kasus is pedagogical: it forces the student to demonstrate two storage strategies (blob vs file-path) side-by-side so the trade-offs (DB size, backup complexity, web-direct-serve, query cost, etc.) become explicit.

No customer concept currently exists in kantin-kita. Guest checkout creates ephemeral `User` rows tagged `role=guest`, but those are not the same as registered/known customers with full address details. This change introduces a first-class `customers` table scoped to each vendor.

## What Changes

- New migration `create_customers_table` with: `vendor_id` FK, `nama`, `alamat`, `provinsi`, `kota`, `kecamatan`, `kelurahan`, `kodepos`, `foto_blob` (LONGBLOB nullable), `foto_path` (string nullable), timestamps
- New `Customer` model with belongsTo Vendor, fillable fields, blob accessor
- New `CustomerController` with: `index`, `createBlob`, `storeBlob`, `createPath`, `storePath`, `photoBlob` (serves the BLOB image bytes for `<img>` rendering)
- New routes under `/dashboard/customer/*`, all in the `auth` middleware group, vendor-guarded (matches the pattern from `DashboardController::menuList`)
- New views: `vendor/customer/index.blade.php`, `vendor/customer/create-blob.blade.php`, `vendor/customer/create-path.blade.php`
- New partial: `vendor/customer/_camera_modal.blade.php` containing the getUserMedia modal HTML + JS (shared between create-blob and create-path)
- "Customer" nav item added to the vendor sidebar in `dashboard-vendor.blade.php` and `vendor/manage-menu.blade.php`
- Run `php artisan storage:link` so `foto_path` images are web-accessible from the `public/storage/customers/` path

## Capabilities

### New Capabilities
- `customer-management`: Vendor can create, list, and view customers with photos stored either as DB blobs or as files on disk

### Modified Capabilities
- (none)

## Impact

- New DB table `customers` with one LONGBLOB column (potentially several MB per row when populated). Backups and replication will grow proportionally — acceptable for an academic project, would be reconsidered in production.
- `storage/app/public/customers/` directory created on first photo upload via path variant
- `public/storage` symlink created (one-time `php artisan storage:link`)
- Three new sidebar nav items wired into two existing views
- No changes to existing routes, models, or schemas
