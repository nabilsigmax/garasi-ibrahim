<!-- FLOATING CHAT WIDGET -->
<div id="garasi-chat-widget" class="fixed bottom-6 right-6 z-50 font-sans">

    @auth
        <!-- Floating Trigger Button -->
        <button id="chat-toggle-btn" onclick="toggleGarasiChat()" class="relative group bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-2xl flex items-center gap-3 transition-all duration-300 transform hover:scale-105 active:scale-95 focus:outline-none">
            <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 border-2 border-white"></span>
            </span>
            <i class="fas fa-comments text-xl"></i>
            <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 text-xs font-bold whitespace-nowrap">
                Chat Admin
            </span>
        </button>

        <!-- Chat Modal Box -->
        <div id="chat-popup-box" class="hidden w-[90vw] sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden flex flex-col transition-all duration-300 animate-in fade-in zoom-in-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-slate-900 to-blue-900 text-white p-4 flex justify-between items-center shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow-inner">
                            <i class="fas fa-headset text-sm"></i>
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></span>
                    </div>
                    <div>
                        <h4 class="font-bold text-xs tracking-wide flex items-center gap-1.5">
                            Customer Support
                            <span class="bg-blue-500/30 text-blue-200 text-[9px] px-1.5 py-0.5 rounded font-normal">Online</span>
                        </h4>
                        <p class="text-[10px] text-slate-300">Garasi Ibrahim Support Center</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="refreshGarasiMessages()" title="Refresh Percakapan" class="text-slate-300 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
                        <i id="chat-refresh-icon" class="fas fa-rotate-right text-xs"></i>
                    </button>
                    <button onclick="toggleGarasiChat()" class="text-slate-300 hover:text-white p-1.5 rounded-lg hover:bg-white/10 text-base font-bold transition">&times;</button>
                </div>
            </div>

            <!-- Quick Questions Chips -->
            <div class="bg-slate-50 px-3 py-2 border-b border-gray-100 flex gap-1.5 overflow-x-auto text-[10px] no-scrollbar">
                <button type="button" onclick="sendQuickReply('Halo Admin, apakah unit mobil ini masih tersedia?')" class="bg-white border border-gray-200 hover:border-blue-500 hover:text-blue-600 text-slate-600 px-2.5 py-1 rounded-full whitespace-nowrap transition shadow-2xs">
                    🚗 Ketersediaan Unit
                </button>
                <button type="button" onclick="sendQuickReply('Halo, boleh minta info simulasi kredit & hitungan TDP?')" class="bg-white border border-gray-200 hover:border-blue-500 hover:text-blue-600 text-slate-600 px-2.5 py-1 rounded-full whitespace-nowrap transition shadow-2xs">
                    💳 Simulasi Kredit
                </button>
                <button type="button" onclick="sendQuickReply('Halo, alamat showroom Garasi Ibrahim di mana ya?')" class="bg-white border border-gray-200 hover:border-blue-500 hover:text-blue-600 text-slate-600 px-2.5 py-1 rounded-full whitespace-nowrap transition shadow-2xs">
                    📍 Lokasi Showroom
                </button>
            </div>

            <!-- Messages Thread -->
            <div id="garasi-chat-messages" class="p-4 h-80 overflow-y-auto space-y-3 bg-slate-50/70 text-xs">
                <div class="text-center text-slate-400 py-10 flex flex-col items-center justify-center gap-2">
                    <i class="fas fa-circle-notch fa-spin text-xl text-blue-500"></i>
                    <p class="text-[11px]">Menghubungkan ke Admin...</p>
                </div>
            </div>

            <!-- Input Box -->
            <form id="garasi-chat-form" onsubmit="submitGarasiUserMessage(event)" class="p-3 bg-white border-t border-gray-200 flex items-center gap-2">
                <input type="text" id="garasi-chat-input" placeholder="Tulis pesan Anda..." class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition" required autocomplete="off">
                <button type="submit" id="garasi-chat-send-btn" class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold transition shrink-0 shadow-sm">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>

    @else
        <!-- Guest Trigger Button (Prompts Login) -->
        <button onclick="toggleGuestChatNotice()" class="relative group bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-2xl flex items-center gap-3 transition-all duration-300 transform hover:scale-105 active:scale-95">
            <i class="fas fa-comments text-xl"></i>
            <span class="text-xs font-bold pr-1">Chat Admin</span>
        </button>

        <!-- Guest Notice Popup -->
        <div id="guest-chat-notice" class="hidden w-80 bg-white rounded-2xl shadow-2xl border border-gray-200 p-5 text-center transition-all animate-in fade-in">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 text-lg">
                <i class="fas fa-user-lock"></i>
            </div>
            <h4 class="font-bold text-sm text-slate-900 mb-1">Masuk untuk Mengobrol</h4>
            <p class="text-xs text-slate-500 mb-4 leading-relaxed">Silakan masuk ke akun Anda agar pesan tersimpan dengan aman dan dapat dibalas oleh Admin.</p>
            <div class="flex gap-2">
                <a href="{{ route('login') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-xs transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs transition">
                    Daftar
                </a>
            </div>
            <button onclick="toggleGuestChatNotice()" class="mt-3 text-[11px] text-slate-400 hover:underline">Tutup</button>
        </div>
    @endauth

