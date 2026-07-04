## Why

Kantin-Kita has roles `admin`, `vendor`, `customer`, `guest` defined in the database, but only the `vendor` role has a working login path and dashboard. There is no UI for the platform owner (admin) to manage users, oversee transactions across all vendors, or publish content. The landing page also has no way to surface fresh information (announcements, "About Us" text, news) — it is fully static. We need an admin panel so the platform owner can manage the marketplace end-to-end and curate landing-page content without code changes.

## What Changes

- Extend `AuthController::login()` so users with `role = admin` can authenticate and are redirected to `/admin` (currently the controller forcibly rejects anyone whose role is not `vendor`).
- Add an admin-only middleware (`admin` route gate) and apply it to a new `/admin/*` route group.
- Add an **Admin Dashboard** landing page at `/admin` showing high-level KPIs (total users by role, total vendors, total orders, GMV by payment status, recent transactions).
- Add **Kelola User** pages (`/admin/users`) — list, search, filter by role, create, edit (name/email/role), reset password, and soft-delete users. Block deleting your own account.
- Add **Kelola Artikel** pages (`/admin/artikel`) — CRUD on a new `artikels` table (judul, slug, ringkasan, konten, gambar_sampul, kategori, status `draft|published|archived`, published_at). Articles flagged `published` and tagged `tentang-kami` SHALL appear in a new section on the landing page; archived articles SHALL be hidden from the landing page but retained for restore.
- Add **Pantau Transaksi** page (`/admin/transaksi`) — cross-vendor list of `Pesanan` joined with `Payment`, filterable by vendor, payment status, order status, and date range, with detail drawer/page. Read-only by default.
- Add a new `artikels` migration, `Artikel` model, and seed an "About Us" article to populate the landing-page section.
- Extend the landing page (`resources/views/welcome.blade.php` or `home.blade.php`) to render published articles in the "Tentang Kami" / news section.
- Seed at least one admin user (idempotent) via a database seeder so the panel is reachable on a fresh install.

## Capabilities

### New Capabilities
- `admin-panel`: Authenticated admin users can sign in and access an admin-only panel that exposes a dashboard, user management, article CRUD with archive/publish workflow, and a read-only cross-vendor transaction monitor.
- `landing-articles`: The public landing page renders a curated section of published articles (e.g. "Tentang Kami") sourced from the `artikels` table, excluding archived/draft entries.

### Modified Capabilities

None. (The existing vendor login flow is the only auth path today and it lives in the controller, not in a spec.)

## Impact

- **DB / migrations**: new `artikels` table (id, judul, slug unique, ringkasan, konten longText, gambar_sampul nullable, kategori string, status enum draft|published|archived, published_at nullable, author_id FK users, timestamps, softDeletes). Add `deleted_at` (softDeletes) on `users` if not present (or use a `status` column — see design.md).
- **Models**: new `App\Models\Artikel`; minor updates on `User` (relationship to `artikels`, soft-delete trait if used).
- **Controllers**: new `Admin\DashboardController`, `Admin\UserController`, `Admin\ArtikelController`, `Admin\TransaksiController`; modify `AuthController::login()` to route admins to `/admin`.
- **Middleware**: new `EnsureUserIsAdmin` middleware, registered in `bootstrap/app.php` (Laravel 13 style) with alias `admin`.
- **Routes**: new `/admin/*` group in `routes/web.php`.
- **Views**: new admin layout + pages under `resources/views/admin/`; update landing page (`welcome.blade.php`) to include the articles section.
- **Public assets**: storage path `storage/app/public/artikel/` for cover images (uses existing public disk symlink).
- **Seeders**: `AdminUserSeeder` (idempotent) + `ArtikelSeeder` (sample "Tentang Kami").
- **Tests**: new feature tests for admin auth gate, user CRUD authorization, article publish/archive lifecycle, and transaction list filters; landing page test asserting only published non-archived articles render.
