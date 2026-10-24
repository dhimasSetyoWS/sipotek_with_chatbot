<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Services\AiService;
use App\Models\MedicineKnowledge;
use RuntimeException;

class ChatbotController extends Controller
{
    private function findKnowledgeBySymptoms(array $symptoms)
    {
        $today = now()->toDateString();

        $query = MedicineKnowledge::query()
            ->where('status', 'reviewed')
            ->whereHas('medicine', function ($query) {
                $query->where('is_active', true);
            });

        $query->where(function ($outerQuery) use ($symptoms) {
            foreach ($symptoms as $symptom) {
                $outerQuery->orWhere(
                    'indications',
                    'like',
                    '%' . $symptom . '%'
                );
            }
        });

        $knowledge = $query
            ->with([
                'medicine' => function ($query) use ($today) {
                    $query->withSum([
                        'batches as available_stock' => function ($batchQuery) use ($today) {
                            $batchQuery
                                ->whereDate('expiry_date', '>=', $today)
                                ->where('stock_quantity', '>', 0);
                        },
                    ], 'stock_quantity');
                },
            ])
            ->limit(10)
            ->get();

        return $knowledge->map(function ($item) {
            return [
                'medicine' => [
                    'id' => $item->medicine->id,
                    'name' => $item->medicine->name,
                    'strength' => $item->medicine->strength,
                    'dosage_form' => $item->medicine->dosage_form,
                    'available_stock' =>
                    $item->medicine->available_stock ?? 0,
                ],
                'indications' => $item->indications,
                'warnings' => $item->warnings,
                'source_name' => $item->source_name,
                'source_url' => $item->source_url,
            ];
        })->values();
    }


    public function searchMedicines(Request $request)
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $today = now()->toDateString();

        $medicines = Medicine::query()
            ->where('is_active', true)
            ->whereHas('knowledge', function ($query) {
                $query->where('status', 'reviewed');
            })
            ->with([
                'category:id,name',
                'knowledge' => function ($query) {
                    $query->where('status', 'reviewed');
                },
            ])
            ->limit(10)
            ->get([
                'id',
                'category_id',
                'name',
                'brand',
                'active_ingredients',
                'strength',
                'dosage_form',
                'classification',
            ]);
        return response()->json([
            'data' => $medicines,
        ]);
    }

    public function retrieveKnowledge(Request $request)
    {
        $validated = $request->validate([
            'symptoms' => ['required', 'array', 'min:1', 'max:10'],
            'symptoms.*' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        return response()->json([
            'data' => $this->findKnowledgeBySymptoms(
                $validated['symptoms']
            ),
        ]);
    }

    public function analyzeMessage(
        Request $request,
        AiService $aiService
    ) {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        try {
            $analysis = $aiService->analyze($validated['message']);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 503);
        }

        return response()->json([
            'message' => 'Analisis berhasil.',
            'analysis' => $analysis,
        ]);
    }

    public function chat(Request $request, AiService $AiService)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        $message = trim($validated['message']);

        if ($message === '') {
            return response()->json([
                'success' => false,
                'status' => 'invalid_message',
                'message' => 'Silakan masukkan pesan terlebih dahulu.',
                'data' => [],
            ], 422);
        }

        try {
            $analysis = $AiService->analyze($message);
        } catch (RuntimeException $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'status' => 'ai_unavailable',
                'message' => 'Layanan chatbot sedang mengalami gangguan. Silakan coba kembali.',
                'data' => [],
            ], 503);
        }

        // Pastikan respons FastAPI memiliki struktur yang diperlukan.
        if (
            !is_array($analysis) ||
            !isset($analysis['intent']) ||
            !isset($analysis['safety']['allow_retrieval']) ||
            !is_bool($analysis['safety']['allow_retrieval'])
        ) {
            return response()->json([
                'success' => false,
                'status' => 'invalid_ai_response',
                'message' => 'Analisis pesan belum dapat diproses. Silakan coba kembali.',
                'data' => [],
            ], 502);
        }

        $intent = $analysis['intent'];
        $safety = $analysis['safety'];

        // Safety check harus dijalankan sebelum retrieval.
        if ($safety['allow_retrieval'] === false) {
            return response()->json([
                'success' => true,
                'status' => 'urgent',
                'message' => $safety['message']
                    ?? 'Keluhan Anda perlu mendapat perhatian medis. Silakan cari pertolongan medis.',
                'intent' => $intent,
                'analysis' => $analysis,
                'data' => [],
            ]);
        }

        // Belum cukup informasi atau tidak ada intent yang dikenali.
        if (
            ($analysis['needs_clarification'] ?? true) ||
            $intent === 'unknown'
        ) {
            return response()->json([
                'success' => true,
                'status' => 'needs_clarification',
                'message' => 'Bisa ceritakan keluhan yang Anda rasakan dengan lebih jelas, termasuk sejak kapan keluhan muncul?',
                'intent' => $intent,
                'analysis' => $analysis,
                'data' => [],
            ]);
        }

        // Retrieval hanya dilakukan untuk intent gejala.
        if ($intent === 'symptom_inquiry') {
            $symptoms = $analysis['symptoms'] ?? [];

            if (
                !is_array($symptoms) ||
                count($symptoms) === 0
            ) {
                return response()->json([
                    'success' => true,
                    'status' => 'needs_clarification',
                    'message' => 'Saya belum dapat mengenali gejala Anda. Bisa jelaskan keluhan dengan kata-kata lain?',
                    'intent' => $intent,
                    'analysis' => $analysis,
                    'data' => [],
                ]);
            }

            $data = $this->findKnowledgeBySymptoms($symptoms);
            return response()->json([
                'success' => true,
                'status' => empty($data)
                    ? 'no_matching_knowledge'
                    : 'knowledge_found',
                'message' => empty($data)
                    ? 'Belum ditemukan informasi obat terverifikasi yang cocok dengan kata kunci keluhan Anda. Silakan konsultasikan dengan apoteker atau tenaga medis.'
                    : 'Berikut informasi obat terverifikasi yang ditemukan berdasarkan kecocokan kata pada keluhan Anda. Hasil ini bukan diagnosis atau rekomendasi pengobatan otomatis.',
                'intent' => $intent,
                'analysis' => $analysis,
                'data' => $data,
            ]);
        }

        // Intent lain belum dihubungkan ke fitur masing-masing.
        return response()->json([
            'success' => true,
            'status' => 'intent_not_supported',
            'message' => 'Saya belum mendukung jenis pertanyaan tersebut. Anda dapat menjelaskan keluhan yang sedang dirasakan.',
            'intent' => $intent,
            'analysis' => $analysis,
            'data' => [],
        ]);
    }
}
