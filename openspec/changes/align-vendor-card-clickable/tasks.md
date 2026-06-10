## 1. Persiapan token & dokumentasi

- [x] 1.1 Tambahkan token canonical card di `:root` `resources/views/select-vendor.blade.php` (`--card-radius`, `--card-image-h`, `--card-body-pad`, `--card-gap`, `--card-shadow-idle`, `--card-shadow-hover`) dengan nilai sesuai design.
- [x] 1.2 Tambahkan token canonical yang sama di `:root` `resources/views/menu-vendor.blade.php` (override nilai eksisting yang sudah ada agar identik dengan vendor list).
- [x] 1.3 Catat di komentar singkat di kedua file: token canonical card harus dijaga konsisten (reference change `align-vendor-card-clickable`).

## 2. Sesuaikan dimensi vendor card

- [x] 2.1 Ubah `.vendors-grid` di `select-vendor.blade.php` menjadi `grid-template-columns: repeat(4, 1fr)` di breakpoint default; `repeat(3, 1fr)` di `@media (max-width: 1024px)`; layout horizontal di `@media (max-width: 768px)` (mengikuti pola `.menu-card` mobile).
- [x] 2.2 Update `.vendor-card`: `border-radius: var(--card-radius)`, `box-shadow: var(--card-shadow-idle)`, hover `box-shadow: var(--card-shadow-hover)`, `cursor: pointer`.
- [x] 2.3 Update `.card-image-wrap` desktop tinggi `var(--card-image-h)` (208px); biarkan mobile 110–126px sesuai breakpoint.
- [x] 2.4 Update `.card-body` padding desktop `var(--card-body-pad)` (20px); turunkan ukuran tipografi (`.vendor-name` 18–20px desktop) agar proporsional.
- [ ] 2.5 Smoke-test visual di breakpoint 1440, 1024, 768, 480 — pastikan tidak ada overflow/clipping. (manual; perlu QA browser)

## 3. Vendor card: click-the-whole-card

- [x] 3.1 Pada Blade markup `.vendor-card`, tambahkan `data-href="{{ route('menu', ['id' => $vendor->id]) }}"`, `role="link"`, `tabindex="0"`, `aria-label="Buka menu {{ $vendor->nama_vendor }}"`.
- [x] 3.2 Tambahkan single event listener di `.vendors-grid` (click + keydown) yang: cek `e.target.closest('a, button, input, textarea')` untuk skip, lalu navigate ke `card.dataset.href`.
- [x] 3.3 Pastikan tombol `.order-btn` (anchor "Order Now") tetap berfungsi (event bubble ditangani oleh closest-check di handler — tidak perlu `stopPropagation`).
- [x] 3.4 Tambahkan style `:focus-visible` untuk `.vendor-card` (outline kontras sage, offset 2px).
- [x] 3.5 Tambahkan `touch-action: manipulation` ke `.vendor-card` untuk responsivitas tap di mobile.

## 4. Menu card: click-the-whole-card → dispatch event

- [x] 4.1 Pada Blade markup `.menu-card`, tambahkan `role="button"`, `tabindex="0"`, `aria-label="Lihat detail {{ $menu->nama_menu }}"`.
- [x] 4.2 Tambahkan single event listener di `#menuGrid` (click + keydown `Enter`/`Space`) yang: cek `e.target.closest('a, button, [data-menu-controls], input, textarea')` untuk skip, lalu dispatch `new CustomEvent('menu-card:open', { bubbles: true, cancelable: true, detail: { menuId, vendorId } })`.
- [x] 4.3 Tambahkan default fallback listener di `document` yang mendengarkan `menu-card:open`; jika event TIDAK `defaultPrevented`, panggil `openMenuDetailModal(card)` (menggantikan `setMenuQuantity` fallback karena modal detail produk sudah tersedia dari change `add-product-detail-modal`).
- [x] 4.4 Tambahkan style `:focus-visible` untuk `.menu-card` (outline kontras sage, offset 2px) — pastikan tidak menimpa hover lift.
- [x] 4.5 Verifikasi handler `[data-menu-controls]` dan `.wishlist-btn` saat ini tetap pakai `event.stopPropagation()` di tempat yang sudah ada; tidak perlu tambahan karena closest-check di handler card-level sudah meng-skip.

## 5. Aksesibilitas & QA

- [ ] 5.1 Tab through `/vendor`: setiap card masuk tab order, Enter melakukan navigasi, sub-tombol tetap reachable. (manual QA)
- [ ] 5.2 Tab through `/vendor/{id}/menu`: setiap card masuk tab order, Enter/Space men-dispatch event dan memicu fallback +1, kontrol `+/-` dan wishlist tetap reachable & independen. (manual QA)
- [ ] 5.3 Verifikasi `aria-label` card terbaca oleh screen reader (uji manual via NVDA/VoiceOver atau Lighthouse a11y audit). (manual QA)
- [ ] 5.4 Verifikasi mobile (≤768px): card horizontal, tap di area kosong bekerja, tap di tombol +/- atau wishlist tidak ikut navigate/dispatch. (manual QA)
- [ ] 5.5 Verifikasi konsistensi visual side-by-side: screenshot `/vendor` dan `/vendor/{id}/menu` di breakpoint 1440 & 768; dimensi card identik. (manual QA)

## 6. Regression & docs

- [x] 6.1 Jalankan suite test eksisting (`php artisan test`) — pastikan tidak ada feature test yang regress. (98 passed)
- [x] 6.2 Tambahkan test Blade di `KantinFlowTest` memverifikasi `data-href`/`role`/`tabindex`/`aria-label` di vendor & menu card.
- [x] 6.3 Update CONTEXT.md untuk mencatat konvensi "card-as-interactive".
- [x] 6.4 Jalankan `openspec validate align-vendor-card-clickable --strict` — passed.
