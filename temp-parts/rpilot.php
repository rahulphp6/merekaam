<!-- AI Canvas Panel -->
<div id="aiCanvas" class="offcanvas offcanvas-end text-bg-dark" tabindex="-1">
    <div class="offcanvas-header dark-mode">
        <h6 class="offcanvas-title"><i class="fa fa-magic"></i> Rpilot AI</h6>
    </div>
    <div class="offcanvas-body">
        <div id="chatWindow" class="overflow-auto">
            <div id="defaultSuggestions" class="d-flex flex-wrap gap-2 mt-3">
                <div class="text-center p-5">
                    <img src="images/rpilot.png" alt="Rpilot AI" class="mb-3" style="width:100px;">
                    <h3>Your Personal <i class="fa fa-magic"></i> AI</h3>
                    <p class="text-sm">Hi! I’m Rpilot, your AI assistant for Rahulphp6. Ask me to fetch sales orders,
                        invoices, or orders tracking!<br><small>i'm just learning</small></p>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-2 dark-mode">
        <div class="position-relative">
            <div id="suggestionBox" class="position-absolute w-100 mt-1 z-3 scrolthin"></div>
            <div class="input-group">
                <button class="btn btn-info" onclick="startVoiceInput()">
                    <i class="fa fa-microphone"></i>
                </button>
                <input type="text" id="prompt" class="form-control bg-dark text-white border-secondary"
                    placeholder="Type your command..." autocomplete="off">
                <button class="btn btn-primary" onclick="sendPrompt()"><i class="fa fa-magic"></i> ASK</button>
                <span id="voiceStatus" class="ms-2 text-muted small"></span>
            </div>
        </div>
    </div>
