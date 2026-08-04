@php
    $lisaAvatar = 'https://static.vecteezy.com/system/resources/previews/054/064/121/non_2x/young-girl-reading-in-library-illustration-for-education-and-learning-themes-free-vector.jpg';
@endphp

<div id="lisa-chatbot-widget" aria-live="polite">
    <button
        type="button"
        id="lisa-chat-launcher"
        class="lisa-launcher"
        aria-label="Open Lisa chat"
        aria-expanded="false">
        <span class="lisa-launcher-avatar" aria-hidden="true"></span>
        <span class="lisa-launcher-text">
            <strong>Lisa</strong>
            <small>MMACI Library Guide</small>
        </span>
        <span class="lisa-launcher-icon" aria-hidden="true">✦</span>
    </button>

    <section id="lisa-chat-panel" class="lisa-panel" aria-label="Lisa chatbot" hidden>
        <header class="lisa-header">
            <div class="lisa-header-left">
                <span class="lisa-header-avatar" aria-hidden="true"></span>
                <div class="lisa-header-copy">
                    <strong>Lisa</strong>
                    <span>MMACI Library Guide</span>
                </div>
            </div>

            <div class="lisa-header-actions">
                <button type="button" id="lisa-chat-minimize" class="lisa-icon-button" aria-label="Minimize chat">—</button>
                <button type="button" id="lisa-chat-close" class="lisa-icon-button" aria-label="Close chat">×</button>
            </div>
        </header>

        <div class="lisa-body">
            <div id="lisa-chat-messages" class="lisa-messages" aria-live="polite"></div>
            <div id="lisa-chat-chips" class="lisa-chips" aria-label="Suggested questions"></div>
        </div>

        <form id="lisa-chat-form" class="lisa-footer" autocomplete="off">
            <label for="lisa-chat-input" class="sr-only">Message Lisa</label>
            <textarea id="lisa-chat-input" class="lisa-input" rows="1" placeholder="Send a message..."></textarea>
            <button type="submit" class="lisa-send" aria-label="Send message">➤</button>
        </form>
    </section>
</div>

