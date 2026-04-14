<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
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

        $totalMingguIni = Pesanan::query()
            ->where('vendor_id', $vendor->id)
            ->sudahDibayar()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total');

        $totalBulanIni = Pesanan::query()
            ->where('vendor_id', $vendor->id)
            ->sudahDibayar()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total');

        $targetBulanIni = 80000000;
        $progressPersen = $targetBulanIni > 0
            ? (int) min(100, round(($totalBulanIni / $targetBulanIni) * 100))
            : 0;

        return view('dashboard-vendor', [
            'vendor' => $vendor,
            'pesananMasuk' => $pesananMasuk,
            'produkTerlaris' => $produkTerlaris,
            'totalHariIni' => $totalHariIni,
            'jumlahPesananMasuk' => $jumlahPesananMasuk,
            'totalMingguIni' => $totalMingguIni,
            'totalBulanIni' => $totalBulanIni,
            'targetBulanIni' => $targetBulanIni,
            'progressPersen' => $progressPersen,
        ]);
    }

    public function markAsDone(Pesanan $pesanan): RedirectResponse
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor || (int) $pesanan->vendor_id !== (int) $vendor->id) {
            abort(403, 'Anda tidak memiliki akses untuk pesanan ini.');
        }

        if ((string) $pesanan->status_pesanan !== 'diproses') {
            return back()->with('orderError', 'Hanya pesanan dengan status diproses yang bisa diselesaikan.');
        }

        $pesanan->update([
            'status_pesanan' => 'selesai',
        ]);

        return back()->with('orderSuccess', 'Status pesanan berhasil diubah menjadi selesai.');
    }
}
