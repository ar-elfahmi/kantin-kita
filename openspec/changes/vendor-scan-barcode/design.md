## Context

Saat ini setelah checkout berhasil, pembeli hanya melihat pesan "Pembayaran berhasil" tanpa cara memverifikasi pesanan saat pengambilan. Vendor di dashboard hanya melihat daftar pesanan berdasarkan nama — rawan salah ambil jika nama mirip.

Alur baru: setelah pembayaran settlement, pembeli redirect ke halaman sukses yang menampilkan QR code berisi order ID. Vendor scan QR via dashboard → lihat detail pesanan → cocokkan dengan pembeli.

**Stack**: Laravel Blade + Tailwind JS (existing). Tidak ada page refresh setelah checkout — alur saat ini SPA-like.

## Goals / Non-Goals

**Goals:**
- QR code ditampilkan di halaman sukses setelah pembayaran berhasil
- Vendor dapat scan QR code via kamera di dashboard
- Hasil scan menampilkan ringkasan pesanan pembeli
- Tidak perlu login untuk lihat halaman sukses sendiri

**Non-Goals:**
- Tidak membuat sistem autentikasi barcode (barcode hanya berisi ID, tidak terenkripsi)
- Tidak membuat notifikasi push real-time
- Tidak menyimpan riwayat scan

## Decisions

1. **Library QR code**: `qrcodejs` (client-side generation) + `jsQR` (client-side scanning via camera). Keduanya ringan, zero dependency, dan bisa dipakai langsung di Blade tanpa build step. Alternatif: `html5-qrcode` — lebih mudah (wrap both scanner + decoder) dengan API `Html5Qrcode` yang simpel. Pilih `html5-qrcode` dari CDN untuk kemudahan.

2. **Barcode content**: Cukup order ID (`KK-{id}-{timestamp}`) — string yang sudah dipakai Midtrans. Tidak perlu data sensitif. Vendor akan fetch detail dari backend berdasarkan ID ini.

3. **Halaman sukses route**: `GET /order/{pesanan:id}` — publik, tanpa middleware. Guard: hanya menampilkan data jika payment status settlement. Jika pending/expire, tampilkan status apa adanya.

4. **Scan flow di vendor**: Tombol "Scan Barcode" di sidebar dashboard → modal overlay kamera → hasil scan → fetch `GET /api/checkout/by-order-id/{orderId}` → tampilkan di modal yang sama. Tidak perlu halaman terpisah.

5. **API endpoint baru**: `GET /api/checkout/by-order-id/{orderId}` — mengembalikan JSON detail pesanan (item, total, status, nama customer, waktu pengambilan). Dilindungi middleware auth (vendor only).

6. **OnSuccess redirect**: Di `checkout.blade.js`, ubah handler `onSuccess` dari "tampilkan pesan" jadi `window.location.href = '/order/' + pesananId`.

## Risks / Trade-offs

| Risk | Mitigation |
|------|-----------|
| Kamera tidak tersedia (desktop tanpa webcam) | Modal scan tetap muncul dengan pesan "Kamera tidak tersedia" dan fallback input manual order ID |
| QR code rusak/terhapus | Pembeli bisa minta petugas scan ulang dari dashboard dengan mencari nama. Vendor juga bisa input order ID manual |
| Privasi — order ID bisa ditebak (sequential ID) | Order ID yang ditampilkan di QR tetap format `KK-{id}-{timestamp}` dengan timestamp sebagai salt. Risiko rendah karena hanya menampilkan data pesanan milik sendiri |
| Library CDN down | Simpan `html5-qrcode.min.js` di `public/vendor/` sebagai fallback |
