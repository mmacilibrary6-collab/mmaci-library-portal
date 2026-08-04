@php
    $lisaAvatar = 'https://static.vecteezy.com/system/resources/previews/054/064/121/non_2x/young-girl-reading-in-library-illustration-for-education-and-learning-themes-free-vector.jpg';
@endphp

<div
    id="lisa-chatbot-widget"
    aria-live="polite"
    style="position:fixed;right:24px;bottom:24px;left:auto;top:auto;width:auto;height:auto;margin:0;padding:0;z-index:2147483000;isolation:isolate;pointer-events:auto;">
    <button
        type="button"
        id="lisa-chat-launcher"
        aria-label="Open Lisa chat"
        aria-expanded="false"
        style="all:unset;box-sizing:border-box;display:block;width:60px;height:60px;border-radius:9999px;overflow:hidden;cursor:pointer;box-shadow:0 14px 30px rgba(11,46,89,.28);background:linear-gradient(135deg,#0b2e59,#184b8c);animation:lisaFloat 3.6s ease-in-out infinite;position:relative;">
        <span
            aria-hidden="true"
            style="display:block;width:100%;height:100%;background-image:url('{{ $lisaAvatar }}');background-size:cover;background-position:center;background-repeat:no-repeat;"></span>
    </button>

    <section
        id="lisa-chat-panel"
        aria-label="Lisa chatbot"
        hidden
        style="position:absolute;right:72px;bottom:0;width:350px;height:480px;max-width:calc(100vw - 32px);max-height:calc(100dvh - 120px);display:flex;flex-direction:column;overflow:hidden;border-radius:12px;background:#f8fafc;border:1px solid rgba(11,46,89,.12);box-shadow:0 24px 60px rgba(11,46,89,.24);opacity:0;transform:translateX(12px) scale(.98);pointer-events:none;transition:opacity .2s ease, transform .2s ease, width .2s ease, height .2s ease;">
        <header style="flex:0 0 auto;display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px 14px;background:linear-gradient(135deg,#0b2e59,#184b8c);color:#fff;">
            <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                <span
                    aria-hidden="true"
                    style="width:36px;height:36px;flex:0 0 auto;border-radius:50%;border:2px solid rgba(255,255,255,.55);background-image:url('{{ $lisaAvatar }}');background-size:cover;background-position:center;background-repeat:no-repeat;"></span>
                <div style="min-width:0;display:flex;flex-direction:column;line-height:1.15;">
                    <strong style="color:#fff;font-size:14px;font-weight:700;">Lisa</strong>
                    <span style="color:rgba(255,255,255,.78);font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">MMACI Library Guide</span>
                </div>
            </div>

            <button
                type="button"
                id="lisa-chat-close"
                aria-label="Close Lisa chat"
                style="all:unset;box-sizing:border-box;display:grid;place-items:center;width:32px;height:32px;border-radius:50%;cursor:pointer;background:rgba(255,255,255,.14);color:#fff;font-size:22px;line-height:1;">×</button>
        </header>

        <div style="flex:1 1 auto;min-height:0;display:flex;flex-direction:column;background:linear-gradient(180deg,#f8fafc 0%,#ffffff 100%);">
            <div id="lisa-chat-messages" aria-live="polite" style="flex:1 1 auto;min-height:0;overflow-y:auto;padding:14px;"></div>
            <div id="lisa-chat-chips" aria-label="Suggested questions" style="flex:0 0 auto;display:flex;flex-wrap:wrap;gap:8px;padding:0 14px 12px;max-height:96px;overflow:hidden;"></div>
        </div>

        <form id="lisa-chat-form" autocomplete="off" style="flex:0 0 auto;display:flex;align-items:flex-end;gap:10px;padding:12px 14px 14px;border-top:1px solid #e3e9f1;background:#fff;">
            <label for="lisa-chat-input" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0;">Message Lisa</label>
            <textarea
                id="lisa-chat-input"
                rows="1"
                placeholder="Ask Lisa about the website, collections, or services..."
                style="box-sizing:border-box;flex:1 1 auto;min-width:0;resize:none;border:1px solid #d9e3ef;border-radius:16px;padding:11px 13px;background:#fff;color:#1f2f46;font-size:14px;line-height:1.5;max-height:108px;outline:none;"></textarea>

            <button
                type="submit"
                aria-label="Send message"
                style="all:unset;box-sizing:border-box;display:grid;place-items:center;width:42px;height:42px;flex:0 0 auto;border-radius:50%;cursor:pointer;color:#fff;background:linear-gradient(135deg,#f4b400,#dca300);box-shadow:0 10px 24px rgba(244,180,0,.28);font-size:18px;line-height:1;">➤</button>
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

            #lisa-chatbot-widget.is-open #lisa-chat-panel {
                opacity: 1;
                transform: translateX(0) scale(1);
                pointer-events: auto;
            }

            #lisa-chatbot-widget .lisa-chat-launcher:focus-visible,
            #lisa-chatbot-widget button:focus-visible,
            #lisa-chatbot-widget textarea:focus-visible {
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

                #lisa-chatbot-widget .lisa-chat-launcher {
                    width: 52px !important;
                    height: 52px !important;
                }

                #lisa-chatbot-widget #lisa-chat-panel {
                    right: 0 !important;
                    bottom: 64px !important;
                    width: min(350px, calc(100vw - 24px)) !important;
                    height: min(480px, calc(100dvh - 100px)) !important;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                #lisa-chatbot-widget .lisa-chat-launcher {
                    animation: none;
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
                    window.LisaChatbot = window.LisaChatbot || {};

                    const storageKey = 'lisa.chat.history';
                    const openKey = 'lisa.chat.open';
                    const quickReplies = [
                        'How do I use the E-books page?',
                        'Where is Reserve AVR?',
                        'How do gallery uploads work?'
                    ];

                    function loadHistory() {
                        try {
                            const stored = JSON.parse(localStorage.getItem(storageKey) || '[]');
                            return Array.isArray(stored) && stored.length ? stored : [{
                                role: 'assistant',
                                text: 'Hi, I’m Lisa — your MMACI Library guide. Ask me about collections, services, reservations, or how to use the site.'
                            }];
                        } catch (error) {
                            return [{
                                role: 'assistant',
                                text: 'Hi, I’m Lisa — your MMACI Library guide. Ask me about collections, services, reservations, or how to use the site.'
                            }];
                        }
                    }

                    let history = loadHistory();

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

                    function openChat() {
                        widget.classList.add('is-open');
                        panel.hidden = false;
                        launcher.setAttribute('aria-expanded', 'true');
                        panel.style.pointerEvents = 'auto';
                        localStorage.setItem(openKey, '1');
                        setTimeout(() => messages.scrollTop = messages.scrollHeight, 0);
                    }

                    function closeChat() {
                        widget.classList.remove('is-open');
                        launcher.setAttribute('aria-expanded', 'false');
                        localStorage.removeItem(openKey);
                        panel.style.pointerEvents = 'none';
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

                    launcher.addEventListener('click', (event) => {
                        event.preventDefault();
                        if (widget.classList.contains('is-open')) {
                            closeChat();
                        } else {
                            openChat();
                        }
                    });

                    closeButton.addEventListener('click', (event) => {
                        event.preventDefault();
                        closeChat();
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

                    renderMessages();
                    renderChips(quickReplies);

                    if (localStorage.getItem(openKey) === '1') {
                        openChat();
                    } else {
                        closeChat();
                    }

                    document.body.appendChild(widget);
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
