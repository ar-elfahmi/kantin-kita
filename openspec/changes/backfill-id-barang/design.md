## Context

`id_barang` column was added as nullable to avoid blocking existing migration. The Menu model's `booted()` `creating` event auto-generates `id_barang` for new records, but ~26 existing seed menus have `id_barang = null`. `PriceTagController::generate()` calls `getBarcode($menu->id_barang, ...)` which crashes on null.

## Goals / Non-Goals

**Goals:**
- Backfill `id_barang` for all existing menu records
- Enforce non-null constraint at database level
- Preserve existing auto-generation logic for new records
- All 59+ existing tests pass unchanged

**Non-Goals:**
- No changes to PriceTagController or Menu model behaviour
- No changes to seeders (fresh migrate will re-create menus fresh)
- No UI changes

## Decisions

- **Single migration for backfill + constraint**: One migration file that backfills null rows (reuses the same 8-char uppercase logic via PHP helper) then `change()` to non-nullable. Keeps deployment atomic.
- **Backfill in `up()` not seeder**: Seed data changes across environments; migration ensures every database gets fixed regardless of seed state
- **Reuse existing ID generation logic**: Call `Str::upper(Str::random(8))` inside migration (same as Model booted) for consistency

## Risks / Trade-offs

- **Duplicate collision on backfill**: Random 8-char has ~2×10¹⁴ combinations for 26 records → negligible. Still wrap in while-loop (same pattern as booted).
- **Rollback**: `down()` sets column back to nullable but doesn't null existing values — acceptable since rollback is rare in practice.
