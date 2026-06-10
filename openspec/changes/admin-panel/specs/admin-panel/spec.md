## ADDED Requirements

### Requirement: Admin can log in via the shared login form

The system SHALL allow a user whose `role` is `admin` to sign in through the existing `/login` form and SHALL redirect them to `/admin` after successful authentication.

#### Scenario: Admin login succeeds
- **WHEN** an admin submits the login form with valid credentials
- **THEN** the system SHALL authenticate the user
- **AND** SHALL regenerate the session
- **AND** SHALL redirect to `/admin`

#### Scenario: Vendor login still works
- **WHEN** a vendor submits the login form with valid credentials
- **THEN** the system SHALL authenticate the user
- **AND** SHALL redirect to `/dashboard`

#### Scenario: Non-admin / non-vendor role is rejected
- **WHEN** a user whose role is `customer` or `guest` submits valid credentials
- **THEN** the system SHALL log them out
- **AND** SHALL return to the login form with an error stating the account has no panel access

#### Scenario: Wrong password
- **WHEN** an admin submits the login form with an incorrect password
- **THEN** the system SHALL reject the attempt
- **AND** SHALL display an "Email atau password salah." error

### Requirement: Admin routes are gated by an admin middleware

The system SHALL protect every `/admin/*` route with an `admin` middleware that verifies the authenticated user has `role = admin`.

#### Scenario: Unauthenticated visitor
- **WHEN** an unauthenticated visitor opens `/admin` or any `/admin/*` route
- **THEN** the system SHALL redirect to `/login`

#### Scenario: Authenticated non-admin
- **WHEN** an authenticated user whose role is not `admin` opens any `/admin/*` route
- **THEN** the system SHALL return HTTP 403

#### Scenario: Authenticated admin
- **WHEN** an authenticated admin opens any `/admin/*` route
- **THEN** the system SHALL serve the requested page

### Requirement: Admin dashboard summarises platform activity

The system SHALL render an admin dashboard at `/admin` that shows aggregate KPIs and the most recent paid transactions.

#### Scenario: Dashboard renders KPIs
- **WHEN** an admin opens `/admin`
- **THEN** the page SHALL display: total users grouped by role, total vendors, total pesanan, total GMV (sum of `payments.gross_amount` where `payments.status = 'settlement'`)

#### Scenario: Recent transactions list
- **WHEN** an admin opens `/admin`
- **THEN** the page SHALL list the 10 most recent pesanan whose payment status is `settlement`, ordered by created_at descending, each showing pesanan id, vendor name, customer name, total, and created_at

### Requirement: Admin can manage users

The system SHALL allow an admin to list, search, create, edit, soft-delete, and restore users from `/admin/users`.

#### Scenario: List users
- **WHEN** an admin opens `/admin/users`
- **THEN** the page SHALL display a paginated table of users with columns: name, email, role, created_at, status (active / deleted)

#### Scenario: Search by name or email
- **WHEN** an admin submits the search field with a query string
- **THEN** the list SHALL only include users whose name or email contains the query (case-insensitive)

#### Scenario: Filter by role
- **WHEN** an admin selects a role filter (`admin`, `vendor`, `customer`, `guest`)
- **THEN** the list SHALL only include users with that role

#### Scenario: Create user
- **WHEN** an admin submits the create-user form with name, email, role, and password
- **THEN** the system SHALL validate the input
- **AND** SHALL persist a new user with a hashed password
- **AND** SHALL redirect to the users index with a success flash

#### Scenario: Create user with duplicate email
- **WHEN** an admin submits the create-user form with an email that already exists
- **THEN** the system SHALL reject the submission
- **AND** SHALL show a validation error on the email field

#### Scenario: Edit user
- **WHEN** an admin submits the edit-user form changing name, email, or role
- **THEN** the system SHALL update the user
- **AND** SHALL redirect to the users index with a success flash

#### Scenario: Reset user password
- **WHEN** an admin submits the "reset password" form for a user with a new password
- **THEN** the system SHALL hash and store the new password

#### Scenario: Soft-delete user
- **WHEN** an admin clicks delete on another user and confirms
- **THEN** the system SHALL soft-delete the user (set `deleted_at`)
- **AND** SHALL redirect to the users index with a success flash

#### Scenario: Restore soft-deleted user
- **WHEN** an admin clicks restore on a soft-deleted user
- **THEN** the system SHALL clear `deleted_at`
- **AND** the user SHALL appear in the default list again

#### Scenario: Admin cannot delete themselves
- **WHEN** an admin clicks delete on their own user row
- **THEN** the system SHALL reject the action with HTTP 403
- **AND** SHALL not modify the user

#### Scenario: Admin cannot demote themselves
- **WHEN** an admin submits the edit-user form for their own account with a role other than `admin`
- **THEN** the system SHALL reject the submission with a validation error

