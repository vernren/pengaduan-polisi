<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PoliceTopicGuard;
use App\Services\PoliceGeminiService;
use App\Models\ChatHistory;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function send(Request $request, PoliceGeminiService $ai)
{
    $request->validate([
        'message' => 'required|string|max:300'
    ]);

    $message = trim($request->message);

    // Guard topik (lebih longgar)
    if (!\App\Services\PoliceTopicGuard::isAllowed($message)) {
        return response()->json([
            'reply' => 'Maaf, saya hanya dapat membantu informasi seputar layanan kepolisian, hukum dasar, dan pengaduan masyarakat.'
        ]);
    }

    // Ambil 3 chat terakhir (konteks)
    $history = \App\Models\ChatHistory::latest()
        ->take(3)
        ->get()
        ->reverse();

    $context = '';
    foreach ($history as $chat) {
        $context .= "User: {$chat->user_message}\n";
        $context .= "Bot: {$chat->bot_reply}\n";
    }

    $reply = $ai->reply($message, $context);

    \App\Models\ChatHistory::create([
    'user_message' => $message,
    'bot_reply' => $reply,
    'user_id' => auth()->id(),
    'session_id' => session()->getId(),
    ]);

    return response()->json(['reply' => $reply]);
    }
}
