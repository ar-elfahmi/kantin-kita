## Why

Setelah pembayaran berhasil, pembeli tidak memiliki cara untuk memverifikasi pesanan saat mengambil di vendor. Vendor juga kesulitan mencocokkan pesanan dengan pembeli karena hanya mengandalkan nama. Dengan menampilkan barcode (berisi ID pesanan) setelah checkout dan menyediakan fitur scan di dashboard vendor, proses pencocokan pesanan jadi cepat dan akurat.

## What Changes

- **Halaman sukses checkout baru**: setelah pembayaran berhasil, redirect ke halaman `/order/{pesananId}` yang menampilkan barcode + ringkasan pesanan
- **Komponen barcode**: generate QR code dari order ID (`KK-{id}-{timestamp}`) menggunakan library qrcode.js
- **Fitur scan di dashboard vendor**: tambah tombol "Scan Barcode" di sidebar, buka modal scanner kamera, scan QR → tampilkan detail pesanan pembeli
- **Route baru**: `GET /order/{pesanan}` untuk halaman sukses publik, `GET /dashboard/scan` untuk halaman scan vendor
- **Middleware**: `/order/{pesanan}` publik (guest bisa lihat pesanan sendiri), `/dashboard/scan` hanya vendor login

## Capabilities

### New Capabilities
- `barcode-display`: Menampilkan QR code berisi order ID di halaman sukses setelah checkout. Pembeli bisa scan untuk verifikasi atau tunjukkan ke vendor.
- `vendor-barcode-scan`: Vendor dapat scan QR code pembeli melalui dashboard untuk melihat detail pesanan. Hasil scan menampilkan ringkasan pesanan (item, total, status, nama pembeli).

### Modified Capabilities
- (none — no existing specs in project)

## Impact

- **New dependency**: qrcode.js atau jsQR library (client-side QR generation & scanning)
- **New routes**: `GET /order/{pesanan}`, `GET /dashboard/scan`, `POST /dashboard/scan/process`
- **Modified file**: `app/Http/Controllers/CheckoutController.php` — onSuccess redirect ke `/order/{id}` instead of staying di checkout
- **New controller method**: `CheckoutController@success` atau controller baru `OrderController@show`
- **New view**: `order-success.blade.php` (QR code + ringkasan)
- **New view**: `vendor-scan.blade.php` (scanner + hasil)
- **Modified file**: `dashboard-vendor.blade.php` — tambah tombol scan di sidebar
- **Modified file**: `checkout.blade.php` — ubah onSuccess dari show message jadi redirect ke `/order/{id}`
- **New API**: `POST /api/checkout/update-status` callback tetap sama, hanya response handling frontend yang diubah
