## Why

Vendor needs printable price tags with barcodes for physical menu/item labelling. Currently no barcode or price tag system exists, making it difficult for vendors to print and attach scannable price labels to their products.

## What Changes

- Add migration to include `id_barang` (item/barcode identifier) field on `menus` table
- Install `picqer/php-barcode-generator` library via Composer
- Create a new route + controller action to generate price tag PDF
- Create a Blade PDF view that renders each menu item as a price tag with barcode above the `id_barang`
- Add "Cetak Tag Harga" button in vendor dashboard for each menu item

## Capabilities

### New Capabilities
- `price-tag-pdf`: Generate downloadable PDF of price tags for vendor menu items, with scannable barcodes

### Modified Capabilities
- (none)

## Impact

- `composer require picqer/php-barcode-generator` — new production dependency
- `database/migrations/` — new migration to add `id_barang` column
- `app/Http/Controllers/` — new or updated controller for PDF generation
- `resources/views/` — new Blade PDF template for price tag
- `routes/web.php` — new route for price tag PDF download
- `app/Models/Menu.php` — add `id_barang` to fillable array
