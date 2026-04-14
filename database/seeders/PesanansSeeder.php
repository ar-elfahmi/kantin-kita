<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PesanansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor = Vendor::where('nama_vendor', 'Warung Mbok Sri')->first();

        if (! $vendor) {
            return;
        }

        $menuNasgor = Menu::where('vendor_id', $vendor->id)->where('nama_menu', 'Nasi Goreng Spesial')->first();
        $menuBakso = Menu::where('vendor_id', $vendor->id)->where('nama_menu', 'Bakso Kuah Spesial')->first();
        $menuSoto = Menu::where('vendor_id', $vendor->id)->where('nama_menu', 'Soto Ayam Lamongan')->first();

        if (! $menuNasgor || ! $menuBakso || ! $menuSoto) {
            return;
        }

        $orderSeeds = [
            [
                'nama_customer' => 'Ahmad',
                'status_pesanan' => 'pending',
                'total' => 36000,
                'item' => ['menu' => $menuNasgor, 'jumlah' => 2],
                'payment_status' => 'pending',
            ],
            [
                'nama_customer' => 'Budi',
                'status_pesanan' => 'diproses',
                'total' => 15000,
                'item' => ['menu' => $menuBakso, 'jumlah' => 1],
                'payment_status' => 'settlement',
            ],
            [
                'nama_customer' => 'Citra',
                'status_pesanan' => 'selesai',
                'total' => 36000,
                'item' => ['menu' => $menuSoto, 'jumlah' => 3],
                'payment_status' => 'settlement',
            ],
        ];

        foreach ($orderSeeds as $seed) {
            $guestUser = User::create([
                'name' => $seed['nama_customer'],
                'role' => 'guest',
                'email' => null,
                'password' => null,
            ]);

            $menu = $seed['item']['menu'];
            $jumlah = $seed['item']['jumlah'];
            $subtotal = $menu->harga * $jumlah;

            $pesanan = Pesanan::create([
                'user_id' => $guestUser->id,
                'vendor_id' => $vendor->id,
                'nama_customer' => $seed['nama_customer'],
                'total' => $seed['total'],
                'status_pesanan' => $seed['status_pesanan'],
                'catatan' => null,
                'waktu_pengambilan' => '15-20 min',
            ]);

            $pesanan->detailPesanans()->create([
                'menu_id' => $menu->id,
                'jumlah' => $jumlah,
                'harga' => $menu->harga,
                'subtotal' => $subtotal,
                'catatan' => null,
            ]);

            Payment::create([
                'pesanan_id' => $pesanan->id,
                'snap_token' => 'SEED-SNAP-' . Str::upper(Str::random(10)),
                'transaction_id' => $seed['payment_status'] === 'settlement'
                    ? 'SEED-TRX-' . Str::upper(Str::random(12))
                    : null,
                'payment_type' => 'qris',
                'gross_amount' => $seed['total'],
                'status' => $seed['payment_status'],
                'paid_at' => $seed['payment_status'] === 'settlement' ? now() : null,
                'midtrans_response' => null,
            ]);
        }
    }
}
