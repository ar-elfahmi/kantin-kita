## 1. Order Success Page

- [ ] 1.1 Buat route `GET /order/{pesanan}` publik di `routes/web.php`
- [ ] 1.2 Buat method `CheckoutController@success(Pesanan $pesanan)` — load pesanan + detail + payment, return view
- [ ] 1.3 Buat view `resources/views/order-success.blade.php` — tampilkan QR code (qrcodejs), ringkasan pesanan (items, total, status, waktu_pengambilan)
- [ ] 1.4 Ubah `onSuccess` handler di `checkout.blade.php` dari show message jadi `window.location.href = '/order/' + pesananId`
- [ ] 1.5 Download `html5-qrcode.min.js` ke `public/vendor/` sebagai fallback CDN

## 2. API Lookup Endpoint

- [ ] 2.1 Buat method `CheckoutController@lookupByOrderId(string $orderId)` — parse order ID format `KK-{id}-{timestamp}`, cari payment → pesanan, return JSON detail
- [ ] 2.2 Buat route `GET /api/checkout/by-order-id/{orderId}` di `routes/api.php` dengan middleware auth
- [ ] 2.3 Validasi format order ID — return 422 jika format invalid
- [ ] 2.4 Return 404 jika payment/pesanan tidak ditemukan

## 3. Vendor Scan Modal

- [ ] 3.1 Tambah tombol "Scan Barcode" di sidebar `dashboard-vendor.blade.php`
- [ ] 3.2 Buat modal scan overlay di `dashboard-vendor.blade.php` — start camera via html5-qrcode, viewfinder, close button
- [ ] 3.3 Implementasi scan callback — decode QR → GET API lookup → tampilkan hasil di modal yang sama
- [ ] 3.4 Tambah fallback input manual order ID + tombol "Input Manual" di modal
- [ ] 3.5 Tampilkan ringkasan pesanan hasil scan: nama customer, items table, total, waktu_pengambilan, status

## 4. Tests

- [ ] 4.1 Test: guest bisa akses `/order/{pesanan}` setelah payment settlement
- [ ] 4.2 Test: order page menampilkan QR code dan ringkasan pesanan
- [ ] 4.3 Test: API lookup valid order ID mengembalikan JSON pesanan lengkap
- [ ] 4.4 Test: API lookup invalid format order ID return 422
- [ ] 4.5 Test: API lookup order not found return 404
- [ ] 4.6 Test: API lookup tanpa auth return 401/redirect
