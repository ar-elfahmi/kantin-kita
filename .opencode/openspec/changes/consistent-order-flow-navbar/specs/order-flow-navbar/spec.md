## ADDED Requirements

### Requirement: Navbar pada alur pesan SHALL konsisten antar halaman
Halaman `/vendor`, `/vendor/{id}/menu`, dan `/checkout` MUST menampilkan navbar dengan struktur yang sama: brand Kantin Kita di kiri, nav-links **Home · Vendors · Cart** di tengah, dan TIDAK ADA elemen tambahan di kanan selain hamburger pada layar sempit.

#### Scenario: Pengguna membuka halaman pilih vendor
- **WHEN** pengguna membuka `/vendor`
- **THEN** navbar MUST menampilkan brand Kantin Kita di kiri dan nav-links `Home`, `Vendors`, `Cart` (tanpa `My Orders`, tanpa `Profile`)

#### Scenario: Pengguna membuka halaman menu vendor
- **WHEN** pengguna membuka `/vendor/{id}/menu`
- **THEN** navbar MUST menampilkan brand, search (eksisting), dan ikon Cart (eksisting) — TANPA avatar profile

#### Scenario: Pengguna membuka halaman checkout
- **WHEN** pengguna membuka `/checkout?vendor_id=X`
- **THEN** navbar MUST menampilkan brand dan nav-links `Home`, `Menu`, `Cart` — TANPA link `Orders`, TANPA notif, TANPA avatar

### Requirement: Navbar SHALL tidak mengandung avatar profile
Pada ketiga halaman alur pesan, navbar MUST tidak merender elemen avatar/foto profil pengguna.

#### Scenario: Pemeriksaan elemen avatar
- **WHEN** halaman `/vendor`, `/vendor/{id}/menu`, atau `/checkout` di-render
- **THEN** DOM-nya MUST tidak mengandung selector `.avatar`, `.avatar-wrap`, atau `.user-avatar` di dalam `<header class="navbar">`

### Requirement: Navbar SHALL tidak mengandung ikon notifikasi/lonceng
Pada ketiga halaman alur pesan, navbar MUST tidak menampilkan tombol notifikasi (lonceng) maupun badge angka notifikasi.

#### Scenario: Pemeriksaan elemen notifikasi
- **WHEN** halaman `/vendor`, `/vendor/{id}/menu`, atau `/checkout` di-render
- **THEN** DOM-nya MUST tidak mengandung selector `.notif-btn`, `.notif-wrapper`, atau `.notif-badge` di dalam `<header class="navbar">`

### Requirement: Navbar SHALL tidak menampilkan link "Orders" / "My Orders"
Nav-links (baik desktop maupun mobile) MUST tidak mengandung item teks `Orders` atau `My Orders` di ketiga halaman alur pesan.

#### Scenario: Pemeriksaan nav-link Orders di desktop
- **WHEN** halaman `/vendor` atau `/checkout` di-render pada viewport ≥ 768px
- **THEN** `.nav-links` MUST tidak mengandung anchor dengan teks `Orders` atau `My Orders`

#### Scenario: Pemeriksaan nav-link Orders di mobile panel
- **WHEN** pengguna membuka hamburger / mobile-nav-panel
- **THEN** panel MUST tidak menampilkan link `Orders`, `My Orders`, atau `Profile`

### Requirement: Active state nav-link SHALL mencerminkan halaman aktif
Nav-link yang berkorespondensi dengan halaman saat ini MUST diberi state `.active` (atau setara) supaya pengguna tahu posisinya dalam alur.

#### Scenario: Halaman pilih vendor
- **WHEN** pengguna di `/vendor`
- **THEN** nav-link `Vendors` MUST ber-state aktif

#### Scenario: Halaman menu vendor
- **WHEN** pengguna di `/vendor/{id}/menu`
- **THEN** nav-link `Vendors` MUST ber-state aktif (menu adalah sub-page dari Vendors)

#### Scenario: Halaman checkout
- **WHEN** pengguna di `/checkout`
- **THEN** nav-link `Cart` MUST ber-state aktif

### Requirement: Cart action SHALL selalu hadir di navbar alur pesan
Setiap halaman alur pesan MUST menampilkan Cart sebagai item navbar (boleh berupa link teks atau tombol ikon) yang menavigasi pengguna ke halaman checkout.

#### Scenario: Cart pada halaman menu vendor
- **WHEN** pengguna di `/vendor/{id}/menu` mengklik ikon Cart
- **THEN** sistem MUST membuka `route('checkout', ['vendor_id' => $vendor->id])`

#### Scenario: Cart pada halaman checkout
- **WHEN** pengguna di `/checkout` melihat nav-link Cart
- **THEN** nav-link MUST hadir dengan state `.active` (sudah berada di Cart)

#### Scenario: Cart pada halaman pilih vendor (vendor belum dipilih)
- **WHEN** pengguna di `/vendor` mengklik nav-link Cart
- **THEN** sistem MUST mengarahkan ke `/vendor` (no-op) ATAU menampilkan hint "Pilih kantin dulu" (implementasi bebas, tidak boleh error)
