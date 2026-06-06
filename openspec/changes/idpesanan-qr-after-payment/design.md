## Context

The post-payment success flow already exists: `CheckoutController::success(Pesanan $pesanan)` loads the order with relations and returns the `order-success` view (route `order.success` at `/order/{pesanan}`). The view currently embeds the `qrcodejs` library from a CDN and constructs the QR client-side using `new QRCode(document.getElementById('qrcode'), { text: orderId, ... })`. The QR content is the canonical Midtrans order ID stored in `payments.midtrans_response['order_id']` (fallback to `KK-{pesanan_id}` if the payment record is missing).

The vendor-side scanner (`vendor-scan-barcode` change, sidebar in `dashboard-vendor.blade.php`) already consumes this exact format and resolves it via `GET /api/checkout/by-order-id/{orderId}`.

## Goals / Non-Goals

**Goals:**
- Generate the QR on the server using a PHP library, matching the modul's recommendation and the project's existing pattern (cf. price-tag barcode via Picqer)
- Preserve the existing visual layout (`.qr-section`, label, hint) and the existing scanner contract (order_id string)
- Keep the change self-contained: no DB migrations, no new routes, no auth changes

**Non-Goals:**
- Caching the QR PNG to disk (regenerated per request; ~10 KB; trivial)
- Embedding the QR into a downloadable PDF receipt — future work
- Branding the QR with the canteen logo in the center — future work
- Falling back to JS rendering if PHP generation fails — over-engineering

## Decisions

| Decision | Choice | Rationale |
|---|---|---|
| Library | `endroid/qr-code` v6.x (installed: 6.0.9) | Listed first in the modul; modern named-argument constructor API; PHP 8.1+ which matches kantin-kita's PHP 8.3 requirement; actively maintained; supports data URI export natively. Note: v6 dropped the static `Builder::create()` fluent API of v5 — use `new Builder(...)` with named args instead. |
| QR content | `payments.midtrans_response['order_id']` with `KK-{id}` fallback | Already the contract used by the existing client-side JS and by the vendor scanner. Changing the content would break the scanner. |
| Generation location | `CheckoutController::success()` method | View should be presentation-only; controller is the right place for data assembly. Matches the price-tag PDF pattern (`PriceTagController::generate` generates barcode then renders view). |
| Output format | base64 data URI passed as `$qrDataUri` | Embeds directly in `<img src="...">` with no extra HTTP request; trivial size (~6–10 KB) |
| Error correction | High (`ErrorCorrectionLevel::High`) | Same as the previous JS configuration (`QRCode.CorrectLevel.H`); 30% recovery makes physical scanning robust |
| Size | 300 px (will be CSS-scaled to 180 px) | Generating at 2× the displayed size keeps the QR sharp on high-DPI displays |
| Colors | Black on white (library default) | The previous JS used brown `#744622` on white; switching to black improves scanner reliability on cheap scanners. Acceptable visual change. |

**Alternatives considered:**
- `bacon/bacon-qr-code`: also a valid PHP option; Endroid's Builder API is more ergonomic and is the modul's first recommendation
- Keep JS rendering and just document it: doesn't match the modul's pedagogical intent (the lecturer explicitly wants students to use PHP QR libraries)
- Generate via a dedicated route `/order/{pesanan}/qr.png`: cleaner for caching but adds a new route for no current benefit

## Risks / Trade-offs

| Risk | Mitigation |
|---|---|
| Composer install pulls many transitive deps and bloats vendor/ | Endroid v5 has minimal deps (BaconQrCode under the hood); acceptable bloat |
| QR color change from brown to black is visually noticeable | Acceptable academic-project trade-off; can re-introduce brown via `RoundBlockSizeMode` options later |
| Removing `qrcodejs` CDN script may break if some other view still uses it | Grep confirms it's only referenced in `order-success.blade.php`; safe to remove |
| `$pesanan->payment` could be null on a freshly created pesanan visited before midtrans webhook | Fallback to `KK-{pesanan_id}` preserved; QR will be non-empty in all cases |
