<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMenusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_menus')->insert([
            [
                'id' => 1,
                'nama_kategori' => 'Nasi & Lauk',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 2,
                'nama_kategori' => 'Mie & Bakso',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 3,
                'nama_kategori' => 'Camilan',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 4,
                'nama_kategori' => 'Minuman',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 5,
                'nama_kategori' => 'Dessert',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
        ]);
    }
}
