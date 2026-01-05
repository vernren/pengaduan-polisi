@extends('layouts.app')

@section('title', 'Chatbot AI Kepolisian')

@section('content')
    <style>
        :root {
            --primary-yellow: #eab308;
            --primary-yellow-dark: #ca8a04;
            --gray-dark: #1f2937;
            --gray-darker: #111827;
            --gray-light: #f3f4f6;
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        /* Hero Section */
        .chat-hero {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            padding: 3rem 1rem;
            margin: -2.5rem -1rem 0;
        }

        .chat-hero h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .chat-hero p {
            color: #d1d5db;
            font-size: 1.125rem;
            margin-bottom: 0;
        }

        /* Container */
        .chat-container {
            max-width: 900px;
            margin: -2rem auto 3rem;
            padding: 0 1rem;
        }

        .chat-shell {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        /* Header */
        .chat-header {
            background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
            color: #1f2937;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 3px solid #ca8a04;
        }

        .chat-header i {
            font-size: 1.5rem;
        }

        /* Status Badge */
        .status-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.3);
            padding: 0.375rem 0.875rem;
            border-radius: 999px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Body */
        .chat-body {
            height: 500px;
            padding: 1.5rem;
            overflow-y: auto;
            background: #f9fafb;
        }

        /* Welcome Card */
        .welcome-card {
            background: white;
            border: 2px solid #eab308;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(234, 179, 8, 0.1);
        }

        .welcome-card h3 {
            color: #1f2937;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .welcome-card p {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Bubble */
        .bubble {
            max-width: 75%;
            padding: 0.875rem 1.125rem;
            margin-bottom: 1rem;
            border-radius: 12px;
            line-height: 1.6;
            font-size: 0.9375rem;
            white-space: pre-wrap;
            word-wrap: break-word;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        /* Bot */
        .bubble-bot {
            background: white;
            color: #1f2937;
            border: 1px solid #e5e7eb;
            border-top-left-radius: 4px;
            margin-right: auto;
        }

        /* User */
        .bubble-user {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: white;
            margin-left: auto;
            border-top-right-radius: 4px;
        }

        /* Typing */
        .typing {
            font-style: italic;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .typing-dots {
            display: flex;
            gap: 4px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            background: #6b7280;
            border-radius: 50%;
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-8px);
            }
        }

        /* Footer */
        .chat-footer {
            background: #f9fafb;
            padding: 1.25rem 1.5rem;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            border-top: 1px solid #e5e7eb;
        }

        /* Input */
        .chat-footer input {
            flex: 1;
            background: white;
            color: #1f2937;
            border: 2px solid #e5e7eb;
            border-radius: 999px;
            padding: 0.875rem 1.25rem;
            font-size: 0.9375rem;
            transition: all 0.2s;
        }

        .chat-footer input:focus {
            outline: none;
            border-color: #eab308;
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.1);
        }

        .chat-footer input::placeholder {
            color: #9ca3af;
        }

        /* Send button */
        .chat-footer button {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.3);
        }

        .chat-footer button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(234, 179, 8, 0.4);
        }

        .chat-footer button:active {
            transform: scale(0.95);
        }

        .chat-footer button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* Scrollbar */
        .chat-body::-webkit-scrollbar {
            width: 8px;
        }

        .chat-body::-webkit-scrollbar-track {
            background: #f3f4f6;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .chat-body::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Info Section */
        .chat-info {
            max-width: 900px;
            margin: 0 auto 3rem;
            padding: 0 1rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border-top: 4px solid #eab308;
        }

        .info-card i {
            color: #eab308;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .info-card h4 {
            color: #1f2937;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-card p {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-hero h1 {
                font-size: 1.875rem;
            }

            .chat-body {
                height: 400px;
            }

            .bubble {
                max-width: 85%;
                font-size: 0.875rem;
            }

            .status-badge {
                display: none;
            }
        }
    </style>

    <!-- Hero Section -->
    <div class="chat-hero">
        <div class="container mx-auto max-w-6xl text-center">
            <h1><i class="fas fa-robot"></i> Chatbot AI Kepolisian</h1>
            <p>Asisten Virtual untuk Informasi Masyarakat</p>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="chat-container">
        <div class="chat-shell">
            <div class="chat-header">
                <i class="fas fa-comments"></i>
                Chat dengan AI
                <div class="status-badge">
                    <span class="status-dot"></span>
                    Online
                </div>
            </div>

            <div id="chatBody" class="chat-body">
                <div class="welcome-card">
                    <h3><i class="fas fa-hand-wave"></i> Selamat Datang!</h3>
                    <p>Saya adalah asisten virtual kepolisian yang siap membantu Anda dengan informasi seputar layanan
                        kepolisian dan pertanyaan umum lainnya.</p>
                </div>

                <div class="bubble bubble-bot">
                    Halo! 👋 Saya chatbot kepolisian siap membantu Anda.<br><br>
                    Silakan ajukan pertanyaan Anda!
                </div>
            </div>

            <form id="chatForm" class="chat-footer">
                @csrf
                <input type="text" id="message" placeholder="Ketik pertanyaan Anda di sini..." autocomplete="off"
                    required>
                <button type="submit" id="sendBtn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Info Section -->
    <div class="chat-info">
        <div class="info-grid">
            <div class="info-card">
                <i class="fas fa-clock"></i>
                <h4>Respon Cepat</h4>
                <p>Dapatkan jawaban instan untuk pertanyaan umum seputar layanan kepolisian</p>
            </div>
            <div class="info-card">
                <i class="fas fa-shield-alt"></i>
                <h4>Informasi Terpercaya</h4>
                <p>Informasi akurat berdasarkan prosedur resmi kepolisian</p>
            </div>
            <div class="info-card">
                <i class="fas fa-headset"></i>
                <h4>24/7 Tersedia</h4>
                <p>Layanan chatbot siap membantu Anda kapan saja</p>
            </div>
        </div>
    </div>

    <script>
        const chatBody = document.getElementById('chatBody');
        const messageInput = document.getElementById('message');
        const chatForm = document.getElementById('chatForm');
        const sendBtn = document.getElementById('sendBtn');

        function scrollBottom() {
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const msg = messageInput.value.trim();
            if (!msg) return;

            // Disable input and button
            messageInput.disabled = true;
            sendBtn.disabled = true;

            // Add user message
            chatBody.innerHTML += `
        <div class="bubble bubble-user">${escapeHtml(msg)}</div>
    `;
            scrollBottom();
            messageInput.value = '';

            // Add typing indicator
            const typingId = 'typing-' + Date.now();
            chatBody.innerHTML += `
        <div id="${typingId}" class="bubble bubble-bot typing">
            <i class="fas fa-robot"></i>
            <span>Sedang mengetik</span>
            <div class="typing-dots">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </div>
        </div>
    `;
            scrollBottom();

            // Send message
            fetch("{{ route('chatbot.send') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        message: msg
                    })
                })
                .then(r => r.json())
                .then(d => {
                    document.getElementById(typingId).remove();
                    chatBody.innerHTML += `
            <div class="bubble bubble-bot">${escapeHtml(d.reply)}</div>
        `;
                    scrollBottom();
                })
                .catch(() => {
                    document.getElementById(typingId).remove();
                    chatBody.innerHTML += `
            <div class="bubble bubble-bot">
                <i class="fas fa-exclamation-circle"></i> Maaf, terjadi kesalahan. Silakan coba lagi.
            </div>
        `;
                    scrollBottom();
                })
                .finally(() => {
                    // Re-enable input and button
                    messageInput.disabled = false;
                    sendBtn.disabled = false;
                    messageInput.focus();
                });
        });

        // Enter to send
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });

        // Auto focus on input
        messageInput.focus();
    </script>
@endsection
