## MODIFIED Requirements

### Requirement: Vendor scanner recognizes both order QR and tag-harga barcode
The sidebar Scan Barcode modal SHALL recognize input from two formats and dispatch each to its appropriate lookup endpoint.

#### Scenario: Scanned order QR resolves to order details (regression check)
- **WHEN** the scanned text matches `^KK-\d+-\d+$`
- **THEN** the modal SHALL call `/api/checkout/by-order-id/{text}` and render the existing order details card unchanged

#### Scenario: Scanned tag-harga barcode resolves to menu details
- **WHEN** the scanned text (after trimming + uppercasing) matches `^[A-Z0-9]{8}$`
- **THEN** the modal SHALL call `/api/menu/by-id-barang/{text}` and render a menu details card with nama_menu, kategori, harga (formatted), id_barang (mono pill), deskripsi, availability badge, and image if present

#### Scenario: Unrecognized format
- **WHEN** the scanned text matches neither regex
- **THEN** the modal SHALL display "Format barcode tidak dikenali" without making any HTTP request

### Requirement: Menu lookup is vendor-scoped
The `/api/menu/by-id-barang/{idBarang}` endpoint SHALL only return menus belonging to the authenticated vendor.

#### Scenario: Own menu lookup succeeds
- **WHEN** the authenticated vendor requests their own menu's id_barang
- **THEN** the endpoint SHALL return 200 with the menu data

#### Scenario: Foreign menu lookup returns 404 (no enumeration leak)
- **WHEN** vendor A requests vendor B's menu by id_barang
- **THEN** the endpoint SHALL return 404 with the same "Menu tidak ditemukan" message as a non-existent id_barang
- **AND** the response SHALL NOT distinguish between "does not exist" and "belongs to another vendor"

#### Scenario: Unauthenticated request rejected
- **WHEN** an unauthenticated client requests the endpoint
- **THEN** the response SHALL be 302 redirect to login (default Laravel `auth` middleware behavior)

### Requirement: Manual input accepts both formats
The "Input Manual" fallback in the scanner modal SHALL accept either an order ID or a menu id_barang and dispatch identically to the camera-scan path.

#### Scenario: Manual order ID
- **WHEN** user types a string matching `^KK-\d+-\d+$` and clicks "Cari"
- **THEN** the modal SHALL invoke the order-lookup flow

#### Scenario: Manual id_barang (lowercase OK)
- **WHEN** user types an 8-character alphanumeric string (any case) and clicks "Cari"
- **THEN** the modal SHALL uppercase the input and invoke the menu-lookup flow
