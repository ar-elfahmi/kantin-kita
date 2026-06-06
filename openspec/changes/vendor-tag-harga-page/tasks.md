## 1. Route

- [x] 1.1 Add `Route::get('/dashboard/menu', [DashboardController::class, 'menuList'])->name('dashboard.menu');` inside the existing `auth` middleware group in `routes/web.php`

## 2. Controller

- [x] 2.1 Add `menuList()` method to `DashboardController`
- [x] 2.2 Method SHALL guard with `auth()->user()->isVendor()` and the user must own a vendor profile (same pattern as `PriceTagController::generate`) — implemented as `Auth::user()?->vendor` null-check + 403, matching the pre-existing `index()` pattern
- [x] 2.3 Method SHALL return `view('vendor.manage-menu', [...])` with the vendor and all of its menus eager-loaded with `kategoriMenu` relation, ordered by `nama_menu`

## 3. View

- [x] 3.1 Create `resources/views/vendor/manage-menu.blade.php`
- [x] 3.2 Reuse the same sidebar layout/styles as `dashboard-vendor.blade.php` for visual consistency (initially duplicated; can be extracted to a partial later)
- [x] 3.3 Main content area: page header ("Kelola Menu — Tag Harga") + table or grid listing every menu with columns: gambar, nama_menu, kategori, id_barang, harga, action button "Cetak Tag Harga"
- [x] 3.4 The action button SHALL link to `route('menu.price-tag', $menu)` — reusing the existing PDF generation
- [x] 3.5 Empty-state row when vendor has no menu items yet

## 4. Sidebar nav

- [x] 4.1 In `dashboard-vendor.blade.php` sidebar, add a "Tag Harga" nav-item linking to `route('dashboard.menu')` — inserted after the "Produk" item
- [x] 4.2 Replace the hardcoded `active` class on the Dashboard nav-item with `{{ request()->routeIs('dashboard') ? 'active' : '' }}` and apply analogous logic to the new Tag Harga item
- [x] 4.3 Repeat the dynamic-active pattern on the new view's sidebar copy

## 5. Verify (manual — user)

- [ ] 5.1 `php artisan serve`; log in as a vendor; visit `/dashboard/menu`; confirm full menu list renders
- [ ] 5.2 Click "Cetak Tag Harga" on at least 2 different menu items; confirm both PDFs download with correct barcode + id_barang
- [ ] 5.3 Confirm a non-vendor user gets 403 (covered by existing PriceTagController guard, but verify the new route also enforces it)
- [ ] 5.4 Confirm the sidebar active state highlights "Tag Harga" when on `/dashboard/menu` and "Dashboard" when on `/dashboard`

## 6. Notes / Known minor issues

- Sidebar HTML is duplicated between `dashboard-vendor.blade.php` and `vendor/manage-menu.blade.php`. Marked as a TODO in the new view. Extract to `resources/views/vendor/_sidebar.blade.php` partial as a follow-up cleanup.
- Dashboard nav SVG paths in `dashboard-vendor.blade.php` still hardcode `fill="#42766A"` (green). In practice the user only views this view when on `/dashboard`, so the icon is always "active" — no visible bug today, but if the sidebar is ever extracted to a partial used on other pages, the SVG fills should be switched to `currentColor`.
- The Scan Barcode modal+JS is intentionally NOT duplicated in the manage-menu view (vendor doesn't need to scan order QRs from the menu management page; they return to /dashboard for that).
