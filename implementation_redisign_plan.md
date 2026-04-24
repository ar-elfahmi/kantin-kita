# Redesign Welcome Page (Landing Page) Kantin Kita

Redesign `welcome.blade.php` agar layout dan UI-nya mengikuti referensi `redisign welcome/home.html`, serta membuat halaman baru `about.blade.php` berdasarkan `redisign welcome/tentang.html`.

## Ruang Lingkup

### Yang Dicakup
1. **Redesign layout** `welcome.blade.php` → mengikuti struktur section dari `home.html`
2. **Redesign UI secara keseluruhan** — font, warna, spacing, dan komponen visual mengikuti design system baru (Manrope + Space Grotesk)
3. **Penggunaan maskot dan image** dari folder `redisign welcome/` (`maskot.png`, `image background.png`, `map placeholder.png`)
4. **Halaman baru** `about.blade.php` berdasarkan `tentang.html` (Tentang, FAQ, Kontak)

### Yang TIDAK Dicakup (Dipertahankan)
1. ~~Layout lama~~ — layout lama **tidak** dipertahankan; layout baru mengikuti `home.html`
2. **Logika aplikasi yang sudah ada** tetap tidak diubah (route, controller, auth, chatbot endpoint, dll)
3. **Efek animasi scroll** yang ada di `welcome.blade.php` saat ini **tetap dipertahankan** dan disesuaikan untuk design baru (class `.reveal`, `.reveal-delay-*`, IntersectionObserver)

### Aturan Data & Link
- Data menu favorit, testimonial, dll menggunakan **data statis** (samakan konten dengan `home.html`)
- Semua `href` link yang mengarah ke alur bisnis tetap menggunakan **Blade route helpers** yang sudah ada:
  - `{{ route('home') }}` — halaman beranda
  - `{{ route('vendor') }}` — halaman pilih vendor (select-vendor)
  - `{{ route('login') }}` — halaman login
  - Link "Tentang" → `/about` (route baru)
  - Link "Kontak" → `/about#kontak`
  - Link "FAQ" → `/about#faq`

---

## Perbandingan Section Layout

### Layout Lama (`welcome.blade.php` saat ini)

| No | Section | Deskripsi |
|----|---------|-----------|
| 1 | Navbar | Fixed, brand+logo, nav-links, login/daftar, hamburger mobile |
| 2 | Hero | Grid 2 kolom: teks + kartu gambar, badge, stats (10 Min / 4.8 Rating) |
| 3 | Features | Grid 4 kolom: Pesan Online, Cepat & Mudah, Cashless, Promo Menarik |
| 4 | Menu Populer | Grid 3 kolom: menu card (gambar, nama, rating, harga, tombol pesan) |
| 5 | CTA | Dark green background, benefits list, gambar |
| 6 | Testimonials | Grid 3 kolom: kartu testimonial (stars, teks, author) + carousel dots mobile |
| 7 | Chatbot | Grid 2 kolom: CTA card + Chat panel |
| 8 | Footer | Grid 4 kolom: brand, menu cepat, bantuan, kontak |

### Layout Baru (`home.html` — target redesign)

| No | Section | Deskripsi |
|----|---------|-----------|
| 1 | **Nav** | Fixed, logo img + text, nav-links, btn-signup (Daftar), hamburger mobile |
| 2 | **Hero** | Centered layout: headline di tengah, subheadline, CTA button, mockup browser frame + `maskot.png` & `image background.png` sebagai background shapes |
| 3 | **Testimonial** (single) | Quote besar di tengah, avatar + nama/role |
| 4 | **Dark Feature** | Background gradient hijau gelap, 2 kolom: teks (judul + deskripsi + testimonial bergeser) + **image carousel** (3D card stack, swipeable, autoplay) |
| 5 | **Feature Cards** | Grid 4 kolom: icon, judul, deskripsi. Hover: icon bg → accent |
| 6 | **Menu Populer** | Grid 4 kolom: menu card (gambar, badge, rating, deskripsi, link detail) |
| 7 | **Chatbot** | Grid 2 kolom: CTA card hijau gelap (chips pertanyaan cepat) + Chat panel |
| 8 | **CTA Form** | Centered: judul + form email + password + tombol daftar |
| 9 | **Footer** | Centered nav, shapes dekoratif, social icons, legal text |

---

