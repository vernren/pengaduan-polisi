@extends('layouts.app')

@section('content')
<style>
:root {
    --brand: #6d6bd3;
    --brand-dark: #4f46e5;
    --bg-dark: #0f172a;
    --panel: #1e293b;
    --bot: #273449;
    --user: #4f46e5;
    --text: #e5e7eb;
    --muted: #9ca3af;
}

/* Container */
.chat-shell {
    max-width: 900px;
    margin: 40px auto;
    background: var(--bg-dark);
    border-radius: 18px;
    box-shadow: 0 20px 50px rgba(0,0,0,.35);
    overflow: hidden;
}

/* Header */
.chat-header {
    background: linear-gradient(135deg, #6d6bd3, #4f46e5);
    color: white;
    padding: 14px 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Body */
.chat-body {
    height: 480px;
    padding: 18px;
    overflow-y: auto;
    background: radial-gradient(circle at top, #111827, #020617);
}

/* Bubble */
.bubble {
    max-width: 75%;
    padding: 12px 16px;
    margin-bottom: 12px;
    border-radius: 14px;
    line-height: 1.6;
    font-size: 14px;
    white-space: pre-wrap;
    color: var(--text);
}

/* Bot */
.bubble-bot {
    background: var(--bot);
    border-top-left-radius: 6px;
}

/* User */
.bubble-user {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    margin-left: auto;
    border-top-right-radius: 6px;
}

/* Typing */
.typing {
    font-style: italic;
    color: var(--muted);
}

/* Footer */
.chat-footer {
    background: #020617;
    padding: 14px;
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Input */
.chat-footer input {
    flex: 1;
    background: #020617;
    color: var(--text);
    border: 1px solid #334155;
    border-radius: 999px;
    padding: 12px 18px;
}

.chat-footer input::placeholder {
    color: var(--muted);
}

/* Send button */
.chat-footer button {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #6d6bd3, #4f46e5);
    color: white;
    font-size: 18px;
}

/* Scrollbar */
.chat-body::-webkit-scrollbar {
    width: 6px;
}
.chat-body::-webkit-scrollbar-thumb {
    background: #334155;
    border-radius: 8px;
}
</style>

<div class="chat-shell">
    <div class="chat-header">
        🤖 Chatbot Kepolisian
    </div>

    <div id="chatBody" class="chat-body">
        <div class="bubble bubble-bot">
            Halo 👋 Saya chatbot kepolisian.<br>
            Silakan ajukan pertanyaan seputar kepolisian dan pengaduan masyarakat.
        </div>
    </div>

    <form id="chatForm" class="chat-footer">
        @csrf
        <input type="text" id="message" placeholder="Ketik pesan..." autocomplete="off">
        <button type="submit">➤</button>
    </form>
</div>

<script>
const chatBody = document.getElementById('chatBody');
const messageInput = document.getElementById('message');
const chatForm = document.getElementById('chatForm');

function scrollBottom() {
    chatBody.scrollTop = chatBody.scrollHeight;
}

chatForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const msg = messageInput.value.trim();
    if (!msg) return;

    chatBody.innerHTML += `
        <div class="bubble bubble-user">${msg}</div>
    `;
    scrollBottom();
    messageInput.value = '';

    const typingId = 'typing-' + Date.now();
    chatBody.innerHTML += `
        <div id="${typingId}" class="bubble bubble-bot typing">
            Bot sedang mengetik...
        </div>
    `;
    scrollBottom();

    fetch("{{ route('chatbot.send') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ message: msg })
    })
    .then(r => r.json())
    .then(d => {
        document.getElementById(typingId).remove();
        chatBody.innerHTML += `
            <div class="bubble bubble-bot">${d.reply}</div>
        `;
        scrollBottom();
    })
    .catch(() => {
        document.getElementById(typingId).remove();
        chatBody.innerHTML += `
            <div class="bubble bubble-bot">
                Terjadi kesalahan. Silakan coba lagi.
            </div>
        `;
        scrollBottom();
    });
});

// Enter to send
messageInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        chatForm.dispatchEvent(new Event('submit'));
    }
});
</script>
@endsection
