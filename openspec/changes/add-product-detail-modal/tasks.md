## 1. Database & Models

- [x] 1.1 Buat migrasi `create_menu_variants_table` dengan kolom: `id`, `menu_id` (FK cascade ke `menus`), `nama` (string), `harga_tambahan` (integer unsigned, default 0), `urutan` (integer unsigned, default 0), `timestamps`.
- [x] 1.2 Buat migrasi `create_menu_toppings_table` dengan kolom: `id`, `menu_id` (FK cascade ke `menus`), `nama` (string), `harga` (integer unsigned, default 0), `urutan` (integer unsigned, default 0), `timestamps`.
- [x] 1.3 Buat model `App\Models\MenuVariant` dan `App\Models\MenuTopping` dengan `$fillable` yang sesuai dan relasi `belongsTo Menu`.
- [x] 1.4 Tambah relasi `variants(): HasMany` (terurut `urutan` ASC) dan `toppings(): HasMany` (terurut `urutan` ASC) di `App\Models\Menu`.
- [x] 1.5 Jalankan `php artisan migrate` lokal dan verifikasi schema sesuai (lihat via `php artisan db:show menu_variants` atau tinker).

## 2. Controller

- [x] 2.1 Update `VendorController@showMenu` agar eager-load `menus.variants` dan `menus.toppings` (jangan hapus eager-load eksisting seperti `menus.kategoriMenu`).
- [x] 2.2 Verifikasi via Laravel debug/log bahwa jumlah query tidak meningkat linier dengan jumlah menu (target ≤ 2 query tambahan untuk variants+toppings). _Eager-load via `with(['menus.variants', 'menus.toppings'])` menghasilkan tepat 1 query masing-masing (where menu_id in ...), tidak bergantung jumlah menu — sesuai jaminan Laravel `with()`._

## 3. Blade view: menu-vendor

