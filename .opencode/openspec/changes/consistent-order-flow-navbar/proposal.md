## Why

Tiga halaman dalam alur pesan/order pelanggan (`/vendor`, `/vendor/{id}/menu`, `/checkout`) saat ini memakai struktur navbar yang berbeda-beda — sebagian menampilkan avatar profile, link "Orders", dan ikon notifikasi/lonceng yang **tidak fungsional** (semua mengarah ke halaman login atau hanya hiasan). Akibatnya pengalaman terasa pecah: pengguna melihat menu yang berubah-ubah antar langkah, dan elemen non-fungsional menambah noise visual. Tujuan change ini: menyamakan navbar di tiga halaman tersebut dan menghapus elemen yang belum dipakai (profile, Orders, notif) supaya alur belanja terasa satu kesatuan.

## What Changes

- Hapus tombol notifikasi (`.notif-btn` / `.notif-wrapper` + badge angka) di:
  - `select-vendor.blade.php` (`/vendor`)
  - `checkout.blade.php` (`/checkout`)
- Hapus avatar profile di kanan navbar:
  - `select-vendor.blade.php` (`.avatar-wrap`)
  - `menu-vendor.blade.php` (`.user-avatar`)
  - `checkout.blade.php` (`.avatar`)
- Hapus nav-link **"Orders"** / **"My Orders"** di:
  - `select-vendor.blade.php` (desktop & mobile)
  - `checkout.blade.php` (desktop & mobile)
- Sesuaikan struktur nav-links agar identik di tiga halaman: **Home · Vendors · Cart**. Item **Cart** di-render sebagai ikon tombol (sudah ada di `menu-vendor.blade.php`) yang membawa ke `route('checkout', ['vendor_id' => ...])` kalau konteks vendor diketahui, atau disabled/`/vendor` redirect kalau belum.
- Item nav aktif (`.active`) di-set sesuai halaman: Vendors aktif di `/vendor`, Vendors aktif di `/vendor/{id}/menu` (dengan sub-context), Cart aktif di `/checkout`.
- Hapus juga link "Profile" di mobile-nav-panel (`select-vendor`) supaya konsisten.

## Capabilities

### New Capabilities
- `order-flow-navbar`: Navbar tunggal yang konsisten untuk seluruh alur pemesanan pelanggan (pilih vendor → lihat menu → checkout). Mendefinisikan struktur (brand, nav-links, cart action), elemen yang dilarang (avatar, Orders, notif), dan rule active state.

### Modified Capabilities
<!-- Belum ada spec eksisting (openspec/specs/ kosong). -->

## Impact

- **Views**: `resources/views/select-vendor.blade.php`, `resources/views/menu-vendor.blade.php`, `resources/views/checkout.blade.php` — hapus markup avatar/notif/Orders + samakan struktur nav-links.
- **CSS**: blok styling untuk `.notif-btn`, `.notif-wrapper`, `.notif-badge`, `.avatar-wrap`, `.user-avatar`, `.avatar` di tiga file boleh dihapus juga (cleanup), tapi opsional — bisa ditinggal kalau dipakai dashboard vendor.
- **Routing**: tidak ada perubahan.
- **JS**: tidak ada handler aktif untuk notif/avatar yang dilepas — aman.
- **Halaman lain (TIDAK terdampak)**: `welcome.blade.php`, `dashboard-vendor.blade.php`, `manage-menu.blade.php`, dan halaman vendor/admin lain tetap memakai navbar masing-masing.
- **Backward compatibility**: tidak ada breaking change pada API/data; hanya UI.
