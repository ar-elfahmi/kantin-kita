## Context

Halaman `resources/views/menu-vendor.blade.php` adalah single-file Blade view (CSS + JS inline) yang menampilkan kartu menu vendor. Cart customer disimpan client-side di `localStorage` dengan key `kantin_cart` (lihat AGENTS.md). Tombol `+` saat ini langsung memanggil `setMenuQuantity(...)` yang menyentuh localStorage; tidak ada UI untuk konfigurasi per item.

Stack: Laravel 13 + Blade + vanilla JS (tanpa framework SPA). Tailwind tersedia tapi view ini menggunakan CSS kustom dengan variabel design tokens (`--cream`, `--brown`, `--sage`, dll). Tidak ada bundler frontend untuk halaman ini selain Vite untuk build umum.

Data menu hari ini hanya punya `harga` tunggal — belum ada konsep varian/ukuran maupun topping. Vendor di lapangan sering menjual menu dengan opsi ukuran (Reguler/Jumbo) dan topping tambahan, dan customer biasanya menyampaikan permintaan khusus (level pedas, tanpa bawang) lewat catatan.

Stakeholder yang terdampak: customer (UX pemesanan), vendor (menerima detail order yang lebih jelas + perlu UI kelola varian/topping di iterasi berikutnya), serta pengembang yang memelihara struktur cart di `menu-vendor` ↔ `checkout`.

## Goals / Non-Goals

**Goals:**
- Tombol `+` membuka modal detail produk; tombol `-` tetap mengurangi langsung dari cart (zero-friction).
- Modal mendukung: jumlah, catatan bebas, pilih satu ukuran (radio), pilih beberapa topping (checkbox), preview subtotal real-time.
- Modal tetap berguna walau menu tidak punya varian/topping (degradasi: section ukuran/topping disembunyikan jika kosong).
- Konfigurasi yang dipilih ikut tersimpan di cart, ikut tampil di halaman checkout, dan ikut terkirim ke `detail_pesanans` saat order dibuat.
- Tidak ada library JS baru — tetap vanilla JS sesuai konvensi `menu-vendor.blade.php`.
- Backward compatible: cart lama di localStorage (tanpa `ukuran`/`toppings`) tetap valid setelah upgrade.

**Non-Goals:**
- UI vendor untuk **membuat/mengedit** varian & topping (ditunda ke change terpisah; iterasi ini hanya menyediakan tabel + relasi + render di sisi customer; data awal diisi via seeder/manual).
- Mengubah skema `harga` di tabel `menus` atau memindahkan harga dasar ke varian default.
- Validasi server-side baru di endpoint checkout (tetap pakai `CheckoutController` eksisting; `catatan` sudah didukung di `detail_pesanans`).
- Mengubah tombol `-` jadi membuka modal — ini akan terasa repetitif.
- Multi-tab cart sync, real-time stock per varian, atau opsi varian/topping per-line-item dengan availability schedule.

## Decisions

### 1. Modal dirender inline di Blade view, bukan via fetch on-demand

**Pilihan:** Render satu `<dialog id="menuDetailModal">` kosong sekali di `menu-vendor.blade.php`, lalu populate kontennya via JS saat tombol `+` diklik. Data menu (variants & toppings) sudah ada di `data-*` attribute kartu (di-JSON-encode dari Blade saat render).

**Alternatif yang ditolak:** Fetch detail per menu via XHR ke endpoint baru `GET /menu/{id}/detail`. Ditolak karena daftar menu sudah lengkap di server saat render halaman; round-trip tambahan menambah latensi tanpa benefit. Halaman ini sudah eager-load `vendor->menus`.

**Konsekuensi:** Sedikit menambah ukuran HTML awal (variants/toppings di-embed), tapi total payload tetap kecil (puluhan kB) untuk kantin dengan puluhan menu.

### 2. Pakai elemen `<dialog>` HTML native, bukan div + overlay manual

**Pilihan:** `<dialog>` native dengan `.showModal()` & `.close()`. Browser modern (>=2022) support semua, termasuk modal backdrop, ESC-to-close, dan focus trap dasar.

**Alternatif yang ditolak:** Div overlay kustom — perlu re-implement focus trap, ESC handler, scroll lock. Tidak worth it.

**Konsekuensi:** Polyfill tidak disediakan. Browser sangat lama (IE11, Safari <15.4) tidak didukung — sejalan dengan target audience kampus (mahasiswa, mobile modern).

### 3. Tabel terpisah `menu_variants` & `menu_toppings`, bukan JSON column di `menus`

**Pilihan:** Dua tabel relasional dengan FK ke `menus`. Field: `id`, `menu_id`, `nama`, `harga_tambahan` (variants) / `harga` (toppings), `urutan`, timestamps.

**Alternatif yang ditolak:** Simpan `variants` & `toppings` sebagai JSON column di `menus`. Lebih cepat dibuat, tapi menyulitkan reporting (mis. topping terlaris) dan validasi referential di iterasi vendor-edit nanti.

