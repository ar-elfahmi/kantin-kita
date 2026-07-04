# Checklist Implementasi — Kantin Kita

> Panduan step-by-step untuk AI agent. Setiap langkah bersifat **atomik** (satu aksi jelas).
> Referensi utama: [implementation_plan.md](file:///C:/Users/lenov/.gemini/antigravity/brain/1b7dd6e2-65dd-4ed7-b5c9-18dcc816fe63/implementation_plan.md)

---

## Fase 1: Konfigurasi Awal

- [ ] **1. Setup `.env`** — Ubah `DB_CONNECTION` dari `sqlite` ke `mysql`, isi `DB_DATABASE=kantin_kita`, `DB_USERNAME=root`, `DB_PASSWORD=`. Tambahkan `MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`, `MIDTRANS_IS_PRODUCTION=false`.
  > Ref: Section 2

- [ ] **2. Buat database MySQL** — Buat database `kantin_kita` di MySQL (via phpMyAdmin atau terminal Laragon).
  > Perintah: `mysql -u root -e "CREATE DATABASE kantin_kita;"`

- [ ] **3. Buat `config/midtrans.php`** — File konfigurasi yang membaca key dari `.env` (`server_key`, `client_key`, `is_production`, `snap_url`).
  > Ref: Section 8.3

- [ ] **4. Install Midtrans package** — Jalankan `composer require midtrans/midtrans-php`.
  > Ref: Section 8.2

---

## Fase 2: Migrations (urutan sesuai FK)

- [ ] **5. Modifikasi migration `create_users_table`** — Tambahkan kolom `role` (`enum: admin, vendor, customer, guest`, default `customer`). Ubah `email` dan `password` menjadi `nullable`.
  > Ref: Section 3.1

- [ ] **6. Buat migration `create_vendors_table`** — Kolom: `user_id` (FK→users), `nama_vendor`, `deskripsi`, `lokasi`, `kategori`, `rating`, `is_open`, `path_logo`, `timestamps`.
  > Ref: Section 3.2

- [ ] **7. Buat migration `create_kategori_menus_table`** — Kolom: `nama_kategori`, `timestamps`.
  > Ref: Section 3.3

- [ ] **8. Buat migration `create_menus_table`** — Kolom: `vendor_id` (FK→vendors), `kategori_menu_id` (FK→kategori_menus, nullable), `nama_menu`, `deskripsi`, `harga` (integer), `path_gambar`, `is_available`, `timestamps`.
  > Ref: Section 3.4

- [ ] **9. Buat migration `create_pesanans_table`** — Kolom: `user_id` (FK→users), `vendor_id` (FK→vendors), `nama_customer`, `total` (integer), `catatan`, `waktu_pengambilan`, `status_pesanan` (enum: pending, diproses, selesai, dibatalkan), `timestamps`.
  > Ref: Section 3.5

- [ ] **10. Buat migration `create_detail_pesanans_table`** — Kolom: `pesanan_id` (FK→pesanans, cascade), `menu_id` (FK→menus), `jumlah`, `harga`, `subtotal`, `catatan`, `timestamps`.
  > Ref: Section 3.6

- [ ] **11. Buat migration `create_payments_table`** — Kolom: `pesanan_id` (FK→pesanans, cascade), `snap_token`, `transaction_id`, `payment_type` (default 'qris'), `gross_amount`, `status` (enum: pending, settlement, expire, cancel, deny), `paid_at`, `midtrans_response` (json), `timestamps`.
  > Ref: Section 3.7

- [ ] **12. Jalankan `php artisan migrate`** — Pastikan semua tabel berhasil dibuat tanpa error.
  > Ref: Section 6

---

## Fase 3: Models

- [ ] **13. Modifikasi `app/Models/User.php`** — Tambahkan `role` ke `$fillable`, ubah `email`/`password` jadi nullable-friendly, tambah relasi `vendor()` (hasOne), `pesanans()` (hasMany), dan helper `isVendor()`, `isAdmin()`, `isGuest()`.
  > Ref: Section 9.1

- [ ] **14. Buat `app/Models/Vendor.php`** — `$fillable`, `$casts`, relasi: `user()` (belongsTo), `menus()` (hasMany), `pesanans()` (hasMany).
  > Ref: Section 9.2

- [ ] **15. Buat `app/Models/KategoriMenu.php`** — Set `$table = 'kategori_menus'`, `$fillable`, relasi: `menus()` (hasMany).
  > Ref: Section 9.3

- [ ] **16. Buat `app/Models/Menu.php`** — `$fillable`, `$casts`, relasi: `vendor()` (belongsTo), `kategoriMenu()` (belongsTo), `detailPesanans()` (hasMany).
  > Ref: Section 9.4

- [ ] **17. Buat `app/Models/Pesanan.php`** — `$fillable`, relasi: `user()`, `vendor()`, `detailPesanans()` (hasMany), `payment()` (hasOne). Tambahkan scope `scopeSudahDibayar()`.
  > Ref: Section 9.5

- [ ] **18. Buat `app/Models/DetailPesanan.php`** — `$fillable`, relasi: `pesanan()` (belongsTo), `menu()` (belongsTo).
  > Ref: Section 9.6

- [ ] **19. Buat `app/Models/Payment.php`** — `$fillable`, `$casts` (paid_at→datetime, midtrans_response→array), relasi: `pesanan()` (belongsTo).
  > Ref: Section 9.7

---

## Fase 4: Seeders

- [ ] **20. Buat `UsersSeeder`** — 1 admin + 8 vendor. Password: `Hash::make('password')`.
  > Ref: Section 5.1

- [ ] **21. Buat `VendorsSeeder`** — 8 record vendor, setiap vendor terhubung ke user vendor yang sesuai. Gunakan deskripsi & lokasi Bahasa Indonesia.
  > Ref: Section 5.2

- [ ] **22. Buat `KategoriMenusSeeder`** — 5 kategori: Nasi & Lauk, Mie & Bakso, Camilan, Minuman, Dessert.
  > Ref: Section 5.3

- [ ] **23. Buat `MenusSeeder`** — 8 menu Warung Bu Sari + 4 menu Warung Mbok Sri. Link ke vendor & kategori yang benar. Deskripsi Bahasa Indonesia.
  > Ref: Section 5.4

- [ ] **24. (Opsional) Buat `PesanansSeeder`** — 3 pesanan demo (pending, diproses, selesai) + detail + payment.
  > Ref: Section 5.5

- [ ] **25. Daftarkan semua seeder di `DatabaseSeeder.php`** lalu jalankan `php artisan db:seed`.

---

## Fase 5: Autentikasi Vendor

- [ ] **26. Buat `AuthController`** — 3 method: `showLogin()` (GET /login), `login()` (POST /login), `logout()` (POST /logout). Gunakan `Auth::attempt()`, cek `role === 'vendor'`, regenerate session.
  > Ref: Section 7a — kode lengkap tersedia

- [ ] **27. Modifikasi `login.blade.php`** — Ubah `name="identifier"` menjadi `name="email"`. Tambahkan blok `@if($errors->any())` untuk tampil error. Tambahkan `@old('email')` untuk isi ulang email.
  > Ref: Section 7a — Komponen #1

- [ ] **28. Modifikasi `dashboard-vendor.blade.php`** — Ubah tombol logout menjadi `<form method="POST" action="/logout">@csrf ...</form>`.
  > Ref: Section 7a — Komponen #4

---

## Fase 6: Controllers & Routes (Halaman Publik)

- [ ] **29. Buat `HomeController`** — Method `index()` return view `welcome`.
  > Ref: Section 10.1

- [ ] **30. Buat `VendorController`** — Method `index()` (tampilkan semua vendor buka) dan `showMenu($id)` (tampilkan menu vendor tertentu + kategori).
  > Ref: Section 10.3

- [ ] **31. Buat `DashboardController`** — Method `index()` query pesanan yang `sudahDibayar()`, hitung statistik (total hari ini, pesanan masuk, produk terlaris).
  > Ref: Section 10.4

- [ ] **32. Buat `CheckoutController`** — 3 method: `index()` (GET halaman checkout), `store()` (POST /api/checkout → buat guest user + pesanan + Midtrans snap token), `updateStatus()` (POST /api/checkout/update-status → update payment setelah bayar).
  > Ref: Section 10.5 + Section 8.5 + Section 8.6

- [ ] **33. Update `routes/web.php`** — Hapus semua route lama. Tulis route baru: publik (/, /vendor, /vendor/{id}/menu, /checkout), guest middleware (/login), auth middleware (/logout, /dashboard).
  > Ref: Section 11.1

- [ ] **34. Update `routes/api.php`** — Tambahkan: `POST /checkout` dan `POST /checkout/update-status`.
  > Ref: Section 11.2

---

## Fase 7: Integrasi Midtrans di Checkout

- [ ] **35. Tambahkan Snap JS di `checkout.blade.php`** — Load script Midtrans Sandbox Snap sebelum `</body>`.
  > Ref: Section 8.7 — Komponen #1

- [ ] **36. Tambahkan input "Nama Pemesan" di `checkout.blade.php`** — Field baru sebelum tombol Place Order.
  > Ref: Section 7b — Modifikasi Checkout UI

- [ ] **37. Tulis JavaScript checkout di `checkout.blade.php`** — Handle klik Place Order: kumpulkan data cart → POST /api/checkout → `window.snap.pay()` → onSuccess POST /api/checkout/update-status → redirect.
  > Ref: Section 8.7 — Komponen #2

---

## Fase 8: Integrasi Blade dengan Data Dinamis

- [ ] **38. Update `welcome.blade.php`** — Pastikan tombol CTA hero ke `/vendor`, tombol Masuk di navbar ke `/login`.

- [ ] **39. Update `select-vendor.blade.php`** — Ganti data statis dengan `@foreach($vendors)`. Tiap vendor card link ke `/vendor/{{ $vendor->id }}/menu`.
  > Ref: Section 12 — Pemetaan #3

- [ ] **40. Update `menu-vendor.blade.php`** — Ganti data statis menu dengan `@foreach($vendor->menus)`. Tambahkan `data-menu-id` di setiap cart item. Implementasikan filter kategori.
  > Ref: Section 12 — Pemetaan #4

- [ ] **41. Update `checkout.blade.php`** — Cart items dari JavaScript state (localStorage/sessionStorage). Tampilkan data vendor dari route parameter.
  > Ref: Section 12 — Pemetaan #5

- [ ] **42. Update `dashboard-vendor.blade.php`** — Ganti data statis dengan data dari controller: `{{ Auth::user()->vendor->nama_vendor }}`, `@foreach($pesananMasuk)`, statistik dinamis.
  > Ref: Section 12 — Pemetaan #6

---

## Fase 9: Verifikasi Akhir

- [ ] **43. Test login vendor** — Login dengan email vendor dari seeder → pastikan redirect ke `/dashboard`.
- [ ] **44. Test akses publik** — Buka `/vendor` tanpa login → pastikan daftar vendor tampil.
- [ ] **45. Test menu vendor** — Klik vendor → pastikan menu tampil sesuai vendor.
- [ ] **46. Test checkout** — Isi nama, klik Place Order → popup Midtrans muncul.
- [ ] **47. Test pembayaran** — Gunakan Midtrans Sandbox Simulator → bayar QRIS → cek status di database.
- [ ] **48. Test dashboard** — Login vendor → pastikan pesanan yang sudah dibayar muncul.
- [ ] **49. Test proteksi route** — Akses `/dashboard` tanpa login → pastikan redirect ke `/login`.
