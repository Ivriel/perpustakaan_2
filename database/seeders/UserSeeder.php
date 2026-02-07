<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@perpustakaan.test',
                'password' => 'password',
                'role' => 'admin',
                'address' => 'Jl. Perpustakaan No. 1',
                'phone' => '081234567890',
            ],
            [
                'name' => 'Staff Perpustakaan',
                'username' => 'staff',
                'email' => 'staff@perpustakaan.test',
                'password' => 'password',
                'role' => 'staff',
                'address' => 'Jl. Perpustakaan No. 2',
                'phone' => '081234567891',
            ],
            [
                'name' => 'Pengunjung Demo',
                'username' => 'visitor',
                'email' => 'visitor@perpustakaan.test',
                'password' => 'password',
                'role' => 'visitor',
                'address' => null,
                'phone' => '081234567892',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
