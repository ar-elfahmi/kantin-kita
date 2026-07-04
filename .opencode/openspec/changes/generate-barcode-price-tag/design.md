## Context

Current vendor system has menu items stored in `menus` table with fields: `id`, `vendor_id`, `nama_menu`, `deskripsi`, `harga`, `path_gambar`, `is_available`. No barcode field or price tag PDF generation exists. No PDF library installed. This is a greenfield addition to support physical price tag printing with scannable barcodes.

## Goals / Non-Goals

**Goals:**
- Add `id_barang` unique identifier to each menu item (for barcode encoding)
- Generate price tag PDFs with scannable barcodes above the `id_barang` text
- Downloadable from vendor dashboard ("Cetak Tag Harga")
- Use Code128 barcode encoding (supports alphanumeric)

**Non-Goals:**
- Bulk PDF generation for all menus at once (future enhancement)
- QR code generation or URL encoding
- Barcode scanning for checkout/menu lookup (separate feature)
- Physical label layout customization (fixed template)

## Decisions

| Decision | Choice | Rationale |
|---|---|---|
| Barcode library | Picqer/php-barcode-generator | 1D Code128 generator optimized for labels/price tags; lightweight; no dependencies |
| PDF library | barryvdh/laravel-dompdf | Native Blade view rendering; most popular Laravel PDF package; simple API |
| Barcode encoding | Code128 | Supports alphanumeric `id_barang`; standard for inventory/item barcodes |
| `id_barang` format | Auto-generated UUID substring (8 chars uppercase) | Unique per vendor scope; human-readable for manual entry |
| Barcode rendering | Base64 PNG embedded in `<img>` tag | DomPDF cannot execute JS canvas rendering; PNG raster is safe |
| UI entry point | "Cetak Tag Harga" button per menu in vendor dashboard | Simple per-item download; no selection UI needed |

**Alternatives considered:**
- Bacon/bacon-qr-code: QR codes are overkill for a simple price tag identifier; 1D barcode is standard in retail
- mpdf/mpdf: Heavier than DomPDF; Blade compatibility is worse
- TCPDF: No native Laravel integration
- Raw `<svg>` barcode rendering via JS in browser: Not printable without PDF; DomPDF wouldn't execute JS

## Risks / Trade-offs

| Risk | Mitigation |
|---|---|
| DomPDF font rendering for Indonesian characters | Use `dejavu sans` font bundled with DomPDF |
| Barcode resolution too low for scanning | Generate at 300 DPI; test with real scanner before production |
| Memory usage for many items in one PDF | Generate per-item PDF only (single menu); paginate if bulk is needed later |
| `id_barang` migration on production data | Add nullable column first; backfill IDs via artisan command; then add NOT NULL |
