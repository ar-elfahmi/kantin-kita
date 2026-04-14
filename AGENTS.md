# AGENTS.md

## Tujuan dokumen

Dokumen ini adalah panduan khusus AI coding agent untuk repo ini.

Dokumen ini sengaja dipisahkan dari README karena:

- memberi lokasi instruksi yang konsisten dan mudah diprediksi untuk agent,
- menjaga README tetap ringkas dan fokus untuk kontributor manusia,
- menyediakan konteks teknis yang detail (build, test, konvensi domain) yang tidak selalu relevan untuk semua pembaca.

Format ini bersifat terbuka (bukan proprietary). Jika bermanfaat, silakan diadopsi pada proyek lain.

## Ringkasan stack

- Backend: Laravel 13, PHP 8.3
- Frontend tooling: Vite 8, Tailwind CSS 4
- Package manager frontend: npm (bukan pnpm)
- Pembayaran: Midtrans Snap
- Test framework: PHPUnit (via `php artisan test`)

## Dev environment tips

- Install dependency backend:
    - `composer install`
- Install dependency frontend:
    - `npm install`
- Siapkan environment:
    - `copy .env.example .env` (Windows) atau `cp .env.example .env`
    - `php artisan key:generate`
- Build cepat sekali jalan (script bawaan composer):
    - `composer run setup`
- Jalankan mode development full stack (server, queue, log, vite):
    - `composer run dev`
- Jalankan frontend dev server saja:
    - `npm run dev`

## Database notes

- Runtime app lokal umumnya menggunakan MySQL (lihat rencana implementasi proyek).
- Testing otomatis menggunakan SQLite in-memory (lihat `phpunit.xml`), jadi test tidak butuh database MySQL aktif.
- Untuk reset data lokal saat verifikasi manual:
    - `php artisan migrate:fresh --seed`

## Struktur penting untuk agent

- Route web: `routes/web.php`
- Route API checkout/midtrans: `routes/api.php`
- Checkout + Midtrans logic: `app/Http/Controllers/CheckoutController.php`
- Dashboard vendor logic: `app/Http/Controllers/DashboardController.php`
- Halaman utama frontend Blade:
    - `resources/views/select-vendor.blade.php`
    - `resources/views/menu-vendor.blade.php`
    - `resources/views/checkout.blade.php`
    - `resources/views/dashboard-vendor.blade.php`
- Feature tests utama alur bisnis:
    - `tests/Feature/KantinFlowTest.php`

## Testing instructions

- Folder `.github/workflows` belum tersedia saat dokumen ini dibuat. Anggap perintah lokal berikut sebagai baseline CI.
- Jalankan seluruh test:
    - `php artisan test`
    - atau `composer test`
- Jalankan test spesifik:
    - `php artisan test --filter KantinFlowTest`
    - `php artisan test --filter test_checkout_store_persists_waktu_pengambilan_from_payload`
- Jika mengubah alur backend (controller, model, route, payment status), wajib tambah/update test feature yang relevan.
- Setelah perubahan frontend Blade/asset, pastikan build lolos:
    - `npm run build`

## Konvensi domain yang wajib dipatuhi

- Role user yang dipakai: `admin`, `vendor`, `customer`, `guest`.
- Status pesanan yang dipakai: `pending`, `diproses`, `selesai`, `dibatalkan`.
- Status payment yang dipakai: `pending`, `settlement`, `expire`, `cancel`, `deny`.
- Rule penting:
    - 1 pesanan hanya boleh berisi item dari 1 vendor.
    - Dashboard vendor hanya menampilkan pesanan yang sudah dibayar (`payment.status = settlement`) melalui scope `sudahDibayar()`.
    - Vendor hanya boleh ubah status dari `diproses` ke `selesai`.
- Midtrans endpoints yang dipakai:
    - `POST /api/checkout`
    - `POST /api/checkout/update-status`
    - `POST /api/midtrans/notification`

## Konvensi frontend state

- Local storage keys yang dipakai saat ini:
    - `kantin_cart`
    - `kantin_customer_name`
    - `kantin_pickup_time`
- Jika mengubah struktur cart atau key localStorage, update semua halaman terkait (`menu-vendor` dan `checkout`) serta test yang terdampak.

## Konvensi perubahan kode

- Gunakan perubahan sekecil mungkin, hindari refactor besar yang tidak diminta.
- Pertahankan nama route yang sudah dipakai view/test kecuali memang ada kebutuhan jelas (dan update semua referensi jika diubah).
- Jangan commit secrets (API key, kredensial `.env`).
- Untuk perubahan backend yang mempengaruhi alur bisnis, prioritas validasi:
    1. `php artisan test`
    2. `npm run build` (jika ada perubahan view/js/css)

## PR instructions

- Format judul PR yang disarankan:
    - `[kantin-kita] <judul singkat perubahan>`
- Sebelum commit/merge, jalankan minimal:
    - `php artisan test`
    - `npm run build` (jika ada perubahan frontend)
- Di deskripsi PR, tulis:
    - ringkasan perubahan,
    - daftar file utama yang diubah,
    - langkah verifikasi yang sudah dijalankan.
