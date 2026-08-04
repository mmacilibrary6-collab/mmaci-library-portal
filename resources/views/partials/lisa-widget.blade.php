@php
    $lisaAvatar = 'https://static.vecteezy.com/system/resources/previews/054/064/121/non_2x/young-girl-reading-in-library-illustration-for-education-and-learning-themes-free-vector.jpg';
@endphp

<div class="lisa-widget" id="lisaWidget" aria-live="polite">
    <button type="button" class="lisa-launcher" id="lisaLauncher" aria-label="Open Lisa chat">
        <span class="lisa-launcher-avatar">
            <img src="{{ $lisaAvatar }}" alt="Lisa avatar">
        </span>
        <span class="lisa-launcher-copy">
            <strong>Lisa</strong>
            <small>Ask the library guide</small>
        </span>
        <i class="bi bi-chat-dots-fill"></i>
    </button>

    <div class="lisa-panel" id="lisaPanel" hidden>
        <header class="lisa-header">
            <div class="lisa-header-copy">
                <span class="lisa-avatar">
                    <img src="{{ $lisaAvatar }}" alt="Lisa">
                </span>
                <div>
                    <strong>Lisa</strong>
                    <small>Official system guide</small>
                </div>
            </div>
            <button type="button" class="lisa-close" id="lisaClose" aria-label="Close chat">
                <i class="bi bi-x-lg"></i>
            </button>
        </header>

        <div class="lisa-messages" id="lisaMessages"></div>

        <div class="lisa-suggestions" id="lisaSuggestions"></div>

        <form class="lisa-form" id="lisaForm">
            <textarea id="lisaInput" rows="2" placeholder="Ask Lisa about collections, services, or how to use the site..."></textarea>
            <button type="submit" class="lisa-send">
                <i class="bi bi-send-fill"></i>
                Send
            </button>
        </form>
    </div>
</div>

