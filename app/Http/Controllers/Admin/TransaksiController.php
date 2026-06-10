<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Vendor;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    private array $paymentStatuses = ['pending', 'settlement', 'expire', 'cancel', 'deny'];
    private array $orderStatuses = ['pending', 'diproses', 'selesai', 'dibatalkan'];

    public function index(Request $request)
    {
        $vendorId = $request->query('vendor_id');
        $paymentStatus = $request->query('payment_status');
        $orderStatus = $request->query('order_status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Pesanan::query()->with(['payment', 'vendor.user', 'user']);

        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }

        if ($paymentStatus && in_array($paymentStatus, $this->paymentStatuses, true)) {
            $query->whereHas('payment', fn ($q) => $q->where('status', $paymentStatus));
        }

        if ($orderStatus && in_array($orderStatus, $this->orderStatuses, true)) {
            $query->where('status_pesanan', $orderStatus);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $transaksi = $query->latest()->paginate(25)->withQueryString();

        $vendors = Vendor::query()->orderBy('nama_vendor')->get(['id', 'nama_vendor']);

        return view('admin.transaksi.index', [
            'transaksi' => $transaksi,
            'vendors' => $vendors,
            'paymentStatuses' => $this->paymentStatuses,
            'orderStatuses' => $this->orderStatuses,
            'filters' => [
                'vendor_id' => $vendorId,
                'payment_status' => $paymentStatus,
                'order_status' => $orderStatus,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
        ]);
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['payment', 'vendor.user', 'user', 'detailPesanans.menu']);

        return view('admin.transaksi.show', [
            'pesanan' => $pesanan,
        ]);
    }
}
