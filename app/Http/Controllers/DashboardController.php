<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $vendor = $user?->vendor;

        if (! $vendor) {
            abort(403, 'Vendor profile tidak ditemukan.');
        }

        $pesananMasuk = Pesanan::query()
            ->where('vendor_id', $vendor->id)
            ->sudahDibayar()
            ->with(['detailPesanans.menu', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        $produkTerlaris = Menu::query()
            ->where('vendor_id', $vendor->id)
            ->withCount('detailPesanans')
            ->orderByDesc('detail_pesanans_count')
            ->take(4)
            ->get();

        $totalHariIni = Pesanan::query()
            ->where('vendor_id', $vendor->id)
            ->sudahDibayar()
            ->whereDate('created_at', today())
            ->sum('total');

        $jumlahPesananMasuk = Pesanan::query()
            ->where('vendor_id', $vendor->id)
            ->sudahDibayar()
            ->whereDate('created_at', today())
            ->count();

        return view('dashboard-vendor', [
            'vendor' => $vendor,
            'pesananMasuk' => $pesananMasuk,
            'produkTerlaris' => $produkTerlaris,
            'totalHariIni' => $totalHariIni,
            'jumlahPesananMasuk' => $jumlahPesananMasuk,
        ]);
    }
}
