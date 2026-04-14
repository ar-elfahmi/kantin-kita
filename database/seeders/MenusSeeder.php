<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriByName = KategoriMenu::pluck('id', 'nama_kategori');

        $menusByVendor = [
            'Warung Bu Sari' => [
                ['nama_menu' => 'Nasi Gudeg Ayam', 'kategori' => 'Nasi & Lauk', 'harga' => 18000, 'deskripsi' => 'Gudeg nangka manis khas Jawa dengan ayam kampung yang empuk'],
                ['nama_menu' => 'Mie Ayam Special', 'kategori' => 'Mie & Bakso', 'harga' => 15000, 'deskripsi' => 'Mie segar dengan ayam bumbu, sayuran dan kuah kaldu gurih'],
                ['nama_menu' => 'Gado-Gado', 'kategori' => 'Nasi & Lauk', 'harga' => 12000, 'deskripsi' => 'Sayuran segar campur dengan saus kacang kental dan kerupuk'],
                ['nama_menu' => 'Sate Ayam', 'kategori' => 'Camilan', 'harga' => 20000, 'deskripsi' => 'Sate ayam bakar dengan saus kacang pedas dan lontong'],
                ['nama_menu' => 'Es Teh Manis', 'kategori' => 'Minuman', 'harga' => 5000, 'deskripsi' => 'Teh manis dingin yang menyegarkan, cocok teman makan'],
                ['nama_menu' => 'Bakso Special', 'kategori' => 'Mie & Bakso', 'harga' => 16000, 'deskripsi' => 'Bakso sapi jumbo dengan mie, sayuran segar dan kuah kaldu'],
                ['nama_menu' => 'Pisang Goreng', 'kategori' => 'Camilan', 'harga' => 8000, 'deskripsi' => 'Pisang goreng renyah, camilan manis yang sempurna'],
                ['nama_menu' => 'Es Jeruk Segar', 'kategori' => 'Minuman', 'harga' => 8000, 'deskripsi' => 'Jus jeruk peras segar dengan es batu, kaya vitamin'],
            ],
            'Warung Mbok Sri' => [
                ['nama_menu' => 'Nasi Goreng Spesial', 'kategori' => 'Nasi & Lauk', 'harga' => 18000, 'deskripsi' => 'Nasi goreng dengan telur mata sapi, ayam, dan bumbu rahasia khas warung'],
                ['nama_menu' => 'Bakso Kuah Spesial', 'kategori' => 'Mie & Bakso', 'harga' => 15000, 'deskripsi' => 'Bakso sapi dengan mie, sayuran segar dan kuah kaldu yang gurih'],
                ['nama_menu' => 'Soto Ayam Lamongan', 'kategori' => 'Nasi & Lauk', 'harga' => 12000, 'deskripsi' => 'Soto ayam kuning dengan telur, soun, dan sayuran segar berkuah bening'],
                ['nama_menu' => 'Es Teh Manis', 'kategori' => 'Minuman', 'harga' => 5000, 'deskripsi' => 'Teh manis dingin dengan es batu, kesegaran di hari yang panas'],
            ],
        ];

        foreach ($menusByVendor as $vendorName => $menus) {
            $vendor = Vendor::where('nama_vendor', $vendorName)->first();

            if (! $vendor) {
                continue;
            }

            foreach ($menus as $menu) {
                Menu::updateOrCreate(
                    [
                        'vendor_id' => $vendor->id,
                        'nama_menu' => $menu['nama_menu'],
                    ],
                    [
                        'kategori_menu_id' => $kategoriByName[$menu['kategori']] ?? null,
                        'deskripsi' => $menu['deskripsi'],
                        'harga' => $menu['harga'],
                        'path_gambar' => null,
                        'is_available' => true,
                    ]
                );
            }
        }
    }
}
