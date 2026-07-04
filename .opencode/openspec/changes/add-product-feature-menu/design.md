## Context

Saat ini halaman `/dashboard/menu` (view `resources/views/vendor/manage-menu.blade.php`) menampilkan tabel menu vendor dan tombol "Scan Tag Harga", tapi tidak ada UI untuk menambahkan menu baru. Endpoint server `POST /dashboard/menu/store` (named route `dashboard.menu.store`) di `DashboardController::storeMenu()` sudah ada dan sudah mem-validasi field `nama_menu`, `deskripsi`, `harga`, `kategori_menu_id`, `path_gambar` (image max 2MB), serta `is_available`. Endpoint mengembalikan JSON.

Method `DashboardController::menuList()` saat ini hanya mengirim `vendor` dan `menus` ke view — daftar kategori belum tersedia di sini (meski `DashboardController::index()` sudah mengirim `kategoriMenus` ke dashboard utama).

Stack: Laravel + Blade + vanilla JS, styling kustom (variabel CSS `--cream`, `--brown`, `--green`).

## Goals / Non-Goals

**Goals:**
- Vendor dapat menambah produk/menu baru langsung dari halaman `/dashboard/menu` tanpa pindah halaman.
- Form mencakup field yang sama dengan validasi `storeMenu()` di server.
- UX konsisten dengan styling halaman (palette cream/brown/green, font Poppins, border-radius lembut).
- Submit non-blocking (AJAX), beri umpan balik sukses/gagal yang jelas, dan tabel ter-refresh dengan menu baru.

**Non-Goals:**
- Edit dan hapus menu (akan ditangani di change lain).
- Bulk import / drag-drop CSV.
- Pengelolaan kategori menu (CRUD kategori) — dropdown hanya menampilkan kategori yang sudah ada.
- Generator/preview tag harga dari modal — tetap melalui tombol "Cetak Tag Harga" baris tabel.

## Decisions

### 1. UI: Modal di-halaman vs halaman terpisah
**Keputusan:** Pakai modal overlay di `manage-menu.blade.php`.
**Alasan:** Mempertahankan konteks (vendor sudah melihat daftar menu), tidak perlu route baru, lebih cepat secara UX. Halaman terpisah menambah navigasi tanpa benefit yang jelas untuk form sederhana.

### 2. Submit: AJAX (`fetch`) vs form POST klasik
**Keputusan:** Pakai `fetch` dengan `FormData` (multipart) ke `dashboard.menu.store`.
**Alasan:** Endpoint sudah mengembalikan JSON. AJAX memungkinkan toast sukses & inject baris baru tanpa reload. Fallback: jika gagal, modal tetap terbuka dengan pesan error.

### 3. Refresh tabel: client-side prepend vs full reload
**Keputusan:** Reload halaman setelah sukses (`window.location.reload()` setelah toast singkat).
**Alasan:** Markup baris tabel cukup kompleks (thumbnail, badge kategori, ID barang yang di-generate server, availability). Reload sederhana, konsisten, dan minim bug. Trade-off: kehilangan state scroll, tapi vendor akan diarahkan ke baris baru via highlight `?highlight=ID`. Versi optimis (prepend DOM) bisa dipertimbangkan di iterasi berikutnya.

### 4. Daftar kategori: dikirim dari controller vs fetch terpisah
**Keputusan:** Di-injeksi via Blade dari `menuList()` controller (mirip pola `DashboardController::index()`).
**Alasan:** Sudah ada model `KategoriMenu`; satu query saat render halaman lebih sederhana daripada endpoint AJAX baru.

### 5. Validasi klien
**Keputusan:** HTML5 (`required`, `type="number"`, `accept="image/*"`) + cek ukuran gambar di JS (max 2MB) sebelum submit. Validasi otoritatif tetap di server.
**Alasan:** UX cepat, tapi tidak menggandakan rule. Pesan error server dipetakan ke field bila tersedia.

### 6. CSRF
**Keputusan:** Kirim `X-CSRF-TOKEN` dari `<meta name="csrf-token">` (tambahkan jika belum ada di head).
**Alasan:** Pola standar Laravel untuk request AJAX yang sudah di middleware `web`.

## Risks / Trade-offs

- **Reload setelah sukses** → menghapus state scroll/filter. Mitigasi: redirect ke `#menu-{id}` dan beri highlight CSS singkat.
- **Upload gambar gagal silently** (mis. disk `public` belum di-link) → tangkap error 500 dari server, tampilkan pesan, log via `console.error`. Mitigasi dokumentasi: pastikan `php artisan storage:link`.
- **Kategori kosong** → dropdown jadi placeholder "Tidak ada kategori". Mitigasi: izinkan submit dengan kategori `null` (sudah `nullable` di server).
- **XSS pada preview deskripsi** di tabel sudah aman karena Blade `{{ }}` meng-escape. Modal tidak menampilkan output dari server selain pesan error → escape via `textContent`.

## Migration Plan

Tidak ada perubahan schema DB; tidak perlu migration. Deploy sekali (atomic):
1. Update controller + view.
2. Pastikan `storage:link` aktif di server target.
3. Smoke test: tambah satu menu (dengan & tanpa gambar), verifikasi muncul di tabel.

Rollback: revert commit; tidak ada side-effect persistent selain file gambar yang sudah ter-upload (boleh ditinggal).

## Open Questions

- Apakah perlu field `id_barang` manual di form? **Tentatif: tidak** — server auto-generate via `Menu::booted()`.
- Apakah perlu input multiple image / galeri? **Tentatif: tidak** — schema saat ini hanya `path_gambar` tunggal.
