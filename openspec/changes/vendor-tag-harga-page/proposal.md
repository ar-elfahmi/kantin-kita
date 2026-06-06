## Why

The price tag PDF feature (`generate-barcode-price-tag`) already exists and is correctly scoped to vendor role, but the "Cetak Tag Harga" button is only surfaced on the top-4 best-selling menu items inside the dashboard's "Produk Terlaris" section (`dashboard-vendor.blade.php:1738-1777`). A vendor with more than 4 menu items currently cannot print tags for the rest — there is no discovery path. This blocks the realistic workflow: vendor manages many products, needs to print tags for any of them on demand.

## What Changes

- Add a new authenticated route `GET /dashboard/menu` for the vendor's full menu list view
- Add a `menuList()` method to `DashboardController` that returns all of the authenticated vendor's menu items
- Create a new Blade view `resources/views/vendor/manage-menu.blade.php` that lists every menu item the vendor owns with a per-row "Cetak Tag Harga" action
- Add a "Tag Harga" sidebar nav item in `dashboard-vendor.blade.php` linking to the new page
- Make the sidebar nav `active` class dynamic based on `request()->routeIs(...)` so the active state reflects the current page

## Capabilities

### New Capabilities
- (none)

### Modified Capabilities
- `price-tag-pdf`: Add the requirement that vendors can browse and print tags for ALL their menu items (not just top sellers)

## Impact

- `routes/web.php` — one new route in the existing `auth` middleware group
- `app/Http/Controllers/DashboardController.php` — new `menuList()` method
- `resources/views/vendor/manage-menu.blade.php` — new file
- `resources/views/dashboard-vendor.blade.php` — add nav item; make active class dynamic
- No new dependencies. No DB changes. No breaking changes to existing routes or views.
