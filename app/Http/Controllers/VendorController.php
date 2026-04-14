<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::query()
            ->where('is_open', true)
            ->orderByDesc('rating')
            ->get();

        return view('select-vendor', compact('vendors'));
    }

    public function showMenu($id)
    {
        $vendor = Vendor::with(['menus.kategoriMenu'])
            ->findOrFail($id);

        $kategoris = KategoriMenu::orderBy('nama_kategori')->get();

        return view('menu-vendor', compact('vendor', 'kategoris'));
    }
}