@once
    @push('styles')
        <style>
            .lisa-widget {
                position: fixed;
                right: 22px;
                bottom: 22px;
                z-index: 1080;
                font-family: 'Poppins', sans-serif;
            }

            .lisa-launcher {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 16px 12px 12px;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                color: #fff;
                border: 0;
                border-radius: 999px;
                box-shadow: 0 18px 40px rgba(11, 46, 89, 0.28);
            }

            .lisa-launcher-avatar,
            .lisa-avatar {
                flex: 0 0 auto;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                overflow: hidden;
                border: 2px solid rgba(255,255,255,.45);
                background: #fff;
            }

            .lisa-launcher-avatar img,
            .lisa-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .lisa-launcher-copy {
                display: grid;
                line-height: 1.1;
                text-align: left;
            }

            .lisa-launcher-copy strong {
                font-size: 14px;
            }

            .lisa-launcher-copy small {
                font-size: 12px;
                color: rgba(255,255,255,.78);
            }

            .lisa-launcher > i {
                margin-left: 4px;
                font-size: 18px;
            }

            .lisa-panel {
                width: min(390px, calc(100vw - 28px));
                height: min(620px, calc(100vh - 96px));
                margin-bottom: 12px;
                background: #fff;
                border: 1px solid rgba(11,46,89,.12);
                border-radius: 24px;
                box-shadow: 0 24px 60px rgba(11,46,89,.22);
                overflow: hidden;
                display: grid;
                grid-template-rows: auto 1fr auto auto;
            }

            .lisa-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 14px 16px;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                color: #fff;
            }

            .lisa-header-copy {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .lisa-header-copy strong,
            .lisa-header-copy small {
                display: block;
            }

            .lisa-header-copy small {
                color: rgba(255,255,255,.78);
                font-size: 12px;
            }

            .lisa-close {
                width: 38px;
                height: 38px;
                border: 0;
                border-radius: 50%;
                background: rgba(255,255,255,.14);
                color: #fff;
            }

            .lisa-messages {
                padding: 16px;
                overflow-y: auto;
                background: linear-gradient(180deg, #f7f9fc, #ffffff);
            }

            .lisa-message {
                display: flex;
                gap: 10px;
                margin-bottom: 14px;
            }

            .lisa-message.user {
                justify-content: flex-end;
            }

            .lisa-bubble {
                max-width: 82%;
                padding: 12px 14px;
                border-radius: 18px;
                font-size: 14px;
                line-height: 1.65;
                white-space: pre-wrap;
            }

            .lisa-message.bot .lisa-bubble {
                background: #fff;
                border: 1px solid #dfe6ef;
                color: #21334d;
                border-top-left-radius: 6px;
            }

            .lisa-message.user .lisa-bubble {
                background: #184b8c;
                color: #fff;
                border-top-right-radius: 6px;
            }

            .lisa-suggestions {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 0 16px 12px;
                background: #fff;
            }

            .lisa-chip {
                border: 1px solid #dfe6ef;
                background: #f4f7fb;
                color: #184b8c;
                border-radius: 999px;
                padding: 8px 11px;
                font-size: 12px;
                font-weight: 600;
            }

            .lisa-form {
                display: grid;
                gap: 10px;
                padding: 14px 16px 16px;
                border-top: 1px solid #dfe6ef;
                background: #fff;
            }

            .lisa-form textarea {
                width: 100%;
                resize: none;
                border-radius: 16px;
                border: 1px solid #dfe6ef;
                padding: 12px 14px;
                min-height: 54px;
                font-size: 14px;
                outline: none;
            }

            .lisa-form textarea:focus {
                border-color: #f4b400;
                box-shadow: 0 0 0 4px rgba(244,180,0,.16);
            }

            .lisa-send {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                border: 0;
                border-radius: 14px;
                padding: 12px 16px;
                font-weight: 700;
                color: #17212b;
                background: #f4b400;
            }

            @media (max-width: 575.98px) {
                .lisa-widget {
                    left: 14px;
                    right: 14px;
                    bottom: 14px;
                }

                .lisa-launcher {
                    width: 100%;
                    justify-content: space-between;
                }

                .lisa-panel {
                    width: 100%;
                    height: min(70vh, 620px);
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                const widget = document.getElementById('lisaWidget');
                const launcher = document.getElementById('lisaLauncher');
                const panel = document.getElementById('lisaPanel');
                const closeButton = document.getElementById('lisaClose');
                const messages = document.getElementById('lisaMessages');
                const form = document.getElementById('lisaForm');
                const input = document.getElementById('lisaInput');
                const suggestions = document.getElementById('lisaSuggestions');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const storageKey = 'lisa.chat.history';
                const openKey = 'lisa.chat.open';

                let history = [];

                const initialMessage = {
                    role: 'assistant',
                    text: 'Hi, I’m Lisa — your MMACI Library guide. Ask me about collections, services, reservations, or how to use the site.',
                    title: 'Welcome'
                };

                function loadHistory() {
                    try {
                        history = JSON.parse(localStorage.getItem(storageKey) || '[]');
                    } catch (error) {
                        history = [];
                    }

                    if (!history.length) {
                        history = [initialMessage];
                    }
                }

                function saveHistory() {
                    localStorage.setItem(storageKey, JSON.stringify(history.slice(-20)));
                }

                function renderMessages() {
                    messages.innerHTML = '';

                    history.forEach(function (entry) {
                        const row = document.createElement('div');
                        row.className = 'lisa-message ' + (entry.role === 'user' ? 'user' : 'bot');

                        const bubble = document.createElement('div');
                        bubble.className = 'lisa-bubble';
                        bubble.textContent = entry.text;

                        row.appendChild(bubble);
                        messages.appendChild(row);
                    });

                    messages.scrollTop = messages.scrollHeight;
                }

                function renderSuggestions(items) {
                    suggestions.innerHTML = '';

                    (items || []).forEach(function (item) {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'lisa-chip';
                        button.textContent = item;
                        button.addEventListener('click', function () {
                            input.value = item;
                            input.focus();
                        });
                        suggestions.appendChild(button);
                    });
                }

                function openPanel() {
                    panel.hidden = false;
                    localStorage.setItem(openKey, '1');
                    setTimeout(function () {
                        messages.scrollTop = messages.scrollHeight;
                    }, 0);
                }

                function closePanel() {
                    panel.hidden = true;
                    localStorage.removeItem(openKey);
                }

                async function sendMessage(text) {
                    history.push({ role: 'user', text: text });
                    renderMessages();
                    saveHistory();

                    const typingId = Date.now().toString();
                    history.push({ role: 'assistant', text: 'Lisa is thinking…', typing: true, id: typingId });
                    renderMessages();
                    saveHistory();

                    try {
                        const response = await fetch('{{ route('lisa.message') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ message: text })
                        });

                        const data = await response.json();

                        history = history.filter(function (entry) {
                            return entry.id !== typingId;
                        });

                        history.push({
                            role: 'assistant',
                            text: data.answer || 'I’m sorry, I could not find an answer right now.',
                            title: data.title || ''
                        });

                        renderMessages();
                        renderSuggestions(data.suggestions || []);
                        saveHistory();
                    } catch (error) {
                        history = history.filter(function (entry) {
                            return entry.id !== typingId;
                        });
                        history.push({
                            role: 'assistant',
                            text: 'Sorry, Lisa could not reach the local knowledge engine just now. Please try again.'
                        });
                        renderMessages();
                        saveHistory();
                    }
                }

                launcher.addEventListener('click', function () {
                    if (panel.hidden) {
                        openPanel();
                    } else {
                        closePanel();
                    }
                });

                closeButton.addEventListener('click', closePanel);

                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const text = input.value.trim();

                    if (!text) {
                        return;
                    }

                    input.value = '';
                    sendMessage(text);
                });

                loadHistory();
                renderMessages();
                renderSuggestions([
                    'How do I use the E-books page?',
                    'Where is Reserve AVR?',
                    'How do gallery uploads work?'
                ]);

                if (localStorage.getItem(openKey) === '1') {
                    openPanel();
                }
            })();
        </script>
    @endpush
@endonce
