## Why

Saat ini di halaman menu vendor (`/vendor/{id}/menu`, view `resources/views/menu-vendor.blade.php`), tombol `+` langsung menambahkan menu ke `kantin_cart` (localStorage) dengan jumlah=1 dan tanpa opsi konfigurasi. Customer tidak bisa mengatur **jumlah awal**, menulis **catatan** (mis. "tanpa sambal"), memilih **ukuran**/varian (regular, large), atau menambahkan **topping**. Akibatnya pengalaman pemesanan terasa kaku, dan kebutuhan pemesanan yang sangat umum di kantin (porsi besar, level pedas, topping ekstra) tidak tertangani sehingga seringkali harus dikomunikasikan ulang ke vendor secara verbal.

## What Changes

- Tombol `+` pada `menu-card` di `menu-vendor.blade.php` tidak lagi langsung memodifikasi cart, melainkan **membuka modal "Detail Produk"** untuk menu yang bersangkutan.
- Modal menampilkan: gambar menu, nama, deskripsi, harga dasar, **selector jumlah** (min 1), **selector ukuran** (opsional per menu), **daftar topping** (multi-select opsional per menu), **field catatan** (textarea bebas, batas 255 karakter), dan ringkasan **subtotal** yang ter-update real-time.
- Tombol "Tambah ke Keranjang" pada modal yang mengirim payload `{menu_id, jumlah, ukuran, toppings[], catatan, subtotal}` ke `kantin_cart` di localStorage, kemudian menutup modal.
- Tombol `-` pada kartu tetap berfungsi seperti sekarang (mengurangi jumlah pada cart) dan **tidak** membuka modal.
- Jika menu sudah ada di cart dengan konfigurasi yang sama persis (ukuran + toppings + catatan), jumlah di-merge; jika berbeda konfigurasi maka diperlakukan sebagai **line item terpisah** di cart.
- Struktur `kantin_cart.items[]` di localStorage diperluas dengan field `ukuran` (string|null), `toppings` (array of `{id, nama, harga}`), dan `subtotal_per_unit` (int) di samping field eksisting (`menu_id`, `nama_menu`, `harga`, `jumlah`, `catatan`, `path_gambar`).
- Data ukuran & topping berasal dari **tabel baru** `menu_variants` (varian/ukuran) dan `menu_toppings`, dengan relasi `Menu hasMany MenuVariant` dan `Menu hasMany MenuTopping`. Vendor mengisi data ini lewat halaman kelola menu (di luar scope perubahan ini; modal harus jalan sekalipun varian/topping kosong).
- Halaman checkout (`resources/views/checkout.blade.php`) menampilkan catatan, ukuran, dan topping yang dipilih, sehingga vendor menerima detail lengkap saat order dibuat.

## Capabilities

### New Capabilities
- `product-detail-modal`: Modal detail produk pada halaman menu vendor yang memungkinkan customer mengonfigurasi jumlah, ukuran, topping, dan catatan sebelum menambahkan menu ke keranjang.

### Modified Capabilities
<!-- Belum ada spec capability eksisting di openspec/specs/. -->

## Impact

- **View**: `resources/views/menu-vendor.blade.php` — perubahan handler tombol `+`, markup modal, CSS modal, JS untuk render konfigurasi, hitung subtotal, dan submit ke cart.
- **View**: `resources/views/checkout.blade.php` — render ukuran, topping, dan catatan per line item pada ringkasan order.
- **Controller**: `app/Http/Controllers/VendorController@showMenu` perlu eager-load `menus.variants` dan `menus.toppings` agar tersedia di Blade tanpa request tambahan.
- **Model**: tambah `App\Models\MenuVariant` dan `App\Models\MenuTopping`; tambah relasi `variants()` & `toppings()` di `App\Models\Menu`.
- **Migration**: `menu_variants` (id, menu_id, nama, harga_tambahan, urutan) dan `menu_toppings` (id, menu_id, nama, harga, urutan).
- **Frontend state**: skema `kantin_cart` di localStorage diperluas (lihat di atas). Kompatibilitas mundur dijaga: cart lama (tanpa `ukuran`/`toppings`) tetap valid, default diisi `null`/`[]`.
- **Routes**: tidak ada perubahan route — semua interaksi modal client-side.
- **Tests**: feature test baru untuk eager-load varian/topping pada `showMenu`, dan untuk pesanan dengan ukuran/topping/catatan yang sampai ke `detail_pesanans.catatan` di `KantinFlowTest` (atau test baru).
- **Backward compatibility**: tidak ada breaking change pada API. Schema `kantin_cart` di localStorage diperluas additif; entry lama tetap bisa dibaca.