## Proposed Changes

### Aset & File Statis

#### [COPY] Aset gambar dari `redisign welcome/` → `public/images/`

Salin file berikut ke `public/images/` agar bisa diakses via `{{ asset('images/...') }}`:

| File Sumber | Tujuan | Digunakan di |
|-------------|--------|--------------|
| `redisign welcome/maskot.png` | `public/images/maskot.png` | Hero background shape |
| `redisign welcome/image background.png` | `public/images/image-background.png` | Hero background circle |
| `redisign welcome/map placeholder.png` | `public/images/map-placeholder.png` | Kontak (about page) |

---

### Routing

#### [MODIFY] [web.php](file:///c:/Users/lenov/laragon/www/kantin-kita/routes/web.php)

Tambah route baru untuk halaman about:

```php
Route::get('/about', function () {
    return view('about');
})->name('about');
```

> [!NOTE]
> Tidak perlu controller karena halaman statis. Jika di kemudian hari butuh data dinamis, bisa dipindah ke controller.

---

### Welcome Page (Home)

#### [MODIFY] [welcome.blade.php](file:///c:/Users/lenov/laragon/www/kantin-kita/resources/views/welcome.blade.php)

Perubahan besar — file ini akan di-rewrite hampir seluruhnya, namun tetap mempertahankan:

1. **Blade route helpers** (`{{ route('home') }}`, `{{ route('vendor') }}`, `{{ route('login') }}`, dll)
2. **Chatbot logic & endpoint** (`@json(route('chatbot.respond', [], false))`)
3. **Scroll reveal animation** (class `.reveal`, `.reveal-delay-*`, IntersectionObserver JS)
4. **Testimonial carousel** (mobile swipe carousel)

**Perubahan CSS (Design System Baru)**:

| Aspek | Lama | Baru |
|-------|------|------|
| Font utama | Poppins | Manrope |
| Font display | Poppins (bold) | Space Grotesk |
| Nav height | 80px | 72px |
| Nav style | brand-icon kotak + brand-text | Logo img + uppercase wordmark |
| Hero layout | Grid 2 kolom (teks + card) | Centered (headline + mockup browser) |
| Hero bg | Gradient + glow blur | `maskot.png` (kanan atas) + `image background.png` (lingkaran kiri bawah) |
| Menu grid | 3 kolom | 4 kolom |
| Footer | Grid 4 kolom detailed | Centered nav + shapes dekoratif |

**Perubahan Section HTML**:

