## ADDED Requirements

### Requirement: Menu item has unique barcode identifier
Every menu item SHALL have a unique `id_barang` string for barcode encoding.

#### Scenario: id_barang auto-generated on create
- **WHEN** a new menu item is created without specifying `id_barang`
- **THEN** system SHALL auto-generate an 8-character uppercase alphanumeric `id_barang`

#### Scenario: id_barang unique per vendor
- **WHEN** two menu items belong to the same vendor
- **THEN** they MUST have different `id_barang` values

#### Scenario: id_barang preserved on update
- **WHEN** vendor updates menu item details (name, price, etc.)
- **THEN** `id_barang` SHALL remain unchanged

### Requirement: Vendor can download price tag PDF with barcode
Vendor SHALL be able to download a PDF price tag for any menu item.

#### Scenario: Price tag PDF from vendor dashboard
- **WHEN** vendor clicks "Cetak Tag Harga" button on a menu item
- **THEN** system SHALL return a PDF file containing the price tag

#### Scenario: PDF contains barcode above id_barang
- **WHEN** vendor downloads price tag PDF
- **THEN** PDF SHALL display a Code128 barcode encoding the `id_barang`

#### Scenario: PDF contains menu information
- **WHEN** vendor downloads price tag PDF
- **THEN** PDF SHALL display: barcode, `id_barang`, `nama_menu`, `harga`

### Requirement: Barcode is scannable
The generated barcode SHALL be readable by standard barcode scanners.

#### Scenario: Scanner can read barcode
- **WHEN** a standard barcode scanner reads the printed price tag
- **THEN** it SHALL output the exact `id_barang` string

#### Scenario: Barcode resolution adequate for printing
- **WHEN** generated at 300 DPI
- **THEN** barcode image SHALL be at minimum 2 inches wide

### Requirement: Access control for price tag download
Only authenticated vendor users SHALL download price tags for their own menu items.

#### Scenario: Non-vendor cannot download
- **WHEN** non-vendor user requests price tag PDF
- **THEN** system SHALL return 403 Forbidden

#### Scenario: Vendor cannot download another vendor's menu
- **WHEN** vendor A requests price tag for vendor B's menu item
- **THEN** system SHALL return 403 Forbidden
