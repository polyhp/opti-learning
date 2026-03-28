<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@opti-learning.com',
            'password' => Hash::make('Admin@123'),
            'first_name' => 'Admin',
            'last_name' => 'OPTI',
            'phone' => '+22900000000',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'birth_place' => 'Système',
            'is_active' => true,
            'role' => 'admin',
        ]);
    }
}