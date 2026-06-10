<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;

class DashboardController extends Controller
{
    public function index()
    {
        $userCountsByRole = User::query()
            ->selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        foreach (['admin', 'vendor', 'customer', 'guest'] as $role) {
            $userCountsByRole[$role] = $userCountsByRole[$role] ?? 0;
        }

        $vendorCount = Vendor::query()->count();
        $totalPesanan = Pesanan::query()->count();
        $gmv = (int) Payment::query()->where('status', 'settlement')->sum('gross_amount');

        $recentTransactions = Pesanan::query()
            ->with(['payment', 'vendor.user', 'user'])
            ->sudahDibayar()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', [
            'userCountsByRole' => $userCountsByRole,
            'vendorCount' => $vendorCount,
            'totalPesanan' => $totalPesanan,
            'gmv' => $gmv,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