**Konsekuensi:** Dua migrasi tambahan; eager-load wajib di controller agar tidak N+1.

### 4. Line item per kombinasi konfigurasi (bukan agregat per `menu_id`)

**Pilihan:** Cart item adalah `(menu_id, ukuran, sorted(toppings.id), catatan)`. Penambahan dengan konfigurasi sama menambah `jumlah`; beda konfigurasi = entri baru.

**Alternatif yang ditolak:** Selalu satu line per `menu_id`. Akan menggabungkan dua order ukuran Reguler dan Jumbo, padahal subtotal & catatan berbeda — bikin checkout salah.

**Konsekuensi:** Tombol `-` di kartu hanya bisa menurunkan satu line item; jika ada beberapa konfigurasi untuk satu menu, kita kurangi line item dengan jumlah terbesar lebih dulu (sederhana & cukup untuk MVP). Total badge cart tetap menjumlah semua line dengan `menu_id` itu.

### 5. Subtotal per unit = `harga_dasar + harga_ukuran_terpilih + Σ harga_topping_terpilih`

**Pilihan:** Hitung di JS saat user mengubah konfigurasi dan saat submit ke cart. Simpan `subtotal_per_unit` ke item cart agar checkout tidak perlu re-derive.

**Alternatif yang ditolak:** Hitung ulang di server saat checkout — masih akan dilakukan untuk validasi keamanan, tetapi cart UI butuh nilai instan. Jadi simpan di cart untuk display; server tetap recompute saat menerima order (di luar scope perubahan ini).

### 6. Eager-load `variants` & `toppings` di `VendorController@showMenu`

**Pilihan:** `Vendor::with(['menus.variants', 'menus.toppings', 'menus.kategoriMenu'])->findOrFail($id)`.

**Alternatif yang ditolak:** Lazy load per kartu → N+1 query.

### 7. Catatan: textarea bebas, maxlength 255, opsional

Cocok dengan kapasitas kolom `detail_pesanans.catatan` (`text` di MySQL, tapi kita batasi UI ke 255 char untuk konsistensi). Tidak menambah kolom baru.

## Risks / Trade-offs

- **[Risk] Cart lama di localStorage user (tanpa `ukuran`/`toppings`) bisa membuat render checkout error.** → Mitigasi: di `checkout.blade.php`, default `item.ukuran ?? null` dan `item.toppings ?? []`. Tambah test JS minimal (manual checklist di tasks.md) untuk verify cart lama tetap dibaca.
- **[Risk] Tombol `-` jadi ambigu bila ada beberapa line untuk satu menu.** → Mitigasi: kurangi line dengan `jumlah` terbesar dulu; di iterasi UX berikutnya bisa diganti dengan "buka cart untuk pilih line".
- **[Risk] Vendor belum bisa input variants/toppings di UI** → Mitigasi: scope ini sengaja menyertakan migrasi + relasi + render publik supaya iterasi vendor-edit selanjutnya tinggal CRUD; sementara data awal via seeder (opsional, tidak wajib di tasks.md).
- **[Risk] Browser lama tanpa support `<dialog>`** → Mitigasi: dokumentasikan minimal browser di README/AGENTS jika perlu; fitur core checkout tetap jalan, tombol `+` cuma fallback ke increment langsung jika `dialog.showModal` tidak tersedia (`if (!('showModal' in dialog))`).
- **[Trade-off] HTML payload halaman menu sedikit lebih besar karena embed variants/toppings di data attribute.** Untuk vendor dengan ratusan menu mungkin terasa; dianggap acceptable untuk MVP, bisa dipindah ke fetch on-demand jika jadi masalah nyata.
- **[Trade-off] Tidak ada server-side render modal.** Refresh saat modal terbuka tidak mempertahankan state — sesuai ekspektasi modal.

## Migration Plan

1. Tambah migrasi `menu_variants` & `menu_toppings` (additive, tidak menyentuh data eksisting).
2. Tambah model + relasi.
3. Update `VendorController@showMenu` (eager-load) — backward compatible.
4. Update `menu-vendor.blade.php`: tambah modal, ubah handler `+`, perluas skema cart. Embed defensive default untuk cart lama.
5. Update `checkout.blade.php`: render ukuran/topping/catatan, fallback ke `null/[]`.
6. Manual verification: cart lama tetap bisa dibaca → modal jalan tanpa variants → modal jalan dengan variants → multiple konfigurasi sama-menu → checkout menampilkan semua detail.

**Rollback:** Revert Blade + controller perubahan; migrasi bisa dibiarkan (tabel kosong tidak mengganggu). Jika perlu rollback total, `php artisan migrate:rollback --step=2`.

## Open Questions

- Apakah `harga_tambahan` varian boleh negatif (untuk diskon ukuran kecil)? Asumsi awal: **tidak**, dibatasi `>= 0` di migrasi. Konfirmasi sebelum implementasi.
- Apakah batas jumlah maks per item di modal perlu? Asumsi: **tidak ada batas hard** kecuali availability — sesuai perilaku tombol `+` saat ini.
