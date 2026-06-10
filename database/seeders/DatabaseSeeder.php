<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            AdminUserSeeder::class,
            VendorsSeeder::class,
            KategoriMenusSeeder::class,
            MenusSeeder::class,
            PesanansSeeder::class,
            ArtikelSeeder::class,
        ]);
    }
}
