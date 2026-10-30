<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * 50 medicine + 50 medicine knowledge, delapan kategori pengguna.
 * Sumber publik dicocokkan 27 Oktober 2026. Bukan sertifikasi izin aktif.
 * Seluruh isi klinis tetap draft; reviewed_at tidak diisi karena belum direview.
 * Nomor registrasi diisi dari sumber, bukan placeholder atau nomor buatan.
 * Catatan konflik/ketidakpastian ada di CSV audit; wajib peninjauan apoteker.
 */
class PharmacyMedicineSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Analgesik',
                'description' => 'Obat pereda nyeri dan demam',
            ],
            [
                'name' => 'Antibiotik',
                'description' => 'Obat antibakteri yang digunakan sesuai indikasi',
            ],
            [
                'name' => 'Antihistamin',
                'description' => 'Obat untuk membantu menangani gejala alergi',
            ],
            [
                'name' => 'Vitamin & Suplemen',
                'description' => 'Vitamin dan suplemen nutrisi',
            ],
            [
                'name' => 'Obat Maag & Pencernaan',
                'description' => 'Obat untuk keluhan pencernaan',
            ],
            [
                'name' => 'Obat Batuk & Flu',
                'description' => 'Obat untuk gejala batuk dan flu',
            ],
            [
                'name' => 'Obat Jantung & Tekanan Darah',
                'description' => 'Obat terkait jantung dan tekanan darah',
            ],
            [
                'name' => 'Obat Kulit & Luar',
                'description' => 'Obat untuk penggunaan luar dan kulit',
            ],
        ];

        $medicines = [
            [
                'category' => 'Analgesik',
                'name' => 'Sanmol 500 mg',
                'brand' => 'Sanmol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '500 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DBL7622235610A2',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Sanmol Forte 650 mg',
                'brand' => 'Sanmol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '650 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DBL1122235610B1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Sanmol Sirup 120 mg/5 ml 60 ml',
                'brand' => 'Sanmol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '120 mg/5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DBL7622235037A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Sanmol Forte Sirup 250 mg/5 ml 60 ml',
                'brand' => 'Sanmol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '250 mg/5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DBL1322235037B1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Tempra Sirup Rasa Anggur 160 mg/5 ml 60 ml',
                'brand' => 'Tempra',
                'active_ingredients' => 'Paracetamol',
                'strength' => '160 mg/5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DBL1124403137A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Tempra Drops Rasa Anggur 80 mg/0.8 ml 15 ml',
                'brand' => 'Tempra',
                'active_ingredients' => 'Paracetamol',
                'strength' => '80 mg/0.8 ml',
                'dosage_form' => 'tetes oral',
                'registration_number' => 'DBL1124403036A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Tempra Forte Sirup Rasa Jeruk 250 mg/5 ml 60 ml',
                'brand' => 'Tempra',
                'active_ingredients' => 'Paracetamol',
                'strength' => '250 mg/5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DBL1124401337A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Panadol 500 mg',
                'brand' => 'Panadol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '500 mg',
                'dosage_form' => 'kaplet',
                'registration_number' => 'DBL9624502804A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Panadol Extra',
                'brand' => 'Panadol',
                'active_ingredients' => 'Paracetamol; Caffeine',
                'strength' => '500 mg; 65 mg',
                'dosage_form' => 'kaplet',
                'registration_number' => 'DBL9424502004A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Panadol Anak Sirup 160 mg/5 ml 30 ml',
                'brand' => 'Panadol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '160 mg/5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DBL7624501537A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Panadol Anak 120 mg Tablet Kunyah',
                'brand' => 'Panadol',
                'active_ingredients' => 'Paracetamol',
                'strength' => '120 mg',
                'dosage_form' => 'tablet kunyah',
                'registration_number' => 'DBL0124501963B1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Farsifen 400 mg',
                'brand' => 'Farsifen',
                'active_ingredients' => 'Ibuprofen',
                'strength' => '400 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL9409204409A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antibiotik',
                'name' => 'Amoxsan 500 mg',
                'brand' => 'Amoxsan',
                'active_ingredients' => 'Amoxicillin',
                'strength' => '500 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DKL0832401701B1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antibiotik',
                'name' => 'Amoxsan 250 mg Tablet Dispersible',
                'brand' => 'Amoxsan',
                'active_ingredients' => 'Amoxicillin',
                'strength' => '250 mg',
                'dosage_form' => 'tablet dispersible',
                'registration_number' => 'DKL0732401281A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antibiotik',
                'name' => 'Amoxsan Dry Sirup 125 mg/5 ml 60 ml',
                'brand' => 'Amoxsan',
                'active_ingredients' => 'Amoxicillin',
                'strength' => '125 mg/5 ml setelah rekonstitusi',
                'dosage_form' => 'serbuk untuk suspensi oral',
                'registration_number' => 'DKL0732401438A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antibiotik',
                'name' => 'Amoxsan Drops 100 mg/ml 15 ml',
                'brand' => 'Amoxsan',
                'active_ingredients' => 'Amoxicillin',
                'strength' => '100 mg/ml setelah rekonstitusi',
                'dosage_form' => 'serbuk untuk tetes oral',
                'registration_number' => 'DKL0732401336A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antibiotik',
                'name' => 'Decamox Dry Sirup 125 mg/5 ml 60 ml',
                'brand' => 'Decamox',
                'active_ingredients' => 'Amoxicillin Trihydrate (setara amoxicillin)',
                'strength' => '125 mg/5 ml setelah rekonstitusi',
                'dosage_form' => 'serbuk untuk suspensi oral',
                'registration_number' => 'DKL8707906638A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antihistamin',
                'name' => 'Incidal-OD 10 mg',
                'brand' => 'Incidal-OD',
                'active_ingredients' => 'Cetirizine Dihydrochloride',
                'strength' => '10 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DTL9902001301A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Antihistamin',
                'name' => 'Aerius 5 mg',
                'brand' => 'Aerius',
                'active_ingredients' => 'Desloratadine',
                'strength' => '5 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKI0887101417A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antihistamin',
                'name' => 'Aerius Sirup 0.5 mg/ml 60 ml',
                'brand' => 'Aerius',
                'active_ingredients' => 'Desloratadine',
                'strength' => '0.5 mg/ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DKI0487101137A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Antibiotik',
                'name' => 'Cefat 500 mg',
                'brand' => 'Cefat',
                'active_ingredients' => 'Cefadroxil',
                'strength' => '500 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DKL8922209701B1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Vitamin & Suplemen',
                'name' => 'Neurobion Tablet',
                'brand' => 'Neurobion',
                'active_ingredients' => 'Vitamin B1; Vitamin B6; Vitamin B12',
                'strength' => '100 mg; 200 mg; 200 mcg',
                'dosage_form' => 'tablet salut gula',
                'registration_number' => 'DBL7215806416B1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Vitamin & Suplemen',
                'name' => 'Neurobion Forte',
                'brand' => 'Neurobion',
                'active_ingredients' => 'Vitamin B1; Vitamin B6; Vitamin B12',
                'strength' => '100 mg; 100 mg; 5000 mcg',
                'dosage_form' => 'tablet salut gula',
                'registration_number' => 'DBL9615806416A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Losec 20 mg',
                'brand' => 'Losec',
                'active_ingredients' => 'Omeprazole',
                'strength' => '20 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DKI9551300701A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Promag Tablet Kunyah',
                'brand' => 'Promag',
                'active_ingredients' => 'Hydrotalcite; Magnesium Hydroxide; Simethicone',
                'strength' => '200 mg; 150 mg; 50 mg',
                'dosage_form' => 'tablet kunyah',
                'registration_number' => 'DBL9111601963A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Promag Suspensi 60 ml',
                'brand' => 'Promag',
                'active_ingredients' => 'Hydrotalcite; Magnesium Hydroxide; Simethicone',
                'strength' => '200 mg; 150 mg; 50 mg per 5 ml',
                'dosage_form' => 'suspensi oral',
                'registration_number' => 'DBL1111641033A3',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Mylanta Tablet Kunyah',
                'brand' => 'Mylanta',
                'active_ingredients' => 'Aluminium Hydroxide; Magnesium Hydroxide; Simethicone',
                'strength' => '200 mg; 200 mg; 20 mg',
                'dosage_form' => 'tablet kunyah',
                'registration_number' => 'DBL1441200163A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Mylanta Suspensi 50 ml',
                'brand' => 'Mylanta',
                'active_ingredients' => 'Aluminium Hydroxide; Magnesium Hydroxide; Simethicone',
                'strength' => '200 mg; 200 mg; 20 mg per 5 ml',
                'dosage_form' => 'suspensi oral',
                'registration_number' => 'DBL1441200233A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Polysilane Tablet Kunyah',
                'brand' => 'Polysilane',
                'active_ingredients' => 'Aluminium Hydroxide; Magnesium Hydroxide; Simethicone',
                'strength' => '200 mg; 200 mg; 80 mg',
                'dosage_form' => 'tablet kunyah',
                'registration_number' => 'DBL7821624163A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Polysilane Suspensi 180 ml',
                'brand' => 'Polysilane',
                'active_ingredients' => 'Aluminium Hydroxide; Magnesium Hydroxide; Dimethylpolysiloxane',
                'strength' => '200 mg; 200 mg; 80 mg per 5 ml',
                'dosage_form' => 'suspensi oral',
                'registration_number' => 'DBL7821624233A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Maag & Pencernaan',
                'name' => 'Polysilane Junior 40 mg',
                'brand' => 'Polysilane',
                'active_ingredients' => 'Simeticone',
                'strength' => '40 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DBL7821628101A1',
                'classification' => 'bebas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Panadol Cold & Flu',
                'brand' => 'Panadol',
                'active_ingredients' => 'Paracetamol; Pseudoephedrine HCl; Dextromethorphan HBr',
                'strength' => '500 mg; 30 mg; 15 mg',
                'dosage_form' => 'kaplet',
                'registration_number' => 'DTL9424502404A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Panadol Flu & Batuk',
                'brand' => 'Panadol',
                'active_ingredients' => 'Paracetamol; Phenylephrine HCl; Dextromethorphan HBr',
                'strength' => '500 mg; 5 mg; 15 mg',
                'dosage_form' => 'kaplet',
                'registration_number' => 'DTL1124503604A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Bisolvon 8 mg',
                'brand' => 'Bisolvon',
                'active_ingredients' => 'Bromhexine HCl',
                'strength' => '8 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DTL1821207010A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Actifed Sirup Kuning 60 ml',
                'brand' => 'Actifed',
                'active_ingredients' => 'Pseudoephedrine HCl; Triprolidine HCl',
                'strength' => '30 mg; 1.25 mg per 5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DTL1624504037A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Actifed Plus Expectorant Hijau 60 ml',
                'brand' => 'Actifed',
                'active_ingredients' => 'Triprolidine HCl; Pseudoephedrine HCl; Guaifenesin',
                'strength' => '1.25 mg; 30 mg; 100 mg per 5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DTL1624504237A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Actifed Plus Cough Suppressant Merah 60 ml',
                'brand' => 'Actifed',
                'active_ingredients' => 'Triprolidine HCl; Pseudoephedrine HCl; Dextromethorphan HBr',
                'strength' => '1.25 mg; 30 mg; 10 mg per 5 ml',
                'dosage_form' => 'sirup',
                'registration_number' => 'DTL1624504137A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'N-Ace 200 mg',
                'brand' => 'N-Ace',
                'active_ingredients' => 'Acetylcysteine',
                'strength' => '200 mg',
                'dosage_form' => 'kapsul',
                'registration_number' => 'DTL1231532501A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Batuk & Flu',
                'name' => 'Mucoxol 30 mg',
                'brand' => 'Mucoxol',
                'active_ingredients' => 'Ambroxol HCl',
                'strength' => '30 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL9422709910A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Jantung & Tekanan Darah',
                'name' => 'Norvask 5 mg',
                'brand' => 'Norvask',
                'active_ingredients' => 'Amlodipine Besylate (setara amlodipine)',
                'strength' => '5 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL9219803410A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Jantung & Tekanan Darah',
                'name' => 'Norvask 10 mg',
                'brand' => 'Norvask',
                'active_ingredients' => 'Amlodipine Besylate (setara amlodipine)',
                'strength' => '10 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL9619803410B1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Jantung & Tekanan Darah',
                'name' => 'Concor 1.25 mg',
                'brand' => 'Concor',
                'active_ingredients' => 'Bisoprolol Fumarate',
                'strength' => '1.25 mg',
                'dosage_form' => 'tablet salut selaput',
                'registration_number' => 'DKL1015803817C1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Jantung & Tekanan Darah',
                'name' => 'Concor 2.5 mg',
                'brand' => 'Concor',
                'active_ingredients' => 'Bisoprolol Fumarate',
                'strength' => '2.5 mg',
                'dosage_form' => 'tablet salut selaput',
                'registration_number' => 'DKL0215803817B1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Jantung & Tekanan Darah',
                'name' => 'Concor 5 mg',
                'brand' => 'Concor',
                'active_ingredients' => 'Bisoprolol Fumarate',
                'strength' => '5 mg',
                'dosage_form' => 'tablet salut selaput',
                'registration_number' => 'DKL9115803817A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Jantung & Tekanan Darah',
                'name' => 'Lasix 40 mg',
                'brand' => 'Lasix',
                'active_ingredients' => 'Furosemide',
                'strength' => '40 mg',
                'dosage_form' => 'tablet',
                'registration_number' => 'DKL0121203710A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Kulit & Luar',
                'name' => 'Daktarin Krim 2% 10 g',
                'brand' => 'Daktarin',
                'active_ingredients' => 'Miconazole Nitrate',
                'strength' => '20 mg/g (2%)',
                'dosage_form' => 'krim',
                'registration_number' => 'DTL1124401729A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Kulit & Luar',
                'name' => 'Canesten Krim 1% 5 g',
                'brand' => 'Canesten',
                'active_ingredients' => 'Clotrimazole',
                'strength' => '1%',
                'dosage_form' => 'krim',
                'registration_number' => 'DTL1202008629A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Kulit & Luar',
                'name' => 'Fungiderm Krim 1% 5 g',
                'brand' => 'Fungiderm',
                'active_ingredients' => 'Clotrimazole',
                'strength' => '1%',
                'dosage_form' => 'krim',
                'registration_number' => 'DTL8913004429A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Obat Kulit & Luar',
                'name' => 'Canesten Pro Krim 1% 15 g',
                'brand' => 'Canesten',
                'active_ingredients' => 'Bifonazole',
                'strength' => '1%',
                'dosage_form' => 'krim',
                'registration_number' => 'DTL8502000629A1',
                'classification' => 'bebas_terbatas',
                'is_active' => true,
            ],
            [
                'category' => 'Analgesik',
                'name' => 'Mefinal 500 mg',
                'brand' => 'Mefinal',
                'active_ingredients' => 'Mefenamic Acid',
                'strength' => '500 mg',
                'dosage_form' => 'kaplet salut selaput',
                'registration_number' => 'DKL8322200409A1',
                'classification' => 'keras',
                'is_active' => true,
            ],
        ];

        $medicineKnowledges = [
            [
                'medicine_registration_number' => 'DBL7622235610A2',
                'medicine_name' => 'Sanmol 500 mg',
                'indications' => 'Meredakan demam serta nyeri ringan hingga sedang seperti sakit kepala, sakit gigi dan nyeri otot.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat atau penyakit hati aktif.',
                'warnings' => 'Jangan melebihi dosis label atau menggabungkan beberapa obat berparacetamol. Alkohol meningkatkan risiko kerusakan hati. Hati-hati pada gangguan ginjal; periksakan diri bila demam tidak turun setelah 2 hari atau nyeri menetap setelah 5 hari.',
                'side_effects' => 'Reaksi alergi seperti ruam, gatal atau bengkak; kerusakan hati serius pada overdosis; kelainan darah sangat jarang.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/sanmol-500-mg-4-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1122235610B1',
                'medicine_name' => 'Sanmol Forte 650 mg',
                'indications' => 'Meredakan demam serta nyeri ringan hingga sedang seperti sakit kepala, sakit gigi dan nyeri otot.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat atau penyakit hati aktif.',
                'warnings' => 'Jangan melebihi dosis label atau menggabungkan beberapa obat berparacetamol. Alkohol meningkatkan risiko kerusakan hati. Hati-hati pada gangguan ginjal; periksakan diri bila demam tidak turun setelah 2 hari atau nyeri menetap setelah 5 hari.',
                'side_effects' => 'Reaksi alergi seperti ruam, gatal atau bengkak; kerusakan hati serius pada overdosis; kelainan darah sangat jarang.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/sanmol-500-mg-4-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL7622235037A1',
                'medicine_name' => 'Sanmol Sirup 120 mg/5 ml 60 ml',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan hingga sedang pada anak sesuai usia dan petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat.',
                'warnings' => 'Gunakan alat takar dan konsentrasi yang tepat sesuai label. Jangan menggabungkan dengan obat berparacetamol lain. Konsultasikan bila demam menetap; jangan melebihi dosis yang dianjurkan.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/tempra-sirup-rasa-anggur-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1322235037B1',
                'medicine_name' => 'Sanmol Forte Sirup 250 mg/5 ml 60 ml',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan hingga sedang pada anak sesuai usia dan petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat.',
                'warnings' => 'Gunakan alat takar dan konsentrasi yang tepat sesuai label. Jangan menggabungkan dengan obat berparacetamol lain. Konsultasikan bila demam menetap; jangan melebihi dosis yang dianjurkan.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/tempra-sirup-rasa-anggur-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1124403137A1',
                'medicine_name' => 'Tempra Sirup Rasa Anggur 160 mg/5 ml 60 ml',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan hingga sedang pada anak sesuai usia dan petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat.',
                'warnings' => 'Gunakan alat takar dan konsentrasi yang tepat sesuai label. Jangan menggabungkan dengan obat berparacetamol lain. Konsultasikan bila demam menetap; jangan melebihi dosis yang dianjurkan.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/tempra-sirup-rasa-anggur-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1124403036A1',
                'medicine_name' => 'Tempra Drops Rasa Anggur 80 mg/0.8 ml 15 ml',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan hingga sedang pada anak sesuai usia dan petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat.',
                'warnings' => 'Gunakan alat takar dan konsentrasi yang tepat sesuai label. Jangan menggabungkan dengan obat berparacetamol lain. Konsultasikan bila demam menetap; jangan melebihi dosis yang dianjurkan.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/tempra-sirup-rasa-anggur-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1124401337A1',
                'medicine_name' => 'Tempra Forte Sirup Rasa Jeruk 250 mg/5 ml 60 ml',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan hingga sedang pada anak sesuai usia dan petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat.',
                'warnings' => 'Gunakan alat takar dan konsentrasi yang tepat sesuai label. Jangan menggabungkan dengan obat berparacetamol lain. Konsultasikan bila demam menetap; jangan melebihi dosis yang dianjurkan.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/tempra-sirup-rasa-anggur-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL9624502804A1',
                'medicine_name' => 'Panadol 500 mg',
                'indications' => 'Meredakan demam serta nyeri ringan hingga sedang seperti sakit kepala, sakit gigi dan nyeri otot.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat atau penyakit hati aktif.',
                'warnings' => 'Jangan melebihi dosis label atau menggabungkan beberapa obat berparacetamol. Alkohol meningkatkan risiko kerusakan hati. Hati-hati pada gangguan ginjal; periksakan diri bila demam tidak turun setelah 2 hari atau nyeri menetap setelah 5 hari.',
                'side_effects' => 'Reaksi alergi seperti ruam, gatal atau bengkak; kerusakan hati serius pada overdosis; kelainan darah sangat jarang.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/sanmol-500-mg-4-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL9424502004A1',
                'medicine_name' => 'Panadol Extra',
                'indications' => 'Meredakan sakit kepala, migrain, sakit gigi, nyeri otot, nyeri haid dan demam.',
                'contraindications' => 'Hipersensitivitas paracetamol atau caffeine; gangguan fungsi hati berat.',
                'warnings' => 'Jangan digabung dengan produk berparacetamol lain. Batasi minuman berkafein, hindari alkohol dan jangan melebihi dosis label.',
                'side_effects' => 'Insomnia, cemas, palpitasi, mual, ruam; kerusakan hati pada overdosis.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/panadol-extra-4-kaplet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL7624501537A1',
                'medicine_name' => 'Panadol Anak Sirup 160 mg/5 ml 30 ml',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan hingga sedang pada anak sesuai usia dan petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat.',
                'warnings' => 'Gunakan alat takar dan konsentrasi yang tepat sesuai label. Jangan menggabungkan dengan obat berparacetamol lain. Konsultasikan bila demam menetap; jangan melebihi dosis yang dianjurkan.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/tempra-sirup-rasa-anggur-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL0124501963B1',
                'medicine_name' => 'Panadol Anak 120 mg Tablet Kunyah',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan hingga sedang pada anak sesuai usia dan petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol; gangguan fungsi hati berat.',
                'warnings' => 'Gunakan alat takar dan konsentrasi yang tepat sesuai label. Jangan menggabungkan dengan obat berparacetamol lain. Konsultasikan bila demam menetap; jangan melebihi dosis yang dianjurkan.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/tempra-sirup-rasa-anggur-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL9409204409A1',
                'medicine_name' => 'Farsifen 400 mg',
                'indications' => 'Meredakan nyeri ringan hingga sedang, demam dan peradangan.',
                'contraindications' => 'Alergi ibuprofen atau OAINS; ulkus peptikum berat; penyakit jantung berat; kehamilan trimester ketiga.',
                'warnings' => 'Risiko perdarahan saluran cerna. Hati-hati pada asma, gangguan ginjal, riwayat tukak lambung dan penyakit jantung; periksa interaksi dengan antikoagulan atau OAINS lain.',
                'side_effects' => 'Mual, muntah, nyeri perut, kembung, pusing dan sakit kepala.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/farsifen-400-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL0832401701B1',
                'medicine_name' => 'Amoxsan 500 mg',
                'indications' => 'Mengatasi infeksi bakteri peka, termasuk infeksi saluran napas, saluran kemih, kulit, jaringan lunak dan gigi sesuai diagnosis dokter.',
                'contraindications' => 'Hipersensitivitas terhadap amoxicillin atau penisilin; riwayat reaksi alergi berat terhadap beta-laktam lain perlu dinilai dokter.',
                'warnings' => 'Gunakan sesuai resep dan durasi dokter. Nilai fungsi ginjal dan riwayat alergi; cari pertolongan segera jika sesak atau bengkak wajah. Laporkan diare berat atau berdarah.',
                'side_effects' => 'Mual, diare, ruam; anafilaksis dan kolitis terkait antibiotik dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/amoxsan-500-mg-10-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL0732401281A1',
                'medicine_name' => 'Amoxsan 250 mg Tablet Dispersible',
                'indications' => 'Mengatasi infeksi bakteri peka, termasuk infeksi saluran napas, saluran kemih, kulit, jaringan lunak dan gigi sesuai diagnosis dokter.',
                'contraindications' => 'Hipersensitivitas terhadap amoxicillin atau penisilin; riwayat reaksi alergi berat terhadap beta-laktam lain perlu dinilai dokter.',
                'warnings' => 'Gunakan sesuai resep dan durasi dokter. Nilai fungsi ginjal dan riwayat alergi; cari pertolongan segera jika sesak atau bengkak wajah. Laporkan diare berat atau berdarah.',
                'side_effects' => 'Mual, diare, ruam; anafilaksis dan kolitis terkait antibiotik dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/amoxsan-500-mg-10-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL0732401438A1',
                'medicine_name' => 'Amoxsan Dry Sirup 125 mg/5 ml 60 ml',
                'indications' => 'Mengatasi infeksi bakteri peka, termasuk infeksi saluran napas, saluran kemih, kulit, jaringan lunak dan gigi sesuai diagnosis dokter.',
                'contraindications' => 'Hipersensitivitas terhadap amoxicillin atau penisilin; riwayat reaksi alergi berat terhadap beta-laktam lain perlu dinilai dokter.',
                'warnings' => 'Gunakan sesuai resep dan durasi dokter. Nilai fungsi ginjal dan riwayat alergi; cari pertolongan segera jika sesak atau bengkak wajah. Laporkan diare berat atau berdarah.',
                'side_effects' => 'Mual, diare, ruam; anafilaksis dan kolitis terkait antibiotik dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/amoxsan-500-mg-10-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL0732401336A1',
                'medicine_name' => 'Amoxsan Drops 100 mg/ml 15 ml',
                'indications' => 'Mengatasi infeksi bakteri peka, termasuk infeksi saluran napas, saluran kemih, kulit, jaringan lunak dan gigi sesuai diagnosis dokter.',
                'contraindications' => 'Hipersensitivitas terhadap amoxicillin atau penisilin; riwayat reaksi alergi berat terhadap beta-laktam lain perlu dinilai dokter.',
                'warnings' => 'Gunakan sesuai resep dan durasi dokter. Nilai fungsi ginjal dan riwayat alergi; cari pertolongan segera jika sesak atau bengkak wajah. Laporkan diare berat atau berdarah.',
                'side_effects' => 'Mual, diare, ruam; anafilaksis dan kolitis terkait antibiotik dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/amoxsan-500-mg-10-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL8707906638A1',
                'medicine_name' => 'Decamox Dry Sirup 125 mg/5 ml 60 ml',
                'indications' => 'Mengatasi infeksi bakteri peka, termasuk infeksi saluran napas, saluran kemih, kulit, jaringan lunak dan gigi sesuai diagnosis dokter.',
                'contraindications' => 'Hipersensitivitas terhadap amoxicillin atau penisilin; riwayat reaksi alergi berat terhadap beta-laktam lain perlu dinilai dokter.',
                'warnings' => 'Gunakan sesuai resep dan durasi dokter. Nilai fungsi ginjal dan riwayat alergi; cari pertolongan segera jika sesak atau bengkak wajah. Laporkan diare berat atau berdarah.',
                'side_effects' => 'Mual, diare, ruam; anafilaksis dan kolitis terkait antibiotik dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/amoxsan-500-mg-10-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL9902001301A1',
                'medicine_name' => 'Incidal-OD 10 mg',
                'indications' => 'Meredakan rinitis alergi dan urtikaria, termasuk bersin, hidung berair, bentol dan gatal.',
                'contraindications' => 'Hipersensitivitas cetirizine; gangguan ginjal berat.',
                'warnings' => 'Dapat menyebabkan kantuk; hindari mengemudi bila terpengaruh. Hindari alkohol atau sedatif. Konsultasikan pada gangguan ginjal/hati, epilepsi, kehamilan atau menyusui.',
                'side_effects' => 'Kantuk, mulut kering, sakit kepala, pusing, mual atau nyeri perut.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/incidal-od-4-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKI0887101417A1',
                'medicine_name' => 'Aerius 5 mg',
                'indications' => 'Meredakan rinitis alergi musiman atau perennial dan urtikaria kronik idiopatik.',
                'contraindications' => 'Hipersensitivitas terhadap desloratadine, loratadine atau komponen sediaan.',
                'warnings' => 'Gunakan sesuai resep. Hati-hati pada gangguan hati/ginjal. Kantuk atau pusing dapat terjadi; penggunaan saat hamil atau menyusui harus dinilai dokter.',
                'side_effects' => 'Kelelahan, kantuk, pusing, mulut kering, mual; reaksi alergi berat atau palpitasi dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/aerius-5-mg-15-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKI0487101137A1',
                'medicine_name' => 'Aerius Sirup 0.5 mg/ml 60 ml',
                'indications' => 'Meredakan rinitis alergi musiman atau perennial dan urtikaria kronik idiopatik.',
                'contraindications' => 'Hipersensitivitas terhadap desloratadine, loratadine atau komponen sediaan.',
                'warnings' => 'Gunakan sesuai resep. Hati-hati pada gangguan hati/ginjal. Kantuk atau pusing dapat terjadi; penggunaan saat hamil atau menyusui harus dinilai dokter.',
                'side_effects' => 'Kelelahan, kantuk, pusing, mulut kering, mual; reaksi alergi berat atau palpitasi dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/aerius-5-mg-15-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL8922209701B1',
                'medicine_name' => 'Cefat 500 mg',
                'indications' => 'Infeksi saluran napas, kulit/jaringan lunak dan saluran kemih oleh bakteri peka sesuai diagnosis dokter.',
                'contraindications' => 'Hipersensitivitas cefadroxil atau sefalosporin lain.',
                'warnings' => 'Nilai riwayat anafilaksis terhadap penisilin. Penyesuaian dosis diperlukan pada gangguan ginjal. Gunakan sesuai resep; laporkan diare berat atau berdarah.',
                'side_effects' => 'Mual, diare, ruam; reaksi alergi berat atau kolitis terkait antibiotik dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/cefat-500-mg-10-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL7215806416B1',
                'medicine_name' => 'Neurobion Tablet',
                'indications' => 'Pencegahan dan pengobatan kondisi terkait kekurangan vitamin B1, B6 dan B12, termasuk neuropati akibat defisiensi vitamin tersebut.',
                'contraindications' => 'Hipersensitivitas terhadap salah satu komponen.',
                'warnings' => 'Vitamin B6 dosis tinggi dalam jangka panjang dapat menyebabkan neuropati. Konsultasikan bila sedang menggunakan levodopa atau obat lain; penggunaan saat hamil atau menyusui memerlukan penilaian tenaga kesehatan.',
                'side_effects' => 'Gangguan pencernaan ringan, mual atau reaksi alergi; neuropati perifer pada pemakaian vitamin B6 dosis tinggi berkepanjangan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/neurobion-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL9615806416A1',
                'medicine_name' => 'Neurobion Forte',
                'indications' => 'Pengobatan kondisi terkait kekurangan vitamin B1, B6 dan B12 seperti neuropati perifer akibat defisiensi, dengan keluhan kesemutan, kebas atau nyeri saraf.',
                'contraindications' => 'Hipersensitivitas terhadap salah satu komponen.',
                'warnings' => 'Penggunaan vitamin B6 dosis tinggi berkepanjangan dapat menyebabkan neuropati. Gunakan sesuai petunjuk tenaga kesehatan; periksa interaksi dengan levodopa.',
                'side_effects' => 'Reaksi alergi, mual atau sakit perut.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/neurobion-forte-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKI9551300701A1',
                'medicine_name' => 'Losec 20 mg',
                'indications' => 'Tukak lambung atau duodenum, lesi terkait OAINS, esofagitis refluks dan sindrom Zollinger-Ellison; eradikasi H. pylori dalam kombinasi antibiotik.',
                'contraindications' => 'Hipersensitivitas terhadap omeprazole.',
                'warnings' => 'Evaluasi sulit menelan, berat badan turun tanpa sebab, muntah berulang, muntah darah atau melena. Hati-hati pada gangguan hati; periksa interaksi dengan warfarin, fenitoin dan obat lain.',
                'side_effects' => 'Sakit kepala, nyeri perut, sembelit, diare, kembung, mual atau muntah.',
                'source_name' => 'BPOM — informasi produk Losec, persetujuan 08-11-2021',
                'source_url' => 'https://registrasiobat.pom.go.id/files/assesment-reports/01702519419.pdf',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL9111601963A1',
                'medicine_name' => 'Promag Tablet Kunyah',
                'indications' => 'Meredakan gejala akibat kelebihan asam lambung seperti nyeri ulu hati, mual, kembung dan rasa penuh.',
                'contraindications' => 'Hipersensitivitas terhadap komponen; gangguan ginjal berat sesuai monograf tablet rujukan.',
                'warnings' => 'Hati-hati pada gangguan ginjal dan diet rendah fosfor. Jangan digunakan terus-menerus lebih dari 2 minggu tanpa petunjuk dokter. Antasida dapat mengganggu penyerapan obat lain; atur jeda sesuai petunjuk tenaga kesehatan.',
                'side_effects' => 'Sembelit, diare, mual atau muntah.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/promag-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1111641033A3',
                'medicine_name' => 'Promag Suspensi 60 ml',
                'indications' => 'Meredakan gejala kelebihan asam lambung seperti mual, nyeri ulu hati, kembung dan rasa penuh.',
                'contraindications' => 'Hipersensitivitas terhadap salah satu komponen obat.',
                'warnings' => 'Kocok dahulu. Hati-hati pada gangguan ginjal karena risiko hipermagnesemia dan pada diet rendah fosfor. Jangan digunakan lebih dari 2 minggu tanpa petunjuk dokter; periksa interaksi dan jeda dengan obat lain.',
                'side_effects' => 'Konstipasi, diare, mual, muntah, sakit kepala, pusing atau ruam.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/promag-suspensi-60-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1441200163A1',
                'medicine_name' => 'Mylanta Tablet Kunyah',
                'indications' => 'Mengurangi gejala kelebihan asam lambung seperti mual, nyeri lambung, nyeri ulu hati, kembung dan rasa penuh.',
                'contraindications' => 'Gangguan fungsi ginjal berat; hipersensitivitas terhadap salah satu komponen.',
                'warnings' => 'Hati-hati pada diet rendah fosfor. Jangan digunakan terus-menerus lebih dari 2 minggu tanpa petunjuk dokter. Periksa interaksi dan jeda waktu dengan obat lain; konsultasikan pada anak di bawah 6 tahun.',
                'side_effects' => 'Sembelit, diare, mual, muntah, perubahan rasa atau reaksi hipersensitivitas.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/mylanta-3-strip-10-tablet-strip-hemat-borongan',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL1441200233A1',
                'medicine_name' => 'Mylanta Suspensi 50 ml',
                'indications' => 'Mengurangi gejala kelebihan asam lambung seperti mual, nyeri lambung, nyeri ulu hati, kembung dan rasa penuh.',
                'contraindications' => 'Gangguan fungsi ginjal berat; hipersensitivitas terhadap salah satu komponen.',
                'warnings' => 'Hati-hati pada diet rendah fosfor. Jangan digunakan terus-menerus lebih dari 2 minggu tanpa petunjuk dokter. Periksa interaksi dan jeda waktu dengan obat lain; konsultasikan pada anak di bawah 6 tahun.',
                'side_effects' => 'Sembelit, diare, mual, muntah, perubahan rasa atau reaksi hipersensitivitas.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/mylanta-3-strip-10-tablet-strip-hemat-borongan',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL7821624163A1',
                'medicine_name' => 'Polysilane Tablet Kunyah',
                'indications' => 'Meredakan nyeri lambung, nyeri ulu hati, kembung dan rasa tidak nyaman akibat kelebihan asam lambung.',
                'contraindications' => 'Hipersensitivitas terhadap komponen produk.',
                'warnings' => 'Hati-hati pada gangguan ginjal karena magnesium dapat menumpuk. Tablet kunyah harus dikunyah; periksa interaksi dengan obat lain.',
                'side_effects' => 'Konstipasi atau diare.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/polysilane-8-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL7821624233A1',
                'medicine_name' => 'Polysilane Suspensi 180 ml',
                'indications' => 'Mengurangi keluhan kelebihan asam lambung seperti mual, nyeri lambung, nyeri ulu hati dan kembung.',
                'contraindications' => 'Gangguan fungsi ginjal berat.',
                'warnings' => 'Kocok dahulu; jangan digunakan terus-menerus lebih dari 2 minggu tanpa petunjuk dokter. Hati-hati pada diet rendah fosfor; periksa jeda dengan obat lain.',
                'side_effects' => 'Sembelit, diare, mual atau muntah.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/polysilane-suspensi-180-ml',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DBL7821628101A1',
                'medicine_name' => 'Polysilane Junior 40 mg',
                'indications' => 'Meredakan ketidaknyamanan akibat gas berlebih, seperti kembung, rasa penuh atau tekanan pada perut.',
                'contraindications' => 'Hipersensitivitas terhadap simeticone atau komponen sediaan.',
                'warnings' => 'Ikuti label produk; beri tahu tenaga kesehatan obat lain yang digunakan. Keluhan menetap atau memburuk memerlukan evaluasi, bukan peningkatan dosis sendiri.',
                'side_effects' => 'Biasanya tidak menimbulkan efek samping bila digunakan sesuai petunjuk; mual atau diare ringan pernah dilaporkan.',
                'source_name' => 'NCBI Bookshelf — StatPearls, Simethicone',
                'source_url' => 'https://www.ncbi.nlm.nih.gov/books/NBK555997/',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL9424502404A1',
                'medicine_name' => 'Panadol Cold & Flu',
                'indications' => 'Meredakan gejala flu berupa demam, sakit kepala, hidung tersumbat dan batuk tidak berdahak.',
                'contraindications' => 'Hipersensitivitas komponen; gangguan fungsi hati berat, gangguan jantung atau diabetes sesuai monograf produk.',
                'warnings' => 'Hati-hati pada hipertensi. Interaksi dengan MAOI dapat menyebabkan krisis hipertensi. Jangan digabung dengan produk berparacetamol lain; hentikan bila insomnia, palpitasi atau pusing.',
                'side_effects' => 'Reaksi hipersensitivitas; kerusakan hati pada dosis besar atau penggunaan berkepanjangan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/panadol-cold-dan-flu-10-kaplet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1124503604A1',
                'medicine_name' => 'Panadol Flu & Batuk',
                'indications' => 'Meredakan gejala flu seperti demam, sakit kepala, hidung tersumbat dan batuk tidak berdahak.',
                'contraindications' => 'Hipersensitivitas komponen; gangguan fungsi hati berat, gangguan jantung atau diabetes sesuai monograf.',
                'warnings' => 'Jangan digabung dengan produk berparacetamol lain. Hati-hati pada hipertensi dan periksa interaksi MAOI. Hentikan bila susah tidur, palpitasi atau pusing; periksakan bila gejala tidak membaik dalam 3 hari.',
                'side_effects' => 'Palpitasi, mual, pusing, gangguan cerna, mengantuk atau insomnia; kerusakan hati pada dosis berlebihan.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/panadol-flu-dan-batuk-10-kaplet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1821207010A1',
                'medicine_name' => 'Bisolvon 8 mg',
                'indications' => 'Mengencerkan dahak kental sehingga lebih mudah dikeluarkan pada batuk berdahak.',
                'contraindications' => 'Hipersensitivitas bromhexine HCl; ulkus lambung aktif sesuai monograf rujukan.',
                'warnings' => 'Hati-hati pada riwayat tukak lambung. Konsultasikan pada kehamilan atau menyusui, terutama trimester pertama.',
                'side_effects' => 'Mual, kembung, diare, sakit kepala, pusing atau ruam.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/bisolvon-8-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1624504037A1',
                'medicine_name' => 'Actifed Sirup Kuning 60 ml',
                'indications' => 'Meredakan pilek dan alergi saluran pernapasan hidung.',
                'contraindications' => 'Hipersensitivitas terhadap simpatomimetik; hipertensi berat; penggunaan MAOI dalam 2 minggu terakhir.',
                'warnings' => 'Dapat menyebabkan kantuk. Hati-hati pada hipertensi, gangguan hati/ginjal, diabetes, pembesaran prostat atau hipertiroid. Hentikan bila insomnia atau palpitasi; tidak dianjurkan untuk anak di bawah 6 tahun kecuali petunjuk dokter.',
                'side_effects' => 'Kantuk, gangguan cerna, sakit kepala, insomnia, mulut kering, palpitasi atau sulit berkemih.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/actifed-sirup-60-ml-kuning',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1624504237A1',
                'medicine_name' => 'Actifed Plus Expectorant Hijau 60 ml',
                'indications' => 'Meredakan pilek dan batuk berdahak.',
                'contraindications' => 'Hipersensitivitas terhadap triprolidine, pseudoephedrine, guaifenesin atau komponen lain.',
                'warnings' => 'Dapat menyebabkan kantuk; hindari mengemudi, alkohol dan sedatif. Hati-hati pada hipertensi, penyakit jantung, glaukoma, gangguan hati/ginjal, hipertiroid atau diabetes. Periksa interaksi MAOI; tidak dianjurkan pada anak di bawah 6 tahun kecuali petunjuk dokter.',
                'side_effects' => 'Kantuk, gangguan cerna, sakit kepala, insomnia, tremor, mulut kering, palpitasi atau kesulitan berkemih.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/actifed-plus-expectorant-sirup-60-ml-hijau',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1624504137A1',
                'medicine_name' => 'Actifed Plus Cough Suppressant Merah 60 ml',
                'indications' => 'Meredakan pilek, hidung tersumbat dan bersin yang disertai batuk tidak berdahak.',
                'contraindications' => 'Hipersensitivitas terhadap komponen, hipertensi berat, penyakit jantung koroner berat atau terapi MAOI.',
                'warnings' => 'Dapat menyebabkan kantuk; hindari mengemudi. Hati-hati pada hipertensi, diabetes, gangguan hati/ginjal, glaukoma atau hipertiroid. Periksa interaksi obat serotonergik dan depresan sistem saraf pusat.',
                'side_effects' => 'Kantuk, pusing, mulut kering, gangguan cerna, palpitasi atau retensi urin.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/actifed-plus-cough-supressant-sirup-60-ml-merah',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1231532501A1',
                'medicine_name' => 'N-Ace 200 mg',
                'indications' => 'Mengencerkan dahak kental di saluran napas.',
                'contraindications' => 'Hipersensitivitas acetylcysteine atau komponen sediaan; anak di bawah 2 tahun sesuai monograf produk.',
                'warnings' => 'Hati-hati pada asma karena bronkospasme dapat terjadi dan pada riwayat ulkus. Hindari kombinasi dengan penekan batuk tanpa penilaian dokter karena risiko penumpukan dahak.',
                'side_effects' => 'Mual, muntah, nyeri perut atau ruam.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/n-ace-200-mg-10-kapsul',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL9422709910A1',
                'medicine_name' => 'Mucoxol 30 mg',
                'indications' => 'Mengencerkan dahak pada gangguan saluran pernapasan dengan sekresi kental.',
                'contraindications' => 'Hipersensitivitas terhadap ambroxol; ulkus lambung sesuai monograf produk.',
                'warnings' => 'Gunakan sesuai petunjuk dokter; konsultasikan pada kehamilan atau menyusui.',
                'side_effects' => 'Gangguan saluran cerna dan reaksi alergi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/mucoxol-30-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL9219803410A1',
                'medicine_name' => 'Norvask 5 mg',
                'indications' => 'Mengobati hipertensi dan angina pektoris.',
                'contraindications' => 'Hipersensitivitas terhadap amlodipine atau dihidropiridin; syok kardiogenik; stenosis aorta berat sesuai monograf rujukan.',
                'warnings' => 'Hati-hati pada gagal jantung dan gangguan hati. Jangan mengubah atau menghentikan terapi tanpa petunjuk dokter.',
                'side_effects' => 'Edema perifer, sakit kepala, kelelahan, flushing, pusing, palpitasi atau mual.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/norvask-10-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL9619803410B1',
                'medicine_name' => 'Norvask 10 mg',
                'indications' => 'Mengobati hipertensi dan angina pektoris.',
                'contraindications' => 'Hipersensitivitas terhadap amlodipine atau dihidropiridin; syok kardiogenik; stenosis aorta berat sesuai monograf rujukan.',
                'warnings' => 'Hati-hati pada gagal jantung dan gangguan hati. Jangan mengubah atau menghentikan terapi tanpa petunjuk dokter.',
                'side_effects' => 'Edema perifer, sakit kepala, kelelahan, flushing, pusing, palpitasi atau mual.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/norvask-10-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL1015803817C1',
                'medicine_name' => 'Concor 1.25 mg',
                'indications' => 'Mengobati hipertensi, angina dan gagal jantung kronik stabil sesuai indikasi serta titrasi dokter.',
                'contraindications' => 'Hipersensitivitas bisoprolol; syok kardiogenik; gagal jantung dekompensasi yang memerlukan inotropik intravena; bradikardia berat; blok AV derajat 2-3 tanpa pacu jantung; hipotensi berat; asma berat dengan bronkospasme.',
                'warnings' => 'Jangan dihentikan mendadak. Dapat menutupi gejala hipoglikemia; hati-hati pada asma, gangguan konduksi, penyakit arteri perifer, gangguan hati atau ginjal. Awal terapi gagal jantung memerlukan pengawasan dokter.',
                'side_effects' => 'Kelelahan, pusing, sakit kepala, bradikardia, tangan/kaki dingin atau gangguan cerna; hipotensi atau bronkospasme dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/concor-2-5-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL0215803817B1',
                'medicine_name' => 'Concor 2.5 mg',
                'indications' => 'Mengobati hipertensi, angina dan gagal jantung kronik stabil sesuai indikasi serta titrasi dokter.',
                'contraindications' => 'Hipersensitivitas bisoprolol; syok kardiogenik; gagal jantung dekompensasi yang memerlukan inotropik intravena; bradikardia berat; blok AV derajat 2-3 tanpa pacu jantung; hipotensi berat; asma berat dengan bronkospasme.',
                'warnings' => 'Jangan dihentikan mendadak. Dapat menutupi gejala hipoglikemia; hati-hati pada asma, gangguan konduksi, penyakit arteri perifer, gangguan hati atau ginjal. Awal terapi gagal jantung memerlukan pengawasan dokter.',
                'side_effects' => 'Kelelahan, pusing, sakit kepala, bradikardia, tangan/kaki dingin atau gangguan cerna; hipotensi atau bronkospasme dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/concor-2-5-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL9115803817A1',
                'medicine_name' => 'Concor 5 mg',
                'indications' => 'Mengobati hipertensi, angina dan gagal jantung kronik stabil sesuai indikasi serta titrasi dokter.',
                'contraindications' => 'Hipersensitivitas bisoprolol; syok kardiogenik; gagal jantung dekompensasi yang memerlukan inotropik intravena; bradikardia berat; blok AV derajat 2-3 tanpa pacu jantung; hipotensi berat; asma berat dengan bronkospasme.',
                'warnings' => 'Jangan dihentikan mendadak. Dapat menutupi gejala hipoglikemia; hati-hati pada asma, gangguan konduksi, penyakit arteri perifer, gangguan hati atau ginjal. Awal terapi gagal jantung memerlukan pengawasan dokter.',
                'side_effects' => 'Kelelahan, pusing, sakit kepala, bradikardia, tangan/kaki dingin atau gangguan cerna; hipotensi atau bronkospasme dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/concor-2-5-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL0121203710A1',
                'medicine_name' => 'Lasix 40 mg',
                'indications' => 'Mengurangi edema akibat gagal jantung, sirosis hati atau penyakit ginjal; hipertensi tertentu sesuai indikasi dokter.',
                'contraindications' => 'Hipersensitivitas furosemide; anuria atau gagal ginjal tidak responsif; hipovolemia/dehidrasi berat; hiponatremia atau hipokalemia berat yang belum terkoreksi; koma hepatikum.',
                'warnings' => 'Pantau keseimbangan cairan, elektrolit, tekanan darah dan fungsi ginjal. Hati-hati pada gout, diabetes atau retensi urin; periksa interaksi digoxin dan obat lain.',
                'side_effects' => 'Dehidrasi, hipotensi, gangguan elektrolit, peningkatan asam urat; gangguan pendengaran dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/lasix-40-mg-10-tablet',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1124401729A1',
                'medicine_name' => 'Daktarin Krim 2% 10 g',
                'indications' => 'Mengobati infeksi jamur pada kulit, termasuk panu dan infeksi pada sela jari atau lipatan kulit.',
                'contraindications' => 'Hipersensitivitas terhadap miconazole, miconazole nitrate atau turunan imidazol lain.',
                'warnings' => 'Hanya untuk penggunaan luar; hindari mata. Hentikan bila iritasi berat; konsultasikan pada kehamilan/menyusui dan penggunaan warfarin.',
                'side_effects' => 'Iritasi, kemerahan, gatal, dermatitis kontak, urtikaria atau reaksi alergi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/daktarin-cream-10-g',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL1202008629A1',
                'medicine_name' => 'Canesten Krim 1% 5 g',
                'indications' => 'Mengobati infeksi jamur kulit seperti kurap, kutu air, panu dan kandidiasis kulit.',
                'contraindications' => 'Hipersensitivitas terhadap clotrimazole atau komponen sediaan.',
                'warnings' => 'Hanya untuk pemakaian luar; jangan ditelan atau terkena mata. Hentikan bila reaksi alergi. Konsultasikan bila memburuk atau tidak membaik; penggunaan saat hamil memerlukan saran tenaga kesehatan.',
                'side_effects' => 'Kemerahan, gatal, rasa terbakar/menyengat, nyeri atau iritasi lokal; reaksi alergi berat jarang.',
                'source_name' => 'NHS — Clotrimazole, informasi sediaan topikal',
                'source_url' => 'https://www.nhs.uk/medicines/clotrimazole/',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL8913004429A1',
                'medicine_name' => 'Fungiderm Krim 1% 5 g',
                'indications' => 'Mengobati infeksi jamur kulit seperti kurap, kutu air, panu dan kandidiasis kulit.',
                'contraindications' => 'Hipersensitivitas terhadap clotrimazole atau komponen sediaan.',
                'warnings' => 'Hanya untuk pemakaian luar; jangan ditelan atau terkena mata. Hentikan bila reaksi alergi. Konsultasikan bila memburuk atau tidak membaik; penggunaan saat hamil memerlukan saran tenaga kesehatan.',
                'side_effects' => 'Kemerahan, gatal, rasa terbakar/menyengat, nyeri atau iritasi lokal; reaksi alergi berat jarang.',
                'source_name' => 'NHS — Clotrimazole, informasi sediaan topikal',
                'source_url' => 'https://www.nhs.uk/medicines/clotrimazole/',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DTL8502000629A1',
                'medicine_name' => 'Canesten Pro Krim 1% 15 g',
                'indications' => 'Mengobati infeksi jamur kulit seperti kutu air, panu atau kurap sesuai petunjuk produk.',
                'contraindications' => 'Hipersensitivitas terhadap bifonazole atau komponen sediaan.',
                'warnings' => 'Hanya untuk pemakaian luar; hindari mata. Hati-hati bila alergi imidazol lain. Konsultasikan pada penggunaan warfarin, kehamilan atau menyusui.',
                'side_effects' => 'Iritasi, rasa terbakar, kemerahan, gatal, kulit kering atau mengelupas; reaksi alergi dapat terjadi.',
                'source_name' => 'eMC — SmPC bifonazole topikal 1%',
                'source_url' => 'https://www.medicines.org.uk/emc/product/13667/smpc',
                'status' => 'draft',
            ],
            [
                'medicine_registration_number' => 'DKL8322200409A1',
                'medicine_name' => 'Mefinal 500 mg',
                'indications' => 'Meredakan nyeri ringan hingga sedang seperti sakit gigi, sakit kepala, nyeri otot atau nyeri haid.',
                'contraindications' => 'Hipersensitivitas asam mefenamat/OAINS; tukak peptikum aktif atau riwayat perdarahan/perforasi terkait OAINS; gangguan ginjal berat; gagal jantung berat; kehamilan trimester ketiga.',
                'warnings' => 'Risiko perdarahan saluran cerna, gangguan ginjal dan kejadian kardiovaskular. Hindari kombinasi OAINS lain; periksa interaksi antikoagulan. Jangan digunakan lebih dari 7 hari kecuali petunjuk dokter.',
                'side_effects' => 'Nyeri lambung, mual, diare/konstipasi, sakit kepala, pusing; perdarahan saluran cerna, gangguan ginjal atau reaksi alergi berat dapat terjadi.',
                'source_name' => 'Halodoc — monograf produk',
                'source_url' => 'https://www.halodoc.com/obat-dan-vitamin/mefinal-500-mg-10-kaplet',
                'status' => 'draft',
            ],
        ];

        // Validasi data sebelum transaksi: tidak ada isi wajib yang kosong.
        if (count($medicines) !== 50 || count($medicineKnowledges) !== 50) {
            throw new RuntimeException('Dataset harus berisi 50 medicine dan 50 knowledge.');
        }

        $allowedClassifications = [
            'bebas', 'bebas_terbatas', 'keras', 'narkotika',
            'psikotropika', 'jamu', 'herbal',
        ];
        $registrations = [];
        $names = [];
        $categoryNames = array_column($categories, 'name');
        $limits = ['name' => 150, 'brand' => 100, 'strength' => 50,
            'dosage_form' => 50, 'registration_number' => 50];

        foreach ($medicines as $medicine) {
            foreach (['category', 'name', 'brand', 'active_ingredients', 'strength',
                'dosage_form', 'registration_number', 'classification'] as $field) {
                if (!isset($medicine[$field]) || !is_string($medicine[$field])
                    || trim($medicine[$field]) === '') {
                    throw new RuntimeException('Field medicine kosong: ' . $field);
                }
            }
            foreach ($limits as $field => $limit) {
                if (mb_strlen($medicine[$field]) > $limit) {
                    throw new RuntimeException('Field terlalu panjang: ' . $field);
                }
            }
            if (!in_array($medicine['classification'], $allowedClassifications, true)
                || !in_array($medicine['category'], $categoryNames, true)) {
                throw new RuntimeException('Golongan atau kategori tidak sesuai schema.');
            }
            $number = $medicine['registration_number'];
            if (isset($registrations[$number]) || isset($names[$medicine['name']])) {
                throw new RuntimeException('Nama atau nomor registrasi duplikat.');
            }
            $registrations[$number] = true;
            $names[$medicine['name']] = $number;
        }

        $knowledgeNumbers = [];
        foreach ($medicineKnowledges as $knowledge) {
            foreach (['medicine_registration_number', 'medicine_name', 'indications',
                'contraindications', 'warnings', 'side_effects', 'source_name',
                'source_url', 'status'] as $field) {
                if (!isset($knowledge[$field]) || !is_string($knowledge[$field])
                    || trim($knowledge[$field]) === '') {
                    throw new RuntimeException('Field knowledge kosong: ' . $field);
                }
            }
            $number = $knowledge['medicine_registration_number'];
            if (!isset($registrations[$number]) || isset($knowledgeNumbers[$number])
                || ($names[$knowledge['medicine_name']] ?? '') !== $number
                || $knowledge['status'] !== 'draft') {
                throw new RuntimeException('Relasi atau status knowledge tidak valid.');
            }
            if (mb_strlen($knowledge['source_name']) > 255
                || filter_var($knowledge['source_url'], FILTER_VALIDATE_URL) === false) {
                throw new RuntimeException('Sumber knowledge tidak valid.');
            }
            $knowledgeNumbers[$number] = true;
        }

        $categoryHasCreatedAt = Schema::hasColumn('categories', 'created_at');
        $categoryHasUpdatedAt = Schema::hasColumn('categories', 'updated_at');

        DB::transaction(function () use ($categories, $medicines, $medicineKnowledges,
            $categoryHasCreatedAt, $categoryHasUpdatedAt): void {
            $now = now();
            $categoryIds = [];
            $medicineIds = [];

            foreach ($categories as $category) {
                $existing = DB::table('categories')->where('name', $category['name'])->first();
                if ($existing) {
                    $categoryIds[$category['name']] = (int) $existing->id;
                    continue;
                }
                $payload = $category;
                if ($categoryHasCreatedAt) {
                    $payload['created_at'] = $now;
                }
                if ($categoryHasUpdatedAt) {
                    $payload['updated_at'] = $now;
                }
                $categoryIds[$category['name']] = (int) DB::table('categories')
                    ->insertGetId($payload);
            }

            foreach ($medicines as $medicine) {
                $categoryName = $medicine['category'];
                unset($medicine['category']);
                $medicine['category_id'] = $categoryIds[$categoryName];
                $medicine['updated_at'] = $now;
                $number = $medicine['registration_number'];
                $existing = DB::table('medicines')->where('registration_number', $number)->first();

                if ($existing) {
                    $medicineId = (int) $existing->id;
                    DB::table('medicines')->where('id', $medicineId)->update($medicine);
                } else {
                    $medicine['created_at'] = $now;
                    $medicineId = (int) DB::table('medicines')->insertGetId($medicine);
                }
                $medicineIds[$number] = $medicineId;
            }

            foreach ($medicineKnowledges as $knowledge) {
                $number = $knowledge['medicine_registration_number'];
                unset($knowledge['medicine_registration_number'], $knowledge['medicine_name']);
                $medicineId = $medicineIds[$number];
                $existing = DB::table('medicine_knowledge')->where('medicine_id', $medicineId)->first();

                // Jangan menimpa hasil review manusia ketika seeder dijalankan ulang.
                if ($existing && $existing->status === 'reviewed') {
                    continue;
                }

                $knowledge['medicine_id'] = $medicineId;
                $knowledge['updated_at'] = $now;
                // reviewed_at sengaja tidak dikirim: belum ada review apoteker.
                if ($existing) {
                    DB::table('medicine_knowledge')->where('id', $existing->id)->update($knowledge);
                } else {
                    $knowledge['created_at'] = $now;
                    DB::table('medicine_knowledge')->insert($knowledge);
                }
            }
        });

        if ($this->command) {
            $this->command->info('Selesai: 50 medicine diproses; 50 pasangan knowledge tersedia. Knowledge reviewed yang sudah ada dipertahankan.');
        }
    }
}