</div>
<script>
    let activeModule = 'salesorders'; // default

    const moduleSuggestions = {
        salesorders: [
            "Show unpaid orders",
            "Add sales order for Rajesh Kumar with total 25000",
            "Show latest 10 sales orders",
            "Find orders by Vivek Menon",
            "Show orders from last week",
            "Switch to invoices"
        ],
        invoices: [
            "Show unpaid invoices",
            "Find invoices by Rajesh",
            "Show invoices due this week",
            "Show overdue invoices",
            "Due in 3 days",
            "Switch to salesorders"
        ]
    };

    const promptInput = document.getElementById('prompt');
    const suggestionBox = document.getElementById('suggestionBox');
    const chatWindow = document.getElementById('chatWindow');
    let activeIndex = -1;

    // 🔍 Fuzzy match
    const fuzzyMatch = (text, input) =>
        new RegExp(input.split('').map(c => c.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')).join('.*?')).test(text);

    // 🧠 Expand prompt
    function expandPrompt(input) {
        input = input.trim().toLowerCase();

        const reserved = ['sqlquery', '/sqlquery', '/debug', '/help'];
        if (reserved.includes(input)) return input;

        const statusList = ['pending', 'approved', 'cancelled', 'rejected', 'completed', 'unpaid', 'paid'];
        const hasStatus = statusList.some(s => input.includes(s));
        const hasFind = input.includes('find');
        const hasShow = input.includes('show');
        const hasOrders = input.includes('orders');
        const hasInvoices = input.includes('invoices');
        const hasInvoiceCreater = input.includes('invoice_creator');

        // ✅ Already a full command — don't expand
        if (
            /^find orders by /.test(input) ||
            /^find invoices by /.test(input) ||
            /^find invoice_creator by /.test(input) ||
            /^show orders with status /.test(input) ||
            /^show invoices with status /.test(input) ||
            /^show invoice_creator with status /.test(input)
        ) return input;

        // ❌ Mixed fragments — don't expand
        const mixedModules = (hasOrders && hasInvoices) || (hasOrders && hasInvoiceCreater) || (hasInvoices && hasInvoiceCreater);
        if ((hasFind && hasShow) || mixedModules) return input;

        // ✅ Expand status-only input
        if (statusList.includes(input)) {
            if (activeModule === 'salesorders') return `Show orders with status ${input}`;
            if (activeModule === 'invoices') return `Show invoices with status ${input}`;
            if (activeModule === 'invoice_creator') return `Show invoice_creator with status ${input}`;
        }

        // ✅ Expand name + status
        if (hasStatus && !hasFind && !hasShow) {
            const words = input.split(/\s+/);
            const status = words.find(w => statusList.includes(w));
            const name = words.filter(w => !statusList.includes(w)).join(' ');
            if (name && status) {
                if (activeModule === 'salesorders') return `Find orders by ${name} with status ${status}`;
                if (activeModule === 'invoices') return `Find invoices by ${name} with status ${status}`;
                if (activeModule === 'invoice_creator') return `Find invoice_creator by ${name} with status ${status}`;
            }
        }

        // ✅ Expand name-only input (safe fallback)
        if (input.length >= 3 && !hasFind && !hasShow && !hasStatus) {
            if (activeModule === 'salesorders') return `Find orders by ${input}`;
            if (activeModule === 'invoices') return `Find invoices by ${input}`;
            if (activeModule === 'invoice_creator') return `Find invoice_creator by ${input}`;
        }

        return input;
    }

    // 🚀 Send prompt
    function sendPrompt() {
        let prompt = promptInput.value.trim();
        if (!prompt) return;

        const expanded = expandPrompt(prompt);
        suggestionBox.innerHTML = ''; // 🧹 Clear suggestions on Enter

        if (expanded === 'switch to invoices') {
            activeModule = 'invoices';
            renderSuggestions();
        }
        if (expanded === 'switch to salesorders') {
            activeModule = 'salesorders';
            renderSuggestions();
        }
        if (expanded === 'switch to invoice_creator') {
            switchModule('invoice_creator');
            return;
        }

        appendMessage(expanded, 'user');
        appendMessage('<span class="typing">🤖 Typing...</span>', 'ai');
        const typingBubbleRow = document.querySelector('#chatWindow .typing')?.closest('.d-flex');

        fetch('rpfiles/rpilot/ai-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'prompt=' + encodeURIComponent(expanded)
        })
            .then(res => res.text())
            .then(data => {
                typingBubbleRow?.remove();
                try {
                    const parsed = JSON.parse(data);
                    if (Array.isArray(parsed)) {
                        parsed.forEach(item => {
                            let html = '';

                            if (item.salesorder_number) html += `<div><strong>📦</strong> ${item.salesorder_number}</div>`;
                            if (item.customer_name) html += `<div><a href='?page'><strong>👤</strong> ${item.customer_name}</div></a>`;
                            if (item.total) html += `<div><strong>💰</strong> AED.${item.total}</div>`;
                            if (item.paid_status) html += `<div><strong>🧾</strong> ${item.paid_status}</div>`;
                            if (item.date) html += `<div><strong><i class='fa fa-calendar'></i></strong> ${item.date}</div>`;

                            if (item.invoice_number) html += `<div><strong>🧾 Invoice</strong> ${item.invoice_number}</div>`;
                            if (item.due_date) html += `<div><strong>📅 Due</strong> ${item.due_date}</div>`;
                            if (item.status) html += `<div><strong>📌 Status</strong> ${item.status}</div>`;

                            appendMessage(html || '⚠️ No displayable data found.', 'ai');
                        });
                    } else {
                        appendMessage(data, 'ai');
                    }
                } catch {
                    appendMessage(data, 'ai');
                }
            });

        promptInput.value = '';
    } // 💬 Append message
    function appendMessage(text, sender = 'ai') {
        const row = document.createElement('div');
        row.className = `d-flex mb-2 ${sender === 'user' ? 'justify-content-end' : 'justify-content-start'}`;

        const avatar = document.createElement('img');
        avatar.src = sender === 'user' ? '<?php echo $getDp; ?>' : 'images/pos.png';
        avatar.alt = sender === 'user' ? 'You' : 'AI';
        avatar.className = 'rounded-circle me-2';
        avatar.style.width = avatar.style.height = '32px';

        const bubble = document.createElement('div');
        bubble.className = `p-2 px-3 rounded-3 ${sender === 'user' ? 'bg-primary text-white' : 'bg-light text-dark'}`;
        bubble.style.maxWidth = '75%';
        bubble.innerHTML = text;

        sender === 'user' ? row.append(bubble, avatar) : row.append(avatar, bubble);
        chatWindow.appendChild(row);
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }

    // 🧠 Render static suggestions
    function renderSuggestions() {
        suggestionBox.innerHTML = '';
        activeIndex = -1;
        moduleSuggestions[activeModule].forEach(text => {
            const item = document.createElement('div');
            item.className = 'suggestion-item';
            item.textContent = text;
            item.onclick = () => {
                promptInput.value = text;
                promptInput.focus();
                suggestionBox.innerHTML = '';
            };
            suggestionBox.appendChild(item);
        });
    }

    // 🔁 Live suggestions
    promptInput.addEventListener('input', () => {
        const query = promptInput.value.trim();
        suggestionBox.innerHTML = '';
        activeIndex = -1;
        if (query.length < 2) return;

        fetch('rpfiles/rpilot/live-suggest.php?q=' + encodeURIComponent(query))
            .then(res => res.json())
            .then(suggestions => {
                suggestions.forEach(match => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.textContent = match;
                    item.onclick = () => {
                        promptInput.value = match;
                        promptInput.focus();
                        suggestionBox.innerHTML = '';
                    };
                    suggestionBox.appendChild(item);
                });
            });
    });

    // ⌨️ Keyboard navigation + Enter
    promptInput.addEventListener('keydown', e => {
        const items = suggestionBox.querySelectorAll('.suggestion-item');
        if (items.length && (e.key === 'ArrowDown' || e.key === 'ArrowUp')) {
            e.preventDefault();
            activeIndex = e.key === 'ArrowDown'
                ? (activeIndex + 1) % items.length
                : (activeIndex - 1 + items.length) % items.length;
            items.forEach((el, i) => el.classList.toggle('active', i === activeIndex));
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (activeIndex >= 0) {
                items[activeIndex].click();
            } else {
                sendPrompt();
            }
        }
    });

    // 🖱️ Outside click clears suggestions
    document.addEventListener('click', e => {
        if (!suggestionBox.contains(e.target) && e.target !== promptInput)
            suggestionBox.innerHTML = '';
    });

    // 🧠 Suggestion buttons
    document.querySelectorAll('.suggestion-btn').forEach(btn =>
        btn.addEventListener('click', () => {
            promptInput.value = btn.textContent;
            document.getElementById('sendBtn').click();
        })
    );

    // 🚀 Initial render
    window.addEventListener('DOMContentLoaded', renderSuggestions);

    // 🎙️ Voice input
    let recognition, isListening = false;

    function startVoiceInput() {
        if (!('webkitSpeechRecognition' in window)) {
            alert('Voice input not supported.');
            return;
        }

        if (!recognition) {
            recognition = new webkitSpeechRecognition();
            recognition.lang = 'en-IN';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.onstart = () => {
                isListening = true;
                document.getElementById('voiceStatus').textContent = '🎙️ Listening...';
            };

            recognition.onresult = e => {
                const transcript = e.results[0][0].transcript;
                promptInput.value = transcript;
                document.getElementById('voiceStatus').textContent = '✅ Got it!';
                sendPrompt();
            };

            recognition.onerror = e => {
                document.getElementById('voiceStatus').textContent = '❌ Error: ' + e.error;
            };

            recognition.onend = () => {
                isListening = false;
                setTimeout(() => {
                    document.getElementById('voiceStatus').textContent = '';
                }, 2000);
            };
        }

        if (!isListening) recognition.start();
    }
    // 🧩 Canvas toggle
    function toggleCanvas() {
        bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('aiCanvas')).toggle();
    }
</script>