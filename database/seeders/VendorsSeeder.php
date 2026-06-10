<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vendors')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'nama_vendor' => 'Warung Nusantara',
                'deskripsi' => 'Masakan Indonesia autentik dengan nasi goreng khas dan sate tradisional. Bahan segar setiap hari.',
                'lokasi' => 'Gedung A, Lantai 1',
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'is_open' => 1,
                'path_logo' => 'https://images.pexels.com/photos/3590401/pexels-photo-3590401.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'nama_vendor' => 'The Burger Hub',
                'deskripsi' => 'Burger premium dengan daging sapi berkualitas, sayuran segar, dan saus homemade.',
                'lokasi' => 'Gedung B, Lantai 2',
                'kategori' => 'Western',
                'rating' => 4.6,
                'is_open' => 1,
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/8eae28831fbb7d76231e72013a84088be8fb3d13?width=864',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'nama_vendor' => 'Bubble Tea Corner',
                'deskripsi' => 'Bubble tea segar dengan berbagai rasa dan topping. Cocok untuk teman belajar!',
                'lokasi' => 'Gedung A, Lantai 2',
                'kategori' => 'Minuman',
                'rating' => 4.9,
                'is_open' => 1,
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/b5ba4c85139506ab2fd522e5e767ae7d0ecbce34?width=864',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 4,
                'user_id' => 5,
                'nama_vendor' => 'Ramen Station',
                'deskripsi' => 'Ramen Jepang autentik dengan kuah kaya rasa dan topping segar.',
                'lokasi' => 'Gedung C, Lantai 1',
                'kategori' => 'Asia',
                'rating' => 4.7,
                'is_open' => 1,
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/0c714eb1825d3dd142cfebe8527dc83ba75a69be?width=864',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 5,
                'user_id' => 6,
                'nama_vendor' => 'Fresh & Healthy',
                'deskripsi' => 'Salad bowl bergizi dan pilihan makanan sehat untuk mahasiswa.',
                'lokasi' => 'Gedung B, Lantai 1',
                'kategori' => 'Sehat',
                'rating' => 4.5,
                'is_open' => 1,
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/ececcd477fc1231e4bbe74a931558732204a0e78?width=864',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 6,
                'user_id' => 7,
                'nama_vendor' => 'Campus Brew',
                'deskripsi' => 'Kopi premium dan minuman spesial. Tempat ngopi favorit antar jam kuliah.',
                'lokasi' => 'Gedung A, Lantai Dasar',
                'kategori' => 'Minuman',
                'rating' => 5.0,
                'is_open' => 1,
                'path_logo' => 'https://api.builder.io/api/v1/image/assets/TEMP/ae917f5edf17a276a169dc78fb9e5a9a81fa6485?width=864',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 7,
                'user_id' => 8,
                'nama_vendor' => 'Warung Bu Sari',
                'deskripsi' => 'Masakan Indonesia autentik dengan bahan segar dan resep turun-temurun.',
                'lokasi' => 'Gedung D, Lantai 1',
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'is_open' => 1,
                'path_logo' => 'https://images.pexels.com/photos/262978/pexels-photo-262978.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],
            [
                'id' => 8,
                'user_id' => 9,
                'nama_vendor' => 'Warung Mbok Sri',
                'deskripsi' => 'Warung masakan rumahan khas Jawa dengan cita rasa yang sudah teruji.',
                'lokasi' => 'Gedung A, Lantai Dasar',
                'kategori' => 'Indonesia',
                'rating' => 4.8,
                'is_open' => 1,
                'path_logo' => 'https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'created_at' => '2026-06-07 12:16:58',
                'updated_at' => '2026-06-07 12:16:58',
            ],

        ]);
    }
}
