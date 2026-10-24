<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $categories = DB::table('categories')
            ->pluck('id', 'name');

        $medicines = [
            [
                'category' => 'Analgesik',
                'name' => 'Paracetamol 500 mg',
                'brand' => 'Sanmol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '500 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DBL8914704010A1',
                'classification' => 'bebas',
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Paracetamol Sirup 120 mg/5 ml',
                'brand' => 'Tempra',
                'active_ingredients' => 'Paracetamol',
                'strength' => '120 mg/5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DBL1012503410A1',
                'classification' => 'bebas',
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Ibuprofen 400 mg',
                'brand' => 'Proris',
                'active_ingredients' => 'Ibuprofen',
                'strength' => '400 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DTL0521631537A1',
                'classification' => 'bebas_terbatas',
            ],
            [
                'category' => 'Antibiotik',
                'name' => 'Amoxicillin 500 mg',
                'brand' => 'Amoxsan',
                'active_ingredients' => 'Amoxicillin Trihydrate',
                'strength' => '500 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DKL9805022601A1',
                'classification' => 'keras',
            ],
            [
                'category' => 'Antihistamin',
                'name' => 'Cetirizine 10 mg',
                'brand' => 'Zyrtec',
                'active_ingredients' => 'Cetirizine Dihydrochloride',
                'strength' => '10 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL9605401011A1',
                'classification' => 'bebas_terbatas',
            ],
            [
                'category' => 'Vitamin & Suplemen',
                'name' => 'Vitamin C 500 mg',
                'brand' => 'Enervon-C',
                'active_ingredients' => 'Ascorbic Acid',
                'strength' => '500 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'SD011501531',
                'classification' => 'bebas',
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Omeprazole 20 mg',
                'brand' => 'Losec',
                'active_ingredients' => 'Omeprazole',
                'strength' => '20 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DKL9505601510A1',
                'classification' => 'keras',
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Ambroxol 30 mg',
                'brand' => 'Mucosolvan',
                'active_ingredients' => 'Ambroxol HCl',
                'strength' => '30 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL0103701212A1',
                'classification' => 'bebas_terbatas',
            ],
            [
                'category' => 'Obat Jantung & Tekanan Darah',
                'name' => 'Amlodipine 10 mg',
                'brand' => 'Norvask',
                'active_ingredients' => 'Amlodipine Besylate',
                'strength' => '10 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL0003001413A1',
                'classification' => 'keras',
            ],
            [
                'category' => 'Obat Kulit & Luar',
                'name' => 'Betadine Solution 10%',
                'brand' => 'Betadine',
                'active_ingredients' => 'Povidone Iodine',
                'strength' => '10%',
                'dosage_form' => 'larutan',
                'registration_number' => 'DBL8201600414A1',
                'classification' => 'bebas',
            ],
        ];

        foreach ($medicines as $medicine) {
            $categoryName = $medicine['category'];
            unset($medicine['category']);

            if (!isset($categories[$categoryName])) {
                throw new \RuntimeException(
                    "Kategori {$categoryName} belum tersedia. Jalankan CategorySeeder terlebih dahulu."
                );
            }

            DB::table('medicines')->updateOrInsert(
                ['registration_number' => $medicine['registration_number']],
                array_merge($medicine, [
                    'category_id' => $categories[$categoryName],
                    'is_active' => true,
                    'updated_at' => now(),
                ])
            );
        }
    }
}
