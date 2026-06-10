## Context

Vendor dashboard already displays a "Tambah Produk" button and renders a product grid from `$produkTerlaris` (top 4 by sales). The Menu model exists with all needed fields: vendor_id, kategori_menu_id, nama_menu, deskripsi, harga, path_gambar, is_available, id_barang. What's missing is the backend endpoint and modal form to create new Menu records.

## Goals / Non-Goals

**Goals:**
- Vendor can add a new menu item via a modal form on the dashboard
- Form fields: nama_menu (required), deskripsi, harga (required), kategori_menu_id (dropdown), path_gambar (file upload), is_available (toggle)
- Auto-generate id_barang via existing Menu::creating() boot logic
- Image uploads stored at `storage/app/public/menus/`
- Validation with error feedback displayed inline in the modal
- Product grid refreshes after successful creation

**Non-Goals:**
- Editing existing menu items (separate change)
- Deleting menu items (separate change)
- Bulk import of menu items
- Image editing/cropping

## Decisions

- **Modal vs separate page**: Use a modal overlay to avoid navigation away from the dashboard, matching existing patterns (scan barcode modal).
- **Storage for images**: Use Laravel's public disk (`storage/app/public/menus/`) with a symlink. This keeps images accessible via URL and follows Laravel conventions.
- **KategoriMenu dropdown**: Fetch categories from the database so the dropdown is dynamic. No seeding needed beyond existing data.
- **Validation on backend**: Validate nama_menu (required, max:255), harga (required, numeric, min:0), deskripsi (nullable, max:1000), path_gambar (nullable, image, max:2048), kategori_menu_id (nullable, exists:kategori_menus,id), is_available (boolean).
- **Controller placement**: Add `storeMenu()` to existing `DashboardController` since it's a related dashboard action.

## Risks / Trade-offs

- Modal form with image upload requires JavaScript (FormData + fetch). If JS fails, the form won't work. Acceptable since the dashboard is JS-heavy already.
- No editing yet — vendor who mistypes must delete and re-add. Mitigation: build edit feature as next step.
