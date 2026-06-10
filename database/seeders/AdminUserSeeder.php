<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kantinkita.id'],
            [
                'name' => 'Admin Kantin Kita',
                'role' => 'admin',
                'password' => User::query()->where('email', 'admin@kantinkita.id')->value('password')
                    ?? Hash::make('password123'),
            ]
        );
    }
}
