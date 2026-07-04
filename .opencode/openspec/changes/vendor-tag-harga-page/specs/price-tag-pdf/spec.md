## ADDED Requirements

### Requirement: Vendor can browse all menu items to print tags
Vendor SHALL have a page that lists every menu item they own, each with an action to download its price tag PDF.

#### Scenario: Manage-menu page shows all vendor menus
- **WHEN** an authenticated vendor visits `/dashboard/menu`
- **THEN** the page SHALL list every `Menu` belonging to that vendor, ordered by `nama_menu`

#### Scenario: Each row links to existing price tag PDF
- **WHEN** vendor clicks "Cetak Tag Harga" on any row
- **THEN** the system SHALL return the same PDF that the existing `route('menu.price-tag', $menu)` endpoint returns

#### Scenario: Access control parity with existing route
- **WHEN** a non-vendor user requests `/dashboard/menu`
- **THEN** the system SHALL return 403 Forbidden

#### Scenario: Empty state for new vendor
- **WHEN** an authenticated vendor with zero menu items visits `/dashboard/menu`
- **THEN** the page SHALL render an empty-state message instead of an empty table

### Requirement: Sidebar reflects current vendor dashboard page
The vendor dashboard sidebar `active` state SHALL match the route the user is currently viewing.

#### Scenario: Active state on dashboard root
- **WHEN** vendor is on `/dashboard`
- **THEN** the "Dashboard" nav item SHALL have the `active` class and no other nav item SHALL

#### Scenario: Active state on tag harga page
- **WHEN** vendor is on `/dashboard/menu`
- **THEN** the "Tag Harga" nav item SHALL have the `active` class and no other nav item SHALL
