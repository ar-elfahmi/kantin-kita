## Context

Saat ini ada dua halaman katalog yang menampilkan kartu produk dengan style yang divergen:

- `resources/views/select-vendor.blade.php` (`/vendor`): grid `repeat(3, 1fr)`, gap 24px; `.vendor-card` dengan `--radius-card: 24px`, `.card-image-wrap` tinggi **256px**, `.card-body` padding **24px**, ada `.card-footer-row` yang memuat `.price-group` + tombol `Order Now` (anchor `<a>` ke `route('menu')`).
- `resources/views/menu-vendor.blade.php` (`/vendor/{id}/menu`): grid `repeat(4, 1fr)`, gap 24px; `.menu-card` dengan `--radius-card: 20px`, `.menu-card-image-wrap` tinggi **208px**, `.menu-card-body` padding **20px**, `cursor: pointer` sudah di-set tapi belum ada click handler — interaksi yang ada hanya tombol `.wishlist-btn` (toggle love) dan `.menu-qty-controls` (+/-).

Token warna dan font sudah sama (`--cream`, `--brown`, `--sage`, font Poppins). Yang berbeda adalah token radius/shadow lokal di masing-masing file (vendor pakai `--shadow-card`/`--shadow-lift`, menu pakai `--shadow-sm`/`--shadow-md`/`--shadow-float`).

Sudah ada change in-flight `add-product-detail-modal` yang berencana mengubah tombol `+` di menu card menjadi pemicu modal Detail Produk. Change ini (`align-vendor-card-clickable`) harus kompatibel: handler klik-card-penuh untuk menu card tidak boleh menabrak rencana tersebut.

## Goals / Non-Goals

**Goals:**
- Vendor card dan menu card terlihat & terasa konsisten secara dimensi, radius, shadow, dan grid breakpoint.
- Seluruh area card dapat di-klik dengan satu tap/click untuk memicu aksi utama (navigasi → menu, atau buka detail produk).
- Sub-elemen interaktif di dalam card (wishlist, +/-, link CTA) tetap independen dan tidak ikut trigger aksi card-level.
- Card dapat dioperasikan dari keyboard (Tab → Enter/Space).
- Tidak ada regression visual di mobile (≤768px) atau di status empty/loading.

**Non-Goals:**
- Mengimplementasikan modal Detail Produk itu sendiri (di-handle oleh change `add-product-detail-modal`).
- Mengubah struktur data, route, model, atau backend.
- Redesign keseluruhan halaman (header, footer, search, filter pill) — hanya area card grid.
- Menambahkan animasi/transisi baru di luar yang sudah ada (hover lift, image scale).

## Decisions

### 1. Wrapper interaktif: `<article>` + JS, bukan `<a>` outer

Membungkus seluruh card dengan `<a href>` outer adalah cara paling sederhana, tetapi:
- HTML5 melarang `<a>` di dalam `<a>` (vendor card masih punya tombol "Order Now" sebagai `<a>`; menu card nanti akan punya tombol modal). Outer `<a>` akan invalidate markup.
- Wishlist button (`<button>`) di dalam `<a>` tetap berfungsi tapi menyebabkan default navigation kecuali `event.preventDefault()` — boilerplate ekstra.

**Keputusan**: gunakan `<article class="vendor-card" data-href="{{ route('menu', ['id' => $vendor->id]) }}" role="link" tabindex="0">` dan attach single click/keydown listener via JS delegation. Untuk menu card: `<article class="menu-card" role="button" tabindex="0">` tanpa `data-href` (aksi adalah dispatch event, bukan navigasi).

**Alternatif yang ditolak**: outer `<a>` (invalid nested anchors), CSS-only `::after` trick dengan absolute positioning (tidak bisa keyboard-accessible, dan menutupi inner buttons sehingga pointer-events jadi rumit).

### 2. Event delegation & isolasi sub-elemen

Click listener di-pasang di level `.vendors-grid` / `.menu-grid` (satu listener per page), bukan per-card. Handler:

```js
grid.addEventListener('click', (e) => {
  const card = e.target.closest('.vendor-card[data-href], .menu-card[role="button"]');
  if (!card) return;
  // Skip jika klik berasal dari elemen interaktif di dalam card
  if (e.target.closest('a, button, [data-menu-controls], input, textarea')) return;
  triggerCardAction(card);
});
```

Pendekatan ini menghindari menambahkan `event.stopPropagation()` ke setiap tombol di dalam card (yang dapat memutus event bubbling untuk handler analytics/global lain yang mungkin ditambahkan kemudian).

### 3. Aksi kartu

