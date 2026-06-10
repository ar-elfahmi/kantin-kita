## 1. select-vendor.blade.php (`/vendor`)

- [x] 1.1 Di `<nav class="main-nav">`, hapus `<a>` "My Orders" dan "Profile". Tambahkan `<a>` "Cart" (href: `route('vendor')` untuk no-op aman). Sesuaikan urutan jadi: Home · Vendors · Cart
- [x] 1.2 Set state aktif: nav-link "Vendors" dapat class `active` (gunakan `request()->routeIs('vendor')`)
- [x] 1.3 Hapus seluruh `<div class="header-actions">` (berisi `notif-btn` dan `avatar-wrap`) dari navbar
- [x] 1.4 Di `mobile-nav-panel`, hapus link "My Orders" dan "Profile"; tambahkan "Cart" agar isinya: Home · Vendors · Cart
- [x] 1.5 Hapus blok CSS yang tidak terpakai lagi: `.notif-btn`, `.notif-badge`, `.avatar-wrap`, `.header-actions` (jika hanya dipakai untuk dua elemen di atas)

## 2. menu-vendor.blade.php (`/vendor/{id}/menu`)

- [x] 2.1 Di `<div class="navbar-actions">`, hapus `<div class="user-avatar">` (jangan sentuh `cart-btn`)
- [x] 2.2 (Opsional) Tambahkan nav-links teks Home · Vendors · Cart di tengah navbar agar **konten** sejajar dengan halaman lain. Jika menyebabkan masalah layout (search-wrapper mendominasi), boleh dilewati — search & cart-btn tetap dianggap memenuhi requirement Cart-action. **Dilewati per disain (search + cart-icon).**
- [x] 2.3 Hapus blok CSS `.user-avatar` dan `.user-avatar img` di `<style>` lokal

## 3. checkout.blade.php (`/checkout`)

- [x] 3.1 Di `<div class="nav-links">`, hapus `<a>` "Orders". Pastikan urutan: Home · Menu · Cart (Cart dengan `active`). **Catatan implementasi: "Menu" diganti jadi "Vendors" agar konsisten dengan /vendor.**
- [x] 3.2 Hapus seluruh `<div class="nav-actions">` (berisi `notif-wrapper` + `img.avatar`) dari navbar
- [x] 3.3 Di `mobile-nav-panel`, hapus link "Orders" (juga ganti Menu → Vendors)
- [ ] 3.4 Hapus juga link "My Orders" dan "Profile" di footer (`class="footer-link"` yang mengarah ke `route('login')`) untuk konsistensi — opsional, konfirmasi user jika ragu. **Dilewati — di luar scope navbar; user spesifik minta navbar saja.**
- [x] 3.5 Hapus blok CSS `.notif-wrapper`, `.notif-badge`, `.avatar`, `.nav-actions` yang tidak lagi terpakai

## 4. Verifikasi

- [x] 4.1 Jalankan `php artisan view:clear`
- [ ] 4.2 Smoke test desktop (≥1024px): buka `/vendor`, `/vendor/{id}/menu` (pakai id valid, mis. 6), `/checkout?vendor_id=6` — periksa: tidak ada avatar, tidak ada notif, tidak ada link Orders
- [ ] 4.3 Smoke test mobile (≤640px): buka hamburger di `/vendor` dan `/checkout` — pastikan panel hanya berisi Home · Vendors · Cart
- [ ] 4.4 Cek active state benar pada masing-masing halaman
- [x] 4.5 Lighthouse/devtools: pastikan tidak ada console error karena selector JS yang menargetkan elemen yang dihapus (`document.querySelector('.notif-btn')` dll.) — grep konfirmasi: tidak ada JS yang mereferensikan selector yang dihapus

## 5. Cleanup & dokumentasi

- [x] 5.1 Tambah entry singkat di `CONTEXT.md` mencatat penyamaan navbar
- [x] 5.2 Cari sisa string "notif-" / "avatar" / "Orders" di tiga file dengan `grep` untuk memastikan tidak ada residu yang lupa
