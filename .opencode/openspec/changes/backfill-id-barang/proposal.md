## Why

Existing menus created before the `id_barang` migration have `id_barang = null`, causing `PriceTagController::generate()` to crash with TypeError when `getBarcode()` receives null instead of string. The database column allows nulls despite the code assuming non-null values.

## What Changes

- New migration to backfill `id_barang` for all existing menu records with null values
- Make `id_barang` column non-nullable to match code assumptions
- Add test verifying existing records can be backfilled

## Capabilities

### New Capabilities
- `backfill-id-barang`: Migration to populate and enforce `id_barang` on all menu records

### Modified Capabilities
- (none)

## Impact

- `database/migrations/` — one new migration file
- `tests/Feature/KantinFlowTest.php` — one new test for backfill behavior
- Existing menus (26+ records in production DB) — all get unique 8-char id_barang
