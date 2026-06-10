## Why

Vendor dashboard currently shows a "Tambah Produk" button that does nothing. Vendor cannot add new menu items from the dashboard — they must go through other means. This blocks vendors from managing their catalog independently.

## What Changes

- Add a working "Tambah Produk" button that opens a modal form on the vendor dashboard
- Create backend endpoint to persist new Menu records with vendor_id, nama_menu, deskripsi, harga, kategori_menu_id, path_gambar, and is_available
- Auto-generate id_barang for each new menu (already handled by Menu model booted())
- Validate input and show success/error feedback
- Refresh the dashboard product list after adding

## Capabilities

### New Capabilities
- `vendor-add-item`: Vendor can add a new menu item via a modal form on the dashboard, including name, description, price, category, image upload, and availability toggle. Submitted data is validated and stored in the `menus` table.

### Modified Capabilities

None.

## Impact

- `app/Http/Controllers/DashboardController.php` — new `storeMenu()` method
- `routes/web.php` — new POST route for menu creation
- `resources/views/dashboard-vendor.blade.php` — add modal form, wire up "Tambah Produk" button
- Requires image upload handling (store in `storage/app/public/menus/`)
- Requires KategoriMenu data seeded so vendor can select a category
