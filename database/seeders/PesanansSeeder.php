<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesanansSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pesanans')->insert([
            [
                'id' => 1,
                'user_id' => 10,
                'vendor_id' => 8,
                'nama_customer' => 'Ahmad',
                'total' => 36000,
                'catatan' => null,
                'waktu_pengambilan' => '15-20 min',
                'status_pesanan' => 'pending',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 2,
                'user_id' => 11,
                'vendor_id' => 8,
                'nama_customer' => 'Budi',
                'total' => 15000,
                'catatan' => null,
                'waktu_pengambilan' => '15-20 min',
                'status_pesanan' => 'diproses',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 3,
                'user_id' => 12,
                'vendor_id' => 8,
                'nama_customer' => 'Citra',
                'total' => 36000,
                'catatan' => null,
                'waktu_pengambilan' => '15-20 min',
                'status_pesanan' => 'selesai',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 4,
                'user_id' => 13,
                'vendor_id' => 7,
                'nama_customer' => 'Dewi',
                'total' => 23000,
                'catatan' => null,
                'waktu_pengambilan' => '15-20 min',
                'status_pesanan' => 'diproses',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 5,
                'user_id' => 14,
                'vendor_id' => 7,
                'nama_customer' => 'Eka',
                'total' => 31000,
                'catatan' => null,
                'waktu_pengambilan' => '15-20 min',
                'status_pesanan' => 'pending',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],

        ]);
    }
}
