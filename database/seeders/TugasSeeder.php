<?php

namespace Database\Seeders;

use App\Models\Tugas;
use Illuminate\Database\Seeder;

class TugasSeeder extends Seeder
{
    public function run()
    {
        Tugas::insert([
            [
                'dosen_id' => null,
                'judul' => 'Tugas Pemrograman Web',
                'deskripsi' => 'Buat aplikasi CRUD dengan Laravel',
                'deadline' => now()->addWeek(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'dosen_id' => null,
                'judul' => 'Tugas Basis Data',
                'deskripsi' => 'Desain database untuk aplikasi e-commerce',
                'deadline' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'dosen_id' => null,
                'judul' => 'Tugas Final Project',
                'deskripsi' => 'Kerjakan proyek akhir semester',
                'deadline' => now()->addMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}