## Context

Alur belanja pelanggan punya tiga langkah:
1. `/vendor` → `select-vendor.blade.php` — pilih kantin.
2. `/vendor/{id}/menu` → `menu-vendor.blade.php` — lihat menu, tambah ke cart.
3. `/checkout?vendor_id=X` → `checkout.blade.php` — review pesanan & bayar.

Tiap halaman saat ini mendefinisikan navbar HTML + CSS lokal di file masing-masing. Stylenya berbeda (warna, ukuran, item) dan kontennya berbeda:

| Halaman | Brand | Search | Nav links (desktop) | Tombol kanan |
|---|---|---|---|---|
| `/vendor` | ✅ | ❌ | Home · Vendors · My Orders · Profile | Notif + Avatar |
| `/vendor/{id}/menu` | ✅ | ✅ | (tidak ada nav-links teks) | Cart + Avatar |
| `/checkout` | ✅ | ❌ | Home · Menu · Cart · Orders | Notif + Avatar |

User menginginkan: hilangkan **avatar, link Orders, notif** pada **tiga halaman ini**. Sisanya tetap dipertahankan.

Stack: Blade + CSS kustom (palette cream/brown/sage) — tidak ada framework UI.

## Goals / Non-Goals

**Goals:**
- Tiga halaman menampilkan nav-links teks yang identik: **Home · Vendors · Cart**.
- Tidak ada avatar profile, ikon lonceng/notif, atau link "Orders/My Orders" di kanan navbar.
- Cart tetap berfungsi sebagai pemicu navigasi ke checkout (di `/vendor/{id}/menu` sudah berupa ikon `.cart-btn`; di halaman lain bisa berupa link teks "Cart" atau ikon — yang penting konsisten **konten**, styling boleh sedikit beda).
- Versi mobile (hamburger menu) juga ikut disamakan.

**Non-Goals:**
- Tidak mengekstrak navbar jadi komponen Blade bersama (`@include` partial). Skala kecil + style berbeda per halaman → biaya refactor tidak sebanding sekarang. Catat sebagai future work.
- Tidak menambah ikon search di halaman yang belum punya, dan tidak menghapus search yang sudah ada di `/vendor/{id}/menu`.
- Tidak mengubah navbar halaman lain (welcome, dashboard, manage-menu, admin).
- Tidak menambah link "Orders" yang fungsional — pesanan ditelusur via `Order ID` di checkout success page (di luar scope).

## Decisions

### 1. Pendekatan: edit per-file vs ekstrak partial
**Keputusan:** Edit per-file (tiga view), hapus markup + style yang tidak terpakai.
**Alasan:** Tiga halaman ini tidak menggunakan layout induk Blade yang sama, dan masing-masing punya CSS scoped. Mengekstrak ke partial membutuhkan koordinasi CSS dan variabel context — overhead besar untuk perubahan kecil. Future work: kalau navbar kustomer makin kompleks, ekstrak ke `resources/views/partials/order-nav.blade.php`.

### 2. Cart di `/vendor` dan `/checkout`
**Keputusan:**
- `/vendor`: tampilkan **link teks "Cart"** di nav-links (mengarah ke `/vendor` saja jika vendor belum dipilih — tidak bisa ke checkout karena tidak ada vendor_id). Atau lebih sederhana: tampilkan Cart sebagai item nav-link tapi dengan `aria-disabled` atau tooltip "Pilih vendor dulu". **Pilihan final:** tampilkan **sebagai nav-link teks** mengarah ke `route('vendor')` (no-op friendly) dengan tooltip — keputusan ringan, tidak menambah komponen baru.
- `/vendor/{id}/menu`: pertahankan **`.cart-btn` (ikon)** yang sudah ada karena fungsional (badge count cart per vendor) dan sudah teruji.
- `/checkout`: tampilkan **link teks "Cart"** dengan state `.active` (sudah ada).

**Alasan:** Konsistensi *konten* (selalu ada Cart) lebih penting daripada konsistensi visual sempurna di halaman dengan kebutuhan berbeda. Ikon cart di menu-vendor punya badge count yang non-trivial untuk dipindah ke desain link teks → biarkan.

### 3. Active state
**Keputusan:** Pakai `request()->routeIs()` di Blade untuk menandai `.active` per halaman.
- `/vendor` → `Vendors` aktif.
- `/vendor/{id}/menu` → `Vendors` aktif (sub-page dari Vendors).
- `/checkout` → `Cart` aktif.

### 4. Cleanup CSS
**Keputusan:** Hapus blok CSS `.notif-btn`, `.notif-wrapper`, `.notif-badge`, `.avatar-wrap`, `.user-avatar`, `.avatar` di tiga file ini agar tidak meninggalkan dead code.
**Alasan:** Style ini didefinisikan lokal per file — aman dihapus. Dashboard pakai CSS terpisah (di `dashboard-vendor.blade.php`).

### 5. Mobile nav panel
**Keputusan:** Samakan isi `mobile-nav-panel` dengan desktop nav-links (Home, Vendors, Cart). Hapus "My Orders", "Profile", "Orders" versi mobile juga.

## Risks / Trade-offs

- **CSS dead code di file lain** → low risk; saya hanya menyentuh tiga file yang disebut user.
- **Link Cart di `/vendor` tanpa vendor_id** → mengarah ke `/vendor` itu sendiri (no-op). Bukan ideal, tapi konsisten dan tidak rusak. Mitigasi: tooltip "Pilih kantin dulu".
- **Visual cart icon vs cart text** beda antara `/vendor/{id}/menu` dan dua halaman lain → trade-off sengaja (lihat keputusan 2). Kalau di-review tampak janggal, iterasi berikutnya bisa pakai ikon di semua tempat.
- **User berharap juga melihat jumlah cart** di `/vendor` & `/checkout` → di luar scope; hanya `/vendor/{id}/menu` yang punya `.cart-badge` saat ini.

## Migration Plan

Hanya edit view + CSS, tidak ada DB/migration. Deploy atomic:
1. Update tiga view.
2. Clear view cache: `php artisan view:clear`.
3. Smoke test ketiga halaman di browser desktop & mobile width.

Rollback: revert commit.

## Open Questions

- Apakah perlu memunculkan cart-badge angka di nav-link teks "Cart" pada `/checkout` & `/vendor`? → Tentatif **tidak** untuk sekarang (butuh session/cart state global yang belum ada).
- Versi mobile: apakah hamburger panel di `/vendor` perlu dihilangkan total kalau item < 4? → **Tidak**, biarkan tetap (Home/Vendors/Cart cukup di hamburger pada layar sempit).
