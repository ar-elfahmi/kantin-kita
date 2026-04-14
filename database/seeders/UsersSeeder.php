<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin Kantin Kita', 'email' => 'admin@kantinkita.id', 'role' => 'admin'],
            ['name' => 'Warung Nusantara', 'email' => 'nusantara@kantinkita.id', 'role' => 'vendor'],
            ['name' => 'The Burger Hub', 'email' => 'burgerhub@kantinkita.id', 'role' => 'vendor'],
            ['name' => 'Bubble Tea Corner', 'email' => 'bubbletea@kantinkita.id', 'role' => 'vendor'],
            ['name' => 'Ramen Station', 'email' => 'ramen@kantinkita.id', 'role' => 'vendor'],
            ['name' => 'Fresh & Healthy', 'email' => 'freshhealty@kantinkita.id', 'role' => 'vendor'],
            ['name' => 'Campus Brew', 'email' => 'campusbrew@kantinkita.id', 'role' => 'vendor'],
            ['name' => 'Warung Bu Sari', 'email' => 'busari@kantinkita.id', 'role' => 'vendor'],
            ['name' => 'Warung Mbok Sri', 'email' => 'mboksri@kantinkita.id', 'role' => 'vendor'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => $user['role'],
                ]
            );
        }
    }
}
