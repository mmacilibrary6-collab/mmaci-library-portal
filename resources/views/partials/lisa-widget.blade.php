@php
    $lisaAvatar = 'https://static.vecteezy.com/system/resources/previews/054/064/121/non_2x/young-girl-reading-in-library-illustration-for-education-and-learning-themes-free-vector.jpg';
@endphp

<div id="lisa-chatbot-widget" class="lisa-chatbot-widget" aria-live="polite">
    <button
        type="button"
        id="lisa-chat-launcher"
        class="lisa-chat-launcher"
        aria-label="Open Lisa chat"
        aria-expanded="false">
        <img src="{{ $lisaAvatar }}" alt="Lisa avatar" class="lisa-chat-avatar">
    </button>

    <section id="lisa-chat-panel" class="lisa-chat-panel" aria-label="Lisa chatbot" hidden>
        <header class="lisa-chat-header">
            <div class="lisa-chat-header-left">
                <img src="{{ $lisaAvatar }}" alt="Lisa avatar" class="lisa-chat-header-avatar">
                <div class="lisa-chat-header-copy">
                    <strong>Lisa</strong>
                    <span>MMACI Library Guide</span>
                </div>
            </div>

            <button type="button" id="lisa-chat-close" class="lisa-chat-icon-button" aria-label="Close Lisa chat">×</button>
        </header>

        <div class="lisa-chat-body">
            <div id="lisa-chat-messages" class="lisa-chat-messages" aria-live="polite"></div>
            <div id="lisa-chat-chips" class="lisa-chat-chips" aria-label="Suggested questions"></div>
        </div>

        <form id="lisa-chat-form" class="lisa-chat-footer" autocomplete="off">
            <label class="sr-only" for="lisa-chat-input">Message Lisa</label>
            <textarea
                id="lisa-chat-input"
                class="lisa-chat-input"
                rows="1"
                placeholder="Ask Lisa about the website, collections, or services..."></textarea>

            <button type="submit" class="lisa-chat-send" aria-label="Send message">➤</button>
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
                width: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                pointer-events: auto !important;
            }

            #lisa-chatbot-widget .lisa-chat-launcher {
                appearance: none;
                -webkit-appearance: none;
                width: 60px;
                height: 60px;
                border: 0;
                margin: 0;
                padding: 0;
                border-radius: 50%;
                overflow: hidden;
                display: grid;
                place-items: center;
                cursor: pointer;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                box-shadow: 0 14px 30px rgba(11, 46, 89, 0.28);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                animation: lisa-float 3.6s ease-in-out infinite;
            }

            #lisa-chatbot-widget .lisa-chat-launcher:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 38px rgba(11, 46, 89, 0.34);
                animation-play-state: paused;
            }

            #lisa-chatbot-widget .lisa-chat-launcher:focus-visible,
            #lisa-chatbot-widget .lisa-chat-icon-button:focus-visible,
            #lisa-chatbot-widget .lisa-chat-send:focus-visible,
            #lisa-chatbot-widget .lisa-chat-chip:focus-visible,
            #lisa-chatbot-widget .lisa-chat-input:focus-visible {
                outline: 3px solid rgba(244, 180, 0, 0.45);
                outline-offset: 2px;
            }

            #lisa-chatbot-widget .lisa-chat-avatar,
            #lisa-chatbot-widget .lisa-chat-header-avatar {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
            }

            #lisa-chatbot-widget .lisa-chat-panel {
                position: absolute !important;
                right: 72px !important;
                bottom: 0 !important;
                width: 350px !important;
                height: 480px !important;
                max-width: calc(100vw - 32px) !important;
                max-height: calc(100dvh - 120px) !important;
                display: flex;
                flex-direction: column;
                overflow: hidden;
                border-radius: 12px;
                background: #f8fafc;
                border: 1px solid rgba(11, 46, 89, 0.12);
                box-shadow: 0 24px 60px rgba(11, 46, 89, 0.24);
                opacity: 0;
                transform: translateX(12px) scale(0.98);
                pointer-events: none;
                transition: opacity 0.2s ease, transform 0.2s ease;
            }

            #lisa-chatbot-widget.is-open .lisa-chat-panel {
                opacity: 1;
                transform: translateX(0) scale(1);
                pointer-events: auto;
            }

            #lisa-chatbot-widget .lisa-chat-header {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 14px;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                color: #fff;
            }

            #lisa-chatbot-widget .lisa-chat-header-left {
                display: flex;
                align-items: center;
                gap: 10px;
                min-width: 0;
            }

            #lisa-chatbot-widget .lisa-chat-header-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                flex: 0 0 auto;
                border: 2px solid rgba(255, 255, 255, 0.55);
                background: #fff;
            }

            #lisa-chatbot-widget .lisa-chat-header-copy {
                min-width: 0;
                display: flex;
                flex-direction: column;
                line-height: 1.15;
            }

            #lisa-chatbot-widget .lisa-chat-header-copy strong {
                color: #fff;
                font-size: 14px;
                font-weight: 700;
            }

            #lisa-chatbot-widget .lisa-chat-header-copy span {
                color: rgba(255, 255, 255, 0.78);
                font-size: 12px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            #lisa-chatbot-widget .lisa-chat-icon-button {
                appearance: none;
                -webkit-appearance: none;
                border: 0;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: grid;
                place-items: center;
                color: #fff;
                background: rgba(255, 255, 255, 0.14);
                cursor: pointer;
                flex: 0 0 auto;
                font-size: 20px;
                line-height: 1;
            }

            #lisa-chatbot-widget .lisa-chat-body {
                flex: 1 1 auto;
                min-height: 0;
                display: flex;
                flex-direction: column;
                background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            }

            #lisa-chatbot-widget .lisa-chat-messages {
                flex: 1 1 auto;
                min-height: 0;
                overflow-y: auto;
                padding: 14px;
            }

            #lisa-chatbot-widget .lisa-chat-message {
                display: flex;
                margin-bottom: 10px;
            }

            #lisa-chatbot-widget .lisa-chat-message.user {
                justify-content: flex-end;
            }

            #lisa-chatbot-widget .lisa-chat-bubble {
                max-width: 84%;
                padding: 11px 13px;
                border-radius: 18px;
                font-size: 13px;
                line-height: 1.6;
                white-space: pre-wrap;
                word-wrap: break-word;
                box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
            }

            #lisa-chatbot-widget .lisa-chat-message.bot .lisa-chat-bubble {
                background: #ffffff;
                color: #1f2f46;
                border: 1px solid #e3e9f1;
                border-top-left-radius: 6px;
            }

            #lisa-chatbot-widget .lisa-chat-message.user .lisa-chat-bubble {
                background: #184b8c;
                color: #fff;
                border-top-right-radius: 6px;
            }

            #lisa-chatbot-widget .lisa-chat-chips {
                flex: 0 0 auto;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 0 14px 12px;
                max-height: 96px;
                overflow: hidden;
            }

            #lisa-chatbot-widget .lisa-chat-chip {
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

            #lisa-chatbot-widget .lisa-chat-footer {
                flex: 0 0 auto;
                display: flex;
                align-items: flex-end;
                gap: 10px;
                padding: 12px 14px 14px;
                border-top: 1px solid #e3e9f1;
                background: #ffffff;
            }

            #lisa-chatbot-widget .lisa-chat-input {
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

            #lisa-chatbot-widget .lisa-chat-input::placeholder {
                color: #91a0b3;
            }

            #lisa-chatbot-widget .lisa-chat-send {
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

            @keyframes lisa-float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-6px); }
            }

            @media (max-width: 576px) {
                #lisa-chatbot-widget {
                    right: 12px !important;
                    bottom: calc(12px + env(safe-area-inset-bottom)) !important;
                }

                #lisa-chatbot-widget .lisa-chat-launcher {
                    width: 52px;
                    height: 52px;
                }

                #lisa-chatbot-widget .lisa-chat-panel {
                    right: 0 !important;
                    bottom: 64px !important;
                    width: min(350px, calc(100vw - 24px)) !important;
                    height: min(480px, calc(100dvh - 100px)) !important;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                #lisa-chatbot-widget .lisa-chat-launcher,
                #lisa-chatbot-widget .lisa-chat-panel {
                    animation: none;
                    transition: none;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                const bootstrap = () => {
                    if (window.__lisaChatbotInitialized) {
                        return;
                    }

                    const widget = document.getElementById('lisa-chatbot-widget');
                    const launcher = document.getElementById('lisa-chat-launcher');
                    const panel = document.getElementById('lisa-chat-panel');
                    const closeButton = document.getElementById('lisa-chat-close');
                    const messages = document.getElementById('lisa-chat-messages');
                    const chips = document.getElementById('lisa-chat-chips');
                    const form = document.getElementById('lisa-chat-form');
                    const input = document.getElementById('lisa-chat-input');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    if (!widget || !launcher || !panel || !closeButton || !messages || !chips || !form || !input || !csrfToken) {
                        return;
                    }

                    window.__lisaChatbotInitialized = true;

                    const storageKey = 'lisa.chat.history';
                    const openKey = 'lisa.chat.open';
                    const quickReplies = [
                        'How do I use the E-books page?',
                        'Where is Reserve AVR?',
                        'How do gallery uploads work?'
                    ];

                    const fallbackMessage = {
                        role: 'assistant',
                        text: 'Hi, I’m Lisa — your MMACI Library guide. Ask me about collections, services, reservations, or how to use the site.'
                    };

                    const api = {
                        open() {
                            widget.classList.add('is-open');
                            panel.hidden = false;
                            launcher.setAttribute('aria-expanded', 'true');
                            panel.setAttribute('aria-hidden', 'false');
                            localStorage.setItem(openKey, '1');
                            setTimeout(() => messages.scrollTop = messages.scrollHeight, 0);
                        },
                        close() {
                            widget.classList.remove('is-open');
                            launcher.setAttribute('aria-expanded', 'false');
                            panel.setAttribute('aria-hidden', 'true');
                            localStorage.removeItem(openKey);
                            setTimeout(() => {
                                panel.hidden = true;
                            }, 150);
                        },
                        toggle() {
                            if (widget.classList.contains('is-open')) {
                                this.close();
                            } else {
                                this.open();
                            }
                            return false;
                        }
                    };

                    window.LisaChatbot = api;

                    let history = [];

                    function loadHistory() {
                        try {
                            history = JSON.parse(localStorage.getItem(storageKey) || '[]');
                        } catch (error) {
                            history = [];
                        }

                        if (!Array.isArray(history) || history.length === 0) {
                            history = [fallbackMessage];
                        }
                    }

                    function saveHistory() {
                        localStorage.setItem(storageKey, JSON.stringify(history.slice(-24)));
                    }

                    function renderMessages() {
                        messages.innerHTML = '';

                        history.forEach((entry) => {
                            const row = document.createElement('div');
                            row.className = `lisa-chat-message ${entry.role === 'user' ? 'user' : 'bot'}`;

                            const bubble = document.createElement('div');
                            bubble.className = 'lisa-chat-bubble';
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
                            chip.className = 'lisa-chat-chip';
                            chip.textContent = item;
                            chip.setAttribute('aria-label', `Ask Lisa: ${item}`);
                            chip.addEventListener('click', () => {
                                input.value = item;
                                input.focus();
                            });
                            chips.appendChild(chip);
                        });
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

                    launcher.addEventListener('click', (event) => {
                        event.preventDefault();
                        api.toggle();
                    });

                    closeButton.addEventListener('click', (event) => {
                        event.preventDefault();
                        api.close();
                    });

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

                    if (localStorage.getItem(openKey) === '1') {
                        api.open();
                    } else {
                        api.close();
                    }
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', bootstrap, { once: true });
                } else {
                    bootstrap();
                }
            })();
        </script>
    @endpush
@endonce
