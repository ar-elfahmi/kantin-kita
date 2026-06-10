## ADDED Requirements

### Requirement: Konsistensi dimensi vendor card dan menu card

Sistem SHALL merender `.vendor-card` di `/vendor` (`select-vendor.blade.php`) dengan dimensi visual yang identik dengan `.menu-card` di `/vendor/{id}/menu` (`menu-vendor.blade.php`), mencakup border-radius, padding body, tinggi image wrapper, dan shadow idle/hover.

#### Scenario: Render vendor card di desktop ≥1025px
- **WHEN** customer membuka `/vendor` di viewport ≥1025px
- **THEN** `.vendors-grid` SHALL memakai `grid-template-columns: repeat(4, 1fr)` dengan `gap: 24px`
- **AND** setiap `.vendor-card` SHALL memakai `border-radius: 20px`, `.card-image-wrap` tinggi `208px`, dan `.card-body` padding `20px`
- **AND** shadow idle SHALL setara `0 1px 2px rgba(0,0,0,.05)` dan shadow hover setara `0 4px 6px rgba(0,0,0,.07), 0 10px 20px rgba(0,0,0,.06)`

#### Scenario: Render vendor card di tablet 768–1024px
- **WHEN** customer membuka `/vendor` di viewport 768–1024px
- **THEN** `.vendors-grid` SHALL memakai `grid-template-columns: repeat(3, 1fr)` dengan gap konsisten

#### Scenario: Render vendor card di mobile ≤768px
- **WHEN** customer membuka `/vendor` di viewport ≤768px
- **THEN** setiap `.vendor-card` SHALL memakai layout horizontal (image + body berdampingan), tinggi minimum `126px`, image wrapper lebar `126px`, mengikuti pola `.menu-card` mobile yang sudah ada

#### Scenario: Konsistensi token antara dua halaman
- **WHEN** developer mengubah token dimensi card di salah satu file view
- **THEN** spec SHALL mewajibkan token dengan nilai yang identik (`--card-radius`, `--card-image-h`, `--card-body-pad`, `--card-gap`, `--card-shadow-idle`, `--card-shadow-hover`) didefinisikan di kedua file dengan nilai yang sama

### Requirement: Seluruh area vendor card dapat diklik untuk navigasi ke menu

Sistem SHALL mendukung klik pada area manapun dari `.vendor-card` untuk menavigasi ke halaman menu vendor terkait (`route('menu', ['id' => $vendor->id])`), kecuali bila klik berasal dari sub-elemen interaktif di dalam card.

#### Scenario: Klik area kosong card
- **WHEN** customer mengklik bagian image, nama vendor, deskripsi, atau area kosong di dalam `.vendor-card`
- **THEN** browser SHALL melakukan navigasi ke URL `route('menu', ['id' => $vendor->id])` sebagaimana ditentukan oleh atribut `data-href` card

#### Scenario: Klik tombol Order Now di dalam card
- **WHEN** customer mengklik tombol/anchor `.order-btn` ("Order Now") di dalam card
- **THEN** browser SHALL melakukan navigasi mengikuti perilaku anchor (sama dengan tujuan card)
- **AND** sistem SHALL TIDAK memicu handler klik card-level dua kali

#### Scenario: Klik tombol wishlist di dalam card
- **WHEN** customer mengklik `.wishlist-btn` di dalam card
- **THEN** sistem SHALL toggle state wishlist tanpa menavigasi halaman

#### Scenario: Tab + Enter dari keyboard
- **WHEN** customer memfokus card via Tab key dan menekan `Enter`
- **THEN** browser SHALL melakukan navigasi yang sama seperti klik mouse

### Requirement: Seluruh area menu card dapat dipicu untuk membuka detail produk

Sistem SHALL mendukung klik pada area manapun dari `.menu-card` untuk memicu aksi "buka detail produk" via dispatch CustomEvent `menu-card:open`, kecuali bila klik berasal dari sub-elemen interaktif (`.wishlist-btn`, `[data-menu-controls]`).

#### Scenario: Klik area kosong menu card
- **WHEN** customer mengklik bagian image, nama menu, deskripsi, atau harga di dalam `.menu-card`
- **THEN** sistem SHALL men-dispatch `CustomEvent('menu-card:open', { bubbles: true, detail: { menuId, vendorId } })` dari elemen card

#### Scenario: Klik tombol +/- qty di dalam card
- **WHEN** customer mengklik tombol di dalam `[data-menu-controls]` (+ atau -)
- **THEN** sistem SHALL menjalankan handler `setMenuQuantity` sebagaimana saat ini
- **AND** sistem SHALL TIDAK men-dispatch event `menu-card:open`

#### Scenario: Klik tombol wishlist
- **WHEN** customer mengklik `.wishlist-btn` di dalam menu card
- **THEN** sistem SHALL toggle ikon wishlist tanpa men-dispatch `menu-card:open`

#### Scenario: Fallback tanpa listener modal
- **WHEN** event `menu-card:open` di-dispatch dan tidak ada listener lain yang memanggil `event.preventDefault()`
- **THEN** sistem SHALL menjalankan aksi fallback `setMenuQuantity(menuData, currentQty + 1)` setara dengan klik tombol `+`

#### Scenario: Tab + Enter atau Space dari keyboard
- **WHEN** customer memfokus menu card via Tab dan menekan `Enter` atau `Space`
- **THEN** sistem SHALL men-dispatch `menu-card:open` yang sama seperti klik mouse

### Requirement: Aksesibilitas card-as-interactive

Sistem SHALL mengekspos semantik dan affordance keyboard pada card sehingga dapat diakses oleh teknologi bantu.

#### Scenario: Atribut ARIA pada vendor card
- **WHEN** halaman `/vendor` di-render
- **THEN** setiap `.vendor-card` SHALL memiliki `role="link"`, `tabindex="0"`, `data-href` berisi URL menu, dan `aria-label` ringkas (mis. `"Buka menu {nama_vendor}"`)

#### Scenario: Atribut ARIA pada menu card
- **WHEN** halaman `/vendor/{id}/menu` di-render
- **THEN** setiap `.menu-card` SHALL memiliki `role="button"`, `tabindex="0"`, dan `aria-label` ringkas (mis. `"Lihat detail {nama_menu}"`)

#### Scenario: Focus indicator terlihat
- **WHEN** card mendapat focus via keyboard (`:focus-visible`)
- **THEN** card SHALL menampilkan outline atau ring fokus yang kontras (mis. `outline: 3px solid var(--sage); outline-offset: 2px;`) dan TIDAK menggantikan shadow idle/hover yang sudah ada

#### Scenario: Sub-tombol di dalam card tetap focusable
- **WHEN** customer menavigasi dengan Tab di dalam card
- **THEN** sub-tombol seperti `.wishlist-btn`, `.order-btn`, dan kontrol `+/-` SHALL tetap mendapat focus sendiri dan dapat dioperasikan independen dari card-level
