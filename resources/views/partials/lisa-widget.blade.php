@php
    $lisaAvatar = 'https://static.vecteezy.com/system/resources/previews/054/064/121/non_2x/young-girl-reading-in-library-illustration-for-education-and-learning-themes-free-vector.jpg';
@endphp

<div id="lisa-widget" class="lisa-widget" aria-live="polite">
    <button
        type="button"
        id="lisa-launcher"
        class="lisa-launcher"
        aria-label="Open Lisa chat">
        <img src="{{ $lisaAvatar }}" alt="Lisa avatar" class="lisa-launcher-avatar">
    </button>

    <section
        id="lisa-panel"
        class="lisa-panel"
        hidden
        aria-label="Lisa chatbot">
        <header class="lisa-header">
            <div class="lisa-header-left">
                <img src="{{ $lisaAvatar }}" alt="Lisa avatar" class="lisa-header-avatar">
                <div class="lisa-header-copy">
                    <strong>Lisa</strong>
                    <span>MMACI Library Guide</span>
                </div>
            </div>

            <button type="button" id="lisa-close" class="lisa-icon-button" aria-label="Close Lisa chat">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
        </header>

        <div class="lisa-body">
            <div id="lisa-messages" class="lisa-messages" aria-live="polite"></div>

            <div id="lisa-chips" class="lisa-chips" aria-label="Suggested questions"></div>
        </div>

        <form id="lisa-form" class="lisa-footer" autocomplete="off">
            <label class="sr-only" for="lisa-input">Message Lisa</label>
            <textarea
                id="lisa-input"
                class="lisa-input"
                rows="1"
                placeholder="Ask Lisa about the website, collections, or services..."></textarea>

            <button type="submit" class="lisa-send" aria-label="Send message">
                <i class="bi bi-send-fill" aria-hidden="true"></i>
            </button>
        </form>
    </section>
</div>

