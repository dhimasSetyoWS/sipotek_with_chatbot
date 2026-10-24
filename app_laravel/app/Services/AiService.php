<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use RuntimeException;

class AiService
{
    public function analyze(string $message): array
    {
        $url = rtrim(config('services.ai.url'), '/') . '/analyze';

        try {
            $response = Http::connectTimeout(3)
                ->timeout(10)
                ->post($url, [
                    'message' => $message,
                ]);
        } catch (ConnectionException $exception) {
            report($exception);

            throw new RuntimeException(
                'Layanan AI sedang tidak dapat dihubungi.'
            );
        }

        if ($response->failed()) {
            throw new RuntimeException(
                'Layanan AI gagal memproses pesan.'
            );
        }

        return $response->json();
    }
}