- [x] 3.1 Pada setiap `.menu-card` di `resources/views/menu-vendor.blade.php`, tambahkan attribute `data-menu-description`, `data-menu-variants` (JSON encoded `$menu->variants`), dan `data-menu-toppings` (JSON encoded `$menu->toppings`). Pastikan gunakan `@json()` atau `htmlspecialchars(json_encode(...))` untuk aman XSS.
- [x] 3.2 Tambahkan markup `<dialog id="menuDetailModal">` sekali di akhir `<main>` dengan struktur: header (judul "Detail Produk" + tombol close), gambar, nama, deskripsi, harga dasar, section ukuran (radio, tersembunyi by default), section topping (checkbox, tersembunyi by default), textarea catatan (maxlength=255), selector jumlah, label subtotal, dan tombol "Tambah ke Keranjang".
- [x] 3.3 Tambahkan CSS untuk modal: backdrop, layout responsive (mobile full-screen, desktop centered max 480px), warna konsisten dengan variabel design (`--cream`, `--brown`, `--sage`).
- [x] 3.4 Tulis fungsi JS `openMenuDetailModal(card)` yang membaca `data-*` dari kartu, populate modal, reset state (jumlah=1, varian pertama dipilih, toppings none, catatan kosong), dan panggil `dialog.showModal()`. Tambahkan fallback: jika `dialog.showModal` tidak tersedia, jalankan flow lama (increment langsung).
- [x] 3.5 Tulis fungsi JS `computeModalSubtotal()` yang membaca state modal saat ini dan mengembalikan integer subtotal sesuai rumus di design (decision #5). Panggil tiap perubahan input (`change`/`input` events) untuk update label subtotal.
- [x] 3.6 Tulis fungsi JS `submitModalToCart()` yang membangun line item baru (`{menu_id, nama_menu, harga, jumlah, catatan, path_gambar, ukuran, toppings, subtotal_per_unit}`), mencari line existing dengan kombinasi `(menu_id, ukuran, sortedToppingIds, catatan)` yang sama, lalu menjumlahkan `jumlah` atau push entri baru. Setelah itu `saveCart`, `bounceCartBadge`, `dialog.close()`.
- [x] 3.7 Ubah handler tombol `[data-action="increase"]` agar tidak lagi memanggil `setMenuQuantity` langsung — sebagai gantinya, panggil `openMenuDetailModal(card)`.
- [x] 3.8 Ubah handler tombol `[data-action="decrease"]` agar mendukung skema cart multi-line per menu: kurangi line dengan `jumlah` terbesar dulu, decrement 1; jika line jadi 0, hapus dari cart.
- [x] 3.9 Update `syncMenuQuantityControls()` agar menjumlahkan SEMUA line item dengan `menu_id` yang sama (bukan asumsi satu line per menu).
- [x] 3.10 Update `updateCartBadge()` (sudah benar dengan reduce — verifikasi tetap berjalan untuk skema baru).

## 4. Blade view: checkout

- [x] 4.1 Buka `resources/views/checkout.blade.php`, identifikasi bagian render item cart.
- [x] 4.2 Tambahkan render untuk `item.ukuran` (label kecil di bawah nama menu, hanya jika truthy).
- [x] 4.3 Tambahkan render untuk `item.toppings` (chip/list daftar nama, hanya jika array non-kosong).
- [x] 4.4 Pastikan render `item.catatan` (jika sudah ada) tetap aman; tambahkan jika belum.
- [x] 4.5 Gunakan default safe untuk semua field baru (`item.ukuran ?? null`, `item.toppings ?? []`) untuk kompatibilitas cart lama.

> **Scope addition during implementation (user-approved):** karena modal subtotal menyertakan biaya ukuran + topping, server (`CheckoutController@store`) ikut diperluas: terima `items.*.ukuran_id` & `items.*.toppings[]`, hitung ulang unit price = `menu.harga + variant.harga_tambahan + Σ topping.harga`, dan masukkan ringkasan ke kolom `detail_pesanans.catatan` (format `Ukuran: X | Topping: A, B | Catatan: ...`). `cart` items juga membawa `ukuran_id` & `subtotal_per_unit` agar server bisa validasi. `checkout.blade.php` parseCart + payload disesuaikan; line items sekarang diidentifikasi per `data-line-index` (bukan `data-menu-id`) untuk mendukung beberapa konfigurasi per menu.

## 5. Verification

- [x] 5.1 `npm run build` lulus tanpa error. _Built in 469ms, no errors._
- [x] 5.2 `php artisan test` lulus (termasuk `KantinFlowTest`). _98 passed, 253 assertions._
- [ ] 5.3 Manual: load `/vendor/{id}/menu` untuk vendor tanpa varian/topping — klik `+`, modal terbuka, ukuran/topping tersembunyi, tambah ke cart, verifikasi cart di localStorage. _Belum diverifikasi manual oleh user — wajib dicek di browser._
- [ ] 5.4 Manual: seed/insert variants & toppings untuk satu menu lewat tinker, reload halaman, klik `+`, verifikasi ukuran/topping muncul, subtotal real-time benar, submit ke cart. _Belum diverifikasi manual oleh user._
- [ ] 5.5 Manual: tambah 2x menu sama dengan konfigurasi berbeda → cart punya 2 line item; tambah lagi dengan konfigurasi identik salah satu → jumlah ter-merge. _Belum diverifikasi manual oleh user._
- [ ] 5.6 Manual: buka `/checkout`, verifikasi ukuran, topping, dan catatan tampil per line item. _Belum diverifikasi manual oleh user._
- [ ] 5.7 Manual backward compat: secara manual set `kantin_cart` lama (tanpa `ukuran`/`toppings`) di DevTools, reload kedua halaman, pastikan tidak ada error console dan render tetap benar. _Belum diverifikasi manual oleh user._
- [ ] 5.8 Manual: pada browser yang tidak support `<dialog>` (atau simulasi dengan stub), klik `+` tetap menambah item ke cart (fallback behavior). _Belum diverifikasi manual oleh user._

## 6. Documentation

- [x] 6.1 Update `AGENTS.md` bagian "Konvensi frontend state": tambahkan field baru `ukuran`, `toppings`, `subtotal_per_unit` pada `kantin_cart.items[]` dan catatan kompatibilitas mundur.
- [x] 6.2 Tambahkan catatan ringkas di section "Struktur penting untuk agent" tentang tabel baru `menu_variants` & `menu_toppings` (jika relevan dengan alur yang sering disentuh agent).
