<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KategoriMenusSeeder::class,
            UsersSeeder::class,
            VendorsSeeder::class,
            MenusSeeder::class,
            MenuVariantsSeeder::class,
            MenuToppingsSeeder::class,
            PesanansSeeder::class,
            DetailPesanansSeeder::class,
            PaymentsSeeder::class,
            CustomersSeeder::class,
            LokasiTokoSeeder::class,
            KunjunganTokoSeeder::class,
            ArtikelSeeder::class,
        ]);
    }
}