- **Vendor card**: `triggerCardAction(card)` → `window.location.href = card.dataset.href`.
- **Menu card**: dispatch `new CustomEvent('menu-card:open', { bubbles: true, detail: { menuId, vendorId } })`. Default handler di `menu-vendor.blade.php` saat ini: bila tidak ada listener lain yang `preventDefault`, fallback memanggil flow `setMenuQuantity(..., currentQty + 1)` (sama dengan tombol `+`). Setelah change `add-product-detail-modal` mendarat, listener-nya cukup `preventDefault()` untuk mengambil alih.

Pemilihan event custom (alih-alih langsung membuka modal) memberi *seam* yang jelas antara dua change in-flight.

### 4. Penyamaan dimensi: extract shared token, bukan duplikat literal

Daripada hard-code 208px/20px/`--shadow-sm` di kedua file, definisikan token canonical di `:root` masing-masing file dengan nilai identik:

```
--card-radius: 20px;
--card-image-h: 208px;
--card-body-pad: 20px;
--card-gap: 24px;
--card-shadow-idle: 0 1px 2px rgba(0,0,0,.05);
--card-shadow-hover: 0 4px 6px rgba(0,0,0,.07), 0 10px 20px rgba(0,0,0,.06);
```

Token lokal lain (`--cream`, `--brown`, dll.) yang sudah duplikat di kedua file dibiarkan apa adanya — extracting ke file CSS global di luar scope change ini.

### 5. Grid breakpoint vendor card

Saat ini vendor grid: `3 cols → 2 cols (≤1024px) → 2 cols (≤640px)`. Menu grid: `4 cols → 3 cols (≤1024px) → 1 col stacked-row (≤768px)`.

**Keputusan**: vendor grid disamakan dengan menu grid:
- `>1024px`: `repeat(4, 1fr)`
- `768–1024px`: `repeat(3, 1fr)`
- `≤768px`: layout row (image 126px + body) — identik dengan menu card mobile.

Konsekuensi: jumlah vendor yang ditampilkan per baris di desktop berubah dari 3 → 4. Vendor list saat ini ~6–8 vendor dari seeder, jadi fit menjadi 1–2 baris (lebih scannable).

### 6. Aksesibilitas keyboard

- `tabindex="0"` agar card masuk tab order.
- `role="link"` untuk vendor card (semantik = "go somewhere"), `role="button"` untuk menu card (semantik = "trigger action").
- `keydown` listener: `Enter` selalu trigger; `Space` hanya trigger untuk `role="button"` (mengikuti spec WAI-ARIA).
- Focus indicator: `.vendor-card:focus-visible, .menu-card:focus-visible { outline: 3px solid var(--sage); outline-offset: 2px; }` — tidak menimpa shadow hover.

### 7. Cursor & hover affordance

`cursor: pointer` ditambahkan ke `.vendor-card` (saat ini hanya `:hover` lift). `.menu-card` sudah punya. Hover lift (-6px translate + shadow-md) tetap, tidak diubah.

## Risks / Trade-offs

- **[Risk]** Klik tidak sengaja saat user men-tap area card dengan maksud lain (mis. mau zoom gambar di mobile). → **Mitigation**: di mobile (≤768px), card jadi layout horizontal pendek (126px tinggi), area tap kecil. Tambahkan `touch-action: manipulation` agar tap responsif tanpa delay 300ms.
- **[Risk]** Screen reader membaca seluruh konten card sebelum menyadari ada interaksi. → **Mitigation**: `role="link"`/`role="button"` di-announce dulu, dan `aria-label` ringkas di card (mis. `aria-label="Buka menu Warung Bu Sari"`). Tombol di dalam tetap punya label sendiri.
- **[Trade-off]** Vendor card jadi lebih kecil dan padat info (deskripsi dipotong lebih agresif). Acceptable karena halaman lebih scannable dan konsisten dengan menu list yang sudah informasi-padat.
- **[Trade-off]** Menggunakan custom event `menu-card:open` membuat klik kartu sebelum modal merge memicu `setMenuQuantity(+1)` — bisa membingungkan tester yang mengira sudah membuka modal. → **Mitigation**: dokumentasikan di task implementation bahwa fallback ini sementara; tambahkan TODO comment yang mereferensikan change `add-product-detail-modal`.
- **[Risk]** `event.target.closest('button, a, ...')` mungkin overlap dengan elemen non-interaktif yang kebetulan `<a>` (mis. price-tag link di vendor card). → **Mitigation**: saat ini tidak ada link non-CTA di dalam card; jaga konvensi: anchor/button di dalam card harus selalu mewakili aksi alternatif.
- **[Risk]** Test E2E lama yang assert tombol "Order Now" sebagai trigger navigasi tetap pass (tombol masih ada), namun test baru yang assert klik card sebagai trigger memerlukan setup keyboard/mouse event. → **Mitigation**: tetap pertahankan tombol "Order Now" di vendor card; tambah test khusus untuk perilaku klik-card jika test framework UI tersedia.
