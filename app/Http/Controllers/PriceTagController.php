<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PriceTagController extends Controller
{
    public function generate(Menu $menu)
    {
        $vendor = $menu->vendor;

        if (!auth()->user()->isVendor() || auth()->user()->vendor->id !== $vendor->id) {
            abort(403);
        }

        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($menu->id_barang, $generator::TYPE_CODE_128, 2, 80);

        $barcodeBase64 = base64_encode($barcode);

        $pdf = Pdf::loadView('vendor.price-tag', [
            'menu' => $menu,
            'vendor' => $vendor,
            'barcodeBase64' => $barcodeBase64,
        ]);

        $pdf->setPaper([0, 0, 283.46, 425.2], 'portrait');

        return $pdf->download("price-tag-{$menu->id_barang}.pdf");
    }

    public function scan()
    {
        $vendor = auth()->user()?->vendor;

        if (! $vendor) {
            abort(403, 'Vendor profile tidak ditemukan.');
        }

        return view('vendor.scan-tag-harga', [
            'vendor' => $vendor,
        ]);
    }

    public function lookupByIdBarang(string $idBarang): JsonResponse
    {
        $vendor = auth()->user()?->vendor;

        if (! $vendor) {
            abort(403, 'Vendor profile tidak ditemukan.');
        }

        $normalized = strtoupper(trim($idBarang));

        $menu = Menu::query()
            ->where('vendor_id', $vendor->id)
            ->where('id_barang', $normalized)
            ->with('kategoriMenu')
            ->first();

        if (! $menu) {
            return response()->json([
                'message' => 'Menu tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'id_barang' => $menu->id_barang,
            'nama_menu' => $menu->nama_menu,
            'harga' => (int) $menu->harga,
            'kategori' => $menu->kategoriMenu?->nama_kategori,
            'deskripsi' => $menu->deskripsi,
            'path_gambar' => $menu->path_gambar,
            'is_available' => (bool) $menu->is_available,
            'vendor_name' => $vendor->nama_vendor,
        ]);
    }
}
