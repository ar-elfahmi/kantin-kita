## ADDED Requirements

### Requirement: Vendor dapat scan QR code dari dashboard
Dashboard vendor SHALL menyediakan tombol "Scan Barcode" yang membuka modal kamera untuk memindai QR code pesanan pembeli.

#### Scenario: Open scan modal
- **WHEN** vendor mengklik tombol "Scan Barcode" di sidebar dashboard
- **THEN** modal overlay terbuka dengan tampilan kamera (viewport scanner)

#### Scenario: Successful scan shows order detail
- **WHEN** QR code berhasil di-scan
- **THEN** system fetch data pesanan via `GET /api/checkout/by-order-id/{orderId}`
- **THEN** modal menampilkan ringkasan pesanan: nama customer, daftar item, total, waktu pengambilan, status

### Requirement: Scan modal memiliki fallback input manual
Modal scan SHALL menyediakan input teks manual order ID jika kamera tidak tersedia atau gagal.

#### Scenario: Manual order ID input
- **WHEN** kamera tidak tersedia atau pengguna mengklik "Input Manual"
- **THEN** input teks muncul untuk memasukkan order ID
- **THEN** setelah submit, system fetch data pesanan dan menampilkan ringkasan

### Requirement: API endpoint lookup by order ID
Sistem SHALL menyediakan endpoint `GET /api/checkout/by-order-id/{orderId}` yang mengembalikan JSON detail pesanan. Endpoint ini SHALL dilindungi middleware auth (vendor only).

#### Scenario: Valid order ID
- **WHEN** vendor terautentikasi request `GET /api/checkout/by-order-id/KK-1-1713100800`
- **THEN** response JSON berisi: `{ order_id, pesanan_id, nama_customer, items: [{nama_menu, jumlah, harga, catatan}], total, status_pesanan, waktu_pengambilan, vendor_id }`

#### Scenario: Invalid order ID format
- **WHEN** order ID tidak sesuai format `KK-{id}-{timestamp}`
- **THEN** response 422 dengan pesan "Format order ID tidak valid."

#### Scenario: Order not found
- **WHEN** order ID valid tapi pesanan tidak ditemukan
- **THEN** response 404 dengan pesan "Pesanan tidak ditemukan."

#### Scenario: Unauthenticated access
- **WHEN** request tanpa session auth vendor
- **THEN** response 401
