<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jasa;

class JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jasa::insert([
            [
                'nama_jasa' => 'Level 1 Ringan',
                'tarif' => 20,
                'keterangan' => 'Ukuran A4 / Lembar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jasa' => 'Level 1 Sedang',
                'tarif' => 25,
                'keterangan' => 'Ukuran A4 / Lembar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jasa' => 'Level 1 Berat',
                'tarif' => 30,
                'keterangan' => 'Ukuran A4 / Lembar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
