<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use Illuminate\Database\Seeder;

class KategoriMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriList = [
            'Nasi & Lauk',
            'Mie & Bakso',
            'Camilan',
            'Minuman',
            'Dessert',
        ];

        foreach ($kategoriList as $kategori) {
            KategoriMenu::updateOrCreate(
                ['nama_kategori' => $kategori],
                ['nama_kategori' => $kategori]
            );
        }
    }
}
