## Why

Halaman vendor `/dashboard/menu` (Kelola Menu & Tag Harga) saat ini hanya menampilkan daftar menu yang sudah ada dan tombol "Scan Tag Harga". Vendor belum dapat menambahkan produk/menu baru langsung dari halaman tersebut, padahal endpoint backend `POST /dashboard/menu/store` sudah tersedia. Akibatnya alur kerja vendor terputus dan tidak intuitif.

## What Changes

- Tambahkan tombol **"Tambah Produk"** pada header panel "Daftar Menu" di view `vendor.manage-menu`.
- Tambahkan **modal form** untuk input produk baru dengan field: nama menu, kategori, harga, deskripsi (opsional), gambar (opsional), dan status ketersediaan.
- Modal dikirim via AJAX (`multipart/form-data`) ke route eksisting `POST /dashboard/menu/store` (`dashboard.menu.store`).
- Setelah sukses, baris menu baru otomatis muncul di tabel tanpa reload (atau dengan reload halaman sebagai fallback), beserta toast/feedback sukses.
- Validasi sisi klien (required, numeric, image max 2MB) selaras dengan validasi server.
- `DashboardController::menuList()` di-update untuk mengirim daftar `kategoriMenus` ke view supaya dropdown kategori terisi.

## Capabilities

### New Capabilities
- `vendor-menu-management`: Kapabilitas vendor untuk mengelola item menu (menambah, dan ke depannya mengedit/menghapus) langsung dari halaman Kelola Menu.

### Modified Capabilities
<!-- Belum ada spec eksisting yang dimodifikasi (folder openspec/specs/ masih kosong). -->

## Impact

- **View**: `resources/views/vendor/manage-menu.blade.php` (tambah tombol, modal, script AJAX).
- **Controller**: `app/Http/Controllers/DashboardController.php` — method `menuList()` perlu menyertakan `kategoriMenus`; method `storeMenu()` sudah ada dan dipakai apa adanya.
- **Routes**: tidak ada perubahan; route `dashboard.menu.store` sudah tersedia.
- **Storage**: upload gambar disimpan di disk `public` folder `menus/` (sudah didukung).
- **Frontend deps**: tidak ada library baru — pakai vanilla JS + `fetch` API.
- **Backward compatibility**: tidak ada breaking change; menambah fitur baru di atas endpoint yang sudah ada.
