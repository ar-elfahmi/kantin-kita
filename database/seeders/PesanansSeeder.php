<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class PesanansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderSeeds = [
            [
                'vendor_name' => 'Warung Mbok Sri',
                'nama_customer' => 'Ahmad',
                'status_pesanan' => 'pending',
                'payment_status' => 'pending',
                'items' => [
                    ['menu' => 'Nasi Goreng Spesial', 'jumlah' => 2],
                ],
            ],
            [
                'vendor_name' => 'Warung Mbok Sri',
                'nama_customer' => 'Budi',
                'status_pesanan' => 'diproses',
                'payment_status' => 'settlement',
                'items' => [
                    ['menu' => 'Bakso Kuah Spesial', 'jumlah' => 1],
                ],
            ],
            [
                'vendor_name' => 'Warung Mbok Sri',
                'nama_customer' => 'Citra',
                'status_pesanan' => 'selesai',
                'payment_status' => 'settlement',
                'items' => [
                    ['menu' => 'Soto Ayam Lamongan', 'jumlah' => 3],
                ],
            ],
            [
                'vendor_name' => 'Warung Bu Sari',
                'nama_customer' => 'Dewi',
                'status_pesanan' => 'diproses',
                'payment_status' => 'settlement',
                'items' => [
                    ['menu' => 'Nasi Gudeg Ayam', 'jumlah' => 1],
                    ['menu' => 'Es Teh Manis', 'jumlah' => 1],
                ],
            ],
            [
                'vendor_name' => 'Warung Bu Sari',
                'nama_customer' => 'Eka',
                'status_pesanan' => 'pending',
                'payment_status' => 'pending',
                'items' => [
                    ['menu' => 'Mie Ayam Special', 'jumlah' => 1],
                    ['menu' => 'Pisang Goreng', 'jumlah' => 2],
                ],
            ],
        ];

        foreach ($orderSeeds as $seed) {
            $vendor = Vendor::where('nama_vendor', $seed['vendor_name'])->first();
            if (! $vendor) {
                continue;
            }

            $guestUser = User::firstOrCreate(
                [
                    'name' => $seed['nama_customer'],
                    'role' => 'guest',
                ],
                [
                    'email' => null,
                    'password' => null,
                ]
            );

            $detailItems = [];
            $total = 0;

            foreach ($seed['items'] as $item) {
                $menu = Menu::query()
                    ->where('vendor_id', $vendor->id)
                    ->where('nama_menu', $item['menu'])
                    ->first();

                if (! $menu) {
                    continue;
                }

                $jumlah = max(1, (int) $item['jumlah']);
                $subtotal = (int) $menu->harga * $jumlah;
                $total += $subtotal;

                $detailItems[] = [
                    'menu_id' => $menu->id,
                    'jumlah' => $jumlah,
                    'harga' => (int) $menu->harga,
                    'subtotal' => $subtotal,
                    'catatan' => null,
                ];
            }

            if (empty($detailItems)) {
                continue;
            }

            $pesanan = Pesanan::updateOrCreate(
                [
                    'vendor_id' => $vendor->id,
                    'nama_customer' => $seed['nama_customer'],
                    'status_pesanan' => $seed['status_pesanan'],
                ],
                [
                    'user_id' => $guestUser->id,
                    'total' => $total,
                    'catatan' => null,
                    'waktu_pengambilan' => '15-20 min',
                ]
            );

            $pesanan->detailPesanans()->delete();
            foreach ($detailItems as $detailItem) {
                $pesanan->detailPesanans()->create($detailItem);
            }

            Payment::updateOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'snap_token' => 'SEED-SNAP-' . $pesanan->id,
                    'transaction_id' => $seed['payment_status'] === 'settlement'
                        ? 'SEED-TRX-' . $pesanan->id
                        : null,
                    'payment_type' => 'qris',
                    'gross_amount' => $total,
                    'status' => $seed['payment_status'],
                    'paid_at' => $seed['payment_status'] === 'settlement' ? now() : null,
                    'midtrans_response' => [
                        'transaction_status' => $seed['payment_status'],
                        'source' => 'seeder',
                    ],
                ]
            );
        }
    }
}
