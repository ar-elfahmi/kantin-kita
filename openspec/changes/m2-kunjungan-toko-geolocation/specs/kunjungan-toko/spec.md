## ADDED Requirements

### Requirement: Vendor can register stores with high-accuracy GPS coordinates
A vendor SHALL be able to record stores in their working area, each with name and geolocation captured from the device.

#### Scenario: Toko registration captures best-effort accurate position
- **WHEN** the vendor clicks "Ambil Lokasi Toko" on the toko-create form
- **THEN** the page SHALL use `navigator.geolocation.watchPosition` with `enableHighAccuracy:true` and select the position with the smallest `accuracy` value reached within a 20-second timeout (modul Lampiran 1)

#### Scenario: Toko persisted with auto-generated barcode
- **WHEN** the vendor submits the toko-create form
- **THEN** the system SHALL persist a `lokasi_toko` row with an 8-character uppercase alphanumeric `barcode`, the submitted `nama_toko`, and the captured `latitude`, `longitude`, `accuracy`
- **AND** the barcode SHALL be unique across all `lokasi_toko` rows

### Requirement: Each store has a printable QR code
Each registered toko SHALL have an associated QR code that encodes its barcode, suitable for printing and posting at the physical store.

#### Scenario: QR encodes only the barcode
- **WHEN** vendor opens `/dashboard/kunjungan/toko/{barcode}/qr`
- **THEN** the page SHALL display a server-rendered PNG QR encoding the toko's `barcode` string and only the barcode (no URL, no JSON payload)

#### Scenario: Cross-vendor QR access is forbidden
- **WHEN** vendor A requests the QR for vendor B's toko via direct URL
- **THEN** the response SHALL be 403 Forbidden

### Requirement: Scanner page resolves QR to toko data
The scanner page SHALL look up the scanned barcode against the current vendor's `lokasi_toko` rows and display the toko's name and recorded accuracy.

#### Scenario: Successful lookup
- **WHEN** the scanner reads a QR containing a barcode belonging to the current vendor
- **THEN** the lookup endpoint `/dashboard/kunjungan/api/toko/{barcode}` SHALL return 200 with JSON `{ barcode, nama_toko, latitude, longitude, accuracy }`

#### Scenario: Unknown or foreign barcode
- **WHEN** the scanned barcode does not exist for the current vendor (either non-existent or belonging to another vendor)
- **THEN** the endpoint SHALL return 404 with a generic "Toko tidak ditemukan" message
- **AND** the response SHALL NOT distinguish between "non-existent" and "belongs to another vendor" (prevents barcode enumeration)

### Requirement: Visit acceptance is computed server-side via Haversine + effective threshold
The system SHALL compute the distance between the sales position and the toko position server-side, compare against the effective threshold, and persist the outcome.

#### Scenario: Haversine distance computation
- **WHEN** a visit is submitted with `barcode`, `sales_latitude`, `sales_longitude`, `sales_accuracy`
- **THEN** the system SHALL compute `jarak_meter` using the Haversine formula from modul Lampiran 2 (R = 6,371,000 meters)

#### Scenario: Effective threshold formula
- **WHEN** computing whether to accept a visit
- **THEN** the system SHALL compare `jarak_meter` against `threshold_efektif = 300 + lokasi_toko.accuracy + sales_accuracy` (modul Lampiran 3)

#### Scenario: Within threshold → accepted and logged
- **WHEN** `jarak_meter <= threshold_efektif`
- **THEN** the system SHALL persist a `kunjungan_toko` row with `status = 'accepted'` and return JSON `{ status: 'accepted', jarak_meter, threshold_efektif }`

#### Scenario: Beyond threshold → rejected and logged
- **WHEN** `jarak_meter > threshold_efektif`
- **THEN** the system SHALL still persist a `kunjungan_toko` row with `status = 'rejected'` (for audit) and return JSON `{ status: 'rejected', jarak_meter, threshold_efektif }`

### Requirement: Visit log scoped to vendor
The kunjungan list SHALL display visits belonging only to the current vendor.

#### Scenario: Vendor sees only own kunjungan
- **WHEN** authenticated vendor visits `/dashboard/kunjungan/`
- **THEN** the Riwayat Kunjungan panel SHALL list only rows where `kunjungan_toko.vendor_id = current vendor.id`
