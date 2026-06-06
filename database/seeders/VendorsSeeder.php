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
                'path_logo' => 'https://images.pexels.com/photos/3590401/pexels-photo-3590401.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'is_open' => true,
            ],
            [
                'email' => 'burgerhub@kantinkita.id',
                'nama_vendor' => 'The Burger Hub',
                'lokasi' => 'Gedung B, Lantai 2',
                'kategori' => 'Western',
                'rating' => 4.6,
                'deskripsi' => 'Burger premium dengan daging sapi berkualitas, sayuran segar, dan saus homemade.',
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/8eae28831fbb7d76231e72013a84088be8fb3d13?width=864',
                'is_open' => true,
            ],
            [
                'email' => 'bubbletea@kantinkita.id',
                'nama_vendor' => 'Bubble Tea Corner',
                'lokasi' => 'Gedung A, Lantai 2',
                'kategori' => 'Minuman',
                'rating' => 4.9,
                'deskripsi' => 'Bubble tea segar dengan berbagai rasa dan topping. Cocok untuk teman belajar!',
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/b5ba4c85139506ab2fd522e5e767ae7d0ecbce34?width=864',
                'is_open' => true,
            ],
            [
                'email' => 'ramen@kantinkita.id',
                'nama_vendor' => 'Ramen Station',
                'lokasi' => 'Gedung C, Lantai 1',
                'kategori' => 'Asia',
                'rating' => 4.7,
                'deskripsi' => 'Ramen Jepang autentik dengan kuah kaya rasa dan topping segar.',
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/0c714eb1825d3dd142cfebe8527dc83ba75a69be?width=864',
                'is_open' => true,
            ],
            [
                'email' => 'freshhealty@kantinkita.id',
                'nama_vendor' => 'Fresh & Healthy',
                'lokasi' => 'Gedung B, Lantai 1',
                'kategori' => 'Sehat',
                'rating' => 4.5,
                'deskripsi' => 'Salad bowl bergizi dan pilihan makanan sehat untuk mahasiswa.',
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/ececcd477fc1231e4bbe74a931558732204a0e78?width=864',
                'is_open' => true,
            ],
            [
                'email' => 'campusbrew@kantinkita.id',
                'nama_vendor' => 'Campus Brew',
                'lokasi' => 'Gedung A, Lantai Dasar',
                'kategori' => 'Minuman',
                'rating' => 5.0,
                'deskripsi' => 'Kopi premium dan minuman spesial. Tempat ngopi favorit antar jam kuliah.',
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/ae917f5edf17a276a169dc78fb9e5a9a81fa6485?width=864',
                'is_open' => true,
            ],
            [
                'email' => 'busari@kantinkita.id',
                'nama_vendor' => 'Warung Bu Sari',
                'lokasi' => 'Gedung D, Lantai 1',
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'deskripsi' => 'Masakan Indonesia autentik dengan bahan segar dan resep turun-temurun.',
                'path_logo' => 'https://images.pexels.com/photos/262978/pexels-photo-262978.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'is_open' => true,
            ],
            [
                'email' => 'mboksri@kantinkita.id',
                'nama_vendor' => 'Warung Mbok Sri',
                'lokasi' => 'Gedung A, Lantai Dasar',
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'deskripsi' => 'Warung masakan rumahan khas Jawa dengan cita rasa yang sudah teruji.',
                'path_logo' => 'https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'is_open' => true,
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
                    'is_open' => $seed['is_open'],
                    'path_logo' => $seed['path_logo'],
                ]
            );
        }
    }
}
