<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Throwable;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = (int) $request->query('vendor_id');

        $vendor = Vendor::query()
            ->when($vendorId > 0, fn($query) => $query->where('id', $vendorId))
            ->first();

        return view('checkout', [
            'vendor' => $vendor,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_customer' => ['required', 'string', 'max:255'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'waktu_pengambilan' => ['nullable', 'string', 'max:100'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_id' => ['required', 'exists:menus,id'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
            'items.*.catatan' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $payload = DB::transaction(function () use ($validated) {
                $guestUser = User::create([
                    'name' => $validated['nama_customer'],
                    'role' => 'guest',
                    'email' => null,
                    'password' => null,
                ]);

                $total = 0;
                $itemsData = [];

                foreach ($validated['items'] as $item) {
                    $menu = Menu::query()->findOrFail($item['menu_id']);

                    if ((int) $menu->vendor_id !== (int) $validated['vendor_id']) {
                        abort(422, 'Semua item harus berasal dari vendor yang sama.');
                    }

                    $subtotal = (int) $menu->harga * (int) $item['jumlah'];
                    $total += $subtotal;

                    $itemsData[] = [
                        'menu' => $menu,
                        'jumlah' => (int) $item['jumlah'],
                        'harga' => (int) $menu->harga,
                        'subtotal' => $subtotal,
                        'catatan' => $item['catatan'] ?? null,
                    ];
                }

                $pesanan = Pesanan::create([
                    'user_id' => $guestUser->id,
                    'vendor_id' => $validated['vendor_id'],
                    'nama_customer' => $validated['nama_customer'],
                    'total' => $total,
                    'waktu_pengambilan' => $validated['waktu_pengambilan'] ?? null,
                    'status_pesanan' => 'pending',
                ]);

                foreach ($itemsData as $itemData) {
                    $pesanan->detailPesanans()->create([
                        'menu_id' => $itemData['menu']->id,
                        'jumlah' => $itemData['jumlah'],
                        'harga' => $itemData['harga'],
                        'subtotal' => $itemData['subtotal'],
                        'catatan' => $itemData['catatan'],
                    ]);
                }

                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = (bool) config('midtrans.is_production');
                Config::$isSanitized = true;
                Config::$is3ds = false;

                $orderId = 'KK-' . $pesanan->id . '-' . time();

                $snapToken = Snap::getSnapToken([
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $total,
                    ],
                    'customer_details' => [
                        'first_name' => $validated['nama_customer'],
                    ],
                    'enabled_payments' => [
                        'gopay',
                        'shopeepay',
                        'other_qris',
                    ],
                    'item_details' => collect($itemsData)->map(fn($detail) => [
                        'id' => (string) $detail['menu']->id,
                        'price' => $detail['harga'],
                        'quantity' => $detail['jumlah'],
                        'name' => $detail['menu']->nama_menu,
                    ])->values()->all(),
                ]);

                Payment::create([
                    'pesanan_id' => $pesanan->id,
                    'snap_token' => $snapToken,
                    'gross_amount' => $total,
                    'status' => 'pending',
                    'midtrans_response' => [
                        'order_id' => $orderId,
                    ],
                ]);

                return [
                    'snap_token' => $snapToken,
                    'pesanan_id' => $pesanan->id,
                    'order_id' => $orderId,
                ];
            });

            return response()->json($payload);
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Gagal memproses checkout.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pesanan_id' => ['required', 'exists:pesanans,id'],
            'transaction_id' => ['nullable', 'string'],
            'payment_type' => ['nullable', 'string'],
            'status' => ['required', 'in:success,pending,error'],
            'result' => ['nullable', 'array'],
        ]);

        $payment = Payment::query()
            ->where('pesanan_id', $validated['pesanan_id'])
            ->firstOrFail();

        $targetStatus = match ($validated['status']) {
            'success' => 'settlement',
            'error' => 'cancel',
            default => 'pending',
        };

        $this->syncPaymentWithStatus($payment, $targetStatus, [
            'transaction_id' => $validated['transaction_id'] ?? null,
            'payment_type' => $validated['payment_type'] ?? null,
            'raw_result' => $validated['result'] ?? null,
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function notification(Request $request): JsonResponse
    {
        $payload = $request->all();

        if (! $this->hasValidMidtransSignature($payload)) {
            return response()->json([
                'message' => 'Invalid Midtrans signature.',
            ], 403);
        }

        $orderId = (string) ($payload['order_id'] ?? '');
        $pesananId = $this->extractPesananIdFromOrderId($orderId);

        if ($pesananId <= 0) {
            return response()->json([
                'message' => 'Order ID format is invalid.',
            ], 422);
        }

        $payment = Payment::query()
            ->where('pesanan_id', $pesananId)
            ->first();

        if (! $payment) {
            return response()->json([
                'message' => 'Payment record not found.',
            ], 404);
        }

        $mappedStatus = $this->mapMidtransTransactionStatus(
            (string) ($payload['transaction_status'] ?? ''),
            (string) ($payload['fraud_status'] ?? '')
        );

        $this->syncPaymentWithStatus($payment, $mappedStatus, [
            'transaction_id' => $payload['transaction_id'] ?? null,
            'payment_type' => $payload['payment_type'] ?? null,
            'gross_amount' => $payload['gross_amount'] ?? null,
            'raw_result' => $payload,
        ]);

        return response()->json(['status' => 'ok']);
    }

    private function hasValidMidtransSignature(array $payload): bool
    {
        $serverKey = (string) config('midtrans.server_key');
        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');

        if ($serverKey === '' || $orderId === '' || $statusCode === '' || $grossAmount === '' || $signatureKey === '') {
            return false;
        }

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return hash_equals($expected, $signatureKey);
    }

    private function extractPesananIdFromOrderId(string $orderId): int
    {
        if (preg_match('/^KK-(\d+)-\d+$/', $orderId, $matches) === 1) {
            return (int) $matches[1];
        }

        return 0;
    }

    private function mapMidtransTransactionStatus(string $transactionStatus, string $fraudStatus = ''): string
    {
        $transactionStatus = strtolower(trim($transactionStatus));
        $fraudStatus = strtolower(trim($fraudStatus));

        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'challenge' ? 'pending' : 'settlement';
        }

        return match ($transactionStatus) {
            'settlement' => 'settlement',
            'pending' => 'pending',
            'deny' => 'deny',
            'expire' => 'expire',
            'cancel' => 'cancel',
            default => 'pending',
        };
    }

    private function syncPaymentWithStatus(Payment $payment, string $targetStatus, array $context = []): void
    {
        $statusPriority = [
            'pending' => 1,
            'deny' => 2,
            'cancel' => 2,
            'expire' => 2,
            'settlement' => 3,
        ];

        $currentStatus = (string) $payment->status;
        $effectiveStatus = (($statusPriority[$targetStatus] ?? 0) < ($statusPriority[$currentStatus] ?? 0))
            ? $currentStatus
            : $targetStatus;

        $grossAmountRaw = $context['gross_amount'] ?? $payment->gross_amount;
        $grossAmount = is_numeric($grossAmountRaw)
            ? (int) round((float) $grossAmountRaw)
            : (int) $payment->gross_amount;

        $payload = [
            'status' => $effectiveStatus,
            'transaction_id' => $context['transaction_id'] ?? $payment->transaction_id,
            'payment_type' => $context['payment_type'] ?? $payment->payment_type,
            'gross_amount' => $grossAmount,
            'midtrans_response' => $context['raw_result'] ?? $payment->midtrans_response,
        ];

        if ($effectiveStatus === 'settlement') {
            $payload['paid_at'] = $payment->paid_at ?? now();
        }

        if (in_array($effectiveStatus, ['cancel', 'deny', 'expire'], true)) {
            $payload['paid_at'] = null;
        }

        $payment->update($payload);

        if (! $payment->pesanan) {
            return;
        }

        if ($effectiveStatus === 'settlement') {
            $payment->pesanan->update(['status_pesanan' => 'diproses']);
        }

        if (in_array($effectiveStatus, ['cancel', 'deny', 'expire'], true)) {
            $payment->pesanan->update(['status_pesanan' => 'dibatalkan']);
        }
    }
}
