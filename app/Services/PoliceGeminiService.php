<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PoliceGeminiService
{
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {

        $this->apiKey = config('services.gemini.key');

        // ✅ MODEL YANG AKTIF & GRATIS
        $this->endpoint =
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
    }

    public function reply(string $message, string $context = ''): string
    {
        if (!$this->apiKey) {
            return 'Layanan AI belum dikonfigurasi.';
        }

        /* =========================
         * MODE EMPATI (No.3)
         * ========================= */
        $empathyWords = [
            'takut', 'panik', 'trauma',
            'bingung', 'khawatir', 'kehilangan'
        ];

        $isEmpathy = false;
        foreach ($empathyWords as $word) {
            if (str_contains(mb_strtolower($message), $word)) {
                $isEmpathy = true;
                break;
            }
        }

        $tone = $isEmpathy
            ? 'Gunakan nada empatik, menenangkan, dan suportif. Dahulukan menenangkan pengguna.'
            : 'Gunakan nada ramah, natural, dan profesional.';

        /* =========================
         * PROMPT FINAL (1,3,4,10)
         * ========================= */
        $prompt =
            "Anda adalah asisten virtual layanan informasi kepolisian Indonesia.\n\n" .

            "PRINSIP UTAMA:\n" .
            "- Jawab SINGKAT dan JELAS terlebih dahulu.\n" .
            "- Tambahkan detail HANYA jika pengguna memintanya.\n" .
            "- Gunakan bahasa Indonesia yang sopan, natural, dan profesional.\n\n" .

            "MODE EMPATI:\n" .
            "{$tone}\n\n" .

            "KONTEKS PERCAKAPAN:\n" .
            "- Gunakan konteks sebelumnya jika tersedia.\n" .
            "- Pahami pertanyaan lanjutan seperti 'jawab singkat', 'terus bagaimana', atau 'lanjutkan'.\n" .
            "- Jangan mengulang dari awal jika konteks sudah jelas.\n\n" .

            "MODE EDUKASI:\n" .
            "- Jika pertanyaan 'apa itu' atau 'kenapa', berikan:\n" .
            "  1. Definisi singkat\n" .
            "  2. Contoh sederhana\n" .
            "  3. Imbauan umum (tanpa menghakimi)\n\n" .

            "BATASAN:\n" .
            "- Jangan memberi opini pribadi.\n" .
            "- Jangan menentukan benar/salah kasus.\n" .
            "- Jangan memberi saran ilegal.\n\n" .

            "KONTEKS SEBELUMNYA:\n{$context}\n\n" .
            "PERTANYAAN PENGGUNA:\n{$message}\n\n" .
            "Akhiri jawaban dengan kalimat opsional:\n" .
            "'Jika ingin penjelasan lebih detail, silakan beri tahu.'";

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($this->endpoint . '?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

            if ($response->failed()) {
                return 'Maaf, layanan AI sedang tidak tersedia.';
            }

            return $response->json('candidates.0.content.parts.0.text')
                ?? 'Maaf, saya belum dapat menjawab pertanyaan tersebut.';

        } catch (\Throwable $e) {
            return 'Maaf, layanan AI sedang bermasalah.';
        }
    }
}
