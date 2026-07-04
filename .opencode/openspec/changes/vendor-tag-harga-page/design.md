## Context

The `generate-barcode-price-tag` change shipped the backend (controller + view + barcode/PDF library) and added a single entry point: a "Cetak Tag Harga" button on each `produkTerlaris` card in the vendor dashboard. The `DashboardController::index` query only loads the top-4 best-sellers, so vendors cannot reach price tags for the rest of their catalog.

This change is **pure UI surfacing**. No new domain entities, no schema changes, no new dependencies. The PDF generation path remains exactly as-is.

## Goals / Non-Goals

**Goals:**
- Give vendor a single page to see all of their menu items and print tags for any of them
- Maintain visual consistency with the existing vendor dashboard (same sidebar, same color palette)
- Keep access control identical to the existing PriceTagController (auth + isVendor + vendor ownership)

**Non-Goals:**
- Bulk PDF generation ("Cetak Semua" combining all tags) — deferred
- Edit/create/delete menu items on this page (CRUD is out of scope for this module)
- Search/filter/pagination — small menu sizes don't need it yet
- Customer-facing changes — none

## Decisions

| Decision | Choice | Rationale |
|---|---|---|
| New view vs. extend existing | New file `vendor/manage-menu.blade.php` | `menu-vendor.blade.php` is customer-facing (route `/vendor/{id}/menu`, no auth); reusing would mix two audiences |
| Sidebar reuse | Duplicate sidebar HTML in new view for now | Extracting to a Blade partial requires refactoring 2000-line dashboard file; risk/reward not justified for one extra view |
| Active-state logic | `request()->routeIs('route.name')` Blade ternary | Native Laravel helper; survives URL changes; no new state plumbing |
| Route placement | Inside the existing `auth` middleware group | Matches `menu.price-tag` placement; consistent with dashboard family |
| Ordering | `ORDER BY nama_menu ASC` | Predictable; vendor scans alphabetically; can later switch to manual sort/availability |
| Eager-loading | `with('kategoriMenu')` | Display kategori per row without N+1; one extra query total |

## Risks / Trade-offs

| Risk | Mitigation |
|---|---|
| Duplicated sidebar drifts between two views over time | TODO comment in new view + small follow-up to extract to `@include('vendor._sidebar', ['active' => 'menu'])` after this ships |
| Adding sidebar nav item to existing dashboard could shift layout on mobile | Re-test the existing `@media (max-width: 900px)` sidebar-row behaviour after the change |
| Hardcoded `active` on existing Dashboard nav item will become wrong when on /dashboard/menu | Replace static `active` with `request()->routeIs(...)` ternary as part of this change (task 4.2) |
