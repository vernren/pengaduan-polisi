@extends('layouts.app')

@section('title', 'Chatbot - Pengaduan Polisi')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mt-6">
        <!-- Header -->
        <div class="gradient-bg text-white p-6">
            <h2 class="text-2xl font-bold flex items-center">
                <i class="fas fa-robot mr-3 text-3xl"></i>
                Asisten Virtual Pengaduan
            </h2>
            <p class="text-sm mt-2 opacity-90">Pilih pertanyaan dari suggestion yang sesuai dengan masalah Anda. Untuk darurat, hubungi <strong>110</strong>.</p>
        </div>

        <!-- Chat area -->
        <div class="p-6 bg-gray-50">
            <div id="chatContainer" class="min-h-[320px] max-h-[420px] overflow-y-auto space-y-4" aria-live="polite">
                <!-- Welcome -->
                <div class="flex items-start space-x-3 chat-bubble">
                    <div class="bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 max-w-3xl">
                        <p class="text-gray-800">
                            Halo! 👋 Saya Asisten Virtual Pengaduan. Pilih salah satu suggestion di bawah yang paling sesuai — cukup ketuk tombolnya, saya akan menjawab.
                        </p>
                        <ul class="mt-2 text-sm text-gray-600 list-disc pl-5">
                            <li>Cara membuat laporan</li>
                            <li>Status pengaduan</li>
                            <li>Dokumen yang diperlukan</li>
                            <li>Kontak darurat</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Category chips -->
            <div class="mt-4">
                <div id="categories" class="flex flex-wrap gap-2">
                    <button class="category-chip px-3 py-1 rounded-full bg-white text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 active"
                            data-category="__all__">Semua</button>

                    @foreach($categories ?? [] as $cat)
                        <button class="category-chip px-3 py-1 rounded-full bg-white text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300"
                                data-category="{{ $cat }}">
                            {{ \Illuminate\Support\Str::title(str_replace(['_','-'], ' ', $cat)) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Suggestions grid -->
            <div class="mt-4">
                <div id="suggestions" class="grid gap-3" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));">
                    @foreach($suggestions as $s)
                        <button
                            type="button"
                            class="suggestion-btn text-sm px-4 py-2 rounded-full text-purple-700 bg-white shadow-sm hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-300 truncate"
                            data-id="{{ $s->id }}"
                            data-question="{{ $s->pertanyaan }}"
                            data-category="{{ $s->kategori ?? '' }}"
                            title="{{ $s->pertanyaan }}"
                            aria-label="Pertanyaan: {{ $s->pertanyaan }}"
                        >
                            {{ \Illuminate\Support\Str::limit($s->pertanyaan, 60) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- NOTE: input intentionally hidden so user only uses suggestions -->
            <div class="mt-4">
                <div class="text-xs text-gray-500">Interaksi dibatasi ke tombol suggestion untuk memastikan pengalaman cepat dan terstruktur.</div>
            </div>
        </div>

        <!-- ACTIONS (Buat Laporan & Hubungi 110) - pinned at bottom -->
        <div class="border-t bg-white p-6">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row gap-4">
                <a href="{{ route('pengaduan.create') }}" class="flex-1 bg-white rounded-lg shadow p-4 hover:shadow-lg transition flex items-center gap-4">
                    <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Buat Laporan</h4>
                        <p class="text-sm text-gray-600">Laporkan kejadian sekarang</p>
                    </div>
                </a>

                <a href="tel:110" class="flex-1 bg-white rounded-lg shadow p-4 hover:shadow-lg transition flex items-center gap-4">
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
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    const chatContainer = document.getElementById('chatContainer');
    const suggestionsWrap = document.getElementById('suggestions');
    const categoriesWrap = document.getElementById('categories');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let busy = false;
    let activeCategory = '__all__';

    // Save initial suggestions from DOM into JS array so we can always restore them
    let initialSuggestions = []; // array of {id, pertanyaan, kategori}
    function initSuggestionsFromDOM() {
        initialSuggestions = [];
        suggestionsWrap.querySelectorAll('.suggestion-btn').forEach(btn => {
            initialSuggestions.push({
                id: btn.dataset.id || null,
                pertanyaan: btn.dataset.question || btn.textContent.trim(),
                kategori: btn.dataset.category || ''
            });
        });
    }

    // Utility to escape text
    function escapeHtml(text) {
        const d = document.createElement('div');
        d.textContent = text;
        return d.innerHTML;
    }

    // Render suggestions array into DOM (replace contents)
    function renderSuggestions(items) {
        suggestionsWrap.innerHTML = '';
        if (!Array.isArray(items)) items = [];
        items.forEach(it => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'suggestion-btn text-sm px-4 py-2 rounded-full text-purple-700 bg-white shadow-sm hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-300 truncate';
            if (it.id !== null && it.id !== undefined) btn.dataset.id = it.id;
            btn.dataset.question = it.pertanyaan;
            btn.dataset.category = it.kategori || '';
            btn.title = it.pertanyaan;
            btn.setAttribute('aria-label', 'Pertanyaan: ' + it.pertanyaan);
            btn.innerText = it.pertanyaan.length > 60 ? it.pertanyaan.slice(0,57) + '...' : it.pertanyaan;
            suggestionsWrap.appendChild(btn);
        });
    }

    // Add chat bubble
    function addMessage(text, sender = 'bot') {
        const wrap = document.createElement('div');
        wrap.className = 'flex items-start space-x-3 chat-bubble';
        if (sender === 'user') {
            wrap.className += ' flex-row-reverse space-x-reverse';
            wrap.innerHTML = `
                <div class="bg-gray-600 text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fas fa-user"></i>
                </div>
                <div class="gradient-bg text-white rounded-lg shadow p-3 max-w-full">
                    <p>${escapeHtml(text)}</p>
                </div>
            `;
        } else {
            wrap.innerHTML = `
                <div class="bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bg-white rounded-lg shadow p-3 max-w-full">
                    <p class="text-gray-800">${escapeHtml(text)}</p>
                </div>
            `;
        }
        chatContainer.appendChild(wrap);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Typing indicator helpers
    function showTyping() {
        const id = 'typing-' + Date.now();
        const el = document.createElement('div');
        el.id = id;
        el.className = 'flex items-start space-x-3 chat-bubble';
        el.innerHTML = `
            <div class="bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center">
                <i class="fas fa-robot"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-3">
                <div class="flex space-x-2">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:0.12s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:0.24s"></div>
                </div>
            </div>
        `;
        chatContainer.appendChild(el);
        chatContainer.scrollTop = chatContainer.scrollHeight;
        return id;
    }
    function removeTyping(id) { const el = document.getElementById(id); if (el) el.remove(); }

    // set busy
    function setBusy(state) {
        busy = state;
        suggestionsWrap.querySelectorAll('.suggestion-btn').forEach(b => {
            if (state) { b.setAttribute('disabled','disabled'); b.classList.add('opacity-60','cursor-not-allowed'); }
            else { b.removeAttribute('disabled'); b.classList.remove('opacity-60','cursor-not-allowed'); }
        });
        categoriesWrap.querySelectorAll('.category-chip').forEach(c => {
            if (state) c.setAttribute('disabled','disabled'); else c.removeAttribute('disabled');
        });
    }

    // filter suggestions client-side
    function filterSuggestions(category) {
        activeCategory = category;
        suggestionsWrap.querySelectorAll('.suggestion-btn').forEach(btn => {
            const cat = (btn.dataset.category || '').toString();
            if (category === '__all__' || cat === category) {
                btn.classList.remove('hidden'); btn.removeAttribute('aria-hidden');
            } else {
                btn.classList.add('hidden'); btn.setAttribute('aria-hidden','true');
            }
        });
    }

    function setActiveCategoryChip(category) {
        categoriesWrap.querySelectorAll('.category-chip').forEach(c => {
            if (c.dataset.category === category) c.classList.add('ring-2','ring-purple-300','bg-purple-50');
            else c.classList.remove('ring-2','ring-purple-300','bg-purple-50');
        });
    }

    // --- IMPORTANT: we NEVER replace suggestions globally.
    // send faq_id to server; display answer only, keep suggestions unchanged
    async function sendFaq(faqId, questionText) {
        if (busy) return;
        setBusy(true);
        addMessage(questionText, 'user');
        const typingId = showTyping();

        try {
            const res = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken,'Accept':'application/json' },
                body: JSON.stringify({ faq_id: faqId })
            });

            const data = await res.json();
            removeTyping(typingId);
            setBusy(false);

            if (data && data.message) {
                addMessage(data.message, 'bot');
                // DO NOT replace suggestions. If you want follow-ups, you can still show them somewhere,
                // but this view keeps the original suggestion list intact.
            } else {
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
            }
        } catch (err) {
            console.error(err);
            removeTyping(typingId);
            setBusy(false);
            addMessage('Maaf, tidak dapat terhubung ke server. Periksa koneksi Anda.', 'bot');
        }
    }

    // categories click
    categoriesWrap.addEventListener('click', (e) => {
        const chip = e.target.closest('.category-chip');
        if (!chip || chip.disabled) return;
        const cat = chip.dataset.category;
        setActiveCategoryChip(cat);
        filterSuggestions(cat);
    });

    // suggestion click (delegated)
    suggestionsWrap.addEventListener('click', (e) => {
        const btn = e.target.closest('.suggestion-btn');
        if (!btn || btn.disabled || btn.classList.contains('hidden')) return;
        const id = btn.dataset.id;
        const question = btn.dataset.question || btn.innerText;
        sendFaq(id, question);
    });

    // keyboard accessibility
    categoriesWrap.addEventListener('keydown', (e) => {
        const active = document.activeElement;
        if (!active || !active.classList.contains('category-chip')) return;
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); active.click(); }
    });
    suggestionsWrap.addEventListener('keydown', (e) => {
        const active = document.activeElement;
        if (!active || !active.classList.contains('suggestion-btn')) return;
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); active.click(); }
    });

    // initialize
    initSuggestionsFromDOM(); // capture initial suggestions
    setActiveCategoryChip('__all__');
    filterSuggestions('__all__');

})();
</script>
@endsection
