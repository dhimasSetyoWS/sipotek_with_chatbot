<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Analgesik', 'description' => 'Obat pereda nyeri dan demam'],
            ['name' => 'Antibiotik', 'description' => 'Obat antibakteri yang digunakan sesuai indikasi'],
            ['name' => 'Antihistamin', 'description' => 'Obat untuk membantu menangani gejala alergi'],
            ['name' => 'Vitamin & Suplemen', 'description' => 'Vitamin dan suplemen nutrisi'],
            ['name' => 'Obat Maag & Pencernaan', 'description' => 'Obat untuk keluhan pencernaan'],
            ['name' => 'Obat Batuk & Flu', 'description' => 'Obat untuk gejala batuk dan flu'],
            ['name' => 'Obat Jantung & Tekanan Darah', 'description' => 'Obat terkait jantung dan tekanan darah'],
            ['name' => 'Obat Kulit & Luar', 'description' => 'Obat untuk penggunaan luar dan kulit'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['name' => $category['name']],
                array_merge($category, [
                    'updated_at' => now(),
                ])
            );
        }
    }
}