@once
    @push('styles')
        <style>
            #lisa-widget,
            #lisa-widget * {
                box-sizing: border-box;
            }

            #lisa-widget {
                position: fixed;
                right: calc(20px + env(safe-area-inset-right, 0px));
                bottom: calc(20px + env(safe-area-inset-bottom, 0px));
                z-index: 2147483000;
                font-family: 'Poppins', sans-serif;
                width: auto;
                height: auto;
            }

            #lisa-widget .lisa-launcher {
                appearance: none;
                -webkit-appearance: none;
                border: 0;
                padding: 0;
                margin: 0;
                width: 60px;
                height: 60px;
                border-radius: 999px;
                display: grid;
                place-items: center;
                overflow: hidden;
                cursor: pointer;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                box-shadow: 0 16px 34px rgba(11, 46, 89, 0.28);
                transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
            }

            #lisa-widget .lisa-launcher:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 38px rgba(11, 46, 89, 0.34);
            }

            #lisa-widget .lisa-launcher:focus-visible,
            #lisa-widget .lisa-icon-button:focus-visible,
            #lisa-widget .lisa-send:focus-visible,
            #lisa-widget .lisa-chip:focus-visible,
            #lisa-widget .lisa-input:focus-visible {
                outline: 3px solid rgba(244, 180, 0, 0.45);
                outline-offset: 2px;
            }

            #lisa-widget .lisa-launcher-avatar,
            #lisa-widget .lisa-header-avatar {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
            }

            #lisa-widget .lisa-panel {
                position: fixed;
                right: calc(20px + env(safe-area-inset-right, 0px));
                bottom: calc(88px + env(safe-area-inset-bottom, 0px));
                width: 350px;
                height: 480px;
                display: flex;
                flex-direction: column;
                overflow: hidden;
                border-radius: 22px;
                background: #f8fafc;
                border: 1px solid rgba(11, 46, 89, 0.12);
                box-shadow: 0 24px 60px rgba(11, 46, 89, 0.24);
                transform: translateY(12px) scale(0.98);
                opacity: 0;
                pointer-events: none;
                transition: transform 0.2s ease, opacity 0.2s ease;
            }

            #lisa-widget .lisa-panel.is-open {
                opacity: 1;
                pointer-events: auto;
                transform: translateY(0) scale(1);
            }

            #lisa-widget .lisa-header {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 14px;
                background: linear-gradient(135deg, #0b2e59, #184b8c);
                color: #fff;
            }

            #lisa-widget .lisa-header-left {
                display: flex;
                align-items: center;
                gap: 10px;
                min-width: 0;
            }

            #lisa-widget .lisa-header-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                border: 2px solid rgba(255, 255, 255, 0.55);
                background: #fff;
                overflow: hidden;
                object-fit: cover;
                flex: 0 0 auto;
            }

            #lisa-widget .lisa-header-copy {
                display: flex;
                flex-direction: column;
                min-width: 0;
                line-height: 1.15;
            }

            #lisa-widget .lisa-header-copy strong {
                color: #fff;
                font-size: 14px;
                font-weight: 700;
            }

            #lisa-widget .lisa-header-copy span {
                color: rgba(255, 255, 255, 0.78);
                font-size: 12px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            #lisa-widget .lisa-icon-button {
                appearance: none;
                -webkit-appearance: none;
                border: 0;
                width: 34px;
                height: 34px;
                border-radius: 999px;
                display: grid;
                place-items: center;
                color: #fff;
                background: rgba(255, 255, 255, 0.14);
                cursor: pointer;
                flex: 0 0 auto;
            }

            #lisa-widget .lisa-body {
                flex: 1 1 auto;
                display: flex;
                flex-direction: column;
                min-height: 0;
                background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            }

            #lisa-widget .lisa-messages {
                flex: 1 1 auto;
                min-height: 0;
                overflow-y: auto;
                padding: 14px;
            }

            #lisa-widget .lisa-message {
                display: flex;
                margin-bottom: 10px;
            }

            #lisa-widget .lisa-message.user {
                justify-content: flex-end;
            }

            #lisa-widget .lisa-bubble {
                max-width: 84%;
                padding: 11px 13px;
                border-radius: 16px;
                font-size: 13px;
                line-height: 1.6;
                white-space: pre-wrap;
                word-wrap: break-word;
                box-shadow: 0 8px 20px rgba(16, 24, 40, 0.06);
            }

            #lisa-widget .lisa-message.bot .lisa-bubble {
                background: #ffffff;
                color: #1f2f46;
                border: 1px solid #e3e9f1;
                border-top-left-radius: 6px;
            }

            #lisa-widget .lisa-message.user .lisa-bubble {
                background: #184b8c;
                color: #ffffff;
                border-top-right-radius: 6px;
            }

            #lisa-widget .lisa-chips {
                flex: 0 0 auto;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 0 14px 12px;
                max-height: 92px;
                overflow: hidden;
            }

            #lisa-widget .lisa-chip {
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
                transition: background 0.18s ease, transform 0.18s ease, border-color 0.18s ease;
            }

            #lisa-widget .lisa-chip:hover {
                transform: translateY(-1px);
                background: #eaf0f8;
                border-color: #c9d7ea;
            }

            #lisa-widget .lisa-footer {
                flex: 0 0 auto;
                display: flex;
                align-items: flex-end;
                gap: 10px;
                padding: 12px 14px 14px;
                border-top: 1px solid #e3e9f1;
                background: #ffffff;
            }

            #lisa-widget .lisa-input {
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

            #lisa-widget .lisa-input::placeholder {
                color: #91a0b3;
            }

            #lisa-widget .lisa-send {
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
            }

            #lisa-widget .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                border: 0;
            }

            @media (max-width: 767.98px) {
                #lisa-widget {
                    right: calc(12px + env(safe-area-inset-right, 0px));
                    bottom: calc(12px + env(safe-area-inset-bottom, 0px));
                }

                #lisa-widget .lisa-launcher {
                    width: 52px;
                    height: 52px;
                }

                #lisa-widget .lisa-panel {
                    right: calc(12px + env(safe-area-inset-right, 0px));
                    left: calc(12px + env(safe-area-inset-left, 0px));
                    width: calc(100vw - 24px);
                    max-width: 420px;
                    height: auto;
                    max-height: 70dvh;
                    bottom: calc(72px + env(safe-area-inset-bottom, 0px));
                }

                #lisa-widget .lisa-body {
                    min-height: 0;
                }

                #lisa-widget .lisa-chips {
                    max-height: 84px;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                #lisa-widget .lisa-launcher,
                #lisa-widget .lisa-panel,
                #lisa-widget .lisa-chip {
                    transition: none;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                if (window.__lisaWidgetInitialized) {
                    return;
                }

                window.__lisaWidgetInitialized = true;

                const widget = document.getElementById('lisa-widget');
                const launcher = document.getElementById('lisa-launcher');
                const panel = document.getElementById('lisa-panel');
                const closeButton = document.getElementById('lisa-close');
                const messages = document.getElementById('lisa-messages');
                const chips = document.getElementById('lisa-chips');
                const form = document.getElementById('lisa-form');
                const input = document.getElementById('lisa-input');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const storageKey = 'lisa.chat.history';
                const openKey = 'lisa.chat.open';
                const quickReplies = [
                    'How do I use the E-books page?',
                    'Where is Reserve AVR?',
                    'How do gallery uploads work?'
                ];

                if (!widget || !launcher || !panel || !closeButton || !messages || !chips || !form || !input || !csrfToken) {
                    return;
                }

                let history = [];

                const welcomeMessage = {
                    role: 'assistant',
                    text: 'Hi, I’m Lisa — your MMACI Library guide. Ask me about collections, services, reservations, or how to use the site.'
                };

                function loadHistory() {
                    try {
                        history = JSON.parse(localStorage.getItem(storageKey) || '[]');
                    } catch (error) {
                        history = [];
                    }

                    if (!Array.isArray(history) || history.length === 0) {
                        history = [welcomeMessage];
                    }
                }

                function saveHistory() {
                    localStorage.setItem(storageKey, JSON.stringify(history.slice(-24)));
                }

                function scrollMessages() {
                    messages.scrollTop = messages.scrollHeight;
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

                    scrollMessages();
                }

                function renderChips(items) {
                    chips.innerHTML = '';

                    (items || []).forEach(function (item) {
                        const chip = document.createElement('button');
                        chip.type = 'button';
                        chip.className = 'lisa-chip';
                        chip.textContent = item;
                        chip.setAttribute('aria-label', 'Ask Lisa: ' + item);
                        chip.addEventListener('click', function () {
                            input.value = item;
                            input.focus();
                        }, { passive: true });
                        chips.appendChild(chip);
                    });
                }

                function openPanel() {
                    panel.hidden = false;
                    requestAnimationFrame(function () {
                        panel.classList.add('is-open');
                    });
                    localStorage.setItem(openKey, '1');
                    setTimeout(scrollMessages, 0);
                }

                function closePanel() {
                    panel.classList.remove('is-open');
                    localStorage.removeItem(openKey);
                    window.setTimeout(function () {
                        panel.hidden = true;
                    }, 180);
                }

                async function sendMessage(text) {
                    history.push({ role: 'user', text: text });
                    renderMessages();
                    saveHistory();

                    const typingId = 'typing-' + Date.now();
                    history.push({ role: 'assistant', text: 'Lisa is thinking…', id: typingId });
                    renderMessages();
                    saveHistory();

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

                        history = history.filter(function (entry) {
                            return entry.id !== typingId;
                        });

                        history.push({
                            role: 'assistant',
                            text: data.answer || 'I’m sorry, I could not find an answer right now.'
                        });

                        renderMessages();
                        renderChips(data.suggestions || quickReplies);
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

                input.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' && !event.shiftKey) {
                        event.preventDefault();
                        form.requestSubmit();
                    }
                });

                loadHistory();
                renderMessages();
                renderChips(quickReplies);

                if (localStorage.getItem(openKey) === '1') {
                    openPanel();
                } else {
                    panel.hidden = true;
                }
            })();
        </script>
    @endpush
@endonce
