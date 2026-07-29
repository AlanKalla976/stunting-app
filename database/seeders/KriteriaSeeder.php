<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('kriteria')->insert([
            ['nama_kriteria' => 'Tinggi Badan', 'jenis' => 'cost', 'bobot' => 0.3, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Berat Badan', 'jenis' => 'cost', 'bobot' => 0.25, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Usia', 'jenis' => 'benefit', 'bobot' => 0.15, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Kondisi Ekonomi', 'jenis' => 'cost', 'bobot' => 0.2, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Sanitasi Lingkungan', 'jenis' => 'cost', 'bobot' => 0.1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
