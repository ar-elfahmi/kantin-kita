<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->where('role', 'admin')->first();

        Artikel::firstOrCreate(
            ['slug' => 'tentang-kami'],
            [
                'judul' => 'Tentang Kantin Kita',
                'ringkasan' => 'Kantin Kita memudahkan civitas kampus memesan makanan favorit tanpa antri.',
                'konten' => "Kantin Kita lahir dari kebutuhan civitas kampus untuk memesan makanan dengan cepat dan mudah.\n\nDengan satu platform, kamu bisa melihat menu dari banyak vendor, memesan, dan membayar tanpa harus mengantri panjang.",
                'kategori' => Artikel::KATEGORI_TENTANG_KAMI,
                'status' => Artikel::STATUS_PUBLISHED,
                'published_at' => now(),
                'author_id' => optional($author)->id,
            ]
        );
    }
}
