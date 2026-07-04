## ADDED Requirements

### Requirement: Open modal from menu card add button
Halaman menu vendor SHALL membuka modal "Detail Produk" untuk menu yang sesuai ketika customer mengeklik tombol `+` pada `menu-card`, dan TIDAK BOLEH lagi langsung menambahkan menu ke `kantin_cart` di interaksi tersebut.

#### Scenario: Plus button opens modal
- **WHEN** customer mengeklik tombol `+` pada salah satu `menu-card` di `/vendor/{id}/menu`
- **THEN** elemen `<dialog id="menuDetailModal">` ditampilkan via `.showModal()`
- **AND** isi modal terpopulate dengan data menu yang diklik (nama, deskripsi, gambar, harga dasar)
- **AND** `kantin_cart` di localStorage TIDAK berubah sampai customer menekan "Tambah ke Keranjang"

#### Scenario: Minus button still decrements directly
- **WHEN** customer mengeklik tombol `-` pada `menu-card` yang sudah ada di cart
- **THEN** jumlah item terkait pada `kantin_cart` berkurang 1 tanpa membuka modal
- **AND** badge cart ter-update

### Requirement: Modal renders configurable options
Modal SHALL merender bagian konfigurasi sesuai data menu: selector jumlah (default 1, min 1), bagian "Ukuran" sebagai radio jika menu memiliki minimal satu `MenuVariant`, bagian "Topping" sebagai checkbox jika menu memiliki minimal satu `MenuTopping`, dan textarea "Catatan" (maks 255 karakter) yang selalu tampil.

#### Scenario: Menu without variants or toppings
- **WHEN** customer membuka modal untuk menu tanpa varian dan tanpa topping
- **THEN** bagian "Ukuran" dan "Topping" disembunyikan
- **AND** bagian jumlah dan catatan tetap tampil
- **AND** subtotal awal sama dengan `harga × jumlah`

#### Scenario: Menu with variants and toppings
- **WHEN** customer membuka modal untuk menu dengan 2 varian (Reguler Rp 0, Jumbo Rp 5000) dan 2 topping (Telur Rp 4000, Keju Rp 3000)
- **THEN** bagian "Ukuran" menampilkan dua radio dengan varian pertama terpilih default
- **AND** bagian "Topping" menampilkan dua checkbox tanpa default tercentang

### Requirement: Subtotal updates in real time
Modal SHALL meng-update tampilan subtotal setiap kali customer mengubah jumlah, ukuran, atau seleksi topping. Subtotal SHALL dihitung sebagai `(harga_dasar + harga_tambahan_ukuran_terpilih + Σ harga_topping_terpilih) × jumlah`.

#### Scenario: Subtotal recalculates on change
- **GIVEN** menu dengan harga dasar Rp 15.000, varian Jumbo (+Rp 5.000), topping Telur (+Rp 4.000)
- **WHEN** customer memilih Jumbo, mencentang Telur, dan mengatur jumlah ke 2
- **THEN** label subtotal modal menampilkan `Rp 48.000`

#### Scenario: Quantity cannot go below 1
- **WHEN** customer menekan tombol kurang pada selector jumlah modal ketika jumlah = 1
- **THEN** jumlah tetap 1 dan subtotal tidak berubah

### Requirement: Add to cart writes structured line item
Menekan tombol "Tambah ke Keranjang" SHALL menulis line item ke `kantin_cart.items[]` di localStorage dengan field minimal: `menu_id`, `nama_menu`, `harga` (harga dasar menu), `jumlah`, `catatan`, `path_gambar`, `ukuran` (string nama varian atau `null`), `toppings` (array `{id, nama, harga}` atau `[]`), dan `subtotal_per_unit` (int). Setelah ditulis, modal SHALL tertutup dan badge cart ter-update.

#### Scenario: Add to cart from fresh state
- **GIVEN** `kantin_cart` kosong dan customer memilih Jumbo + Telur, jumlah 2, catatan "tidak pedas"
- **WHEN** customer menekan "Tambah ke Keranjang"
- **THEN** `kantin_cart.items` berisi satu entri dengan `ukuran="Jumbo"`, `toppings=[{id:..., nama:"Telur", harga:4000}]`, `catatan="tidak pedas"`, `jumlah=2`, `subtotal_per_unit=24000`
- **AND** modal tertutup
- **AND** badge cart menampilkan `2`

