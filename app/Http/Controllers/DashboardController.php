<?php

namespace App\Http\Controllers;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $kategoriMenus = KategoriMenu::orderBy('nama_kategori')->get();

        return view('dashboard-vendor', [
            'vendor' => $vendor,
            'pesananMasuk' => $pesananMasuk,
            'produkTerlaris' => $produkTerlaris,
            'kategoriMenus' => $kategoriMenus,
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

    public function storeMenu(Request $request): JsonResponse
    {
        $user = Auth::user();
        $vendor = $user?->vendor;

        if (! $vendor) {
            abort(403, 'Vendor profile tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'harga' => 'required|numeric|min:0',
            'kategori_menu_id' => 'nullable|exists:kategori_menus,id',
            'path_gambar' => 'nullable|image|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $pathGambar = null;
        if ($request->hasFile('path_gambar')) {
            $pathGambar = $request->file('path_gambar')->store('menus', 'public');
        }

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'kategori_menu_id' => $validated['kategori_menu_id'] ?? null,
            'nama_menu' => $validated['nama_menu'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
            'path_gambar' => $pathGambar,
            'is_available' => $request->boolean('is_available', true),
        ]);

        $menu->load('kategoriMenu');

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan.',
            'menu' => $menu,
        ]);
    }

    public function menuList()
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor) {
            abort(403, 'Vendor profile tidak ditemukan.');
        }

        $menus = $vendor->menus()
            ->with('kategoriMenu')
            ->orderBy('nama_menu')
            ->get();

        $kategoriMenus = KategoriMenu::orderBy('nama_kategori')->get();

        return view('vendor.manage-menu', [
            'vendor' => $vendor,
            'menus' => $menus,
            'kategoriMenus' => $kategoriMenus,
        ]);
    }

    public function updateMenu(Request $request, Menu $menu): JsonResponse
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor || (int) $menu->vendor_id !== (int) $vendor->id) {
            abort(403, 'Anda tidak memiliki akses ke menu ini.');
        }

        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'harga' => 'required|numeric|min:0',
            'kategori_menu_id' => 'nullable|exists:kategori_menus,id',
            'path_gambar' => 'nullable|image|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        if ($request->hasFile('path_gambar')) {
            if ($menu->path_gambar && Storage::disk('public')->exists($menu->path_gambar)) {
                Storage::disk('public')->delete($menu->path_gambar);
            }
            $validated['path_gambar'] = $request->file('path_gambar')->store('menus', 'public');
        } else {
            unset($validated['path_gambar']);
        }

        $validated['is_available'] = $request->boolean('is_available', true);

        $menu->update($validated);
        $menu->load('kategoriMenu');

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diperbarui.',
            'menu' => $menu,
        ]);
    }

    public function destroyMenu(Request $request, Menu $menu): JsonResponse
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor || (int) $menu->vendor_id !== (int) $vendor->id) {
            abort(403, 'Anda tidak memiliki akses ke menu ini.');
        }

        if ($menu->path_gambar && Storage::disk('public')->exists($menu->path_gambar)) {
            Storage::disk('public')->delete($menu->path_gambar);
        }

        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dihapus.',
        ]);
    }

    public function pesananList(Request $request)
    {
        $vendor = Auth::user()?->vendor;

        if (! $vendor) {
            abort(403, 'Vendor profile tidak ditemukan.');
        }

        $statusFilter = (string) $request->query('status', 'diproses');
        $allowedStatuses = ['diproses', 'selesai', 'semua'];
        if (! in_array($statusFilter, $allowedStatuses, true)) {
            $statusFilter = 'diproses';
        }

        $pesananQuery = Pesanan::query()
            ->where('vendor_id', $vendor->id)
            ->sudahDibayar()
            ->with(['detailPesanans.menu', 'payment'])
            ->latest();

        if ($statusFilter !== 'semua') {
            $pesananQuery->where('status_pesanan', $statusFilter);
        }

        $pesanans = $pesananQuery->paginate(15)->withQueryString();

        $counts = [
            'diproses' => Pesanan::query()
                ->where('vendor_id', $vendor->id)
                ->sudahDibayar()
                ->where('status_pesanan', 'diproses')
                ->count(),
            'selesai' => Pesanan::query()
                ->where('vendor_id', $vendor->id)
                ->sudahDibayar()
                ->where('status_pesanan', 'selesai')
                ->count(),
        ];
        $counts['semua'] = $counts['diproses'] + $counts['selesai'];

        return view('vendor.manage-orders', [
            'vendor' => $vendor,
            'pesanans' => $pesanans,
            'statusFilter' => $statusFilter,
            'counts' => $counts,
        ]);
    }
}
