## 1. Backend: Route & Controller

- [x] 1.1 Add POST route `/dashboard/menu/store` pointing to `DashboardController@storeMenu` in `routes/web.php`
- [x] 1.2 Add `storeMenu()` method to `DashboardController` with validation and image upload handling
- [x] 1.3 Create `storage/app/public/menus/` directory and link storage symlink if not already done

## 2. Frontend: Modal Form

- [x] 2.1 Add modal overlay HTML to `dashboard-vendor.blade.php` with form fields (nama_menu, deskripsi, harga, kategori_menu_id dropdown, path_gambar file input, is_available toggle)
- [x] 2.2 Wire "Tambah Produk" button to open the modal
- [x] 2.3 Add JavaScript to handle form submission via fetch/FormData, display validation errors, and refresh product grid on success
- [x] 2.4 Pass `$kategoriMenus` from `DashboardController@index` to the view for the category dropdown

## 3. Verification

- [x] 3.1 Run `php artisan test` to ensure no regressions
- [x] 3.2 Run `npm run build` to ensure frontend build passes
- [ ] 3.3 Manual verification: login as vendor, add a product, confirm it appears in the grid
