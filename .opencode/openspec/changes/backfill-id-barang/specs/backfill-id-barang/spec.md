## ADDED Requirements

### Requirement: Existing menu records SHALL have id_barang populated

The system SHALL ensure all existing menu records that were created before the id_barang migration receive a unique auto-generated id_barang value. The auto-generation SHALL follow the same logic as the Menu model's creating event (8-character uppercase alphanumeric).

#### Scenario: Backfill existing null id_barang records
- **WHEN** the migration runs
- **THEN** all menu records with `id_barang IS NULL` receive a unique 8-character uppercase alphanumeric string

### Requirement: id_barang column SHALL be non-nullable

The database schema SHALL enforce that `id_barang` cannot be null, matching the application code's assumption.

#### Scenario: New menu always has id_barang
- **WHEN** a new menu is created
- **THEN** `id_barang` is automatically populated by the model booted event, never null
