<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Price Tag - {{ $menu->id_barang }}</title>
    <style>
        @page {
            margin: 8mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            text-align: center;
            margin: 0;
            padding: 12mm 0;
        }
        .barcode {
            margin-bottom: 6mm;
        }
        .barcode img {
            max-width: 100%;
            height: auto;
        }
        .id-barang {
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 1px;
            color: #333;
            margin-bottom: 4mm;
        }
        .nama-menu {
            font-size: 11pt;
            font-weight: bold;
            color: #111;
            margin-bottom: 3mm;
        }
        .harga {
            font-size: 14pt;
            font-weight: bold;
            color: #c0392b;
        }
        .vendor-name {
            font-size: 7pt;
            color: #888;
            margin-top: 4mm;
        }
    </style>
</head>
<body>
    <div class="barcode">
        <img src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Barcode {{ $menu->id_barang }}">
    </div>
    <div class="id-barang">{{ $menu->id_barang }}</div>
    <div class="nama-menu">{{ $menu->nama_menu }}</div>
    <div class="harga">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
    <div class="vendor-name">{{ $vendor->nama_vendor }}</div>
</body>
</html>
