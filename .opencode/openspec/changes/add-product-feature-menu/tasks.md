## 1. Backend / Controller

- [x] 1.1 Update `DashboardController::menuList()` agar mengambil `KategoriMenu::orderBy('nama_kategori')->get()` dan mengirimnya ke view sebagai `kategoriMenus`
- [x] 1.2 Verifikasi `storeMenu()` mengembalikan error 422 dengan struktur `{ message, errors: { field: [...] } }` (default Laravel `ValidationException::render`); kalau belum, sesuaikan
- [x] 1.3 (Opsional) Tambah header `Accept: application/json` handling pada `storeMenu()` agar pasti me-return JSON saat AJAX

## 2. View: tombol & modal

- [x] 2.1 Pastikan `<meta name="csrf-token" content="{{ csrf_token() }}">` ada di `<head>` `resources/views/vendor/manage-menu.blade.php`
- [x] 2.2 Tambah tombol "Tambah Produk" di samping tombol "Scan Tag Harga" pada panel-header `Daftar Menu` (class `.btn-cetak` atau varian baru `.btn-primary`)
- [x] 2.3 Bangun markup modal `#modal-add-product` dengan overlay + container form (mirip pola modal lain di project, mis. `_scan_barcode_modal`)
- [x] 2.4 Tambah field form: `nama_menu` (text, required), `kategori_menu_id` (select dari `$kategoriMenus`, optional), `harga` (number, min=0, required), `deskripsi` (textarea, max 1000), `path_gambar` (file, accept image/*), `is_available` (checkbox, default checked)
- [x] 2.5 Tambah tombol "Batal" (close modal) dan "Simpan" (submit), serta area `.form-error` per field

## 3. Styling

- [x] 3.1 Tambah CSS untuk overlay modal (semi-transparent, `position: fixed; inset: 0;`), card form (radius `--radius-lg`, padding 24px, max-width 520px), label & input (border `--brown-20`, focus `--green`)
- [x] 3.2 Variasi tombol primary hijau (`--green`) untuk "Simpan" supaya beda dari `.btn-cetak`
- [x] 3.3 State `.is-open` pada modal (toggle via JS) untuk fade-in
- [x] 3.4 Responsive: pada layar < 640px, modal jadi full-width dengan margin 16px

## 4. JavaScript

- [x] 4.1 Bind klik tombol "Tambah Produk" → buka modal, reset form
- [x] 4.2 Bind klik overlay / tombol "Batal" / tombol close → tutup modal
- [x] 4.3 Validasi klien sebelum submit: cek `nama_menu` non-empty, `harga` numeric ≥ 0, file gambar ≤ 2MB
- [x] 4.4 Submit handler `fetch(route, { method: 'POST', body: FormData, headers: { 'X-CSRF-TOKEN', 'Accept': 'application/json' } })`
- [x] 4.5 Handle response: 200/201 → toast sukses + `window.location.reload()`; 422 → render error per field; lainnya → toast error generik
- [x] 4.6 Disable tombol submit + tampilkan spinner saat request berjalan

## 5. Verifikasi

- [ ] 5.1 Smoke test manual: tambah menu tanpa gambar → muncul di tabel dengan `id_barang` ter-generate
- [ ] 5.2 Smoke test manual: tambah menu dengan gambar valid (~500KB) → thumbnail tampil
- [ ] 5.3 Smoke test manual: submit tanpa nama → pesan error tampil di field
- [ ] 5.4 Smoke test manual: submit gambar > 2MB → tertolak di klien
- [ ] 5.5 Smoke test manual: user tanpa vendor → 403 (test via tinker / route langsung)
- [x] 5.6 Pastikan `php artisan storage:link` sudah jalan di environment dev

## 6. Dokumentasi & cleanup

- [x] 6.1 Update `CONTEXT.md` / `task.md` jika perlu mencatat fitur baru
- [x] 6.2 Pastikan tidak ada `console.log` debugging tersisa di JS
- [x] 6.3 Jalankan `php artisan route:list | grep menu` untuk konfirmasi route tetap konsisten
