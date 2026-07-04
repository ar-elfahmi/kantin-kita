## Context

Kantin-kita already has the building blocks this feature needs:
- **Endroid QR Code** — installed for SK2 (post-payment idpesanan QR). Same Builder API will generate toko QRs.
- **html5-qrcode** — loaded as a CDN script in `dashboard-vendor.blade.php` for the vendor's order-receipt scanner. Same library scans toko QRs.
- **Vendor-scoped authenticated route group** — same pattern as `dashboard.menu` and `dashboard.customer.*`.
- **Browser Geolocation API** — `navigator.geolocation.watchPosition` with `enableHighAccuracy:true`. The modul gives the JS implementation as Lampiran 1.

The canteen domain does not natively have field sales visiting stores, but the modul invites a stretch: vendors maintain a list of "outlet"-style stores and use the same workflow. The grade is on demonstrating the technique, not the business fit.

## Goals / Non-Goals

**Goals:**
- Implement the exact `lokasi_toko` schema specified by the modul (no liberties with column names/types)
- Match the modul's accuracy logic: `threshold_efektif = threshold + accuracy_toko + accuracy_sales` (Lampiran 3)
- Use Haversine for distance (Lampiran 2), implemented server-side so the threshold check cannot be bypassed by tampering with client-side JS
- Reuse Endroid for QR generation (consistent with SK2) and html5-qrcode for scanning (consistent with M1 vendor sidebar)
- Strict vendor scoping: vendor A cannot view, scan, or visit vendor B's toko

**Non-Goals:**
- Sales user accounts / multi-staff per vendor (the vendor user plays the sales role for the demo)
- Configurable threshold per toko or per vendor (constant 300m for now; refactor later if needed)
- Toko edit/delete (this module is about adding + scanning; CRUD is M3+)
- Offline support / sync-when-back-online (academic project scope)
- Map preview UI (Leaflet/Mapbox) — text-only lat/lng is sufficient for the modul

## Decisions

| Decision | Choice | Rationale |
|---|---|---|
| `lokasi_toko` primary key | `barcode VARCHAR(8)` (per modul spec) | Stays faithful to the modul's table definition. PK collisions across vendors are tolerated as a small risk; mitigated by uniqueness check loop on generation. |
| `kunjungan_toko` PK | Auto-inc `id` | Many visits per toko, need natural ordering by time. Not specified by modul, so chose pragmatic default. |
| Threshold | Constant `300` meters | Matches modul Lampiran 3 example. Documented as a class constant so future per-vendor config is a small change. |
| Distance computation | Server-side Haversine | Client-side is untrustworthy: a malicious sales could spoof lat/lng to claim a visit. Server-side computation + accept/reject persisted in DB makes the audit trail authoritative. |
| `accuracy` semantics | Stored in METERS (per `position.coords.accuracy` from the Geolocation API) | Modul example uses 30m, 20m — clearly meters. Browser standard. |
| Threshold_efektif formula | `300 + lokasi_toko.accuracy + sales_accuracy` (per Lampiran 3) | Exact modul formula. |
| QR content | Just the barcode string (8 chars) | Smallest QR → fastest scan, lowest version → most error correction headroom. Lookup endpoint resolves it server-side to full toko data. |
| `getAccuratePosition` JS | Copy verbatim from modul Lampiran 1 | The modul gave the snippet; pedagogically expected. |
| Scanner library | `html5-qrcode` v2.3.8 CDN (same as dashboard sidebar) | Reuse: zero new dependency; consistent scanning UX across pages. |
| Sidebar partial reuse | Promote `vendor/customer/_sidebar.blade.php` to a general dashboard sidebar partial; add Kunjungan Toko nav-item there + update the two inline copies (dashboard-vendor, manage-menu) | The partial is already vendor-generic; only its filename is misleading. Rename deferred to avoid breaking the 3 customer views that include it by name. |
| Route-model binding key | `barcode` (via `$primaryKey` on `LokasiToko`) | Laravel auto-resolves `{lokasi_toko}` URL segment as a string lookup on the model's PK. Same pattern Laravel docs recommend for non-id keys. |
| Scoping check in scan/lookup endpoints | Filter `where('vendor_id', $vendor->id)` before find | Hard cross-tenant boundary; foreign barcode looks indistinguishable from non-existent (returns 404) so vendor B can't enumerate vendor A's barcodes by probing. |

**Alternatives considered:**
- **Leaflet map preview with "drop pin here" UX** — would be a richer experience but adds a JS dependency and offline tiles complexity. Modul does not require it.
- **Use `getCurrentPosition` instead of `watchPosition`** — Lampiran 1 uses `watchPosition` to converge on best accuracy; respecting that.
- **Store accuracy in millimeters / integer microdegrees** — overkill for a 300m radius use case; DOUBLE is fine.
- **Combine `lokasi_toko` and `kunjungan_toko` into a single denormalized table** — would lose history of repeat visits to same toko.
- **Client-side Haversine for instant feedback before submit** — could mirror server logic for UX, but adds duplication and a "lies to user" attack surface. Server is single source of truth.

## Risks / Trade-offs

| Risk | Mitigation |
|---|---|
| Browser geolocation requires HTTPS or localhost | Local dev on `php artisan serve` (localhost) works. If user tests from a phone over LAN, they'll hit the HTTPS requirement; documented as a known constraint, ngrok is the easy fix (same as M3 NFC). |
| Indoor GPS accuracy degrades (~50-200m); legitimate visits get rejected | `accuracy` is included in `threshold_efektif`; high-accuracy values inflate the threshold so the visit is more likely accepted. The modul's Lampiran 3 explicitly models this. |
| Vendor accidentally registers their own toko while NOT at the store | First-time setup error; vendor can re-register via the same form. Edit/delete is out of scope; manual DB fix if needed. |
| Sales spoofs location via DevTools sensor emulation | Acknowledged academic-project limitation. Production would add server-side cross-checks (IP geolocation, time-since-previous-visit plausibility). |
| Cross-vendor barcode collision on auto-generation | `Str::random(8)` over A-Z0-9 has 36^8 ≈ 2.8 trillion combinations; uniqueness check loop in `static::creating` guarantees no collision; not a real risk at academic scale. |
| Migration order matters: `vendor_id` FK requires `vendors` table | All vendor migrations are from 2026-04; this migration is dated 2026-05, naturally after. |
| Adding a 4th sidebar nav item in inline dashboards (dashboard-vendor + manage-menu) keeps growing the duplication | Tracked as a known follow-up (see SK3 tasks notes). Migration to a shared partial in a future pass. |
