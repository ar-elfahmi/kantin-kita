## ADDED Requirements

### Requirement: Vendor can register customers with full address details
A vendor SHALL be able to record customers under their own account, each with name, address, and a captured photo.

#### Scenario: Vendor opens the customer index
- **WHEN** an authenticated vendor visits `/dashboard/customer`
- **THEN** the page SHALL list every customer where `customers.vendor_id` equals the authenticated vendor's id, and SHALL NOT list customers belonging to other vendors

#### Scenario: Vendor creates a customer via the blob variant
- **WHEN** the vendor submits the Tambah Customer 1 form with all required fields and a valid PNG `data:` URL
- **THEN** the system SHALL persist a new `customers` row with `foto_blob` populated and `foto_path` NULL

#### Scenario: Vendor creates a customer via the path variant
- **WHEN** the vendor submits the Tambah Customer 2 form with all required fields and a valid PNG `data:` URL
- **THEN** the system SHALL write the decoded bytes to `storage/app/public/customers/{uuid}.png`, persist a new `customers` row with `foto_path` equal to `customers/{uuid}.png`, and `foto_blob` NULL

### Requirement: Photos render correctly regardless of storage variant
The customer list page SHALL display photo thumbnails for both storage variants without exposing which variant was used to the casual viewer.

#### Scenario: Blob-stored photo renders in the list
- **WHEN** the customer's `foto_blob` is non-null
- **THEN** the list SHALL render `<img src="/dashboard/customer/{id}/photo">` and the response body SHALL contain the raw PNG bytes with `Content-Type: image/png`

#### Scenario: Path-stored photo renders in the list
- **WHEN** the customer's `foto_path` is non-null
- **THEN** the list SHALL render `<img src="/storage/{foto_path}">` (served by the public storage symlink)

### Requirement: Photo capture supports multi-camera devices
The capture modal SHALL allow the user to choose between available cameras on devices that have more than one (e.g., laptop with built-in webcam plus USB cam; phone with front and back).

#### Scenario: Single-camera device
- **WHEN** the device has exactly one camera
- **THEN** the camera selector MAY be hidden or shown disabled; the single camera SHALL be activated by default

#### Scenario: Multi-camera device
- **WHEN** the device exposes more than one video input device
- **THEN** the camera selector SHALL list all of them and switching the selection SHALL replace the active stream within 2 seconds

### Requirement: Cross-tenant photo access is forbidden
A vendor SHALL NOT be able to access another vendor's customer photos via direct URL guessing.

#### Scenario: Foreign customer photo blocked
- **WHEN** vendor A authenticates and requests `/dashboard/customer/{id}/photo` for a customer that belongs to vendor B
- **THEN** the response SHALL be 403 Forbidden

#### Scenario: Path-variant foreign customer photo
- **WHEN** vendor A authenticates and guesses the UUID-based path of vendor B's customer photo
- **THEN** the request SHALL still succeed because the path is on the public disk — this is an accepted academic-project trade-off; mitigated by UUID-v4 unguessability
