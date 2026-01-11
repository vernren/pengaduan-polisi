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

        /* Force scroll to top */
        html {
            scroll-behavior: auto;
        }

        body {
            overflow-x: hidden;
        }

        /* Main wrapper to center content */
        .chat-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 2rem 1rem;
        }

        /* Hero Section - Compact */
        .chat-hero {
            text-align: center;
            margin-bottom: 2rem;
        }

        .chat-hero h1 {
            color: #1f2937;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .chat-hero h1 i {
            color: #eab308;
        }

        .chat-hero p {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Container - Centered */
        .chat-container {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: center;
        }

        .chat-shell {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .chat-shell:hover {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
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
            0%, 100% {
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
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            0%, 60%, 100% {
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

        /* Info Section - Below Chat */
        .chat-info {
            max-width: 900px;
            width: 100%;
            margin: 2rem auto 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border-top: 4px solid #eab308;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
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

        /* ==================== RESPONSIVE DESIGN ==================== */
        
        /* Tablet (768px - 1024px) */
        @media (max-width: 1024px) {
            .chat-wrapper {
                padding: 1.5rem 1rem;
            }

            .chat-container {
                max-width: 100%;
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Mobile Landscape & Portrait (481px - 768px) */
        @media (max-width: 768px) {
            .chat-wrapper {
                padding: 1rem 0.75rem;
                min-height: 100vh;
            }

            /* Hero - Compact for Mobile */
            .chat-hero {
                margin-bottom: 1.5rem;
            }

            .chat-hero h1 {
                font-size: 1.5rem;
                gap: 0.5rem;
            }

            .chat-hero h1 i {
                font-size: 1.5rem;
            }

            .chat-hero p {
                font-size: 0.875rem;
                padding: 0 1rem;
            }

            /* Chat Shell */
            .chat-shell {
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }

            /* Header */
            .chat-header {
                padding: 1rem 1.25rem;
                font-size: 1rem;
                gap: 0.5rem;
            }

            .chat-header i {
                font-size: 1.25rem;
            }

            /* Hide status badge on mobile */
            .status-badge {
                display: none;
            }

            /* Chat Body */
            .chat-body {
                height: 450px;
                padding: 1rem;
            }

            /* Welcome Card */
            .welcome-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .welcome-card h3 {
                font-size: 1rem;
            }

            .welcome-card p {
                font-size: 0.8125rem;
            }

            /* Bubbles */
            .bubble {
                max-width: 85%;
                font-size: 0.875rem;
                padding: 0.75rem 1rem;
                margin-bottom: 0.875rem;
            }

            /* Footer */
            .chat-footer {
                padding: 1rem 1.25rem;
                gap: 0.625rem;
            }

            .chat-footer input {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .chat-footer button {
                width: 44px;
                height: 44px;
                font-size: 1.125rem;
            }

            /* Info Grid */
            .chat-info {
                margin-top: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .info-card {
                padding: 1.25rem;
            }

            .info-card i {
                font-size: 1.75rem;
                margin-bottom: 0.75rem;
            }

            .info-card h4 {
                font-size: 1rem;
            }
        }

        /* Small Mobile (max-width: 480px) */
        @media (max-width: 480px) {
            .chat-wrapper {
                padding: 0.75rem 0.5rem;
            }

            /* Hero - Extra Compact */
            .chat-hero {
                margin-bottom: 1rem;
            }

            .chat-hero h1 {
                font-size: 1.25rem;
                gap: 0.375rem;
                flex-wrap: wrap;
            }

            .chat-hero h1 i {
                font-size: 1.25rem;
            }

            .chat-hero p {
                font-size: 0.8125rem;
                padding: 0 0.5rem;
            }

            /* Chat Shell */
            .chat-shell {
                border-radius: 10px;
            }

            /* Header */
            .chat-header {
                padding: 0.875rem 1rem;
                font-size: 0.9375rem;
            }

            /* Chat Body */
            .chat-body {
                height: 400px;
                padding: 0.875rem;
            }

            /* Welcome Card */
            .welcome-card {
                padding: 0.875rem;
                margin-bottom: 0.875rem;
                border-radius: 10px;
            }

            .welcome-card h3 {
                font-size: 0.9375rem;
                gap: 0.375rem;
            }

            .welcome-card h3 i {
                font-size: 1rem;
            }

            .welcome-card p {
                font-size: 0.8125rem;
            }

            /* Bubbles */
            .bubble {
                max-width: 90%;
                font-size: 0.8125rem;
                padding: 0.625rem 0.875rem;
                margin-bottom: 0.75rem;
                border-radius: 10px;
            }

            /* Typing Indicator */
            .typing {
                font-size: 0.8125rem;
                gap: 0.375rem;
            }

            .typing-dot {
                width: 5px;
                height: 5px;
            }

            /* Footer */
            .chat-footer {
                padding: 0.875rem 1rem;
                gap: 0.5rem;
            }

            .chat-footer input {
                padding: 0.625rem 0.875rem;
                font-size: 0.8125rem;
            }

            .chat-footer button {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            /* Info Section */
            .chat-info {
                margin-top: 1rem;
            }

            .info-grid {
                gap: 0.875rem;
            }

            .info-card {
                padding: 1rem;
                border-radius: 10px;
            }

            .info-card i {
                font-size: 1.5rem;
                margin-bottom: 0.625rem;
            }

            .info-card h4 {
                font-size: 0.9375rem;
            }

            .info-card p {
                font-size: 0.8125rem;
            }
        }

        /* Extra Small Mobile (max-width: 360px) */
        @media (max-width: 360px) {
            .chat-wrapper {
                padding: 0.5rem 0.375rem;
            }

            .chat-hero h1 {
                font-size: 1.125rem;
            }

            .chat-hero p {
                font-size: 0.75rem;
            }

            .chat-body {
                height: 350px;
                padding: 0.75rem;
            }

            .bubble {
                font-size: 0.75rem;
                padding: 0.5rem 0.75rem;
            }

            .chat-footer {
                padding: 0.75rem 0.875rem;
            }

            .chat-footer input {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }

            .chat-footer button {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }
        }

        /* Landscape Orientation for Mobile */
        @media (max-height: 600px) and (orientation: landscape) {
            .chat-wrapper {
                padding: 0.5rem;
            }

            .chat-hero {
                margin-bottom: 0.75rem;
            }

            .chat-hero h1 {
                font-size: 1.125rem;
            }

            .chat-hero p {
                font-size: 0.75rem;
            }

            .chat-body {
                height: 250px;
            }

            .chat-info {
                margin-top: 1rem;
            }

            .info-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Touch Optimizations */
        @media (hover: none) and (pointer: coarse) {
            /* Increase touch targets */
            .chat-footer button {
                min-width: 44px;
                min-height: 44px;
            }

            /* Disable hover effects on touch devices */
            .chat-shell:hover {
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            }

            .info-card:hover {
                transform: none;
            }

            .chat-footer button:hover {
                transform: none;
            }
        }
    </style>

    <div class="chat-wrapper">
        <!-- Hero Section - Compact -->
        <div class="chat-hero">
            <h1><i class="fas fa-robot"></i> Chatbot AI Kepolisian</h1>
            <p>Asisten Virtual untuk Informasi Masyarakat</p>
        </div>

        <!-- Chat Container - Centered -->
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

        <!-- Info Section - Below Chat -->
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

        // Auto focus on input (only on desktop)
        if (window.innerWidth > 768) {
            messageInput.focus();
        }

        // Scroll to top on page load
        window.addEventListener('load', function() {
            window.scrollTo(0, 0);
        });

        // Also scroll to top immediately
        document.addEventListener('DOMContentLoaded', function() {
            window.scrollTo(0, 0);
            document.documentElement.scrollTop = 0;
            document.body.scrollTop = 0;
        });

        // Prevent zoom on input focus (iOS)
        messageInput.addEventListener('touchstart', function() {
            messageInput.style.fontSize = '16px';
        });
    </script>
@endsection