#### Scenario: Adding same config merges quantity
- **GIVEN** cart sudah berisi satu line item untuk menu A dengan ukuran Jumbo, topping [Telur], catatan "tidak pedas", jumlah 2
- **WHEN** customer menambah menu A lagi via modal dengan konfigurasi identik dan jumlah 1
- **THEN** cart tetap satu line item untuk konfigurasi tersebut dengan `jumlah=3`

#### Scenario: Different config creates new line item
- **GIVEN** cart sudah berisi satu line item untuk menu A dengan ukuran Reguler
- **WHEN** customer menambah menu A lagi via modal dengan ukuran Jumbo
- **THEN** cart berisi dua line item terpisah untuk menu A

### Requirement: Cart schema is backward compatible
Halaman menu vendor dan halaman checkout SHALL tetap dapat membaca `kantin_cart` lama yang dibuat sebelum perubahan (tanpa field `ukuran`, `toppings`, atau `subtotal_per_unit`) tanpa error JS.

#### Scenario: Reading legacy cart entry
- **GIVEN** `kantin_cart.items[0]` di localStorage berisi `{menu_id, nama_menu, harga, jumlah, catatan, path_gambar}` saja
- **WHEN** halaman menu vendor di-load dan `syncMenuQuantityControls()` berjalan
- **THEN** tidak ada exception
- **AND** badge dan kontrol jumlah pada kartu menampilkan akumulasi jumlah dari entri tersebut

#### Scenario: Checkout renders legacy entry
- **GIVEN** cart memuat satu line item tanpa `ukuran` & `toppings`
- **WHEN** customer membuka `/checkout`
- **THEN** baris item tetap dirender dengan nama, harga, jumlah, dan catatan; bagian ukuran/topping tidak ditampilkan untuk item tersebut

### Requirement: Checkout displays variant, toppings, and notes per line item
Halaman checkout (`resources/views/checkout.blade.php`) SHALL menampilkan ukuran (jika ada), daftar topping (jika ada), dan catatan (jika ada) per line item, sehingga vendor dapat melihat detail order sebelum membayar.

#### Scenario: Render full configuration on checkout
- **GIVEN** cart memiliki line item dengan ukuran "Jumbo", topping ["Telur", "Keju"], catatan "tidak pedas"
- **WHEN** customer membuka `/checkout`
- **THEN** baris item menampilkan label ukuran "Jumbo", daftar topping "Telur, Keju", dan teks catatan "tidak pedas"

### Requirement: Menu detail data is server-rendered without extra request
`VendorController@showMenu` SHALL eager-load relasi `menus.variants` dan `menus.toppings` saat merender halaman menu vendor, dan view SHALL meng-embed data tersebut pada `data-*` attribute kartu (JSON-encoded) sehingga modal dapat dirender tanpa request tambahan.

#### Scenario: Eager loading avoids N+1
- **WHEN** request `GET /vendor/{id}/menu` dilayani dan vendor punya 10 menu
- **THEN** jumlah query database untuk memuat variants/toppings ≤ 2 (satu per relasi), bukan 10+

#### Scenario: Data attribute carries variants and toppings
- **WHEN** halaman dirender untuk menu yang memiliki varian/topping
- **THEN** elemen `.menu-card` memiliki attribute `data-menu-variants` dan `data-menu-toppings` berisi JSON array yang valid

### Requirement: Menu may have variants and toppings via dedicated tables
Sistem SHALL menyediakan tabel `menu_variants` dan `menu_toppings` dengan foreign key `menu_id` (cascade on delete) dan field harga (`harga_tambahan` untuk variants, `harga` untuk toppings) yang `>= 0`. Model `App\Models\Menu` SHALL meng-expose relasi `variants()` (HasMany) dan `toppings()` (HasMany), terurut oleh kolom `urutan` ASC.

#### Scenario: Variants ordered by urutan
- **GIVEN** menu memiliki 3 varian dengan `urutan` 2, 1, 3
- **WHEN** `$menu->variants` di-akses
- **THEN** collection terurut dengan `urutan` 1, 2, 3

#### Scenario: Deleting menu cascades to variants and toppings
- **WHEN** sebuah menu dihapus
- **THEN** semua baris `menu_variants` dan `menu_toppings` dengan `menu_id` tersebut juga terhapus