| Section | Perubahan |
|---------|-----------|
| **Nav** | Redesign komponen: logo img, nav-links (Beranda, Menu, Tentang→route('about'), Kontak→route('about')#kontak), btn-signup, hamburger + mobile nav panel |
| **Hero** | Centered layout: h1 di tengah, subheadline, CTA button "Mulai Pesan" → `route('vendor')`, mockup browser frame (3 dots + gambar), bg shapes maskot + image-background |
| **Testimonial (single)** | Tambah section baru: blockquote besar di tengah, avatar + nama/role |
| **Dark Feature** | Tambah section baru: gradient hijau gelap, 2 kolom, carousel gambar 3D stack + testimonial text bergeser |
| **Features** | Pindah posisi ke setelah Dark Feature, tetap 4 card (Pesan Online, Cepat & Mudah, Cashless, Promo Menarik) |
| **Menu Populer** | Grid 4 kolom, menu card tanpa harga/tombol pesan (sesuai home.html: hanya gambar, badge, nama, rating, deskripsi, link "Lihat Detail →" menuju `route('vendor')`) |
| **Chatbot** | Redesign CTA card: background hijau gelap + glassmorphism chips. Panel chat tetap sama logikanya |
| **CTA Form** | Tambah section baru: form email + password + tombol "Daftar Sekarang" (visual only, form action bisa ke route login/register) |
| **Footer** | Redesign: centered nav groups, decorative shapes (SVG triangles, circles), social icons (Instagram, Facebook, Twitter), legal text. Link: Beranda→home, Menu→#menu, Tentang→about, FAQ→about#faq, Kontak→about#kontak |

**Perubahan JavaScript**:

| Fungsi | Status |
|--------|--------|
| Navbar scroll effect | ✅ Dipertahankan, sesuaikan selector (`.nav` bukan `.navbar`) |
| Mobile hamburger | ✅ Dipertahankan, sesuaikan untuk `.nav-toggle` / `.nav-mobile` pattern |
| Scroll reveal (IntersectionObserver) | ✅ Dipertahankan sepenuhnya |
| Chatbot interaction (fetch, appendMessage, typing indicator) | ✅ Dipertahankan sepenuhnya termasuk Blade @json endpoint |
| Parallax hero glow | ❌ Dihapus (tidak ada glow blur di design baru) |
| Testimonial carousel (mobile) | ✅ Dipertahankan, sesuaikan |
| **Dark Feature carousel** | ✅ **Tambah baru** — carousel 3D stack cards (autoplay 5s, swipe, dot navigation, testimoni text fade) |
| **CTA Form** | Visual only, submit bisa prevent default atau redirect ke register |

---

### About Page (Baru)

#### [NEW] [about.blade.php](file:///c:/Users/lenov/laragon/www/kantin-kita/resources/views/about.blade.php)

Halaman baru berdasarkan `tentang.html`, berisi:

| Section | Deskripsi |
|---------|-----------|
| **Nav** | Sama persis dengan `welcome.blade.php`, hanya link "Tentang" yang aktif (`.active`) |
| **Hero Tentang** | Grid 2 kolom: kicker + h1 + intro + stats (40+ Tenant, 9.500+ Pesanan, 4.8/5 Rating) + photo card |
| **Tentang Kami (Story)** | Grid 2 kolom: gambar + visi/misi list |
| **FAQ** | Accordion (4 pertanyaan), expand/collapse dengan animasi `max-height` |
| **Kontak** | Grid 2 kolom: form kontak (nama, email, pesan, tombol kirim) + info kontak (email, telepon, lokasi) + peta (`map-placeholder.png`) |
| **Footer** | Sama persis dengan `welcome.blade.php` |

**JavaScript di About Page**:
- Nav scroll effect (sama)
- Mobile hamburger (sama)
- FAQ accordion (click → toggle `.open`, animate `max-height`)
- Contact form (client-side feedback saja, tanpa backend)

---

## Mapping Link href

| Link Teks | Target di Design Baru | Blade Route |
|-----------|----------------------|-------------|
| Beranda | Home | `{{ route('home') }}` |
| Menu (nav) | Scroll ke #menu | `{{ route('home') }}#menu-title` |
| Tentang | About page | `{{ route('about') }}` |
| Kontak | About page #kontak | `{{ route('about') }}#kontak` |
| FAQ | About page #faq | `{{ route('about') }}#faq` |
| Mulai Pesan | Select vendor | `{{ route('vendor') }}` |
| Lihat Detail (menu card) | Select vendor | `{{ route('vendor') }}` |
| Daftar (nav) | Login page | `{{ route('login') }}` |
| Masuk | Login page | `{{ route('login') }}` |

---

## Open Questions

> [!IMPORTANT]
> 1. **CTA Form (Daftar)**:  Di `home.html` ada form email + password "Daftar Sekarang". Apakah form ini hanya visual/placeholder, atau ingin langsung diarahkan ke `route('login')` saat submit?
> 2. **Chatbot Section**: Apakah section chatbot tetap dipertahankan di design baru? Di `home.html` memang ada chatbot section. Saya asumsikan **ya, tetap ada**.
> 3. **Nav link "Daftar"**: Di design baru ada tombol "Daftar" di nav. Ini saya arahkan ke `route('login')` karena tidak ada route register terpisah. Apakah benar?

---

## Verification Plan

### Automated Tests
```bash
php artisan test
npm run build
```

### Manual Verification
- Buka `http://localhost/` → pastikan layout dan UI sesuai `home.html`
- Buka `http://localhost/about` → pastikan layout sesuai `tentang.html`
- Cek semua link navigasi (Beranda, Menu, Tentang, Kontak, FAQ) mengarah ke tujuan yang benar
- Cek maskot dan image background tampil di hero section
- Cek responsive: resize ke mobile (< 768px) → hamburger menu, section stacking
- Cek chatbot masih berfungsi (kirim pesan, terima respons)
- Cek scroll animation (reveal) masih aktif
- Cek carousel di Dark Feature section berfungsi (autoplay, swipe, dots)
- Cek FAQ accordion di about page (expand/collapse)
- Cek form kontak (client-side feedback)
