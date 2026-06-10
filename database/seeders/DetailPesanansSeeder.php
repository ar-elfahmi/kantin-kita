<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPesanansSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detail_pesanans')->insert([
            [
                'id' => 1,
                'pesanan_id' => 1,
                'menu_id' => 41,
                'jumlah' => 2,
                'harga' => 18000,
                'subtotal' => 36000,
                'catatan' => null,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 2,
                'pesanan_id' => 2,
                'menu_id' => 42,
                'jumlah' => 1,
                'harga' => 15000,
                'subtotal' => 15000,
                'catatan' => null,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 3,
                'pesanan_id' => 3,
                'menu_id' => 43,
                'jumlah' => 3,
                'harga' => 12000,
                'subtotal' => 36000,
                'catatan' => null,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 4,
                'pesanan_id' => 4,
                'menu_id' => 31,
                'jumlah' => 1,
                'harga' => 18000,
                'subtotal' => 18000,
                'catatan' => null,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 5,
                'pesanan_id' => 4,
                'menu_id' => 35,
                'jumlah' => 1,
                'harga' => 5000,
                'subtotal' => 5000,
                'catatan' => null,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 6,
                'pesanan_id' => 5,
                'menu_id' => 32,
                'jumlah' => 1,
                'harga' => 15000,
                'subtotal' => 15000,
                'catatan' => null,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 7,
                'pesanan_id' => 5,
                'menu_id' => 37,
                'jumlah' => 2,
                'harga' => 8000,
                'subtotal' => 16000,
                'catatan' => null,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],

        ]);
    }
}
