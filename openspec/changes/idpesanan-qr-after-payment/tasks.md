## 1. Dependency

- [x] 1.1 `composer require endroid/qr-code` from inside `C:\laragon\www\kantin-kita`
- [x] 1.2 Verify v5.x installs cleanly on PHP 8.3 and shows up in `composer.json` `require`
  - NOTE: Composer pulled `endroid/qr-code v6.0.9` (latest), not v5. v6 dropped the static `Builder::create()` fluent API in favor of named-argument constructor on `final readonly class Builder`. Tasks/design adjusted accordingly.

## 2. Controller

- [x] 2.1 In `CheckoutController::success()`, compute `$orderId = $pesanan->payment?->midtrans_response['order_id'] ?? 'KK-' . $pesanan->id;` (matches the same fallback already used by the view)
- [x] 2.2 Build a PNG QR for `$orderId` using `(new Builder(...))->build()` with `PngWriter`, UTF-8 encoding, error correction High, size 300, margin 10
- [x] 2.3 Get the data URI (`$result->getDataUri()`) and pass it to the view as `qrDataUri`

## 3. View

- [x] 3.1 Remove the `<script src=".../qrcode.min.js">` CDN tag from `order-success.blade.php` `<head>`
- [x] 3.2 Replace `<div id="qrcode"></div>` with `<img src="{{ $qrDataUri }}" alt="QR pesanan {{ $orderId }}" style="display:block;margin:0 auto;width:180px;height:180px;">`
- [x] 3.3 Remove the inline `<script>` block at the bottom that constructs `new QRCode(...)` and the `var orderId = ...` line
- [x] 3.4 Keep the `.qr-section`, `.qr-label`, and `.qr-hint` markup so visual layout is preserved
- [x] 3.5 Update the `.qr-hint` to use the `$orderId` variable from the controller (instead of re-deriving it inline) for consistency

## 4. Verify

- [x] 4.1 `php artisan view:cache` compiles without errors
- [x] 4.2 Runtime smoke test via `php -r`: generated a QR for `KK-42-1713100800`, got a 598-byte `data:image/png;base64,...` URI (correct PNG header `iVBORw0KGgo...`). PHP linter on the controller also passes.
- [ ] 4.3 MANUAL (user): `php artisan serve`, complete a Midtrans sandbox payment, land on `/order/{id}`, confirm the QR renders as a static image (right-click → Save Image works)
- [ ] 4.4 MANUAL (user): Scan the QR with the existing vendor sidebar scanner (`/dashboard` → "Scan Barcode") and confirm the order details load — round-trip works
- [ ] 4.5 MANUAL (user): Disable JavaScript in the browser, reload the success page, confirm the QR still renders (this proves server-side generation)

## 5. Notes

- v6 visual change vs the previous JS rendering: foreground is now pure black `#000000` (library default) instead of the previous `--brown #744622`. Improves scanner reliability on low-quality scanners. If brown is required for visual brand consistency later, pass `foregroundColor: new \Endroid\QrCode\Color\Color(116, 70, 34)` to the Builder constructor.
- The QR content (the actual encoded string) is unchanged: it is still the Midtrans `order_id` (e.g., `KK-42-1713100800`), so the existing vendor scanner contract (`/api/checkout/by-order-id/{orderId}`) keeps working.