### Requirement: Admin can manage articles with publish and archive lifecycle

The system SHALL allow an admin to perform full CRUD on articles from `/admin/artikel` and SHALL support `draft`, `published`, and `archived` statuses.

#### Scenario: List articles
- **WHEN** an admin opens `/admin/artikel`
- **THEN** the page SHALL display a paginated table of articles with columns: judul, kategori, status, published_at, author, updated_at

#### Scenario: Filter by status
- **WHEN** an admin selects a status filter (`draft`, `published`, `archived`, or `all`)
- **THEN** the list SHALL only include articles with the selected status (or all if `all`)

#### Scenario: Create article as draft
- **WHEN** an admin submits the create-article form with judul, konten, kategori, and status=`draft`
- **THEN** the system SHALL validate input (judul required max:255, konten required, kategori required, gambar_sampul nullable image max:2048)
- **AND** SHALL auto-generate a unique slug from judul
- **AND** SHALL persist the article with status=`draft` and published_at=null
- **AND** SHALL set author_id to the current admin's id

#### Scenario: Publish an article
- **WHEN** an admin saves an article with status=`published` and the previous status was not `published`
- **THEN** the system SHALL set published_at to the current timestamp

#### Scenario: Re-publish does not reset published_at
- **WHEN** an admin saves an article whose status was already `published` and remains `published`
- **THEN** the system SHALL NOT overwrite published_at

#### Scenario: Archive an article
- **WHEN** an admin clicks "Arsipkan" on a published article
- **THEN** the system SHALL set status to `archived`
- **AND** the article SHALL no longer appear on the public landing page

#### Scenario: Restore from archive
- **WHEN** an admin saves an archived article with status=`draft` or `published`
- **THEN** the system SHALL update status accordingly
- **AND** SHALL keep konten and gambar_sampul intact

#### Scenario: Cover image upload
- **WHEN** an admin submits the article form with a valid image file under 2MB
- **THEN** the system SHALL store it at `storage/app/public/artikel/<randomized-filename>`
- **AND** SHALL set `gambar_sampul` to the storage path

#### Scenario: Replace cover image
- **WHEN** an admin submits the edit-article form with a new image file
- **THEN** the system SHALL store the new file
- **AND** SHALL delete the previously stored image from disk

#### Scenario: Slug collision
- **WHEN** an admin submits a new article whose generated slug already exists
- **THEN** the system SHALL append `-2`, `-3`, ... until the slug is unique

#### Scenario: Delete article
- **WHEN** an admin clicks delete on an article and confirms
- **THEN** the system SHALL soft-delete the article
- **AND** the article SHALL not appear in the default index

### Requirement: Admin can monitor transactions across all vendors

The system SHALL render a read-only transaction monitor at `/admin/transaksi` that lists every `Pesanan` joined with its `Payment` and `Vendor`, with filtering.

#### Scenario: List transactions
- **WHEN** an admin opens `/admin/transaksi`
- **THEN** the page SHALL display a paginated table (page size 25) with columns: pesanan id, vendor name, customer name, total, payment status, order status, created_at

#### Scenario: Filter by vendor
- **WHEN** an admin selects a vendor in the filter dropdown
- **THEN** the list SHALL only include pesanan whose vendor matches

#### Scenario: Filter by payment status
- **WHEN** an admin selects a payment status (`pending`, `settlement`, `expire`, `cancel`, `deny`)
- **THEN** the list SHALL only include pesanan whose payment status matches

#### Scenario: Filter by order status
- **WHEN** an admin selects an order status (`pending`, `diproses`, `selesai`, `dibatalkan`)
- **THEN** the list SHALL only include pesanan with that status

#### Scenario: Filter by date range
- **WHEN** an admin sets a start date and end date
- **THEN** the list SHALL only include pesanan whose `created_at` falls within the range (inclusive)

#### Scenario: View transaction detail
- **WHEN** an admin opens a pesanan detail page
- **THEN** the page SHALL display the pesanan header, payment record, and all `detail_pesanans` line items with menu name, quantity, and subtotal

#### Scenario: Transactions are read-only
- **WHEN** an admin views the transaction list or detail
- **THEN** the system SHALL NOT expose any UI to mutate pesanan status or payment status

### Requirement: A seeded admin user exists out of the box

The system SHALL provide an idempotent seeder that creates or refreshes at least one admin account so the panel is reachable on a fresh install.

#### Scenario: Fresh seed
- **WHEN** an operator runs `php artisan migrate:fresh --seed`
- **THEN** a user with email `admin@kantinkita.id` and role `admin` SHALL exist
- **AND** that user SHALL be able to log in via `/login`

#### Scenario: Re-seed does not duplicate
- **WHEN** the seeder runs a second time
- **THEN** the system SHALL NOT create a duplicate admin user
- **AND** the existing admin's password SHALL remain unchanged unless explicitly intended by the seeder
