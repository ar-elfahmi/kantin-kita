## 1. Setup

- [x] 1.1 Install barcode library: `composer require picqer/php-barcode-generator`
- [x] 1.2 Install PDF library: `composer require barryvdh/laravel-dompdf`

## 2. Migration & Model

- [ ] 2.1 Create migration to add `id_barang` string column (unique per vendor) to `menus` table
- [ ] 2.2 Add `id_barang` to `$fillable` in `Menu` model
- [ ] 2.3 Auto-generate `id_barang` on menu creation (8-char uppercase alphanumeric)

## 3. Controller

- [ ] 3.1 Create `PriceTagController` with `generate(Menu $menu)` method
- [ ] 3.2 Generate Code128 barcode PNG via Picqer, convert to base64
- [ ] 3.3 Return PDF response via DomPDF using Blade view

## 4. View

- [ ] 4.1 Create `resources/views/vendor/price-tag.blade.php` with barcode image and menu info

## 5. Route & Navigation

- [ ] 5.1 Add `Route::get('/menu/{menu}/price-tag', [PriceTagController::class, 'generate'])->middleware('auth')` in `web.php`
- [ ] 5.2 Add "Cetak Tag Harga" button per menu item in dashboard-vendor.blade.php

## 6. Tests

- [ ] 6.1 Test PDF download returns 200 for vendor own menu
- [ ] 6.2 Test PDF download returns 403 for non-vendor user
- [ ] 6.3 Test PDF download returns 403 for another vendor's menu
- [ ] 6.4 Test PDF download returns 404 for nonexistent menu
- [ ] 6.5 Test PDF content type is `application/pdf`
- [ ] 6.6 Test `id_barang` auto-generation on menu create
- [ ] 6.7 Test barcode generates valid image
