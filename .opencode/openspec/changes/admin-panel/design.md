## Context

Kantin-Kita is a Laravel 13 / PHP 8.3 marketplace with role-based users (`admin`, `vendor`, `customer`, `guest`) and Midtrans Snap for payments. Today only the vendor side is wired up: `AuthController::login()` hard-fails any non-vendor login, and there is no admin UI. Operationally that means the platform owner cannot manage accounts, reconcile transactions across vendors, or publish landing-page content. We want a single coherent admin panel rather than ad-hoc artisan commands.

Relevant existing surfaces:
- `routes/web.php` — vendor dashboard routes live under `auth` middleware, no role gate is enforced at the route layer (the controller does the role check).
- `app/Http/Controllers/AuthController.php` — single login form/controller for the whole app.
- `app/Models/User.php` — role enum already includes `admin` and an `isAdmin()` helper. No soft deletes today.
- `app/Models/Pesanan.php` / `Payment.php` — payment statuses `pending|settlement|expire|cancel|deny`; pesanan statuses `pending|diproses|selesai|dibatalkan`. Admin transaction view should respect these.
- `resources/views/welcome.blade.php` is the public landing page; the `/about` route currently returns a static `about.blade.php`.
- `database/migrations/0001_01_01_000000_create_users_table.php` creates `users` with no `deleted_at`.

## Goals / Non-Goals

**Goals:**
- Admins can log in via the existing `/login` form and land on `/admin` instead of `/dashboard`.
- A single `admin` middleware guards every `/admin/*` route; non-admins get 403 (or redirected to `/dashboard` if they are vendors).
- Admin dashboard surfaces at-a-glance metrics: user counts by role, vendor count, total pesanan, GMV by payment status (`settlement` totals), 10 most recent paid pesanan.
- User management: index with search by name/email and filter by role; create/edit form (name, email, role, optional password); reset-password action; soft-delete with restore; prevents an admin from deleting/demoting their own account.
- Article management: full CRUD; statuses `draft|published|archived`; archive is a soft-hide for landing-page exposure but the record stays editable/restorable; cover image upload to `storage/app/public/artikel/`; slug auto-generated from `judul` and unique.
- Transaction monitor: read-only cross-vendor list joining `pesanans` ⇆ `payments` ⇆ `vendors` ⇆ `users`; filters (vendor, payment status, order status, date range); detail view shows line items.
- Landing page renders a "Tentang Kami" section sourced from `artikels` where `status = 'published'` and `kategori = 'tentang-kami'`, ordered by `published_at DESC`, archived rows excluded.
- Seeders create at least one admin user idempotently (`admin@kantinkita.test`) and a sample "Tentang Kami" article.
- Feature tests cover: admin auth gate, admin CRUD authorization (non-admin gets 403), publish/archive lifecycle, landing page visibility rules, transaction list filtering.

**Non-Goals:**
- Two-factor auth, password policy hardening, or audit log UI.
- Refund / void actions on transactions — admin view is read-only this iteration.
- Rich-text editor for articles (use a plain `<textarea>`; markdown rendering is out of scope).
- Bulk imports / exports (CSV, XLSX).
- Vendor approval / KYC workflow.
- Multi-language content fields on articles.

## Decisions

- **Route guard via middleware, not controller checks.** Add `App\Http\Middleware\EnsureUserIsAdmin` and register the alias `admin` in `bootstrap/app.php` (`$middleware->alias([...])`). Every `/admin/*` route gets `['auth', 'admin']`. Rationale: keeps controllers thin and matches Laravel 13 conventions; current vendor flow's controller-level check is the legacy pattern and will be left alone for vendors but mirrored for vendors in a follow-up.
- **Single login form for both roles.** Keep `/login` as-is. Modify `AuthController::login()` to: (a) accept `admin` and `vendor` roles, (b) redirect admins to `/admin` and vendors to `/dashboard`, (c) keep the rejection message for other roles. Rationale: avoids a duplicate login UI; the role check moves out of the "non-vendor → reject" branch.
- **User soft delete via `softDeletes` migration.** Add a new migration `add_soft_deletes_to_users_table` rather than editing the original. The `User` model gets `SoftDeletes`. Rationale: protects from accidental data loss and lets us restore. Alternative considered: a `status` column (active/disabled) — rejected because deletion semantics are clearer and Laravel's tooling handles it.
- **Artikel model schema.**
  - `id`, `judul` (string 255), `slug` (string 255, unique), `ringkasan` (string 500 nullable), `konten` (longText), `gambar_sampul` (string nullable), `kategori` (string 50, indexed — values like `tentang-kami`, `pengumuman`, `berita`), `status` (enum `draft|published|archived`, default `draft`, indexed), `published_at` (timestamp nullable, indexed), `author_id` (FK to `users`, nullable for safety), timestamps, `deleted_at` (softDeletes for "delete forever" path).
  - Status transitions are open (draft↔published↔archived) — no formal state machine, just validation rules + UI buttons. Archived means hidden from public site but still listed/editable in admin. Rationale: keeps the spec small; we can tighten transitions later if needed.
  - `published_at` is auto-set to `now()` when status flips to `published` and was previously null; not overwritten on subsequent edits.
