## ADDED Requirements

### Requirement: Vendor can add new menu item via dashboard

The system SHALL allow an authenticated vendor user to add a new menu item from the dashboard page via a modal form.

#### Scenario: Open add product modal
- **WHEN** vendor clicks "Tambah Produk" button on the dashboard
- **THEN** a modal form SHALL appear with fields: Nama Menu, Deskripsi, Harga, Kategori, Gambar, Status Tersedia

#### Scenario: Submit with valid data
- **WHEN** vendor fills all required fields and submits the form
- **THEN** the system SHALL create a new Menu record with auto-generated id_barang
- **AND** the system SHALL store the uploaded image to `storage/app/public/menus/`
- **AND** the system SHALL show a success message
- **AND** the product grid SHALL refresh to include the new item

#### Scenario: Submit with missing required fields
- **WHEN** vendor submits the form without nama_menu or harga
- **THEN** the system SHALL reject the submission
- **AND** SHALL display validation errors for the missing fields inline in the modal

#### Scenario: Submit with invalid image
- **WHEN** vendor uploads a file larger than 2MB or a non-image file
- **THEN** the system SHALL reject the submission
- **AND** SHALL display a validation error for path_gambar

#### Scenario: Submit with harga set to zero or negative
- **WHEN** vendor submits the form with harga <= 0
- **THEN** the system SHALL reject the submission
- **AND** SHALL display a validation error for harga

#### Scenario: Non-vendor user cannot access
- **WHEN** a user without a vendor profile attempts to submit the form
- **THEN** the system SHALL return a 403 error

### Requirement: Image upload for menu item

The system SHALL accept an optional image file for the menu item and store it persistently.

#### Scenario: Image uploaded successfully
- **WHEN** vendor submits the form with a valid image file
- **THEN** the file SHALL be stored at `storage/app/public/menus/<randomized-filename>`
- **AND** the `Menu.path_gambar` field SHALL contain the storage path

#### Scenario: No image uploaded
- **WHEN** vendor submits the form without an image
- **THEN** the system SHALL create the Menu with path_gambar set to null
- **AND** the frontend SHALL display a placeholder image

### Requirement: Category selection for menu item

The system SHALL allow the vendor to select a category for the new menu item from existing KategoriMenu records.

#### Scenario: Select existing category
- **WHEN** vendor selects a category from the dropdown
- **AND** submits the form
- **THEN** the Menu.kategori_menu_id SHALL be set to the selected category's ID

#### Scenario: No category selected
- **WHEN** vendor does not select a category
- **AND** submits the form
- **THEN** the Menu.kategori_menu_id SHALL be null
