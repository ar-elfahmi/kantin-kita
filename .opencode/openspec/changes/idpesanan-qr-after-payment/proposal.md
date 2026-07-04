## Why

Module 1 Studi Kasus 2 (`Modul_barcode, qr code, akses kamera.md`) requires a QR code containing the `idpesanan` to be displayed after a customer successfully completes payment. The current `order-success.blade.php` page already renders a QR code, but it is generated client-side via the `qrcodejs` CDN library — not via the PHP libraries the modul explicitly recommends (`Endroid QR Code`, `PHP QR Code`).

Switching to server-side generation:
- Aligns with the modul's stated library list and the rest of kantin-kita's "generate-on-server" pattern (cf. `picqer/php-barcode-generator` for the price tag PDF)
- Allows the QR to be saved / shared as a real image (not a runtime-rendered canvas)
- Works even if JS is blocked or the CDN is unreachable
- Makes the QR available to downstream consumers (PDF receipts, email attachments) later

## What Changes

- Add `endroid/qr-code` as a Composer dependency
- Generate a PNG QR encoding the canonical `order_id` (e.g. `KK-{pesanan_id}-{timestamp}`) inside `CheckoutController::success()`
- Convert the QR PNG to a base64 data URI and pass it to the `order-success` view
- Replace the client-side `<div id="qrcode">` + `qrcodejs` script with a server-rendered `<img>` tag using the data URI
- Remove the `qrcodejs` CDN `<script>` tag and the inline JS that initialized it

## Capabilities

### New Capabilities
- `pesanan-qr-after-payment`: Generate and display a server-side QR code containing the order ID on the payment-success page

### Modified Capabilities
- (none)

## Impact

- `composer require endroid/qr-code` — new production dependency (~5 packages including dependencies)
- `app/Http/Controllers/CheckoutController.php` — `success()` method now generates a QR PNG and passes `$qrDataUri` to the view
- `resources/views/order-success.blade.php` — replace JS QR generation with server-rendered `<img>`; drop the CDN script tag and inline JS
- No DB changes, no new routes, no auth changes
- Behavior: the visible QR remains identical (same order_id content, same visual placement on the page); the underlying rendering pipeline moves from browser-side JS to server-side PHP
