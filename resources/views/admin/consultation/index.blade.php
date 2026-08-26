<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Chat Admin - Garasi Ibrahim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between p-6 shrink-0">
            <div>
                <h1 class="text-xl font-extrabold tracking-wider mb-8">PANEL<span class="text-blue-500">ADMIN</span></h1>
                <nav class="space-y-3">
                    <a href="{{ route('admin.index') }}" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
                        <i class="fas fa-car"></i> Kelola Mobil
                    </a>
                    <a href="{{ route('admin.consultation') }}" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium bg-blue-600 text-white transition">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-comments"></i> Chat Pelanggan
                        </div>
                        <span class="bg-blue-500/30 text-blue-300 text-[10px] px-2 py-0.5 rounded-full">Live</span>
                    </a>
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 hover:bg-slate-800 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white transition">
                        <i class="fas fa-globe"></i> Lihat Website
                    </a>
                </nav>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:bg-red-900/30 transition">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Konsultasi Pelanggan</h2>
                    <p class="text-xs text-gray-500">Balas percakapan pelanggan yang membutuhkan informasi secara real-time.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="pollAdminRooms()" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 shadow-2xs transition">
                        <i id="room-refresh-spinner" class="fas fa-arrows-rotate text-blue-600"></i> Refresh Daftar
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex h-[620px]">
                <!-- Sidebar Daftar Pelanggan (1/3) -->
                <div class="w-1/3 border-r border-gray-200 flex flex-col bg-slate-50/50">
                    <!-- Search Bar -->
                    <div class="p-3 border-b border-gray-200 bg-white">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                            <input type="text" id="search-customer" oninput="filterCustomerList()" placeholder="Cari nama / WhatsApp..." class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                        </div>
                    </div>

                    <!-- Room List Container -->
                    <div id="room-list" class="flex-1 overflow-y-auto divide-y divide-gray-100">
                        @forelse($chatRooms ?? [] as $room)
                            @php
                                $lastMsg = $room->messages->first();
                                $userName = $room->user->name ?? 'Pelanggan';
                                $userPhone = $room->user->phone ?? '';
                                $userEmail = $room->user->email ?? '';
                                $firstChar = strtoupper(substr($userName, 0, 1));
                                $unreadCount = $room->messages->where('sender_role', 'user')->where('is_read', false)->count();
                            @endphp
                            <div id="room-item-{{ $room->id }}"
                                 onclick="selectRoom({{ $room->id }}, {{ $room->user_id }}, '{{ addslashes($userName) }}', '{{ addslashes($userPhone) }}', '{{ addslashes($userEmail) }}')"
                                 data-name="{{ strtolower($userName) }}"
                                 data-phone="{{ strtolower($userPhone) }}"
                                 data-email="{{ strtolower($userEmail) }}"
                                 class="room-card p-3.5 hover:bg-blue-50/60 cursor-pointer transition flex items-start gap-3 bg-white border-l-4 border-transparent">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-sm">
                                    {{ $firstChar }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline mb-0.5">
                                        <h4 class="font-bold text-xs text-gray-900 truncate">{{ $userName }}</h4>
                                        <div class="flex items-center gap-1 shrink-0 ml-1">
                                            @if(!empty($unreadCount) && $unreadCount > 0)
                                                <span class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shrink-0">
                                                    {{ $unreadCount }} baru
                                                </span>
                                            @endif
                                            <span class="text-[10px] text-gray-400 font-medium">{{ $lastMsg ? $lastMsg->created_at->format('H:i') : '' }}</span>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-500 truncate room-last-msg">
                                        {{ $lastMsg ? $lastMsg->message : 'Belum ada pesan' }}
                                    </p>
                                    @if($userPhone)
                                        <span class="inline-flex items-center gap-1 text-[9px] text-emerald-600 font-semibold mt-1 bg-emerald-50 px-1.5 py-0.5 rounded">
                                            <i class="fab fa-whatsapp"></i> {{ $userPhone }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-xs text-gray-400">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-2 block"></i>
                                Belum ada ruang konsultasi yang aktif.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Room Percakapan & Input Pesan (2/3) -->
                <div class="w-2/3 flex flex-col bg-white">
                    <!-- Chat Header -->
                    <div id="chat-header" class="p-3.5 border-b border-gray-200 text-xs bg-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-500">
                            <i class="fas fa-comments text-blue-500 text-base"></i>
                            <span>Pilih pelanggan di panel kiri untuk membuka obrolan.</span>
                        </div>
                    </div>

                    <!-- Messages Thread -->
                    <div id="admin-messages" class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50/40 text-xs">
                        <div class="text-center text-xs text-gray-400 mt-28">
                            <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fas fa-comments"></i>
                            </div>
                            <p class="font-bold text-gray-700">Belum Ada Percakapan Dipilih</p>
                            <p class="text-[11px] text-gray-400 mt-1">Klik salah satu pelanggan dari daftar di sebelah kiri untuk mulai merespons.</p>
                        </div>
                    </div>

                    <!-- Canned Quick Replies -->
                    <div id="admin-quick-replies" class="px-3 py-2 bg-white border-t border-gray-100 flex gap-1.5 overflow-x-auto text-[10px] hidden no-scrollbar">
                        <button type="button" onclick="useAdminTemplate('Halo! Ada yang bisa kami bantu seputar unit mobil kami?')" class="bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-gray-200 px-2.5 py-1 rounded-full whitespace-nowrap transition">
                            👋 Sapaan
                        </button>
                        <button type="button" onclick="useAdminTemplate('Unit mobil ini masih tersedia dan siap untuk cek unit / test drive.')" class="bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-gray-200 px-2.5 py-1 rounded-full whitespace-nowrap transition">
                            🚗 Unit Tersedia
                        </button>
                        <button type="button" onclick="useAdminTemplate('Bisa kami bantu buatkan simulasi hitungan TDP & angsuran per bulannya?')" class="bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-gray-200 px-2.5 py-1 rounded-full whitespace-nowrap transition">
                            💳 Simulasi Kredit
                        </button>
                        <button type="button" onclick="useAdminTemplate('Showroom kami beralamat di Jl. Trunojoyo No. 09, Malang. Buka setiap hari pukul 09.00 - 18.00.')" class="bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-gray-200 px-2.5 py-1 rounded-full whitespace-nowrap transition">
                            📍 Lokasi
                        </button>
                    </div>

                    <!-- Input Form -->
                    <form id="admin-form" onsubmit="sendAdminMessage(event)" class="p-3 border-t border-gray-200 bg-white flex gap-2 hidden">
                        <input type="text" id="admin-input" placeholder="Tulis balasan pesan untuk pelanggan..." class="flex-1 px-3.5 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 bg-slate-50 focus:bg-white transition" required autocomplete="off">
                        <button type="submit" id="admin-send-btn" class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm shrink-0">
                            <i class="fas fa-paper-plane text-[10px]"></i> Kirim
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        let selectedRoomId = null;
        let selectedRoomUserId = null;
        let selectedCustomerName = '';
        let selectedCustomerPhone = '';
        let selectedCustomerEmail = '';
        let autoRefreshInterval = null;
        let adminRoomsInterval = null;
        let lastAdminMessagesJson = '';

        function selectRoom(roomId, roomUserId, userName, userPhone = '', userEmail = '') {
            selectedRoomId = Number(roomId);
            selectedRoomUserId = Number(roomUserId);
            selectedCustomerName = userName;
            selectedCustomerPhone = userPhone;
            selectedCustomerEmail = userEmail;

            // Highlight active room card
            document.querySelectorAll('.room-card').forEach(el => {
                el.classList.remove('bg-blue-50/80', 'border-blue-600');
                el.classList.add('border-transparent');
            });
            const activeCard = document.getElementById(`room-item-${roomId}`);
            if (activeCard) {
                activeCard.classList.add('bg-blue-50/80', 'border-blue-600');
                activeCard.classList.remove('border-transparent');
                const badge = activeCard.querySelector('.bg-red-500');
                if (badge) badge.remove();
            }

            // Build dynamic header
            const cleanPhone = (userPhone || '').replace(/[^0-9]/g, '');
            const waPhone = cleanPhone.startsWith('0') ? '62' + cleanPhone.substring(1) : cleanPhone;
            const waBtn = userPhone ? `
                <a href="https://wa.me/${waPhone}?text=Halo%20${encodeURIComponent(userName)},%20kami%20dari%20Garasi%20Ibrahim..." target="_blank" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition shadow-xs">
                    <i class="fab fa-whatsapp"></i> Chat WhatsApp
                </a>
            ` : '';

            document.getElementById('chat-header').innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                        ${userName.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-xs">${escapeHtml(userName)}</h4>
                        <p class="text-[10px] text-gray-400">${escapeHtml(userEmail || userPhone || 'Pelanggan')}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    ${waBtn}
                    <button onclick="deleteChatRoom(event, ${roomId})" title="Hapus Riwayat Chat" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg text-xs transition">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;

            document.getElementById('admin-form').classList.remove('hidden');
            document.getElementById('admin-quick-replies').classList.remove('hidden');

            lastAdminMessagesJson = '';
            loadAdminMessages();

            if (autoRefreshInterval) clearInterval(autoRefreshInterval);
            autoRefreshInterval = setInterval(loadAdminMessages, 2500);
        }

        async function loadAdminMessages() {
            if (!selectedRoomId) return;

            try {
                const res = await fetch(`/chat/${selectedRoomId}/messages`);
                const messages = await res.json();
                const jsonStr = JSON.stringify(messages);

                if (jsonStr === lastAdminMessagesJson) return;
                lastAdminMessagesJson = jsonStr;

                const container = document.getElementById('admin-messages');
                container.innerHTML = '';

                if (!messages || messages.length === 0) {
                    container.innerHTML = `
                        <div class="text-center text-gray-400 py-16">
                            <i class="fas fa-comments text-3xl text-gray-200 mb-2 block"></i>
                            <p class="font-bold text-gray-600">Belum ada riwayat pesan.</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Kirim pesan pertama atau gunakan template balasan cepat di bawah.</p>
                        </div>
                    `;
                    return;
                }

                messages.forEach(msg => {
                    // Jika pesan dikirim oleh customer (pemilik room), letakkan di KIRI.
                    // Jika pesan dikirim oleh Admin / support, letakkan di KANAN.
                    const isCustomer = (Number(msg.sender_id) === Number(selectedRoomUserId)) || (Number(msg.room_user_id) === Number(msg.sender_id) && Number(msg.sender_id) !== Number({{ auth()->id() ?? 0 }}));
                    const isMe = !isCustomer;
                    const senderLabel = isMe ? 'Admin (Anda)' : escapeHtml(msg.sender_name || selectedCustomerName || 'Pelanggan');

                    container.innerHTML += `
                        <div class="flex flex-col ${isMe ? 'items-end' : 'items-start'} w-full">
                            <div class="flex items-center gap-1.5 mb-1 px-1">
                                <span class="text-[10px] font-bold ${isMe ? 'text-blue-600' : 'text-gray-700'}">${senderLabel}</span>
                                <span class="text-[9px] text-gray-400">${msg.time || ''}</span>
                            </div>
                            <div class="${isMe ? 'bg-blue-600 text-white rounded-2xl rounded-tr-none shadow-xs' : 'bg-white text-gray-800 border border-gray-200 rounded-2xl rounded-tl-none shadow-xs'} px-3.5 py-2.5 max-w-[75%] text-xs break-words leading-relaxed">
                                ${escapeHtml(msg.message)}
                            </div>
                        </div>
                    `;
                });
                container.scrollTop = container.scrollHeight;
            } catch (error) {
                console.error("Gagal memuat pesan chat:", error);
            }
        }

        async function sendAdminMessage(e) {
            e.preventDefault();
            const input = document.getElementById('admin-input');
            const messageText = input.value.trim();
            if (!messageText || !selectedRoomId) return;

            const sendBtn = document.getElementById('admin-send-btn');
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin text-[10px]"></i>';

            try {
                const res = await fetch("{{ route('chat.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        chat_room_id: selectedRoomId,
                        message: messageText
                    })
                });

                if (res.ok) {
                    input.value = '';
                    await loadAdminMessages();
                    pollAdminRooms();
                }
            } catch (err) {
                console.error("Gagal mengirim pesan admin:", err);
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fas fa-paper-plane text-[10px]"></i> Kirim';
                input.focus();
            }
        }

        function useAdminTemplate(text) {
            const input = document.getElementById('admin-input');
            input.value = text;
            input.focus();
        }

        function filterCustomerList() {
            const query = (document.getElementById('search-customer').value || '').toLowerCase().trim();
            document.querySelectorAll('.room-card').forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const phone = card.getAttribute('data-phone') || '';
                const email = card.getAttribute('data-email') || '';

                if (!query || name.includes(query) || phone.includes(query) || email.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        async function pollAdminRooms() {
            const spinner = document.getElementById('room-refresh-spinner');
            if (spinner) spinner.classList.add('fa-spin');

            try {
                const res = await fetch("{{ route('chat.admin.rooms') }}");
                if (!res.ok) return;
                const rooms = await res.json();

                const container = document.getElementById('room-list');
                if (!rooms || rooms.length === 0) {
                    container.innerHTML = `
                        <div class="p-8 text-center text-xs text-gray-400">
                            <i class="fas fa-inbox text-3xl text-gray-300 mb-2 block"></i>
                            Belum ada ruang konsultasi yang aktif.
                        </div>`;
                    return;
                }

                let html = '';
                rooms.forEach(r => {
                    const isActive = selectedRoomId === r.id;
                    const firstChar = (r.user_name || 'P').charAt(0).toUpperCase();
                    const phoneTag = r.user_phone ? `
                        <span class="inline-flex items-center gap-1 text-[9px] text-emerald-600 font-semibold mt-1 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <i class="fab fa-whatsapp"></i> ${escapeHtml(r.user_phone)}
                        </span>
                    ` : '';
                    const unreadBadge = r.unread_count > 0 ? `
                        <span class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shrink-0">
                            ${r.unread_count} baru
                        </span>
                    ` : '';

                    html += `
                        <div id="room-item-${r.id}"
                             onclick="selectRoom(${r.id}, ${r.user_id}, '${escapeJs(r.user_name)}', '${escapeJs(r.user_phone)}', '${escapeJs(r.user_email)}')"
                             data-name="${escapeHtml((r.user_name || '').toLowerCase())}"
                             data-phone="${escapeHtml((r.user_phone || '').toLowerCase())}"
                             data-email="${escapeHtml((r.user_email || '').toLowerCase())}"
                             class="room-card p-3.5 hover:bg-blue-50/60 cursor-pointer transition flex items-start gap-3 bg-white border-l-4 ${isActive ? 'bg-blue-50/80 border-blue-600' : 'border-transparent'}">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-sm">
                                ${firstChar}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <h4 class="font-bold text-xs text-gray-900 truncate">${escapeHtml(r.user_name)}</h4>
                                    <div class="flex items-center gap-1 shrink-0 ml-1">
                                        ${unreadBadge}
                                        <span class="text-[10px] text-gray-400 font-medium">${r.last_time || ''}</span>
                                    </div>
                                </div>
                                <p class="text-[11px] text-gray-500 truncate room-last-msg">
                                    ${escapeHtml(r.last_message || 'Belum ada pesan')}
                                </p>
                                ${phoneTag}
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
                filterCustomerList();
            } catch (err) {
                console.error("Gagal polling room admin:", err);
            } finally {
                if (spinner) setTimeout(() => spinner.classList.remove('fa-spin'), 400);
            }
        }

        async function deleteChatRoom(event, roomId) {
            event.stopPropagation();
            if (!confirm("Apakah Anda yakin ingin menghapus seluruh pesan dalam percakapan ini?")) return;

            try {
                const res = await fetch(`/chat/room/${roomId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await res.json();
                if (data.success) {
                    lastAdminMessagesJson = '';
                    if (selectedRoomId === roomId) {
                        document.getElementById('admin-messages').innerHTML = `
                            <div class="text-center text-xs text-gray-400 py-16">
                                <i class="fas fa-comments text-3xl text-gray-200 mb-2 block"></i>
                                Belum ada riwayat pesan.
                            </div>`;
                    }
                    pollAdminRooms();
                    alert("Riwayat pesan berhasil dibersihkan.");
                }
            } catch (error) {
                console.error("Gagal menghapus chat:", error);
                alert("Terjadi kesalahan saat menghapus pesan.");
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.innerText = text;
            return div.innerHTML;
        }

        function escapeJs(text) {
            if (!text) return '';
            return text.replace(/'/g, "\\'").replace(/"/g, '\\"');
        }

        // Start room list polling every 6 seconds
        setInterval(pollAdminRooms, 6000);
    </script>
</body>
</html>