## 1. Database & Models

- [x] 1.1 Create migration `add_soft_deletes_to_users_table` that adds `deleted_at` to `users` (with `down()` to drop)
- [x] 1.2 Create migration `create_artikels_table` with columns per design.md (id, judul, slug unique, ringkasan, konten longText, gambar_sampul nullable, kategori indexed, status enum default `draft` indexed, published_at nullable indexed, author_id FK users nullable on delete set null, timestamps, softDeletes)
- [x] 1.3 Run `php artisan migrate` to apply both migrations locally
- [x] 1.4 Update `app/Models/User.php`: add `SoftDeletes` trait; add `artikels()` HasMany relation
- [x] 1.5 Audit existing `User::` query call sites (`AuthController`, `DashboardController`, customer code) to confirm soft-delete default scope is the correct behaviour
- [x] 1.6 Create `app/Models/Artikel.php` with fillable fields, `SoftDeletes` trait, `author()` BelongsTo `User`, and a `booted()` hook that auto-generates slug from judul on create and auto-sets published_at when status flips to `published` from a non-published state

## 2. Authentication & Authorization

- [x] 2.1 Modify `app/Http/Controllers/AuthController.php::login()` so that users with role `admin` or `vendor` are accepted; admins redirect to `/admin`, vendors to `/dashboard`; all other roles continue to be rejected with the existing error
- [x] 2.2 Create `app/Http/Middleware/EnsureUserIsAdmin.php` that checks `Auth::check()` and `Auth::user()->isAdmin()`; returns 403 otherwise
- [x] 2.3 Register the alias `admin => EnsureUserIsAdmin::class` in `bootstrap/app.php`
- [x] 2.4 Create `app/Policies/UserPolicy.php` with `delete(User $admin, User $target)` and `update(User $admin, User $target)` returning false if `$admin->id === $target->id` is being demoted/deleted; register in `AuthServiceProvider`

## 3. Routes

- [x] 3.1 In `routes/web.php`, add a route group: `Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(...)`
- [x] 3.2 Inside the group, add routes for dashboard (`GET /`), users (resource-style: index, create, store, edit, update, destroy, restore, password-reset), artikel (resource-style), transaksi (`GET /transaksi`, `GET /transaksi/{pesanan}`)
- [x] 3.3 Ensure existing vendor routes remain on `auth` only (do not add `admin` middleware to them)

## 4. Admin Controllers

- [x] 4.1 Create `app/Http/Controllers/Admin/DashboardController.php@index` that computes user counts by role, vendor count, total pesanan, GMV (sum of settled payments), and the 10 most recent settled pesanan; pass to view
- [x] 4.2 Create `app/Http/Controllers/Admin/UserController.php` with index (search + role filter + paginate), create, store (validate name/email unique/role/password), edit, update (apply `UserPolicy::update`), destroy (soft delete, apply policy), restore, resetPassword
- [x] 4.3 Create `app/Http/Controllers/Admin/ArtikelController.php` with index (status filter + paginate), create, store, edit, update, destroy, archive (sets status=archived); include slug generation, image upload to `storage/app/public/artikel/`, replace-image deletion, and published_at auto-set logic
- [x] 4.4 Create `app/Http/Controllers/Admin/TransaksiController.php` with index (filters: vendor_id, payment_status, order_status, start_date, end_date; eager load `payment`, `vendor.user`; paginate 25) and show (eager load `detailPesanans.menu`)

## 5. Admin Views

- [x] 5.1 Create `resources/views/admin/layouts/app.blade.php` with sidebar (Dashboard / User / Artikel / Transaksi / Logout) and content slot
- [x] 5.2 Create `resources/views/admin/dashboard.blade.php` rendering KPI cards and recent settled transactions table
- [x] 5.3 Create `resources/views/admin/users/index.blade.php`, `create.blade.php`, `edit.blade.php` (forms with name/email/role/password) and reset-password partial; include search/filter form and trashed indicator
- [x] 5.4 Create `resources/views/admin/artikel/index.blade.php`, `create.blade.php`, `edit.blade.php` with status filter, judul/kategori/status/published_at columns, archive button, and image upload field
- [x] 5.5 Create `resources/views/admin/transaksi/index.blade.php` and `show.blade.php` with vendor/payment-status/order-status/date-range filter form, totals, and line-item detail view

## 6. Landing Page Integration

- [x] 6.1 Modify `app/Http/Controllers/HomeController.php@index` to fetch published `tentang-kami` articles (select only id, judul, slug, ringkasan, gambar_sampul, published_at; order by published_at desc) and pass to the view
- [x] 6.2 Modify `resources/views/welcome.blade.php` to render the "Tentang Kami" section iterating the articles; omit the section entirely when collection is empty; use placeholder image when gambar_sampul is null

## 7. Seeders

- [x] 7.1 Create `database/seeders/AdminUserSeeder.php` using `User::updateOrCreate(['email'=>'admin@kantinkita.test'], [...])` with role `admin`; do NOT overwrite an existing password (use `firstOrCreate` semantics for the password field)
- [x] 7.2 Create `database/seeders/ArtikelSeeder.php` that ensures one published `tentang-kami` article exists via `Artikel::firstOrCreate(['slug'=>'tentang-kami'], [...])`
- [x] 7.3 Wire both seeders into `database/seeders/DatabaseSeeder.php::run()`

## 8. Tests

- [x] 8.1 Create `tests/Feature/Admin/AdminAuthTest.php` covering: admin login redirects to /admin, vendor login still redirects to /dashboard, customer/guest rejected, wrong-password rejected
- [x] 8.2 Create `tests/Feature/Admin/AdminMiddlewareTest.php` covering: guest gets redirect to /login on /admin, vendor gets 403 on /admin, admin gets 200
- [x] 8.3 Create `tests/Feature/Admin/AdminUserManagementTest.php` covering: index search + role filter, create with duplicate email rejected, update happy path, soft-delete + restore, self-delete blocked, self-demote blocked
- [x] 8.4 Create `tests/Feature/Admin/AdminArtikelTest.php` covering: create draft, publish sets published_at, re-publish does not reset published_at, archive hides from landing page, image upload + replace deletes old, slug collision suffix
- [x] 8.5 Create `tests/Feature/Admin/AdminTransaksiTest.php` covering: list paginated, vendor filter, payment-status filter, order-status filter, date-range filter, detail page renders line items
- [x] 8.6 Create `tests/Feature/LandingArticlesTest.php` covering: published tentang-kami article visible, draft hidden, archived hidden, non-tentang-kami category hidden, ordering desc by published_at, empty state when none

## 9. Verification

- [x] 9.1 Run `php artisan migrate:fresh --seed` and verify no errors
- [x] 9.2 Run `php artisan test` — all suites green
- [x] 9.3 Run `npm run build` — frontend build succeeds
- [ ] 9.4 Manual: log in as `admin@kantinkita.id`, verify dashboard counts, create + publish + archive an article, verify it appears/disappears on `/`
- [ ] 9.5 Manual: log in as an existing vendor, confirm vendor dashboard still works (no regression)
- [ ] 9.6 Manual: as a customer-role user, confirm `/login` still rejects with the existing error message