- **Slug generation.** Use `Str::slug($judul)` on save; on collision, append `-{n}` (no DB-level constraint on numeric suffix — just re-query until unique). Admins can also manually edit slug in the edit form.
- **Cover image storage.** Same convention as menu images: store on the `public` disk under `artikel/`. Validation: `image, max:2048`. Old image deleted when replaced. Rationale: consistent with `vendor-add-item`.
- **Transaction monitor query.** Use Eloquent eager loading: `Pesanan::with('payment','vendor.user','detailPesanans.menu')`. Default sort by `created_at desc`, paginate 25. Date filter applies to `pesanans.created_at`. Rationale: matches existing query patterns; no need for a custom report query yet.
- **Admin layout.** New `resources/views/admin/layouts/app.blade.php` with a left sidebar (Dashboard / User / Artikel / Transaksi / Logout). Keeps admin visually distinct from the vendor dashboard so role-switching is obvious. CSS via existing Tailwind 4 setup; reuse colors/components where possible.
- **No new front-end framework.** Stick with Blade + Tailwind + minimal vanilla JS (matches `vendor-add-item` precedent). Tables use server-side pagination via Laravel's `paginate()`. Rationale: project explicitly chose npm + Tailwind, not React/Vue.
- **Authorization on top of middleware.** A small `App\Policies\UserPolicy` guards the "cannot delete/demote self" rule. Article policies are not needed beyond the admin gate (any admin can edit any article). Rationale: self-protection is the only nuanced authorization here.
- **Seeders are idempotent.** `AdminUserSeeder::run()` uses `User::updateOrCreate(['email' => 'admin@kantinkita.test'], [...])`; `ArtikelSeeder` uses `Artikel::firstOrCreate(['slug' => 'tentang-kami'], [...])`. Wire both into `DatabaseSeeder`. Rationale: tests run `migrate:fresh --seed` and we don't want duplicates on re-runs.

## Risks / Trade-offs

- **[Risk]** Modifying `AuthController::login()` could regress the existing vendor flow. → **Mitigation:** keep an explicit allowlist of accepted roles (`['admin','vendor']`), and add a feature test that re-asserts the existing "customer/guest tries to login" rejection path.
- **[Risk]** Adding `SoftDeletes` to `User` may silently change query behavior elsewhere (relationships, login). → **Mitigation:** audit all `User::` query sites (`AuthController`, `DashboardController`, customer relationships) and explicitly call `withTrashed()` only in admin-side queries. Default scope (soft-deleted excluded) is exactly what auth/login wants.
- **[Risk]** Articles on the landing page increase the public query surface — large `konten` columns could bloat the homepage payload. → **Mitigation:** the landing-page section only loads `id, judul, slug, ringkasan, gambar_sampul, published_at`. Full `konten` is only fetched on the article detail page (out of scope this change — link can 404 for now, or we add a minimal show route).
- **[Risk]** No rate-limit on admin login lets brute-force attempts hit the seeded admin email. → **Mitigation:** rely on Laravel's default `throttle:login` if already wired; if not, add `RateLimiter::for('login', ...)` in `bootstrap/app.php`. Tracked as a tasks.md item.
- **[Trade-off]** Read-only transaction view means admin must still use DB/CLI to refund. Accepted for v1; a follow-up can add `cancel` / `refund` actions guarded by Midtrans API integration.
- **[Trade-off]** No rich-text editor means newlines in `konten` need a simple `nl2br()` on the public side. Acceptable; can swap to Markdown later.

## Migration Plan

1. Deploy migrations: `add_soft_deletes_to_users_table` and `create_artikels_table`.
2. Run `php artisan db:seed --class=AdminUserSeeder` (or full `migrate:fresh --seed` on dev) so an admin login exists.
3. Deploy code (controllers/middleware/views/routes).
4. Smoke test: login as the seeded admin, verify dashboard counts match production, create one article, archive it, view landing page.
5. Rollback strategy: the migrations are reversible (`down()` drops `artikels` and removes `deleted_at` from `users`). Code rollback is a normal revert; no data is destroyed since soft-deleted users are restored on schema drop only if the column itself is dropped — communicate this in the rollback runbook.

## Open Questions

- Should we add a public `/artikel/{slug}` show route in this change so the landing-page "Read more" links resolve, or defer it? (Default: defer; the landing section shows `ringkasan` only.)
- Should "archived" articles be visible to admins in a separate "Arsip" tab, or interleaved in the index with a status badge filter? (Default: single index with a status filter dropdown defaulting to `draft+published`; an "Arsip" preset hides everything except archived.)
- Pagination size for transactions — 25 vs 50? (Default: 25, configurable via `?per_page=` if needed.)
