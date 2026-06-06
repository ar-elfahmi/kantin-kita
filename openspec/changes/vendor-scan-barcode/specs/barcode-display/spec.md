## ADDED Requirements

### Requirement: QR code ditampilkan setelah checkout berhasil
Setelah pembayaran sukses (Midtrans onSuccess), sistem SHALL redirect ke halaman `/order/{pesanan:id}` yang menampilkan QR code berisi order ID dan ringkasan pesanan.

#### Scenario: Redirect to success page after payment
- **WHEN** pembayaran Midtrans selesai dengan status success
- **THEN** browser redirect ke `/order/{pesanan:id}`
- **THEN** halaman menampilkan QR code yang mengandung order ID format `KK-{id}-{timestamp}`

#### Scenario: Success page shows order summary
- **WHEN** halaman `/order/{pesanan:id}` diakses
- **THEN** menampilkan nama customer, daftar item (nama + jumlah), total harga, status pesanan, dan waktu pengambilan

### Requirement: Barcode di-scan oleh vendor untuk lookup
Vendor SHALL dapat memindai QR code dari halaman sukses menggunakan kamera, dan hasil scan mengarah ke order ID yang dapat digunakan untuk lookup di dashboard vendor.

#### Scenario: QR code scanable
- **WHEN** QR code di-scan dengan aplikasi scanner QR atau kamera
- **THEN** hasil scan adalah string order ID format `KK-{id}-{timestamp}`

### Requirement: Halaman sukses publik tanpa login
Halaman `/order/{pesanan:id}` SHALL bisa diakses tanpa login. Pembeli bisa melihat status pesanannya sendiri.

#### Scenario: Guest access order page
- **WHEN** pengguna (tidak login) membuka `/order/{id}`
- **THEN** halaman menampilkan data pesanan jika payment status settlement
- **THEN** halaman menampilkan status pesanan apa adanya untuk status lain
