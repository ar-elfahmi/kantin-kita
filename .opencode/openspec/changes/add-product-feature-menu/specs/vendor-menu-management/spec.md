## ADDED Requirements

### Requirement: Vendor SHALL melihat tombol "Tambah Produk" pada halaman Kelola Menu
Halaman `/dashboard/menu` MUST menampilkan tombol aksi "Tambah Produk" di header panel "Daftar Menu" yang dapat membuka form penambahan menu.

#### Scenario: Vendor membuka halaman kelola menu
- **WHEN** vendor yang sudah login mengakses `/dashboard/menu`
- **THEN** sistem MUST menampilkan tombol "Tambah Produk" di area header panel daftar menu, di samping tombol "Scan Tag Harga"

#### Scenario: Vendor mengklik tombol Tambah Produk
- **WHEN** vendor mengklik tombol "Tambah Produk"
- **THEN** sistem MUST menampilkan modal form tambah produk dalam keadaan kosong (tanpa nilai sebelumnya)

### Requirement: Modal form tambah produk SHALL mengumpulkan data menu baru
Modal MUST berisi field input untuk: nama menu (wajib), kategori menu (opsional, dropdown), harga (wajib, numeric), deskripsi (opsional), gambar (opsional, image), dan status ketersediaan (boolean, default tersedia).

#### Scenario: Field wajib tidak diisi
- **WHEN** vendor menekan "Simpan" tanpa mengisi `nama_menu` atau `harga`
- **THEN** sistem MUST mencegah submit dan menampilkan pesan error pada field yang kosong

#### Scenario: Harga bukan angka
- **WHEN** vendor mengisi `harga` dengan karakter non-numerik
- **THEN** sistem MUST menolak submit dan menampilkan pesan validasi pada field harga

#### Scenario: Gambar melebihi 2MB
- **WHEN** vendor memilih file gambar dengan ukuran > 2MB
- **THEN** sistem MUST menolak file di sisi klien sebelum submit dan menampilkan pesan ukuran maksimum

#### Scenario: Kategori menu tidak ada
- **WHEN** belum ada kategori menu di sistem
- **THEN** dropdown kategori MUST menampilkan placeholder "Tidak ada kategori" dan vendor TETAP dapat menyimpan menu tanpa kategori

### Requirement: Vendor SHALL dapat menyimpan produk baru via AJAX
Form MUST mengirim data sebagai `multipart/form-data` ke endpoint `POST /dashboard/menu/store` dengan header `X-CSRF-TOKEN`, dan menampilkan umpan balik tanpa berpindah halaman saat menunggu respons.

#### Scenario: Submit sukses tanpa gambar
- **WHEN** vendor mengisi `nama_menu` dan `harga` valid lalu menekan "Simpan"
- **THEN** sistem MUST mengirim request ke `dashboard.menu.store`, menerima JSON `{ success: true, menu: {...} }`, menampilkan notifikasi sukses, dan memuat ulang halaman sehingga menu baru tampil di tabel

#### Scenario: Submit sukses dengan gambar
- **WHEN** vendor menyertakan file gambar valid ≤ 2MB
- **THEN** sistem MUST meng-upload gambar ke disk `public` folder `menus/`, menyimpan `path_gambar` di DB, dan menampilkan thumbnail tersebut di kolom Gambar pada tabel setelah reload

#### Scenario: Server mengembalikan error validasi
- **WHEN** server merespons 422 dengan payload error per field
- **THEN** modal MUST tetap terbuka, menampilkan pesan error per field, dan TIDAK me-reload halaman

#### Scenario: Vendor membatalkan
- **WHEN** vendor menekan tombol "Batal" atau menutup modal
- **THEN** sistem MUST menutup modal tanpa mengirim request dan tidak menyimpan perubahan

### Requirement: Sistem SHALL menampilkan menu baru di daftar setelah berhasil disimpan
Setelah penyimpanan sukses, tabel daftar menu MUST mencerminkan menu baru beserta `id_barang` yang di-generate server.

#### Scenario: Verifikasi tampilan menu baru
- **WHEN** vendor berhasil menyimpan menu baru
- **THEN** baris baru MUST muncul di tabel dengan kolom Gambar, Nama Menu, Kategori, ID Barang, Harga (format `Rp x.xxx`), dan Status (Tersedia/Habis) sesuai input

#### Scenario: Counter jumlah menu di-update
- **WHEN** menu baru tersimpan
- **THEN** label "{n} menu" di header panel MUST bertambah satu

### Requirement: Hanya vendor yang berwenang SHALL dapat menambah produk
Endpoint dan UI MUST membatasi penambahan menu hanya untuk user yang memiliki profil vendor terkait.

#### Scenario: User tanpa vendor mencoba submit
- **WHEN** user yang login tetapi tidak memiliki profil vendor mengakses `/dashboard/menu` atau mengirim POST ke `dashboard.menu.store`
- **THEN** sistem MUST menolak dengan HTTP 403 "Vendor profile tidak ditemukan."

#### Scenario: Guest mencoba akses
- **WHEN** user yang belum login membuka `/dashboard/menu`
- **THEN** sistem MUST mengarahkan ke halaman login (middleware `auth`)
