## Context

The existing sidebar scanner uses `html5-qrcode` v2.3.8 (CDN-loaded) and was designed in the `vendor-scan-barcode` OpenSpec change purely around order-receipt QRs. Its `onScanSuccess` handler unconditionally calls `lookupOrder(decoded)`, which then hits `/api/checkout/by-order-id/{orderId}` and renders a fixed order card.

The two formats we need to distinguish are unambiguous at the regex level:
- Order QR: `^KK-\d+-\d+$` (literal `KK-`, then numeric pesanan id, dash, numeric unix timestamp)
- Tag harga barcode: `^[A-Z0-9]{8}$` (from `Menu::booted::creating` which generates via `strtoupper(Str::random(8))`)

There is no overlap: `KK-` is 3 chars + dashes, an 8-char alphanumeric without dashes cannot match the order regex, and vice versa.

## Goals / Non-Goals

**Goals:**
- Recognize tag-harga barcodes from the same scanner UX (no separate button, no separate page)
- Preserve the existing order-scan behavior bit-for-bit (no regression)
- Hard tenant isolation: vendor cannot look up another vendor's menu by guessing id_barang
- Return-shape mirrors the order-lookup endpoint style (flat JSON, no nested envelopes)

**Non-Goals:**
- Adding a POS / shopping-cart UI off the back of the scan (a separate "scan to add to order" flow is a future module — see the kunjungan-toko design doc's mention of POS ambitions)
- Allowing customers (non-vendor users) to use the scanner — vendor-only is sufficient and matches the placement (it lives in the vendor dashboard sidebar)
- Multi-format encoding fallback (we trust Picqer's Code128 output and Endroid's QR output; both round-trip the exact string)

## Decisions

| Decision | Choice | Rationale |
|---|---|---|
| New route location | `GET /api/menu/by-id-barang/{idBarang}` under existing `auth` group | Mirrors `/api/checkout/by-order-id/{orderId}` exactly; same audience (authenticated vendor); same return-shape pattern |
| Controller home | `PriceTagController::lookupByIdBarang` | This controller already deals with menu+id_barang in `generate()`; adding the lookup keeps the pair (generate ↔ lookup) co-located. Creating a new `MenuLookupController` for one method would be premature abstraction. |
| Format dispatcher in JS | Regex on uppercased input | Trivial, fast, no roundtrip needed to guess format. Uppercasing first means manual-typed lowercase id_barangs still match. |
| Unknown format handling | Show a user-facing "Format barcode tidak dikenali" error in the modal | Prevents wasted HTTP calls; explicit feedback so the user knows the scan was read but not understood. |
| 404 on cross-tenant lookup | Generic "Menu tidak ditemukan" (no leakage between "missing" and "foreign") | Matches the kunjungan-toko design philosophy (see `m2-kunjungan-toko-geolocation/design.md`). |
| Result card | Reuse `.scan-result-card` / `.scan-result-item` CSS already defined for the order modal | Zero new CSS, consistent visual language; the menu card is structurally similar (header + label/value rows) |
| Image rendering | Use `$menu->path_gambar` directly if set, otherwise omit the image | The DB column stores either a URL or null; no fallback placeholder needed in v1 |
| Field returned: `harga` | Raw integer (rupiah, e.g. 12500) | Client-side formats with `numberFormat` helper that's already in scope inside the IIFE; consistent with how `lookupOrder` returns raw integers |

**Alternatives considered:**
- **Server-side detection** (one endpoint `/api/scan/{code}` that branches by format) — pushes the dispatch logic to the server, hides it from the client, but adds a roundtrip just to discover the format. Client-side regex is free and matches the spirit of "fast feedback".
- **Two distinct scanner buttons in the sidebar** (one for orders, one for tags) — worse UX; vendor knows what they're scanning, the system should figure out the format. Also conflicts with the existing single-button placement.
- **Encode the menu URL inside the QR / barcode** (`/dashboard/menu/{idBarang}`) — would let any scanner navigate to a page, not just our app's modal. Rejected: vendor scanner is the only consumer; URL-encoding would inflate the QR version unnecessarily; tag-harga uses 1D Code128 which doesn't fit a URL well anyway.

## Risks / Trade-offs

| Risk | Mitigation |
|---|---|
| Future order_id format changes (e.g., `KK-{vendor_id}-{seq}`) could collide with the menu regex | Current order pattern is hard-coded in `extractPesananIdFromOrderId` regex in `CheckoutController`; both regexes live in the same module — easy to coordinate any future change. Document the format claim in the design doc. |
| User scans a barcode from another app (random QR, contact card, etc.) | The dispatcher returns "Format barcode tidak dikenali" instead of silently failing or making a useless HTTP call. |
| `id_barang` collision space is small (36^8 ≈ 2.8 trillion) — could theoretically collide across the whole system | Existing `Menu::booted::creating` already loops until unique. Vendor scoping on lookup means the cross-vendor case is impossible to surface even if a collision happened. |
| Vendor accidentally scans a menu from someone else's printout | 404 + "Menu tidak ditemukan" — same UX as scanning a non-existent code. No information leak. |
