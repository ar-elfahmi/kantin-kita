## ADDED Requirements

### Requirement: QR code rendered server-side on order success
The order success page SHALL display a QR code that was generated on the server in PHP, not in the browser via JavaScript.

#### Scenario: QR is a static image
- **WHEN** a customer lands on `/order/{pesanan}` after payment
- **THEN** the page SHALL render the QR as an `<img>` element whose `src` is a `data:image/png;base64,...` URI

#### Scenario: QR survives JavaScript disabled
- **WHEN** a customer opens `/order/{pesanan}` with JavaScript disabled
- **THEN** the QR image SHALL still be visible and contain the correct order ID

### Requirement: QR content is the canonical order ID
The QR code SHALL encode the same order ID string that the vendor scanner consumes.

#### Scenario: QR encodes the Midtrans order_id when payment exists
- **WHEN** the pesanan has an associated payment record with `midtrans_response.order_id`
- **THEN** the QR SHALL encode that exact string (e.g., `KK-42-1713100800`)

#### Scenario: QR encodes the fallback order ID when payment is missing
- **WHEN** the pesanan does NOT yet have a payment record
- **THEN** the QR SHALL encode `KK-{pesanan.id}`

#### Scenario: QR is readable by the vendor scanner
- **WHEN** the vendor scans the displayed QR from the customer's phone
- **THEN** the `/api/checkout/by-order-id/{orderId}` endpoint SHALL return the matching pesanan details (200 OK with the expected JSON shape)

### Requirement: QR generation library is server-side PHP
The implementation SHALL use a PHP QR code library recommended by the modul.

#### Scenario: Composer dependency present
- **WHEN** inspecting `composer.json` `require`
- **THEN** `endroid/qr-code` SHALL be listed

#### Scenario: No client-side QR library loaded on the success page
- **WHEN** loading `/order/{pesanan}`
- **THEN** the HTML SHALL NOT include any `<script>` tag referencing `qrcode.min.js` or any other client-side QR library
