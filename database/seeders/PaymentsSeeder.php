<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'id' => 1,
                'pesanan_id' => 1,
                'snap_token' => 'SEED-SNAP-1',
                'transaction_id' => null,
                'payment_type' => 'qris',
                'gross_amount' => 36000,
                'status' => 'pending',
                'paid_at' => null,
                'midtrans_response' => json_encode(['source' => 'seeder', 'transaction_status' => 'pending']),
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 2,
                'pesanan_id' => 2,
                'snap_token' => 'SEED-SNAP-2',
                'transaction_id' => 'SEED-TRX-2',
                'payment_type' => 'qris',
                'gross_amount' => 15000,
                'status' => 'settlement',
                'paid_at' => '2026-06-07 12:16:58',
                'midtrans_response' => json_encode(['source' => 'seeder', 'transaction_status' => 'settlement']),
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 3,
                'pesanan_id' => 3,
                'snap_token' => 'SEED-SNAP-3',
                'transaction_id' => 'SEED-TRX-3',
                'payment_type' => 'qris',
                'gross_amount' => 36000,
                'status' => 'settlement',
                'paid_at' => '2026-06-07 12:16:58',
                'midtrans_response' => json_encode(['source' => 'seeder', 'transaction_status' => 'settlement']),
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 4,
                'pesanan_id' => 4,
                'snap_token' => 'SEED-SNAP-4',
                'transaction_id' => 'SEED-TRX-4',
                'payment_type' => 'qris',
                'gross_amount' => 23000,
                'status' => 'settlement',
                'paid_at' => '2026-06-07 12:16:58',
                'midtrans_response' => json_encode(['source' => 'seeder', 'transaction_status' => 'settlement']),
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 5,
                'pesanan_id' => 5,
                'snap_token' => 'SEED-SNAP-5',
                'transaction_id' => null,
                'payment_type' => 'qris',
                'gross_amount' => 31000,
                'status' => 'pending',
                'paid_at' => null,
                'midtrans_response' => json_encode(['source' => 'seeder', 'transaction_status' => 'pending']),
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],

        ]);
    }
}
