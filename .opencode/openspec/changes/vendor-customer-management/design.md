## Context

Kantin-kita has a multi-vendor architecture: each vendor row in `vendors` owns menus, pesanans, etc. End customers ordering food are modeled as ephemeral `User` rows with `role=guest`. There is no "registered customer" concept today.

The modul's Studi Kasus 3 introduces a richer customer entity with full address fields. The pedagogical point of the exercise is to compare two photo-storage strategies (BLOB-in-DB vs file-on-disk-with-path-in-DB) by implementing both in parallel.

## Goals / Non-Goals

**Goals:**
- Implement both photo-storage variants in the same `customers` table so the same data model can be queried/displayed identically regardless of which submenu created the row
- Scope customers per vendor (consistent with the rest of kantin-kita's tenant model)
- Camera capture must support multi-camera devices (front/back) — the modul explicitly mentions "Pilihan Kamera"
- Reuse the existing dashboard visual language (cream / brown / green palette)

**Non-Goals:**
- Customer login / customer-facing portal — customers are records the vendor maintains, not authenticated users
- Edit/delete operations on customers — only create + list for this module
- Bulk import — single-row creation only
- Image resizing / compression — store as captured (academic project; production would resize to a sane max)
- Cross-vendor customer search — strict tenant isolation

## Decisions

| Decision | Choice | Rationale |
|---|---|---|
| Customer scoping | Vendor-scoped (`vendor_id` FK) | Matches kantin-kita's multi-tenant pattern; prevents leakage between vendors |
| One table or two | One `customers` table with both `foto_blob` (nullable) and `foto_path` (nullable) | Modul wants both variants in parallel; a single table makes listing trivial (one query) and forces the student to handle the polymorphism in the view |
| Blob column type | LONGBLOB (4 GB max) via post-create `ALTER` | Laravel's `binary()` defaults to BLOB (64 KB cap); webcam JPEGs commonly exceed that |
| Photo serving for blob rows | Dedicated route `GET /dashboard/customer/{id}/photo` that streams the raw bytes | Embedding blobs as `data:` URIs in the list page would bloat HTML; a dedicated route lets the browser cache the image and serve it like any other resource |
| Photo serving for path rows | Public `storage` symlink, served as `<img src="/storage/customers/...">` | Standard Laravel pattern; the file is already on disk, no PHP roundtrip needed for serving |
| Storage disk | `public` (mapped to `storage/app/public/`) | Web-serveable via `storage:link`; private disk would require a PHP-served stream which defeats the path-variant lesson |
| Camera capture transport | Submit a PNG `data:` URL via a hidden form field for **both** variants; decode server-side | Identical JS for both flows; server-side branching is trivial; no multipart-form complexity for the JS |
| Photo format | PNG | `<canvas>.toDataURL()` defaults to PNG; lossless; consistent across variants |
| Camera modal placement | Partial `_camera_modal.blade.php` included by both create views | Single source of truth for the capture UI; avoids drift between blob and path variants |
| Address: kodepos + kelurahan | Two separate columns | Better data quality than one combined string; the modul diagram shows them as adjacent fields anyway |
| Validation | Server-side via `Request::validate` (required nama, alamat, provinsi, kota, kecamatan, kelurahan, kodepos, foto_data_url) | Standard Laravel; lightweight; no FormRequest class needed for this scope |

**Alternatives considered:**
- **Two separate tables (`customers_blob` and `customers_path`)**: rejected — explodes view logic and obscures the comparison the modul is teaching.
- **Submit photo as multipart file upload for the path variant**: rejected — would force the JS to differ between variants, adding accidental complexity.
- **Eloquent's `Crypt` cast for the blob**: rejected — not requested by the modul; encryption-at-rest would also make the blob 33% larger.
- **Use a packages like `intervention/image` for resizing**: rejected — out of scope; the lesson is about storage choice, not image processing.
- **Customer auth (treating Customer as a User)**: rejected — the modul does not describe login or customer-side actions; the customer is a record, not an actor.

## Risks / Trade-offs

| Risk | Mitigation |
|---|---|
| LONGBLOB rows bloat the database; slow backups | Acceptable for academic project; documented in proposal as a "would reconsider in production" |
| `php artisan binary()` defaulting to BLOB silently truncates photos to 64 KB | Migration explicitly runs `ALTER TABLE ... MODIFY foto_blob LONGBLOB NULL` immediately after create; verified in MySQL |
| MIME-sniffing attacks on the BLOB photo endpoint | `photoBlob` controller sets `Content-Type: image/png` explicitly and `X-Content-Type-Options: nosniff`; only the owning vendor's authenticated session can hit the route (auth middleware + vendor ownership check) |
| Browser denies camera permission | JS catches the rejection from `getUserMedia` and displays an inline error message in the modal; user can close and retry |
| Multi-camera enumeration requires camera permission first | The "Pilihan Kamera" select is populated only AFTER the initial getUserMedia succeeds (Chrome / Firefox behavior); documented in code comments |
| `storage:link` step easy to forget on fresh clones | Listed as a setup task in tasks.md; failing silently (404 on photo) is also a quick debug signal |
| Sidebar duplication keeps growing (now 4 views with the same sidebar) | TODO comment in each view; planned follow-up to extract `vendor/_sidebar.blade.php` partial once the module is complete |
