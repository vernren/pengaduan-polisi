<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function index()
    {
        // Ambil suggestions awal (limit 48 untuk cadangan; view akan tampil sebagian)
        $suggestions = Faq::where('is_active', true)
            ->orderBy('view_count', 'desc')
            ->take(48)
            ->get(['id', 'pertanyaan', 'kategori']);

        // Ambil kategori unik
        $categories = Faq::where('is_active', true)
            ->select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->values()
            ->toArray();

        return view('chatbot.index', compact('suggestions', 'categories'));
    }

    /**
     * Menerima faq_id (klik suggestion) atau message (teks — optional)
     * Mengembalikan: { success, message, faq_id, suggestions: [ {id,pertanyaan,kategori}, ... ] }
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'faq_id' => 'nullable|integer|exists:faq,id',
        ]);

        $faqId = $request->input('faq_id');
        $message = trim($request->input('message') ?? '');
        $sessionId = $request->session()->get('chat_session_id', Str::uuid());
        $request->session()->put('chat_session_id', $sessionId);

        $jawaban = null;
        $usedFaqId = null;

        // Prioritas: faq_id (klik suggestion)
        if ($faqId) {
            $faq = Faq::find($faqId);
            if ($faq && $faq->is_active) {
                $jawaban = $faq->jawaban;
                $message = $faq->pertanyaan;
                $usedFaqId = $faq->id;
                try { $faq->increment('view_count'); } catch (\Throwable $e) { /* ignore */ }
            }
        }

        // fallback: cari berdasarkan teks message
        if (!$jawaban && $message) {
            $faqs = Faq::search($message);
            if ($faqs->isNotEmpty()) {
                $faq = $faqs->first();
                $jawaban = $faq->jawaban;
                $usedFaqId = $faq->id;
                try { $faq->increment('view_count'); } catch (\Throwable $e) { /* ignore */ }
            }
        }

        // fallback default jika masih tidak ada jawaban
        if (!$jawaban) {
            $jawaban = "Maaf, saya belum punya jawaban otomatis untuk itu. Silakan pilih suggestion lain atau buat laporan. Untuk situasi darurat hubungi 110.";
        }

        // Simpan chat history (toleransi error)
        try {
            ChatHistory::create([
                'user_id' => auth()->id(), // boleh null
                'session_id' => $sessionId,
                'pertanyaan' => $message,
                'jawaban' => $jawaban,
                'faq_id' => $usedFaqId,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal simpan ChatHistory: '.$e->getMessage());
        }

        // Selalu kirim suggestions: related jika ada, atau fallback ke top FAQs
        $suggestions = $this->getSuggestionsArray($message, 12);

        return response()->json([
            'success' => true,
            'message' => $jawaban,
            'faq_id' => $usedFaqId,
            'suggestions' => $suggestions,
        ]);
    }

    /**
     * Mengembalikan array suggestions sebagai associative array
     * - selalu return array (bisa kosong jika tidak ada FAQ sama sekali)
     */
    private function getSuggestionsArray($query = null, $limit = 6)
    {
        if ($query) {
            $related = Faq::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('pertanyaan', 'like', "%{$query}%")
                      ->orWhere('keywords', 'like', "%{$query}%")
                      ->orWhere('jawaban', 'like', "%{$query}%");
                })
                ->orderBy('view_count', 'desc')
                ->take($limit)
                ->get(['id','pertanyaan','kategori']);

            if ($related->isNotEmpty()) {
                return $related->map(function($r){
                    return [
                        'id' => $r->id,
                        'pertanyaan' => $r->pertanyaan,
                        'kategori' => $r->kategori ?? ''
                    ];
                })->toArray();
            }
        }

        // fallback: top FAQs
        $general = Faq::where('is_active', true)
            ->orderBy('view_count', 'desc')
            ->take($limit)
            ->get(['id','pertanyaan','kategori']);

        return $general->map(function($r){
            return [
                'id' => $r->id,
                'pertanyaan' => $r->pertanyaan,
                'kategori' => $r->kategori ?? ''
            ];
        })->toArray();
    }
}
