<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorSeeds = [
            [
                'email' => 'nusantara@kantinkita.id',
                'nama_vendor' => 'Warung Nusantara',
                'lokasi' => 'Gedung A, Lantai 1',
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'deskripsi' => 'Masakan Indonesia autentik dengan nasi goreng khas dan sate tradisional. Bahan segar setiap hari.',
            ],
            [
                'email' => 'burgerhub@kantinkita.id',
                'nama_vendor' => 'The Burger Hub',
                'lokasi' => 'Gedung B, Lantai 2',
                'kategori' => 'Western',
                'rating' => 4.6,
                'deskripsi' => 'Burger premium dengan daging sapi berkualitas, sayuran segar, dan saus homemade.',
            ],
            [
                'email' => 'bubbletea@kantinkita.id',
                'nama_vendor' => 'Bubble Tea Corner',
                'lokasi' => 'Gedung A, Lantai 2',
                'kategori' => 'Minuman',
                'rating' => 4.9,
                'deskripsi' => 'Bubble tea segar dengan berbagai rasa dan topping. Cocok untuk teman belajar!',
            ],
            [
                'email' => 'ramen@kantinkita.id',
                'nama_vendor' => 'Ramen Station',
                'lokasi' => 'Gedung C, Lantai 1',
                'kategori' => 'Asia',
                'rating' => 4.7,
                'deskripsi' => 'Ramen Jepang autentik dengan kuah kaya rasa dan topping segar.',
            ],
            [
                'email' => 'freshhealty@kantinkita.id',
                'nama_vendor' => 'Fresh & Healthy',
                'lokasi' => 'Gedung B, Lantai 1',
                'kategori' => 'Sehat',
                'rating' => 4.5,
                'deskripsi' => 'Salad bowl bergizi dan pilihan makanan sehat untuk mahasiswa.',
            ],
            [
                'email' => 'campusbrew@kantinkita.id',
                'nama_vendor' => 'Campus Brew',
                'lokasi' => 'Gedung A, Lantai Dasar',
                'kategori' => 'Minuman',
                'rating' => 5.0,
                'deskripsi' => 'Kopi premium dan minuman spesial. Tempat ngopi favorit antar jam kuliah.',
            ],
            [
                'email' => 'busari@kantinkita.id',
                'nama_vendor' => 'Warung Bu Sari',
                'lokasi' => null,
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'deskripsi' => 'Masakan Indonesia autentik dengan bahan segar dan resep turun-temurun.',
            ],
            [
                'email' => 'mboksri@kantinkita.id',
                'nama_vendor' => 'Warung Mbok Sri',
                'lokasi' => 'Gedung A, Lantai Dasar',
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'deskripsi' => 'Warung masakan rumahan khas Jawa dengan cita rasa yang sudah teruji.',
            ],
        ];

        foreach ($vendorSeeds as $seed) {
            $user = User::where('email', $seed['email'])
                ->where('role', 'vendor')
                ->first();

            if (! $user) {
                continue;
            }

            Vendor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_vendor' => $seed['nama_vendor'],
                    'deskripsi' => $seed['deskripsi'],
                    'lokasi' => $seed['lokasi'],
                    'kategori' => $seed['kategori'],
                    'rating' => $seed['rating'],
                    'is_open' => true,
                    'path_logo' => null,
                ]
            );
        }
    }
}
