<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineKnowledge;
use Illuminate\Database\Seeder;

class MedicineKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $verifiedKnowledge = [
            /*
             * Isi setelah lu memverifikasi informasi obat.
             *
             * Contoh struktur:
             *
             * [
             *     'medicine_name' => 'Nama obat yang ada di database',
             *     'indications' => 'Indikasi sesuai sumber resmi',
             *     'contraindications' => 'Kontraindikasi sesuai sumber',
             *     'warnings' => 'Peringatan sesuai sumber',
             *     'side_effects' => 'Efek samping sesuai sumber',
             *     'source_name' => 'Nama referensi',
             *     'source_url' => 'URL referensi',
             * ],
             */

            [
                'medicine_name' => 'Paracetamol 500 mg',
                'indications' => 'Meredakan demam dan nyeri ringan hingga sedang seperti sakit kepala, sakit gigi, dan nyeri otot.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol, gangguan fungsi hati berat.',
                'warnings' => 'Hati-hati penggunaan pada penderita gangguan fungsi hati/ginjal dan alkoholisme.',
                'side_effects' => 'Reaksi alergi (jarang), mual, kerusakan hati (pada penggunaan dosis berlebih).',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Paracetamol Sirup 120 mg/5 ml',
                'indications' => 'Menurunkan demam dan meredakan nyeri ringan pada anak-anak.',
                'contraindications' => 'Hipersensitivitas terhadap paracetamol, gangguan fungsi hati berat.',
                'warnings' => 'Gunakan sendok takar yang sesuai; hati-hati pada pasien dengan gangguan fungsi hati atau ginjal.',
                'side_effects' => 'Ruam kulit, mual, reaksi hipersensitivitas.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Ibuprofen 400 mg',
                'indications' => 'Meredakan nyeri ringan hingga sedang (seperti sakit kepala, sakit gigi, nyeri haid), menurunkan demam, serta meredakan peradangan sendi.',
                'contraindications' => 'Riwayat tukak lambung aktif, asma sensitif terhadap NSAID, kehamilan trimester akhir, gagal jantung berat.',
                'warnings' => 'Dapat meningkatkan risiko perdarahan saluran cerna; hati-hati pada pasien hipertensi, gangguan ginjal, atau riwayat penyakit jantung.',
                'side_effects' => 'Mual, muntah, nyeri lambung, heartburn, pusing, sakit kepala.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Amoxicillin 500 mg',
                'indications' => 'Mengatasi infeksi bakteri yang peka, seperti infeksi saluran pernapasan, saluran kemih, kulit, dan infeksi gigi.',
                'contraindications' => 'Hipersensitivitas terhadap golongan penisilin atau sefalosporin.',
                'warnings' => 'Habiskan seluruh antibiotik yang diresepkan meskipun gejala sudah membaik; hati-hati pada riwayat alergi berat atau gangguan ginjal.',
                'side_effects' => 'Diare, mual, muntah, ruam kulit, reaksi alergi.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Cetirizine 10 mg',
                'indications' => 'Meredakan gejala alergi seperti rinitis alergi (bersin-bersin, hidung berair), biduran (urtikaria), dan gatal-gatal pada kulit.',
                'contraindications' => 'Hipersensitivitas terhadap cetirizine atau hydroxyzine, gagal ginjal berat.',
                'warnings' => 'Dapat menyebabkan kantuk; hindari mengemudi atau mengoperasikan mesin setelah mengonsumsinya.',
                'side_effects' => 'Kantuk, kelelahan, mulut kering, sakit kepala, pusing.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Vitamin C 500 mg',
                'indications' => 'Mencegah dan mengobati defisiensi vitamin C, membantu memelihara daya tahan tubuh, serta berperan sebagai antioksidan.',
                'contraindications' => 'Hipersensitivitas terhadap asam askorbat, riwayat batu ginjal (untuk penggunaan dosis tinggi).',
                'warnings' => 'Konsumsi dosis tinggi dalam jangka panjang dapat meningkatkan risiko batu ginjal atau gangguan pencernaan.',
                'side_effects' => 'Gangguan pencernaan ringan (mual, kram perut) pada dosis tinggi.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Omeprazole 20 mg',
                'indications' => 'Mengatasi tukak lambung, tukak duodenum, penyakit refluks asam lambung (GERD), dan sindrom Zollinger-Ellison.',
                'contraindications' => 'Hipersensitivitas terhadap omeprazole atau penghambat pompa proton (PPI) lainnya.',
                'warnings' => 'Penggunaan jangka panjang dapat meningkatkan risiko kekurangan vitamin B12 dan patah tulang; konsultasikan dengan dokter.',
                'side_effects' => 'Sakit kepala, diare, mual, muntah, kembung, nyeri perut.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Ambroxol 30 mg',
                'indications' => 'Meredakan batuk berdahak dengan cara mengencerkan dahak di saluran pernapasan.',
                'contraindications' => 'Hipersensitivitas terhadap ambroxol, ulkus peptikum aktif.',
                'warnings' => 'Hati-hati pada pasien dengan gangguan fungsi hati atau ginjal serta riwayat tukak lambung.',
                'side_effects' => 'Gangguan saluran pencernaan ringan (mual, muntah, nyeri ulu hati), reaksi alergi pada kulit.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Amlodipine 10 mg',
                'indications' => 'Menurunkan tekanan darah pada hipertensi dan mengatasi nyeri dada (angina pectoris).',
                'contraindications' => 'Hipersensitivitas terhadap golongan dihydropyridine, hipotensi berat, syok kardiogenik.',
                'warnings' => 'Hati-hati pada pasien dengan gagal jantung atau gangguan fungsi hati; jangan menghentikan obat secara mendadak tanpa petunjuk dokter.',
                'side_effects' => 'Pembengkakan pada pergelangan kaki (edema), pusing, kelelahan, flushing (wajah memerah), palpitasi.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],
            [
                'medicine_name' => 'Betadine Solution 10%',
                'indications' => 'Antiseptik untuk membersihkan luka, mencegah infeksi pada luka kecil, luka gores, luka bakar ringan, serta sterilisasi kulit sebelum operasi.',
                'contraindications' => 'Hipersensitivitas terhadap iodium, gangguan fungsi tiroid berat, penggunaan pada neonatus prematur.',
                'warnings' => 'Hanya untuk pemakaian luar (topikal); hindari kontak dengan mata dan jangan digunakan dalam jangka panjang pada area kulit yang luas tanpa pengawasan medis.',
                'side_effects' => 'Iritasi kulit lokal, reaksi alergi kemerahan pada individu yang sensitif terhadap iodium.',
                'source_name' => 'MIMS Indonesia / BPOM',
                'source_url' => 'https://www.mims.com/indonesia',
            ],

        ];

        foreach ($verifiedKnowledge as $item) {
            $medicine = Medicine::where(
                'name',
                $item['medicine_name']
            )->firstOrFail();

            MedicineKnowledge::updateOrCreate(
                ['medicine_id' => $medicine->id],
                [
                    'indications' => $item['indications'],
                    'contraindications' => $item['contraindications'],
                    'warnings' => $item['warnings'],
                    'side_effects' => $item['side_effects'],
                    'source_name' => $item['source_name'],
                    'source_url' => $item['source_url'],
                    'status' => 'draft',
                    'reviewed_at' => null,
                ]
            );
        }
    }
}
