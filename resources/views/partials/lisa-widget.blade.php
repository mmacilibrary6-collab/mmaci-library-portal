@php
    $lisaAvatar = 'https://static.vecteezy.com/system/resources/previews/054/064/121/non_2x/young-girl-reading-in-library-illustration-for-education-and-learning-themes-free-vector.jpg';
@endphp

<div id="lisa-chatbot-widget" class="lisa-chatbot-widget" aria-live="polite" style="position:fixed!important;right:24px!important;bottom:24px!important;left:auto!important;top:auto!important;width:auto!important;height:auto!important;margin:0!important;padding:0!important;z-index:2147483000!important;isolation:isolate!important;display:block!important;pointer-events:auto!important;transform:none!important;float:none!important;clear:both!important;">
    <button
        type="button"
        id="lisa-chat-launcher"
        class="lisa-chat-launcher"
        style="width:60px!important;height:60px!important;min-width:60px!important;min-height:60px!important;max-width:60px!important;max-height:60px!important;display:grid!important;"
        aria-label="Open Lisa chat">
        <img src="{{ $lisaAvatar }}" alt="Lisa avatar" class="lisa-chat-avatar" style="width:100%!important;height:100%!important;display:block!important;object-fit:cover!important;">
    </button>

    <section
        id="lisa-chat-panel"
        class="lisa-chat-panel"
        hidden
        aria-label="Lisa chatbot"
        style="position:absolute!important;right:72px!important;bottom:0!important;width:350px!important;height:480px!important;max-width:calc(100vw - 32px)!important;max-height:calc(100dvh - 120px)!important;overflow:hidden!important;display:none!important;margin:0!important;padding:0!important;transform:none!important;border-radius:12px!important;">
        <header class="lisa-chat-header">
            <div class="lisa-chat-header-left">
                <img src="{{ $lisaAvatar }}" alt="Lisa avatar" class="lisa-chat-header-avatar" style="width:36px!important;height:36px!important;display:block!important;object-fit:cover!important;">
                <div class="lisa-chat-header-copy">
                    <strong>Lisa</strong>
                    <span>MMACI Library Guide</span>
                </div>
            </div>

            <button type="button" id="lisa-chat-close" class="lisa-chat-icon-button" aria-label="Close Lisa chat">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
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

            <button type="submit" class="lisa-chat-send" aria-label="Send message">
                <i class="bi bi-send-fill" aria-hidden="true"></i>
            </button>
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
                left: auto !important;
                top: auto !important;
                width: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                z-index: 2147483000 !important;
                isolation: isolate;
                contain: layout paint;
            }

            #lisa-chatbot-widget .lisa-chat-launcher {
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
                animation: lisa-bob 3.6s ease-in-out infinite;
            }

            #lisa-chatbot-widget .lisa-chat-launcher:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 38px rgba(11, 46, 89, 0.34);
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
                right: 0 !important;
                bottom: 72px !important;
                width: 350px !important;
                height: 480px !important;
                max-width: calc(100vw - 32px) !important;
                max-height: calc(100dvh - 120px) !important;
                overflow: hidden !important;
                display: flex;
                flex-direction: column;
                border-radius: 12px;
                background: #f8fafc;
                border: 1px solid rgba(11, 46, 89, 0.12);
                box-shadow: 0 24px 60px rgba(11, 46, 89, 0.24);
                transform: translateX(12px) scale(0.98);
                opacity: 0;
                pointer-events: none;
                transition: transform 0.2s ease, opacity 0.2s ease;
            }

            #lisa-chatbot-widget .lisa-chat-panel.is-open {
                opacity: 1;
                pointer-events: auto;
                transform: translateX(0) scale(1);
            }

            #lisa-chatbot-widget [hidden] {
                display: none !important;
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
                border: 2px solid rgba(255, 255, 255, 0.55);
                background: #fff;
                object-fit: cover;
                flex: 0 0 auto;
            }

            #lisa-chatbot-widget .lisa-chat-header-copy {
                display: flex;
                flex-direction: column;
                min-width: 0;
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
                border-radius: 22px;
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
                border-top-left-radius: 16px;
            }

            #lisa-chatbot-widget .lisa-chat-message.user .lisa-chat-bubble {
                background: #184b8c;
                color: #ffffff;
                border-top-right-radius: 16px;
            }

            #lisa-chatbot-widget .lisa-chat-chips {
                flex: 0 0 auto;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 0 14px 12px;
                max-height: 92px;
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
                transition: background 0.18s ease, transform 0.18s ease, border-color 0.18s ease;
            }

            #lisa-chatbot-widget .lisa-chat-chip:hover {
                transform: translateY(-1px);
                background: #eaf0f8;
                border-color: #c9d7ea;
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

            @media (max-width: 576px) {
                #lisa-chatbot-widget {
                    right: 12px !important;
                    bottom: calc(12px + env(safe-area-inset-bottom)) !important;
                }

                #lisa-chatbot-widget .lisa-chat-launcher {
                    width: 52px !important;
                    height: 52px !important;
                }

                #lisa-chatbot-widget .lisa-chat-panel {
                    right: 0 !important;
                    bottom: 64px !important;
                    width: min(350px, calc(100vw - 24px)) !important;
                    height: min(480px, calc(100dvh - 100px)) !important;
                }
            }

            @keyframes lisa-bob {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-6px);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                #lisa-chatbot-widget .lisa-chat-launcher,
                #lisa-chatbot-widget .lisa-chat-panel,
                #lisa-chatbot-widget .lisa-chat-chip {
                    transition: none;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                if (window.__lisaChatbotInitialized) {
                    return;
                }

                window.__lisaChatbotInitialized = true;

                const widget = document.getElementById('lisa-chatbot-widget');
                const launcher = document.getElementById('lisa-chat-launcher');
                const panel = document.getElementById('lisa-chat-panel');
                const closeButton = document.getElementById('lisa-chat-close');
                const messages = document.getElementById('lisa-chat-messages');
                const chips = document.getElementById('lisa-chat-chips');
                const form = document.getElementById('lisa-chat-form');
                const input = document.getElementById('lisa-chat-input');
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

                if (widget.parentElement !== document.body) {
                    document.body.appendChild(widget);
                }

                widget.style.position = 'fixed';
                widget.style.right = '24px';
                widget.style.bottom = '24px';
                widget.style.left = 'auto';
                widget.style.top = 'auto';
                widget.style.width = 'auto';
                widget.style.height = 'auto';
                widget.style.margin = '0';
                widget.style.padding = '0';
                widget.style.zIndex = '2147483000';
                widget.style.isolation = 'isolate';
                widget.style.display = 'block';
                widget.style.pointerEvents = 'auto';
                widget.style.transform = 'none';
                widget.style.float = 'none';
                widget.style.clear = 'both';
                widget.style.contain = 'layout paint';

                launcher.style.width = '60px';
                launcher.style.height = '60px';
                launcher.style.minWidth = '60px';
                launcher.style.minHeight = '60px';
                launcher.style.maxWidth = '60px';
                launcher.style.maxHeight = '60px';
                launcher.style.display = 'grid';

                panel.style.position = 'absolute';
                panel.style.right = '72px';
                panel.style.bottom = '0';
                panel.style.width = '350px';
                panel.style.height = '480px';
                panel.style.maxWidth = 'calc(100vw - 32px)';
                panel.style.maxHeight = 'calc(100dvh - 120px)';
                panel.style.overflow = 'hidden';
                panel.style.display = 'none';
                panel.style.margin = '0';
                panel.style.padding = '0';
                panel.style.transform = 'none';
                panel.style.borderRadius = '12px';

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
                        row.className = 'lisa-chat-message ' + (entry.role === 'user' ? 'user' : 'bot');

                        const bubble = document.createElement('div');
                        bubble.className = 'lisa-chat-bubble';
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
                        chip.className = 'lisa-chat-chip';
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
                    panel.style.display = 'flex';
                    panel.classList.add('is-open');
                    localStorage.setItem(openKey, '1');
                    setTimeout(scrollMessages, 0);
                }

                function closePanel() {
                    panel.classList.remove('is-open');
                    localStorage.removeItem(openKey);
                    setTimeout(function () {
                        panel.style.display = 'none';
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
                    panel.style.display = 'none';
                }

                const applyResponsivePanelPlacement = () => {
                    if (window.matchMedia('(max-width: 576px)').matches) {
                        panel.style.right = '0';
                        panel.style.bottom = '64px';
                    } else {
                        panel.style.right = '72px';
                        panel.style.bottom = '0';
                    }
                };

                applyResponsivePanelPlacement();
                window.addEventListener('resize', applyResponsivePanelPlacement, { passive: true });
            })();
        </script>
    @endpush
@endonce