</div>

<script>
    @auth
        const garasiCurrentUserId = {{ auth()->id() }};
        let garasiChatRoomId = null;
        let garasiChatInterval = null;
        let garasiLastMessagesJson = '';

        function toggleGarasiChat() {
            const popup = document.getElementById('chat-popup-box');
            const toggleBtn = document.getElementById('chat-toggle-btn');
            
            popup.classList.toggle('hidden');
            
            if (!popup.classList.contains('hidden')) {
                toggleBtn.classList.add('hidden');
                initGarasiChat();
            } else {
                toggleBtn.classList.remove('hidden');
                if (garasiChatInterval) clearInterval(garasiChatInterval);
            }
        }

        async function initGarasiChat() {
            try {
                const res = await fetch("{{ route('chat.room') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data && data.id) {
                    garasiChatRoomId = data.id;
                    await fetchGarasiMessages();
                    if (garasiChatInterval) clearInterval(garasiChatInterval);
                    garasiChatInterval = setInterval(fetchGarasiMessages, 2500);
                }
            } catch (err) {
                console.error("Gagal inisialisasi chat room:", err);
            }
        }

        async function fetchGarasiMessages() {
            if (!garasiChatRoomId) return;

            try {
                const res = await fetch(`/chat/${garasiChatRoomId}/messages`);
                const messages = await res.json();
                const jsonStr = JSON.stringify(messages);

                if (jsonStr === garasiLastMessagesJson) return;
                garasiLastMessagesJson = jsonStr;

                const container = document.getElementById('garasi-chat-messages');
                container.innerHTML = '';

                if (!messages || messages.length === 0) {
                    container.innerHTML = `
                        <div class="text-center text-slate-400 py-10 bg-white rounded-xl border border-dashed border-gray-200 p-4">
                            <i class="fas fa-hand-wave text-blue-500 text-2xl mb-2"></i>
                            <p class="font-bold text-slate-700 text-xs">Halo, {{ auth()->user()->name }}!</p>
                            <p class="text-[11px] text-slate-400 mt-1">Ada yang bisa kami bantu seputar unit kendaraan atau pembelian? Tulis pesan di bawah.</p>
                        </div>
                    `;
                    return;
                }

                messages.forEach(msg => {
                    const isMe = Number(msg.sender_id) === Number(garasiCurrentUserId);
                    const senderLabel = isMe ? 'Anda' : (msg.sender_role === 'admin' ? 'Admin Garasi' : escapeHtml(msg.sender_name));

                    container.innerHTML += `
                        <div class="flex flex-col ${isMe ? 'items-end' : 'items-start'} w-full">
                            <div class="flex items-center gap-1.5 mb-1 px-1">
                                <span class="text-[10px] font-bold ${isMe ? 'text-blue-600' : 'text-slate-600'}">${senderLabel}</span>
                                <span class="text-[9px] text-slate-400">${msg.time || ''}</span>
                            </div>
                            <div class="${isMe ? 'bg-blue-600 text-white rounded-2xl rounded-tr-none shadow-sm' : 'bg-white text-slate-800 border border-gray-200 rounded-2xl rounded-tl-none shadow-sm'} px-3.5 py-2.5 max-w-[85%] text-xs break-words leading-relaxed">
                                ${escapeHtml(msg.message)}
                            </div>
                        </div>
                    `;
                });

                container.scrollTop = container.scrollHeight;
            } catch (err) {
                console.error("Gagal mengambil pesan:", err);
            }
        }

        async function submitGarasiUserMessage(e) {
            e.preventDefault();
            const input = document.getElementById('garasi-chat-input');
            const message = input.value.trim();
            if (!message || !garasiChatRoomId) return;

            const sendBtn = document.getElementById('garasi-chat-send-btn');
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            try {
                const res = await fetch("{{ route('chat.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        chat_room_id: garasiChatRoomId,
                        message: message
                    })
                });

                if (res.ok) {
                    input.value = '';
                    await fetchGarasiMessages();
                }
            } catch (err) {
                console.error("Gagal mengirim pesan:", err);
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                input.focus();
            }
        }

        function sendQuickReply(text) {
            const input = document.getElementById('garasi-chat-input');
            input.value = text;
            input.focus();
        }

        function refreshGarasiMessages() {
            const icon = document.getElementById('chat-refresh-icon');
            if (icon) icon.classList.add('fa-spin');
            garasiLastMessagesJson = '';
            fetchGarasiMessages().finally(() => {
                setTimeout(() => { if (icon) icon.classList.remove('fa-spin'); }, 500);
            });
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.innerText = text;
            return div.innerHTML;
        }
    @else
        function toggleGuestChatNotice() {
            const notice = document.getElementById('guest-chat-notice');
            notice.classList.toggle('hidden');
        }
    @endauth
</script>   
