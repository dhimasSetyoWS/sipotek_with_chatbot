<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineBatchSeeder extends Seeder
{
    public function run(): void
    {
        $batches = [
            [
                'registration_number' => 'DBL8914704010A1',
                'batch_number' => 'BATCH-PCT-001',
                'stock_quantity' => 100,
                'expiry_date' => now()->addMonths(12)->toDateString(),
            ],
            [
                'registration_number' => 'DBL8914704010A1',
                'batch_number' => 'BATCH-PCT-002',
                'stock_quantity' => 50,
                'expiry_date' => now()->addMonths(6)->toDateString(),
            ],
            [
                'registration_number' => 'DBL1012503410A1',
                'batch_number' => 'BATCH-TMP-001',
                'stock_quantity' => 30,
                'expiry_date' => now()->addMonths(8)->toDateString(),
            ],
            [
                'registration_number' => 'DTL0521631537A1',
                'batch_number' => 'BATCH-IBU-001',
                'stock_quantity' => 0,
                'expiry_date' => now()->addMonths(10)->toDateString(),
            ],
            [
                'registration_number' => 'DKL9805022601A1',
                'batch_number' => 'BATCH-AMX-001',
                'stock_quantity' => 25,
                'expiry_date' => now()->addMonths(9)->toDateString(),
            ],
            [
                'registration_number' => 'DKL9605401011A1',
                'batch_number' => 'BATCH-CTR-001',
                'stock_quantity' => 40,
                'expiry_date' => now()->addMonths(7)->toDateString(),
            ],
            [
                'registration_number' => 'SD011501531',
                'batch_number' => 'BATCH-VTC-001',
                'stock_quantity' => 60,
                'expiry_date' => now()->addMonths(18)->toDateString(),
            ],
            [
                'registration_number' => 'DKL9505601510A1',
                'batch_number' => 'BATCH-OMP-001',
                'stock_quantity' => 20,
                'expiry_date' => now()->addMonths(11)->toDateString(),
            ],
            [
                'registration_number' => 'DKL0103701212A1',
                'batch_number' => 'BATCH-AMB-001',
                'stock_quantity' => 35,
                'expiry_date' => now()->addMonths(5)->toDateString(),
            ],
            [
                'registration_number' => 'DKL0003001413A1',
                'batch_number' => 'BATCH-AML-001',
                'stock_quantity' => 15,
                'expiry_date' => now()->addMonths(10)->toDateString(),
            ],
            [
                'registration_number' => 'DBL8201600414A1',
                'batch_number' => 'BATCH-BTD-001',
                'stock_quantity' => 20,
                'expiry_date' => now()->addMonths(14)->toDateString(),
            ],
        ];

        foreach ($batches as $batch) {
            $registrationNumber = $batch['registration_number'];
            unset($batch['registration_number']);

            $medicineId = DB::table('medicines')
                ->where('registration_number', $registrationNumber)
                ->value('id');

            if (!$medicineId) {
                throw new \RuntimeException(
                    "Obat dengan nomor registrasi {$registrationNumber} belum tersedia."
                );
            }

            DB::table('medicine_batches')->updateOrInsert(
                [
                    'medicine_id' => $medicineId,
                    'batch_number' => $batch['batch_number'],
                ],
                array_merge($batch, [
                    'medicine_id' => $medicineId,
                    'updated_at' => now(),
                ])
            );
        }
    }
}
