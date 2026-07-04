## Why

Saat ini halaman daftar vendor (`/vendor`, view `select-vendor.blade.php`) dan halaman menu vendor (`/vendor/{id}/menu`, view `menu-vendor.blade.php`) memiliki dimensi kartu yang berbeda (vendor card: grid 3 kolom, tinggi gambar 256px, padding 24px, radius 24px; menu card: grid 4 kolom, tinggi gambar 208px, padding 20px, radius 20px). Ketidakkonsistenan visual ini membuat transisi antar dua halaman terasa kasar. Selain itu, di kedua halaman hanya **sub-elemen kecil** yang clickable: tombol "Order Now" di vendor card dan tombol `+` (atau di rencana ke depan, modal Detail Produk) di menu card. Target hit area kecil ini menyulitkan customer (terutama di mobile) dan tidak sesuai pola e-commerce yang umum di mana seluruh kartu dapat diklik untuk aksi utama.

## What Changes

- Sesuaikan dimensi `.vendor-card` di `select-vendor.blade.php` agar identik dengan `.menu-card` di `menu-vendor.blade.php`:
  - Grid container `repeat(4, 1fr)` di breakpoint desktop (≥1025px); turunkan ke `repeat(3, 1fr)` di 1024px, `repeat(2, 1fr)` di 768px, dan layout horizontal (image + body berdampingan) di ≤768px — mengikuti pola responsive menu card.
  - Tinggi `.card-image-wrap`: 208px (desktop), border-radius card 20px, padding body 20px, gap 24px antar card, shadow `--shadow-sm` saat idle dan `--shadow-md` saat hover.
  - Sesuaikan ukuran tipografi internal (nama vendor, deskripsi, harga) agar proporsional dengan card yang lebih kompak.
- Buat **seluruh** `.vendor-card` di `select-vendor.blade.php` dapat diklik untuk navigasi ke `route('menu', ['id' => $vendor->id])`, bukan hanya tombol "Order Now". Tombol "Order Now" tetap dipertahankan sebagai CTA eksplisit untuk aksesibilitas, namun klik di area manapun kartu memicu navigasi yang sama.
- Buat **seluruh** `.menu-card` di `menu-vendor.blade.php` dapat diklik untuk membuka **modal Detail Produk** (selaras dengan rencana di change `add-product-detail-modal`). Untuk saat ini (sebelum modal dibuat), klik card memicu event `menu-card:open` pada elemen card sehingga handler modal nantinya tinggal mendengarkan event tersebut; sebagai fallback default, dispatch event sekaligus memanggil aksi yang sama dengan tombol `+` (memastikan klik selalu menghasilkan aksi terlihat).
- Pastikan klik pada sub-elemen interaktif di dalam card (wishlist heart, tombol `+`/`-`, link "Order Now") **tidak** memicu klik card-level (gunakan `event.stopPropagation()` atau pengecekan `event.target.closest(...)`).
- Tambahkan affordance keyboard: card mendapat `role="link"` (vendor card) atau `role="button"` (menu card), `tabindex="0"`, dan handler `keydown` untuk `Enter`/`Space` agar setara dengan klik.

## Capabilities

### New Capabilities
- `vendor-card-presentation`: Standar presentasi kartu (dimensi, hit area, keyboard interaction) untuk daftar vendor dan daftar menu, termasuk aturan klik-kartu-penuh dan event delegation.

### Modified Capabilities
<!-- Belum ada spec capability eksisting di openspec/specs/ untuk halaman vendor/menu list. -->

## Impact

- **View**: `resources/views/select-vendor.blade.php` — perubahan CSS untuk grid + dimensi card; tambah wrapper anchor/handler agar seluruh card clickable; markup tombol "Order Now" dijaga (stopPropagation).
- **View**: `resources/views/menu-vendor.blade.php` — perubahan handler JS untuk menambahkan listener klik-kartu, dispatch event `menu-card:open`, dan stopPropagation pada elemen di dalam card (`.wishlist-btn`, `[data-menu-controls]`).
- **Controller/Route**: tidak ada perubahan; route `menu` (`/vendor/{id}/menu`) dan `checkout` sudah tersedia.
- **Backend / DB**: tidak ada perubahan model, migration, atau seeder.
- **Frontend deps**: vanilla JS, tidak ada library baru.
- **Aksesibilitas**: card menjadi target keyboard-navigable; perlu pastikan focus ring terlihat (gunakan `outline` atau `box-shadow` saat `:focus-visible`).
- **Interaksi dengan change lain**:
  - `add-product-detail-modal` (in-flight): event `menu-card:open` yang di-dispatch oleh klik kartu akan menjadi entry point modal — perlu disepakati nama event saat merge.
  - `add-product-feature-menu` (in-flight): hanya menyentuh halaman vendor dashboard (`vendor.manage-menu`), tidak konflik.
- **Backward compatibility**: tidak ada breaking change. Markup `Order Now` dan kontrol `+/-` tetap berfungsi seperti sebelumnya bila JS gagal load (graceful degradation: card biasa, hanya tombol yang clickable).
- **Tests**: feature test smoke untuk memastikan klik card di kedua halaman tidak regress (test bisa berupa Dusk/Playwright snapshot jika tersedia, atau cukup test render markup `role`/`tabindex`/`data-href` di Blade).
