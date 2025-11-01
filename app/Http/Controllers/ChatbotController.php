<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function sendMessage(Request $request)
    {
        $pertanyaan = $request->input('message');
        $sessionId = $request->session()->get('chat_session_id', Str::uuid());
        $request->session()->put('chat_session_id', $sessionId);

        $faqs = Faq::search($pertanyaan);
        
        if ($faqs->isEmpty()) {
            $jawaban = "Maaf, saya tidak menemukan jawaban yang sesuai. Silakan hubungi petugas melalui menu pengaduan atau hubungi nomor darurat 110 untuk situasi mendesak.";
            $faqId = null;
        } else {
            $faq = $faqs->first();
            $jawaban = $faq->jawaban;
            $faqId = $faq->id;
            $faq->increment('view_count');
        }

        ChatHistory::create([
            'user_id' => auth()->id(),
            'session_id' => $sessionId,
            'pertanyaan' => $pertanyaan,
            'jawaban' => $jawaban,
            'faq_id' => $faqId,
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $jawaban,
            'suggestions' => $this->getSuggestions($pertanyaan)
        ]);
    }

    private function getSuggestions($query)
    {
        $suggestions = [
            'Bagaimana cara membuat laporan?',
            'Berapa lama proses pengaduan?',
            'Dokumen apa yang diperlukan?',
        ];

        return array_slice($suggestions, 0, 3);
    }
}
