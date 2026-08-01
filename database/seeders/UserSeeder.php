<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@stunting.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Puskesmas',
                'email' => 'petugas@stunting.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']], // kondisi pencarian (unique key)
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'updated_at' => now(),
                    'created_at' => now(), // hanya dipakai jika insert baru
                ]
            );
        }
    }
}