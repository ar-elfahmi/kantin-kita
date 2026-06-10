<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('artikels')->insert([
            [
                'id' => 1,
                'judul' => 'Tentang Kantin Kita',
                'slug' => 'tentang-kami',
                'ringkasan' => 'Kantin Kita memudahkan civitas kampus memesan makanan favorit tanpa antri.',
                'konten' => "Kantin Kita lahir dari kebutuhan civitas kampus untuk memesan makanan dengan cepat dan mudah.\n\nDengan satu platform, kamu bisa melihat menu dari banyak vendor, memesan, dan membayar tanpa harus mengantri panjang.",
                'gambar_sampul' => null,
                'kategori' => 'tentang-kami',
                'status' => 'published',
                'published_at' => '2026-06-07 12:16:58',
                'author_id' => 1,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'judul' => 'Event Vocer belanja',
                'slug' => 'event-vocer-belanja',
                'ringkasan' => 'test',
                'konten' => 'new menu kopi tubruk',
                'gambar_sampul' => 'artikel/2j1vtB00oJR902nw2CmbdRkIrhBnS7bx9RUayceV.jpg',
                'kategori' => 'tentang-kami',
                'status' => 'published',
                'published_at' => '2026-06-07 12:28:17',
                'author_id' => 1,
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-10 04:02:37',
                'deleted_at' => null,
            ],
        ]);
    }
}
