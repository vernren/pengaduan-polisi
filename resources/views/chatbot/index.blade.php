<!-- resources/views/chatbot/index.blade.php -->
@extends('layouts.app')

@section('title', 'Chatbot - Pengaduan Polisi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="gradient-bg text-white p-6">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-robot mr-3 text-3xl"></i>
                Asisten Virtual Polisi
            </h2>
            <p class="text-sm mt-2 opacity-90">Tanyakan apa saja seputar pengaduan dan layanan kepolisian</p>
        </div>

        <!-- Chat Container -->
        <div id="chatContainer" class="h-96 overflow-y-auto p-6 bg-gray-50 space-y-4">
            <!-- Welcome Message -->
            <div class="flex items-start space-x-3 chat-bubble">
                <div class="bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bg-white rounded-lg shadow p-4 max-w-md">
                    <p class="text-gray-800">
                        Halo! 👋 Saya asisten virtual kepolisian. Saya siap membantu menjawab pertanyaan Anda seputar:
                    </p>
                    <ul class="mt-2 text-sm text-gray-700 space-y-1">
                        <li>✓ Cara membuat laporan pengaduan</li>
                        <li>✓ Status pengaduan Anda</li>
                        <li>✓ Dokumen yang diperlukan</li>
                        <li>✓ Kontak darurat</li>
                    </ul>
                    <p class="text-gray-800 mt-3">Silakan ajukan pertanyaan Anda!</p>
                </div>
            </div>
        </div>

        <!-- Suggestion Chips -->
        <div id="suggestions" class="px-6 py-3 bg-gray-100 flex flex-wrap gap-2">
            <button onclick="sendSuggestion('Bagaimana cara membuat laporan?')" 
                class="bg-white px-4 py-2 rounded-full text-sm text-purple-600 hover:bg-purple-50 transition shadow-sm">
                Cara membuat laporan
            </button>
            <button onclick="sendSuggestion('Berapa lama proses pengaduan?')" 
                class="bg-white px-4 py-2 rounded-full text-sm text-purple-600 hover:bg-purple-50 transition shadow-sm">
                Lama proses
            </button>
            <button onclick="sendSuggestion('Dokumen apa yang diperlukan?')" 
                class="bg-white px-4 py-2 rounded-full text-sm text-purple-600 hover:bg-purple-50 transition shadow-sm">
                Dokumen persyaratan
            </button>
        </div>

        <!-- Input Area -->
        <div class="p-6 bg-white border-t">
            <form id="chatForm" class="flex space-x-3">
                <input type="text" id="messageInput" 
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                    placeholder="Ketik pertanyaan Anda..." required>
                <button type="submit" 
                    class="gradient-bg text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 grid md:grid-cols-2 gap-4">
        <a href="{{ route('pengaduan.create') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition flex items-center space-x-4">
            <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center">
                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Buat Laporan</h4>
                <p class="text-sm text-gray-600">Laporkan kejadian sekarang</p>
            </div>
        </a>
        <a href="tel:110" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition flex items-center space-x-4">
            <div class="bg-red-100 w-12 h-12 rounded-full flex items-center justify-center">
                <i class="fas fa-phone text-red-600 text-xl"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Panggilan Darurat</h4>
                <p class="text-sm text-gray-600">Hubungi 110</p>
            </div>
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const chatContainer = document.getElementById('chatContainer');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        // Add user message
        addMessage(message, 'user');
        messageInput.value = '';

        // Show typing indicator
        const typingId = showTypingIndicator();

        try {
            const response = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            
            // Remove typing indicator
            removeTypingIndicator(typingId);

            // Add bot response
            addMessage(data.message, 'bot');

        } catch (error) {
            removeTypingIndicator(typingId);
            addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
        }
    });

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex items-start space-x-3 chat-bubble';
        
        if (sender === 'user') {
            messageDiv.className += ' flex-row-reverse space-x-reverse';
            messageDiv.innerHTML = `
                <div class="bg-gray-600 text-white w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user"></i>
                </div>
                <div class="gradient-bg text-white rounded-lg shadow p-4 max-w-md">
                    <p>${escapeHtml(text)}</p>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bg-white rounded-lg shadow p-4 max-w-md">
                    <p class="text-gray-800">${escapeHtml(text)}</p>
                </div>
            `;
        }

        chatContainer.appendChild(messageDiv);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-' + Date.now();
        typingDiv.className = 'flex items-start space-x-3 chat-bubble';
        typingDiv.innerHTML = `
            <div class="bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-robot"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex space-x-2">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        `;
        chatContainer.appendChild(typingDiv);
        chatContainer.scrollTop = chatContainer.scrollHeight;
        return typingDiv.id;
    }

    function removeTypingIndicator(id) {
        const typingDiv = document.getElementById(id);
        if (typingDiv) typingDiv.remove();
    }

    function sendSuggestion(text) {
        messageInput.value = text;
        chatForm.dispatchEvent(new Event('submit'));
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endsection