@once
    @push('styles')
        <style>
            #lisa-chatbot-widget,
            #lisa-chatbot-widget * {
                box-sizing: border-box;
            }

            #lisa-chatbot-widget {
                position: fixed !important;
                right: 24px !important;
                bottom: 24px !important;
                z-index: 2147483000 !important;
                isolation: isolate !important;
                pointer-events: auto !important;
                width: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            #lisa-chatbot-widget .lisa-launcher {
                all: unset;
                box-sizing: border-box;
                width: 250px;
                max-width: calc(100vw - 32px);
                min-height: 64px;
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 14px;
                border-radius: 18px;
                cursor: pointer;
                color: #fff;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                box-shadow: 0 14px 34px rgba(11, 46, 89, 0.28);
                animation: lisaFloat 3.8s ease-in-out infinite;
            }

            #lisa-chatbot-widget .lisa-launcher:hover {
                transform: translateY(-2px);
            }

            #lisa-chatbot-widget .lisa-launcher-avatar,
            #lisa-chatbot-widget .lisa-header-avatar {
                background-image: url('{{ $lisaAvatar }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                flex: 0 0 auto;
            }

            #lisa-chatbot-widget .lisa-launcher-avatar {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                border: 2px solid rgba(255, 255, 255, 0.55);
                background-color: #fff;
            }

            #lisa-chatbot-widget .lisa-launcher-text {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                min-width: 0;
                line-height: 1.15;
                flex: 1 1 auto;
            }

            #lisa-chatbot-widget .lisa-launcher-text strong {
                font-size: 14px;
                font-weight: 700;
                color: #fff;
            }

            #lisa-chatbot-widget .lisa-launcher-text small {
                font-size: 12px;
                color: rgba(255, 255, 255, 0.78);
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            #lisa-chatbot-widget .lisa-launcher-icon {
                width: 24px;
                height: 24px;
                display: grid;
                place-items: center;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.12);
                font-size: 16px;
                line-height: 1;
                flex: 0 0 auto;
            }

            #lisa-chatbot-widget .lisa-panel {
                position: absolute;
                right: 0;
                bottom: 76px;
                width: 360px;
                max-width: calc(100vw - 32px);
                height: 500px;
                max-height: calc(100dvh - 120px);
                display: flex;
                flex-direction: column;
                overflow: hidden;
                border-radius: 18px;
                background: #f8fafc;
                border: 1px solid rgba(11, 46, 89, 0.12);
                box-shadow: 0 24px 60px rgba(11, 46, 89, 0.24);
                opacity: 0;
                transform: translateY(12px) scale(0.98);
                pointer-events: none;
                transition: opacity 0.2s ease, transform 0.2s ease;
            }

            #lisa-chatbot-widget.is-open .lisa-panel {
                opacity: 1;
                transform: translateY(0) scale(1);
                pointer-events: auto;
            }

            #lisa-chatbot-widget .lisa-header {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 14px;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                color: #fff;
            }

            #lisa-chatbot-widget .lisa-header-left {
                display: flex;
                align-items: center;
                gap: 10px;
                min-width: 0;
            }

            #lisa-chatbot-widget .lisa-header-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                border: 2px solid rgba(255, 255, 255, 0.55);
                background-color: #fff;
            }

            #lisa-chatbot-widget .lisa-header-copy {
                display: flex;
                flex-direction: column;
                min-width: 0;
                line-height: 1.15;
            }

            #lisa-chatbot-widget .lisa-header-copy strong {
                color: #fff;
                font-size: 14px;
                font-weight: 700;
            }

            #lisa-chatbot-widget .lisa-header-copy span {
                color: rgba(255, 255, 255, 0.78);
                font-size: 12px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            #lisa-chatbot-widget .lisa-header-actions {
                display: flex;
                align-items: center;
                gap: 8px;
                flex: 0 0 auto;
            }

            #lisa-chatbot-widget .lisa-icon-button {
                appearance: none;
                -webkit-appearance: none;
                border: 0;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: grid;
                place-items: center;
                background: rgba(255, 255, 255, 0.14);
                color: #fff;
                cursor: pointer;
                font-size: 20px;
                line-height: 1;
            }

            #lisa-chatbot-widget .lisa-body {
                flex: 1 1 auto;
                min-height: 0;
                display: flex;
                flex-direction: column;
                background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            }

            #lisa-chatbot-widget .lisa-messages {
                flex: 1 1 auto;
                min-height: 0;
                overflow-y: auto;
                padding: 14px;
            }

            #lisa-chatbot-widget .lisa-message {
                display: flex;
                margin-bottom: 10px;
            }

            #lisa-chatbot-widget .lisa-message.user {
                justify-content: flex-end;
            }

            #lisa-chatbot-widget .lisa-bubble {
                max-width: 84%;
                padding: 11px 13px;
                border-radius: 18px;
                font-size: 13px;
                line-height: 1.6;
                white-space: pre-wrap;
                word-break: break-word;
                box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
            }

            #lisa-chatbot-widget .lisa-message.bot .lisa-bubble {
                background: #ffffff;
                color: #1f2f46;
                border: 1px solid #e3e9f1;
                border-top-left-radius: 6px;
            }

            #lisa-chatbot-widget .lisa-message.user .lisa-bubble {
                background: #184b8c;
                color: #fff;
                border-top-right-radius: 6px;
            }

            #lisa-chatbot-widget .lisa-chips {
                flex: 0 0 auto;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 0 14px 12px;
                max-height: 96px;
                overflow: hidden;
            }

            #lisa-chatbot-widget .lisa-chip {
                appearance: none;
                -webkit-appearance: none;
                border: 1px solid #d9e3ef;
                background: #f4f7fb;
                color: #184b8c;
                border-radius: 999px;
                padding: 8px 12px;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
            }

            #lisa-chatbot-widget .lisa-footer {
                flex: 0 0 auto;
                display: flex;
                align-items: flex-end;
                gap: 10px;
                padding: 12px 14px 14px;
                border-top: 1px solid #e3e9f1;
                background: #fff;
            }

            #lisa-chatbot-widget .lisa-input {
                flex: 1 1 auto;
                min-width: 0;
                resize: none;
                border: 1px solid #d9e3ef;
                border-radius: 16px;
                padding: 11px 13px;
                background: #fff;
                color: #1f2f46;
                font-size: 14px;
                line-height: 1.5;
                max-height: 108px;
                outline: none;
            }

            #lisa-chatbot-widget .lisa-input::placeholder {
                color: #91a0b3;
            }

            #lisa-chatbot-widget .lisa-send {
                appearance: none;
                -webkit-appearance: none;
                border: 0;
                width: 42px;
                height: 42px;
                flex: 0 0 auto;
                border-radius: 50%;
                display: grid;
                place-items: center;
                color: #fff;
                background: linear-gradient(135deg, #f4b400, #dca300);
                box-shadow: 0 10px 24px rgba(244, 180, 0, 0.28);
                cursor: pointer;
                font-size: 18px;
                line-height: 1;
            }

            #lisa-chatbot-widget .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                border: 0;
            }

            #lisa-chatbot-widget .lisa-launcher:focus-visible,
            #lisa-chatbot-widget .lisa-icon-button:focus-visible,
            #lisa-chatbot-widget .lisa-send:focus-visible,
            #lisa-chatbot-widget .lisa-chip:focus-visible,
            #lisa-chatbot-widget .lisa-input:focus-visible {
                outline: 3px solid rgba(244, 180, 0, 0.45);
                outline-offset: 2px;
            }

            @keyframes lisaFloat {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-6px); }
            }

            @media (max-width: 576px) {
                #lisa-chatbot-widget {
                    right: 12px !important;
                    bottom: calc(12px + env(safe-area-inset-bottom)) !important;
                }

                #lisa-chatbot-widget .lisa-launcher {
                    width: min(240px, calc(100vw - 24px));
                }

                #lisa-chatbot-widget .lisa-panel {
                    right: 0;
                    bottom: 76px;
                    width: min(360px, calc(100vw - 24px));
                    height: min(500px, calc(100dvh - 110px));
                }
            }

            @media (prefers-reduced-motion: reduce) {
                #lisa-chatbot-widget .lisa-launcher {
                    animation: none;
                }
                #lisa-chatbot-widget .lisa-panel {
                    transition: none;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                function initLisaChatbot() {
                    if (window.__lisaChatbotInitialized) {
                        return;
                    }

                    const widget = document.getElementById('lisa-chatbot-widget');
                    const launcher = document.getElementById('lisa-chat-launcher');
                    const panel = document.getElementById('lisa-chat-panel');
                    const minimizeButton = document.getElementById('lisa-chat-minimize');
                    const closeButton = document.getElementById('lisa-chat-close');
                    const messages = document.getElementById('lisa-chat-messages');
                    const chips = document.getElementById('lisa-chat-chips');
                    const form = document.getElementById('lisa-chat-form');
                    const input = document.getElementById('lisa-chat-input');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    if (!widget || !launcher || !panel || !minimizeButton || !closeButton || !messages || !chips || !form || !input || !csrfToken) {
                        return;
                    }

                    window.__lisaChatbotInitialized = true;
                    window.LisaChatbot = window.LisaChatbot || {};

                    const storageKey = 'lisa.chat.history';
                    const openKey = 'lisa.chat.open';
                    const quickReplies = [
                        'How do I use the E-books page?',
                        'Where is Reserve AVR?',
                        'How do gallery uploads work?'
                    ];

                    const welcomeMessage = {
                        role: 'assistant',
                        text: 'Hi, I’m Lisa — your MMACI Library guide. Ask me about collections, services, reservations, or how to use the site.'
                    };

                    let history = [];

                    function loadHistory() {
                        try {
                            const stored = JSON.parse(localStorage.getItem(storageKey) || '[]');
                            history = Array.isArray(stored) && stored.length ? stored : [welcomeMessage];
                        } catch (error) {
                            history = [welcomeMessage];
                        }
                    }

                    function saveHistory() {
                        localStorage.setItem(storageKey, JSON.stringify(history.slice(-24)));
                    }

                    function renderMessages() {
                        messages.innerHTML = '';

                        history.forEach((entry) => {
                            const row = document.createElement('div');
                            row.className = `lisa-message ${entry.role === 'user' ? 'user' : 'bot'}`;

                            const bubble = document.createElement('div');
                            bubble.className = 'lisa-bubble';
                            bubble.textContent = entry.text;

                            row.appendChild(bubble);
                            messages.appendChild(row);
                        });

                        messages.scrollTop = messages.scrollHeight;
                    }

                    function renderChips(items) {
                        chips.innerHTML = '';

                        (items || []).forEach((item) => {
                            const chip = document.createElement('button');
                            chip.type = 'button';
                            chip.className = 'lisa-chip';
                            chip.textContent = item;
                            chip.setAttribute('aria-label', `Ask Lisa: ${item}`);
                            chip.addEventListener('click', () => {
                                input.value = item;
                                input.focus();
                            });
                            chips.appendChild(chip);
                        });
                    }

                    function openChat() {
                        widget.classList.add('is-open');
                        panel.hidden = false;
                        launcher.setAttribute('aria-expanded', 'true');
                        localStorage.setItem(openKey, '1');
                        setTimeout(() => messages.scrollTop = messages.scrollHeight, 0);
                    }

                    function closeChat() {
                        widget.classList.remove('is-open');
                        launcher.setAttribute('aria-expanded', 'false');
                        localStorage.removeItem(openKey);
                        panel.hidden = true;
                    }

                    async function sendMessage(text) {
                        history.push({ role: 'user', text });
                        renderMessages();
                        saveHistory();

                        const typingId = `typing-${Date.now()}`;
                        history.push({ role: 'assistant', text: 'Lisa is thinking…', id: typingId });
                        renderMessages();

                        try {
                            const response = await fetch('{{ route('lisa.message') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({ message: text })
                            });

                            const data = await response.json();

                            history = history.filter((entry) => entry.id !== typingId);
                            history.push({
                                role: 'assistant',
                                text: data.answer || 'I’m sorry, I could not find an answer right now.'
                            });

                            renderMessages();
                            renderChips(data.suggestions || quickReplies);
                            saveHistory();
                        } catch (error) {
                            history = history.filter((entry) => entry.id !== typingId);
                            history.push({
                                role: 'assistant',
                                text: 'Sorry, Lisa could not reach the local knowledge engine just now. Please try again.'
                            });
                            renderMessages();
                            saveHistory();
                        }
                    }

                    launcher.addEventListener('click', () => {
                        if (widget.classList.contains('is-open')) {
                            closeChat();
                        } else {
                            openChat();
                        }
                    });

                    minimizeButton.addEventListener('click', closeChat);
                    closeButton.addEventListener('click', closeChat);

                    form.addEventListener('submit', (event) => {
                        event.preventDefault();
                        const text = input.value.trim();

                        if (!text) {
                            return;
                        }

                        input.value = '';
                        sendMessage(text);
                    });

                    input.addEventListener('keydown', (event) => {
                        if (event.key === 'Enter' && !event.shiftKey) {
                            event.preventDefault();
                            form.requestSubmit();
                        }
                    });

                    loadHistory();
                    renderMessages();
                    renderChips(quickReplies);
                    widget.appendChild(panel);

                    if (localStorage.getItem(openKey) === '1') {
                        openChat();
                    } else {
                        closeChat();
                    }

                    window.LisaChatbot.open = openChat;
                    window.LisaChatbot.close = closeChat;
                    window.LisaChatbot.toggle = () => {
                        if (widget.classList.contains('is-open')) {
                            closeChat();
                        } else {
                            openChat();
                        }
                    };
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initLisaChatbot, { once: true });
                } else {
                    initLisaChatbot();
                }
            })();
        </script>
    @endpush
@endonce
