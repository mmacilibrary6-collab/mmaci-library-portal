@php
    $lisaAvatar = 'https://static.vecteezy.com/system/resources/previews/054/064/121/non_2x/young-girl-reading-in-library-illustration-for-education-and-learning-themes-free-vector.jpg';
@endphp

<div id="lisa-chatbot-widget" aria-live="polite">
    <button type="button" id="lisa-chat-launcher" aria-label="Open Lisa chat" aria-expanded="false">
        <span class="lisa-launcher-avatar" aria-hidden="true"></span>
        <span class="lisa-launcher-label">Lisa</span>
    </button>

    <section id="lisa-chat-panel" aria-label="Lisa chatbot" hidden>
        <header class="lisa-header">
            <div class="lisa-header-left">
                <span class="lisa-header-avatar" aria-hidden="true"></span>
                <div class="lisa-header-copy">
                    <strong>Lisa</strong>
                    <span>MMACI Library Guide</span>
                </div>
            </div>

            <div class="lisa-header-actions">
                <button type="button" id="lisa-chat-minimize" aria-label="Minimize chat">—</button>
                <button type="button" id="lisa-chat-close" aria-label="Close chat">×</button>
            </div>
        </header>

        <div class="lisa-body">
            <div id="lisa-chat-messages" aria-live="polite"></div>
            <div id="lisa-chat-chips" role="region" aria-label="Suggested questions"></div>
        </div>

        <form id="lisa-chat-form" autocomplete="off">
            <label for="lisa-chat-input" class="sr-only">Message Lisa</label>
            <textarea id="lisa-chat-input" rows="1" placeholder="Send a message..."></textarea>
            <button type="submit" aria-label="Send message">➤</button>
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
                width: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                isolation: isolate !important;
                pointer-events: auto !important;
            }

            #lisa-chatbot-widget #lisa-chat-launcher {
                appearance: none;
                -webkit-appearance: none;
                border: 0;
                margin: 0;
                padding: 10px 14px;
                display: flex;
                align-items: center;
                gap: 10px;
                border-radius: 999px;
                cursor: pointer;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                color: #fff;
                box-shadow: 0 16px 34px rgba(11, 46, 89, 0.28);
                animation: lisaFloat 3.6s ease-in-out infinite;
            }

            #lisa-chatbot-widget #lisa-chat-launcher:hover {
                box-shadow: 0 20px 38px rgba(11, 46, 89, 0.34);
            }

            #lisa-chatbot-widget .lisa-launcher-avatar,
            #lisa-chatbot-widget .lisa-header-avatar {
                background-image: url('{{ $lisaAvatar }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            #lisa-chatbot-widget .lisa-launcher-avatar {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background-color: #fff;
                border: 2px solid rgba(255, 255, 255, 0.55);
                flex: 0 0 auto;
            }

            #lisa-chatbot-widget .lisa-launcher-label {
                font-size: 13px;
                font-weight: 700;
                letter-spacing: 0.01em;
            }

            #lisa-chatbot-widget #lisa-chat-panel {
                position: fixed;
                right: 24px;
                bottom: 92px;
                width: 380px;
                height: 520px;
                max-width: calc(100vw - 32px);
                max-height: calc(100dvh - 120px);
                display: flex;
                flex-direction: column;
                overflow: hidden;
                border-radius: 16px;
                background: #f8fafc;
                border: 1px solid rgba(11, 46, 89, 0.12);
                box-shadow: 0 24px 60px rgba(11, 46, 89, 0.24);
                opacity: 0;
                transform: translateY(12px) scale(0.98);
                pointer-events: none;
                transition: opacity 0.2s ease, transform 0.2s ease;
            }

            #lisa-chatbot-widget.is-open #lisa-chat-panel {
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
                flex: 0 0 auto;
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
            }

            #lisa-chatbot-widget .lisa-header-actions button {
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

            #lisa-chatbot-widget #lisa-chat-messages {
                flex: 1 1 auto;
                min-height: 0;
                overflow-y: auto;
                padding: 14px;
            }

            #lisa-chatbot-widget .lisa-message {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 10px;
            }

            #lisa-chatbot-widget .lisa-message.user {
                align-items: flex-end;
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

            #lisa-chatbot-widget .lisa-page-link {
                align-self: flex-start;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                max-width: 84%;
                margin-top: 8px;
                padding: 9px 14px;
                border-radius: 12px;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                color: #ffffff;
                font-size: 12px;
                font-weight: 700;
                line-height: 1.35;
                text-align: center;
                text-decoration: none;
                white-space: normal;
                overflow-wrap: anywhere;
                box-shadow: 0 8px 18px rgba(11, 46, 89, 0.14);
                transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
            }

            #lisa-chatbot-widget .lisa-page-link:hover,
            #lisa-chatbot-widget .lisa-page-link:focus-visible {
                transform: translateY(-1px);
                box-shadow: 0 10px 22px rgba(11, 46, 89, 0.18);
                opacity: 0.96;
            }

            #lisa-chatbot-widget #lisa-chat-chips {
                flex: 0 0 auto;
                display: flex;
                flex-wrap: nowrap;
                gap: 8px;
                padding: 8px 14px 12px;
                overflow-x: auto;
                overflow-y: hidden;
                scroll-snap-type: x proximity;
                scrollbar-width: thin;
                scrollbar-color: #c5d2e2 transparent;
                -webkit-overflow-scrolling: touch;
            }

            #lisa-chatbot-widget #lisa-chat-chips::-webkit-scrollbar {
                height: 5px;
            }

            #lisa-chatbot-widget #lisa-chat-chips::-webkit-scrollbar-thumb {
                border-radius: 999px;
                background: #c5d2e2;
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
                line-height: 1.35;
                white-space: nowrap;
                scroll-snap-align: start;
                flex: 0 0 auto;
                cursor: pointer;
            }

            #lisa-chatbot-widget #lisa-chat-form {
                flex: 0 0 auto;
                display: flex;
                align-items: flex-end;
                gap: 10px;
                padding: 12px 14px 14px;
                border-top: 1px solid #e3e9f1;
                background: #fff;
            }

            #lisa-chatbot-widget #lisa-chat-input {
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

            #lisa-chatbot-widget #lisa-chat-input::placeholder {
                color: #91a0b3;
            }

            #lisa-chatbot-widget #lisa-chat-form button {
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
            #lisa-chatbot-widget .lisa-header-actions button:focus-visible,
            #lisa-chatbot-widget .lisa-chip:focus-visible,
            #lisa-chatbot-widget #lisa-chat-form button:focus-visible,
            #lisa-chatbot-widget #lisa-chat-input:focus-visible {
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

                #lisa-chatbot-widget #lisa-chat-panel {
                    left: 12px;
                    right: 12px;
                    bottom: calc(78px + env(safe-area-inset-bottom));
                    width: auto;
                    max-width: calc(100vw - 24px);
                    height: min(500px, calc(100dvh - 120px));
                    max-height: calc(100dvh - 120px);
                }

                #lisa-chatbot-widget #lisa-chat-panel .lisa-header-copy span {
                    white-space: normal;
                }

                #lisa-chatbot-widget #lisa-chat-launcher {
                    padding: 12px 16px;
                    min-width: 48px;
                }
            }
                #lisa-chatbot-widget #lisa-chat-panel {
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

                    const storageKey = 'lisa.chat.history';
                    const openKey = 'lisa.chat.open';
                    const quickReplies = [
                        'Where can I find E-books for my program?',
                        'What services and facilities are available?',
                        'How do I contact the librarian?',
                        'How do I reserve the AVR?'
                    ];

                    const welcomeMessage = {
                        role: 'assistant',
                        text: 'Hi, I’m Lisa — your MMACI Library guide. Ask me about collections, services, reservations, or how to use the site.'
                    };

                    let history = [];

                    try {
                        const stored = JSON.parse(localStorage.getItem(storageKey) || '[]');
                        history = Array.isArray(stored) && stored.length ? stored : [welcomeMessage];
                    } catch (error) {
                        history = [welcomeMessage];
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

                            if (entry.pageUrl) {
                                const link = document.createElement('a');
                                link.href = entry.pageUrl;
                                link.target = '_self';
                                link.rel = 'noopener';
                                link.textContent = entry.pageLabel || 'Open page';
                                link.className = 'lisa-page-link';
                                row.appendChild(link);
                            }

                            messages.appendChild(row);
                        });

                        messages.scrollTop = messages.scrollHeight;
                    }

                    function renderChips(items) {
                        chips.innerHTML = '';

                        const uniqueItems = [...new Set(
                            (items || [])
                                .map((item) => String(item).trim())
                                .filter(Boolean)
                        )];

                        uniqueItems.slice(0, 4).forEach((item) => {
                            const chip = document.createElement('button');
                            chip.type = 'button';
                            chip.className = 'lisa-chip';
                            chip.textContent = item;
                            chip.addEventListener('click', () => {
                                input.value = item;
                                form.requestSubmit();
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

                    let isSending = false;

                    async function sendMessage(text) {
                        if (isSending) {
                            return;
                        }

                        isSending = true;
                        const submitButton = form.querySelector('button[type="submit"]');
                        const requestHistory = history
                            .filter((entry) => entry.text && !entry.id)
                            .slice(-10)
                            .map((entry) => ({
                                role: entry.role,
                                text: entry.text
                            }));

                        history.push({ role: 'user', text });
                        renderMessages();
                        saveHistory();

                        input.disabled = true;
                        if (submitButton) submitButton.disabled = true;

                        const typingId = `typing-${Date.now()}`;
                        history.push({ role: 'assistant', text: 'Lisa is checking the library system…', id: typingId });
                        renderMessages();

                        try {
                            const response = await fetch('{{ route('lisa.message') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    message: text,
                                    history: requestHistory
                                })
                            });

                            const data = await response.json();

                            if (!response.ok) {
                                throw new Error(data.message || 'Request failed.');
                            }

                            history = history.filter((entry) => entry.id !== typingId);
                            history.push({
                                role: 'assistant',
                                text: data.answer || 'I’m sorry, I could not find an answer right now.',
                                pageUrl: data.pageUrl || null,
                                pageLabel: data.title ? `Open ${data.title}` : 'Open page'
                            });

                            renderMessages();
                            renderChips(data.suggestions || quickReplies);
                            saveHistory();
                        } catch (error) {
                            history = history.filter((entry) => entry.id !== typingId);
                            history.push({
                                role: 'assistant',
                                text: 'Sorry, I could not check the library information right now. Please try again.'
                            });
                            renderMessages();
                            saveHistory();
                        } finally {
                            isSending = false;
                            input.disabled = false;
                            if (submitButton) submitButton.disabled = false;
                            input.focus();
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

                    renderMessages();
                    renderChips(quickReplies);

                    if (localStorage.getItem(openKey) === '1') {
                        openChat();
                    } else {
                        closeChat();
                    }

                    window.LisaChatbot = {
                        open: openChat,
                        close: closeChat,
                        toggle: () => {
                            if (widget.classList.contains('is-open')) {
                                closeChat();
                            } else {
                                openChat();
                            }
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
