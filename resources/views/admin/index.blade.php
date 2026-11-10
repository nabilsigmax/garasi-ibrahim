<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Garasi Ibrahim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 font-sans" x-data="{ activeTab: 'dashboard', openCreate: false, openEdit: false, editCar: {} }">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between p-6 shrink-0">
            <div>
                <h1 class="text-xl font-extrabold tracking-wider mb-8">PANEL<span class="text-blue-500">ADMIN</span></h1>
                <nav class="space-y-3">
                    <button @click="activeTab = 'dashboard'" :class="activeTab === 'dashboard' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-chart-pie"></i> Dashboard
                    </button>
                    <button @click="activeTab = 'cars'" :class="activeTab === 'cars' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-car"></i> Kelola Mobil
                    </button>
                    <button @click="activeTab = 'chat'" :class="activeTab === 'chat' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white'" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-comments"></i> Chat Pelanggan
                        </div>
                        <span class="bg-blue-500/30 text-blue-300 text-[10px] px-2 py-0.5 rounded-full">Live</span>
                    </button>
                    <button @click="activeTab = 'transactions'" :class="activeTab === 'transactions' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white'" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <span class="flex items-center gap-3"><i class="fas fa-receipt"></i> Transaksi</span>
                        @if($transactions->where('status', 'pending')->count())
                            <span class="bg-amber-500/20 text-amber-300 text-[10px] px-2 py-0.5 rounded-full">{{ $transactions->where('status', 'pending')->count() }}</span>
                        @endif
                    </button>
                    <button @click="activeTab = 'bodyTypes'" :class="activeTab === 'bodyTypes' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-tags"></i> Tipe Body
                    </button>
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 hover:bg-slate-800 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white transition">
                        <i class="fas fa-globe"></i> Lihat Website
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <!-- Alert Session Sukses/Error -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-xs font-medium">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-xs">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- DASHBOARD RINGKASAN -->
            <div x-show="activeTab === 'dashboard'">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                    <p class="text-xs text-gray-500">Pantau inventaris, kategori, dan perkembangan transaksi showroom.</p>
                </div>

                <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><i class="fas fa-car"></i></span><span class="text-3xl font-extrabold text-slate-900">{{ $dashboardStats['cars'] }}</span></div><p class="mt-4 text-xs font-semibold text-slate-600">Total Mobil</p><p class="mt-1 text-[11px] text-slate-400">Unit dalam inventaris</p></div>
                    <div class="rounded-xl border border-violet-100 bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600"><i class="fas fa-tags"></i></span><span class="text-3xl font-extrabold text-slate-900">{{ $dashboardStats['categories'] }}</span></div><p class="mt-4 text-xs font-semibold text-slate-600">Kategori Mobil</p><p class="mt-1 text-[11px] text-slate-400">Tipe body yang tersedia</p></div>
                    <div class="rounded-xl border border-emerald-100 bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><i class="fas fa-receipt"></i></span><span class="text-3xl font-extrabold text-slate-900">{{ $dashboardStats['transactions'] }}</span></div><p class="mt-4 text-xs font-semibold text-slate-600">Total Transaksi</p><p class="mt-1 text-[11px] text-slate-400">Seluruh booking pelanggan</p></div>
                    <div class="rounded-xl border border-amber-100 bg-white p-5 shadow-sm"><div class="flex items-center justify-between"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600"><i class="fas fa-clock"></i></span><span class="text-3xl font-extrabold text-slate-900">{{ $dashboardStats['pendingTransactions'] }}</span></div><p class="mt-4 text-xs font-semibold text-slate-600">Menunggu Verifikasi</p><p class="mt-1 text-[11px] text-slate-400">Transaksi perlu ditindaklanjuti</p></div>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 p-5"><h3 class="font-bold text-slate-800">Jumlah Mobil per Kategori</h3><p class="mt-1 text-xs text-slate-500">Distribusi inventaris berdasarkan tipe body.</p></div>
                        <div class="divide-y divide-gray-100">
                            @forelse($bodyTypes as $bodyType)
                                <div class="flex items-center justify-between px-5 py-3.5"><span class="text-sm font-medium text-slate-700">{{ $bodyType->name }}</span><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">{{ $bodyType->cars_count }} unit</span></div>
                            @empty
                                <p class="p-5 text-center text-xs text-slate-400">Belum ada kategori mobil.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 p-5"><h3 class="font-bold text-slate-800">Status Transaksi</h3><p class="mt-1 text-xs text-slate-500">Ringkasan progres seluruh booking pelanggan.</p></div>
                        <div class="grid grid-cols-2 gap-px bg-gray-100">
                            @foreach(['pending' => ['Menunggu Verifikasi', 'amber'], 'approved' => ['Unit Terkunci', 'emerald'], 'completed' => ['Selesai', 'blue'], 'rejected' => ['Dibatalkan', 'rose']] as $status => [$label, $color])
                                <div class="bg-white p-5"><p class="text-2xl font-extrabold text-slate-900">{{ $transactionSummary->get($status, 0) }}</p><p class="mt-1 text-xs font-medium text-{{ $color }}-600">{{ $label }}</p></div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>

            <!-- TAB 1: KELOLA MOBIL -->
            <div x-show="activeTab === 'cars'" x-cloak>
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Mobil</h2>
                        <p class="text-xs text-gray-500">Kelola inventaris kendaraan di showroom.</p>
                    </div>
                    <button @click="openCreate = true" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs px-4 py-2.5 rounded-lg flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Mobil
                    </button>
                </div>

                <!-- Table Mobil -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full text-left text-xs text-gray-600">
                        <thead class="bg-gray-50 text-gray-700 uppercase border-b border-gray-200">
                            <tr>
                                <th class="p-4">Foto</th>
                                <th class="p-4">Nama Mobil</th>
                                <th class="p-4">Merek</th>
                                <th class="p-4">Tahun</th>
                                <th class="p-4">Harga</th>
                                <th class="p-4">Kondisi</th>
                                <th class="p-4">Transmisi</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($cars as $car)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4">
                                        <img src="{{ $car->image ?: 'https://via.placeholder.com/150' }}" class="w-12 h-12 object-cover rounded-lg">
                                    </td>
                                    <td class="p-4 font-bold text-gray-900">{{ $car->name }}</td>
                                    <td class="p-4">{{ $car->brand }}</td>
                                    <td class="p-4">{{ $car->year ?? '-' }}</td>
                                    <td class="p-4 font-semibold text-gray-900">Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded text-[10px] font-semibold {{ $car->condition == 'Baru' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                            {{ $car->condition }}
                                        </span>
                                    </td>
                                    <td class="p-4">{{ $car->transmission }}</td>
                                    <td class="p-4 text-center space-x-2 flex justify-center items-center">
                                        <button @click="openEdit = true; editCar = {{ json_encode($car) }}; editCar.gallery = Array.isArray(editCar.gallery) ? editCar.gallery.join(', ') : editCar.gallery" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-6 text-center text-gray-400">Belum ada data mobil.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: TRANSAKSI -->
            <div x-show="activeTab === 'transactions'" x-cloak>
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Transaksi Booking</h2>
                        <p class="text-xs text-gray-500">Verifikasi pembayaran, kunci unit, atau batalkan transaksi pelanggan.</p>
                    </div>
                    <a href="{{ route('admin.transactions.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Halaman lengkap <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
                    <table class="w-full text-left text-xs text-gray-600">
                        <thead class="border-b border-gray-200 bg-gray-50 uppercase text-gray-700">
                            <tr><th class="p-4">Invoice & Pembeli</th><th class="p-4">Unit</th><th class="p-4">DP</th><th class="p-4">Status</th><th class="p-4 text-center">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4"><p class="font-mono font-bold text-blue-600">{{ $tx->invoice_number }}</p><p class="mt-0.5 font-semibold text-gray-900">{{ $tx->user->name }}</p></td>
                                    <td class="p-4"><p class="font-semibold text-gray-900">{{ $tx->car->name }}</p><p class="text-[10px] text-gray-400">{{ $tx->payment_method === 'credit' ? 'DP Kredit' : ($tx->payment_method === 'cash' ? 'Cash' : 'Booking Fee') }}</p></td>
                                    <td class="p-4 font-semibold text-emerald-600">Rp {{ number_format($tx->down_payment, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        <span class="rounded-full px-2 py-1 text-[10px] font-bold {{ $tx->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($tx->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($tx->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">{{ ['pending' => 'Menunggu Verifikasi', 'approved' => 'Unit Terkunci', 'completed' => 'Selesai', 'rejected' => 'Dibatalkan'][$tx->status] }}</span>
                                    </td>
                                    <td class="p-4"><form action="{{ route('admin.transactions.update', $tx) }}" method="POST" class="flex items-center justify-center gap-2">@csrf @method('PATCH')
                                        <select name="status" class="rounded-lg border border-gray-300 bg-white p-1.5 text-[11px]" {{ $tx->status === 'completed' ? 'disabled' : '' }}>
                                            <option value="pending" @selected($tx->status === 'pending')>Pending</option><option value="approved" @selected($tx->status === 'approved')>Setujui</option><option value="completed" @selected($tx->status === 'completed')>Selesai</option><option value="rejected" @selected($tx->status === 'rejected')>Batalkan</option>
                                        </select>
                                        @if($tx->status !== 'completed')<button type="submit" class="rounded-lg bg-blue-600 p-1.5 text-white hover:bg-blue-700" title="Simpan status"><i class="fas fa-save"></i></button>@endif
                                    </form></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-8 text-center text-gray-400">Belum ada transaksi booking.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: MASTER TIPE BODY -->
            <div x-show="activeTab === 'bodyTypes'" x-cloak>
                <div class="mb-6"><h2 class="text-2xl font-bold text-gray-800">Kategori Tipe Body</h2><p class="text-xs text-gray-500">Kelola kategori seperti SUV, Off-road, Sedan, dan tipe body lainnya.</p></div>
                <div class="grid gap-6 lg:grid-cols-3">
                    <form action="{{ route('body-types.store') }}" method="POST" class="h-fit rounded-xl border border-gray-200 bg-white p-5 shadow-sm">@csrf
                        <h3 class="mb-4 font-bold text-gray-800">Tambah Kategori</h3><label class="mb-1 block text-xs font-medium text-gray-600">Nama tipe body</label>
                        <input name="name" value="{{ old('name') }}" required maxlength="50" placeholder="Contoh: Crossover" class="w-full rounded-lg border border-gray-300 p-2.5 text-xs focus:border-blue-500 focus:outline-none">
                        <button class="mt-3 w-full rounded-lg bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white hover:bg-blue-700"><i class="fas fa-plus mr-1"></i> Tambah Kategori</button>
                    </form>
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm lg:col-span-2"><table class="w-full text-left text-xs text-gray-600"><thead class="border-b border-gray-200 bg-gray-50 uppercase text-gray-700"><tr><th class="p-4">Nama Kategori</th><th class="p-4">Jumlah Unit</th><th class="p-4 text-center">Aksi</th></tr></thead><tbody class="divide-y divide-gray-100">
                        @forelse($bodyTypes as $bodyType)
                            <tr><td class="p-4"><form id="body-type-{{ $bodyType->id }}" action="{{ route('body-types.update', $bodyType) }}" method="POST">@csrf @method('PUT')<input name="name" value="{{ $bodyType->name }}" required maxlength="50" class="w-full rounded-lg border border-gray-300 p-2 text-xs focus:border-blue-500 focus:outline-none"></form></td><td class="p-4"><span class="rounded-full bg-slate-100 px-2 py-1 font-semibold text-slate-600">{{ $bodyType->cars_count }} unit</span></td><td class="p-4"><div class="flex justify-center gap-2"><button form="body-type-{{ $bodyType->id }}" class="rounded-lg bg-blue-50 p-2 text-blue-600 hover:bg-blue-100" title="Simpan perubahan"><i class="fas fa-save"></i></button><form action="{{ route('body-types.destroy', $bodyType) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Unit yang memakainya akan menjadi tanpa kategori.');">@csrf @method('DELETE')<button class="rounded-lg bg-red-50 p-2 text-red-600 hover:bg-red-100" title="Hapus kategori"><i class="fas fa-trash"></i></button></form></div></td></tr>
                        @empty
                            <tr><td colspan="3" class="p-8 text-center text-gray-400">Belum ada kategori tipe body.</td></tr>
                        @endforelse
                    </tbody></table></div>
                </div>
            </div>

            <!-- TAB 4: INBOX CHAT PELANGGAN -->
            <div x-show="activeTab === 'chat'" x-cloak>
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Konsultasi & Live Chat</h2>
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
            </div>

        </main>
    </div>

    <!-- MODAL TAMBAH MOBIL -->
    <div x-show="openCreate" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50 overflow-y-auto" x-cloak>
        <div class="bg-white rounded-xl max-w-2xl w-full p-6 my-8 max-h-[90vh] overflow-y-auto">
            <h3 class="font-bold text-lg text-gray-900 mb-4">Tambah Mobil Baru</h3>
            <form action="{{ route('cars.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                @csrf
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-600 font-medium mb-1">Nama Mobil *</label>
                    <input type="text" name="name" placeholder="Contoh: Toyota Avanza" required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Merek *</label>
                    <input type="text" name="brand" placeholder="Toyota, Honda, Mitsubishi, dll." required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Tahun</label>
                    <input type="number" name="year" placeholder="2024, 2025, 2026" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Tipe Body</label>
                    <select name="body_type_id" class="w-full border rounded-lg p-2 text-xs"><option value="">Pilih tipe body</option>@foreach($bodyTypes as $bodyType)<option value="{{ $bodyType->id }}">{{ $bodyType->name }}</option>@endforeach</select>
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Harga (Rp) *</label>
                    <input type="number" name="price" placeholder="Contoh: 250000000" required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Warna</label>
                    <input type="text" name="color" placeholder="Hitam, Putih, Silver, dll." class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Transmisi *</label>
                    <select name="transmission" required class="w-full border rounded-lg p-2 text-xs">
                        <option value="Automatic">Automatic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Bahan Bakar</label>
                    <input type="text" name="fuel" placeholder="Bensin, Diesel, Hybrid" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kapasitas Mesin</label>
                    <input type="text" name="engine_capacity" placeholder="Contoh: 1.500 cc" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kapasitas Penumpang</label>
                    <input type="text" name="passenger_capacity" placeholder="Contoh: 7 orang" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kilometer (Untuk Bekas)</label>
                    <input type="number" name="mileage" placeholder="Contoh: 15000" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kondisi *</label>
                    <select name="condition" required class="w-full border rounded-lg p-2 text-xs">
                        <option value="Baru">Baru</option>
                        <option value="Bekas">Bekas</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-600 font-medium mb-1">Foto Utama (URL)</label>
                    <input type="text" name="image" placeholder="https://..." class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-600 font-medium mb-1">Foto Galeri (Pisahkan URL dengan Koma)</label>
                    <textarea name="gallery" rows="2" placeholder="https://link1.com, https://link2.com" class="w-full border rounded-lg p-2 text-xs"></textarea>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-600 font-medium mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Penjelasan tentang mobil..." class="w-full border rounded-lg p-2 text-xs"></textarea>
                </div>

                <div class="col-span-1 md:col-span-2 flex justify-end gap-2 mt-4">
                    <button type="button" @click="openCreate = false" class="px-4 py-2 text-xs text-gray-600 bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs text-white bg-blue-600 rounded-lg font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT MOBIL -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openEdit = false" class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-base text-gray-800">Edit Unit Mobil</h3>
                <button type="button" @click="openEdit = false" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form :action="'/admin/cars/' + editCar.id" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Nama Unit *</label>
                    <input type="text" name="name" x-model="editCar.name" required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Merek *</label>
                    <input type="text" name="brand" x-model="editCar.brand" required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Tipe Bodi *</label>
                    <select name="body_type_id" x-model="editCar.body_type_id" class="w-full border rounded-lg p-2 text-xs">
                        <option value="">Pilih tipe body</option>
                        @foreach($bodyTypes as $bodyType)<option value="{{ $bodyType->id }}">{{ $bodyType->name }}</option>@endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Tahun *</label>
                    <input type="number" name="year" x-model="editCar.year" required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Harga (Rp) *</label>
                    <input type="number" name="price" x-model="editCar.price" required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Bahan Bakar *</label>
                    <input type="text" name="fuel" x-model="editCar.fuel" required class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Transmisi *</label>
                    <select name="transmission" x-model="editCar.transmission" required class="w-full border rounded-lg p-2 text-xs">
                        <option value="Automatic">Automatic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kapasitas Mesin (CC)</label>
                    <input type="text" name="engine_capacity" x-model="editCar.engine_capacity" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kapasitas Penumpang</label>
                    <input type="text" name="passenger_capacity" x-model="editCar.passenger_capacity" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kilometer (Untuk Bekas)</label>
                    <input type="number" name="mileage" x-model="editCar.mileage" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium mb-1">Kondisi *</label>
                    <select name="condition" x-model="editCar.condition" required class="w-full border rounded-lg p-2 text-xs">
                        <option value="Baru">Baru</option>
                        <option value="Bekas">Bekas</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-600 font-medium mb-1">Foto Utama (URL)</label>
                    <input type="text" name="image" x-model="editCar.image" class="w-full border rounded-lg p-2 text-xs">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-600 font-medium mb-1">Foto Galeri (Pisahkan URL dengan Koma)</label>
                    <textarea name="gallery" x-model="editCar.gallery" rows="2" class="w-full border rounded-lg p-2 text-xs"></textarea>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-600 font-medium mb-1">Deskripsi</label>
                    <textarea name="description" x-model="editCar.description" rows="3" class="w-full border rounded-lg p-2 text-xs"></textarea>
                </div>

                <div class="col-span-1 md:col-span-2 flex justify-end gap-2 mt-4">
                    <button type="button" @click="openEdit = false" class="px-4 py-2 text-xs text-gray-600 bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs text-white bg-blue-600 rounded-lg font-medium">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT CHAT ADMIN & HAPUS ROOM -->
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
