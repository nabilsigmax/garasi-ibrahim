<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garasi Ibrahim - Showroom Mobil</title>
    
    <!-- CDN Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="font-extrabold text-2xl tracking-wider text-slate-900">GARASI<span class="text-blue-600">IBRAHIM</span></a>
            
            <div class="hidden md:flex space-x-8 font-medium text-sm text-gray-600">
                <a href="#home" class="text-blue-600 font-semibold">Home</a>
                <a href="#katalog" class="hover:text-blue-600 transition">Katalog</a>
                <a href="#kontak" class="hover:text-blue-600 transition">Kontak</a>
            </div>

            <!-- AREA LOGIN / REGISTER / USER STATS -->
            <div class="flex items-center gap-3">
                <a href="https://wa.me/628123456789" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg text-xs flex items-center gap-2 transition mr-1">
                    <i class="fab font-bold fa-whatsapp text-sm"></i> Chat Sales
                </a>

                @auth
                    <!-- Tombol Wishlist Navigasi -->
                    <a href="{{ route('wishlist.index') }}" class="text-xs font-semibold text-slate-700 hover:text-red-500 flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200/70 px-3 py-2 rounded-lg transition">
                        <i class="fas fa-heart text-red-500"></i>
                        <span>Wishlist</span>
                    </a>

                    <!-- Jika Sudah Login -->
                    <div class="flex items-center gap-3 pl-2 border-l border-gray-200">
                        <span class="text-xs font-bold text-slate-800">Hi, {{ Auth::user()->name }}</span>
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold">
                                Logout
                            </button>
                        </form> 
                    </div>
                @else
                    <!-- Jika Belum Login -->
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-700 hover:text-blue-600 px-3 py-2 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-bold bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white px-4 py-2 rounded-lg transition shadow-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="home" class="bg-[#344878] text-white py-24 text-center px-6 relative overflow-hidden">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                Temukan Mobil Impian Anda
            </h1>
            <p class="text-slate-400 text-sm md:text-base mb-8 max-w-2xl mx-auto">
                Dapatkan unit mobil berkualitas premium, bersertifikat aman, bergaransi resmi, dan nikmati pelayanan pembelian cash/kredit terbaik khusus untuk Anda.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#katalog" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg text-sm transition">Lihat Katalog</a>
                <a href="#kontak" class="bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 font-medium px-6 py-3 rounded-lg text-sm transition">Hubungi Kami</a>
            </div>
        </div>
    </section>

    <!-- STATS / VALUE PROPOSITION -->
    <section class="max-w-7xl mx-auto px-6 -mt-10 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
                    <i class="fas fa-car"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">500+ Unit Terjual</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Kepercayaan pelanggan adalah prioritas utama kami dalam melayani unit terbaik.</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Kualitas Terjamin</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Setiap unit melewati inspeksi ketat 150+ titik untuk memastikan kondisi prima.</p>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">10+ Tahun Pengalaman</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Satu dekade melayani pasar mobil premium di Indonesia dengan transparansi penuh.</p>
            </div>
        </div>
    </section>

    <!-- KATALOG SECTION -->
    <section id="katalog" class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-10">
            <span class="text-blue-600 text-xs font-bold uppercase tracking-widest">KATALOG KAMI</span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-1">Pilih Unit Unggulan Terbaik</h2>
        </div>

        <!-- FILTER BAR WITH FORM -->
        <form action="{{ url()->current() }}#katalog" method="GET" id="filterForm">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    <!-- Cari Unit -->
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Cari Unit</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari nama mobil/impian Anda..." 
                                   class="w-full pl-8 pr-3 py-2 border rounded-lg text-xs focus:outline-none focus:border-blue-500"
                                   onkeydown="if(event.key === 'Enter'){ this.form.submit(); }">
                        </div>
                    </div>

                    <!-- Tipe Body -->
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Tipe Body</label>
                        <select name="body_type" 
                                onchange="this.form.submit()" 
                                class="w-full py-2 px-3 border rounded-lg text-xs text-gray-600 focus:outline-none">
                            <option value="">Semua Kategori</option>
                            <option value="Sedan" {{ request('body_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                            <option value="SUV" {{ request('body_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                            <option value="Off-road" {{ request('body_type') == 'Off-road' ? 'selected' : '' }}>Off-road</option>
                        </select>
                    </div>

                    <!-- Filter Harga (IDR) -->
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Filter Harga (IDR)</label>
                        <div class="flex gap-2">
                            <input type="number" 
                                   name="min_price" 
                                   value="{{ request('min_price') }}" 
                                   placeholder="Harga Minimal" 
                                   class="w-1/2 py-2 px-3 border rounded-lg text-xs focus:outline-none"
                                   onchange="this.form.submit()">
                            <input type="number" 
                                   name="max_price" 
                                   value="{{ request('max_price') }}" 
                                   placeholder="Harga Maksimal" 
                                   class="w-1/2 py-2 px-3 border rounded-lg text-xs focus:outline-none"
                                   onchange="this.form.submit()">
                        </div>
                    </div>

                    <!-- Transmisi -->
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Transmisi</label>
                        <select name="transmission" 
                                onchange="this.form.submit()" 
                                class="w-full py-2 px-3 border rounded-lg text-xs text-gray-600 focus:outline-none">
                            <option value="">Semua Transmisi</option>
                            <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                </div>
            </div>
        </form>

        <!-- CAR CARDS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($cars as $car)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group border border-gray-100 flex flex-col justify-between relative">
                    <div>
                        <!-- Gambar Mobil & Tombol Wishlist -->
                        <div class="relative overflow-hidden">
                            <a href="{{ route('cars.show', $car->id) }}" class="block">
                                <img src="{{ $car->image }}" alt="{{ $car->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                            </a>

                            <!-- Badge Status -->
                            @if($car->badge)
                                <span class="absolute top-3 left-3 text-xs font-bold text-white px-3 py-1 rounded-full {{ $car->badge_color ?? 'bg-gray-800' }}">
                                    {{ $car->badge }}
                                </span>
                            @endif

                            <!-- Tombol Wishlist -->
                            <form action="{{ route('wishlist.toggle', $car->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                @csrf
                                <button type="submit" title="Tambah/Hapus Wishlist" class="w-9 h-9 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-red-500 hover:bg-white hover:scale-110 shadow-md transition-all">
                                    <i class="fa-heart {{ auth()->check() && auth()->user()->wishlists && auth()->user()->wishlists->contains('car_id', $car->id) ? 'fa-solid' : 'fa-regular' }}"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Informasi Mobil -->
                        <div class="p-5">
                            <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">{{ $car->brand }}</div>
                            <a href="{{ route('cars.show', $car->id) }}" class="block">
                                <h3 class="text-lg font-bold text-gray-900 hover:text-blue-600 transition-colors line-clamp-1 mb-2">{{ $car->name }}</h3>
                            </a>
                            
                            <div class="text-xl font-extrabold text-gray-900 mb-4">
                                Rp {{ number_format($car->price, 0, ',', '.') }}
                            </div>

                            <!-- Spesifikasi Ringkas -->
                            <div class="grid grid-cols-3 gap-2 py-3 border-t border-b border-gray-100 text-xs text-gray-500 mb-4">
                                <div class="text-center">
                                    <i class="fa-solid fa-calendar text-gray-400 mb-1 block"></i>
                                    <span>{{ $car->year }}</span>
                                </div>
                                <div class="text-center border-x border-gray-100">
                                    <i class="fa-solid fa-gear text-gray-400 mb-1 block"></i>
                                    <span>{{ $car->transmission }}</span>
                                </div>
                                <div class="text-center">
                                    <i class="fa-solid fa-gas-pump text-gray-400 mb-1 block"></i>
                                    <span>{{ $car->fuel }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Detail di Bawah Card -->
                    <div class="p-5 pt-0">
                        <a href="{{ route('cars.show', $car->id) }}" class="block w-full text-center bg-gray-900 hover:bg-blue-600 text-white font-medium py-2.5 rounded-xl transition-colors duration-300">
                            Lihat Detail <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-gray-100">
                    <i class="fas fa-car-side text-4xl text-gray-300 mb-3 block"></i>
                    <p class="text-gray-500 text-sm">Unit mobil yang Anda cari tidak ditemukan.</p>
                    <a href="{{ url()->current() }}#katalog" class="text-blue-600 text-xs font-semibold mt-2 inline-block hover:underline">Reset Filter</a>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ url()->current() }}#katalog" class="inline-block border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-medium px-8 py-3 rounded-lg text-xs transition">
                Lihat Semua Katalog
            </a>
        </div>
    </section>

    <!-- SECTION HUBUNGI KAMI -->
    <section id="kontak" class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            
            <div class="text-center mb-10">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">HUBUNGI KAMI</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Mari Berdiskusi Dengan Kami</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- KOLOM KIRI: PETA & KARTU INFORMASI -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="w-full h-72 bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.213824147348!2d112.6302821!3d-7.977824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6282be3154881%3A0x6b107b5a83a48e42!2sJl.%20Trunojoyo%20No.09%2C%20Klojen%2C%20Kec.%20Klojen%2C%20Kota%20Malang%2C%20Jawa%20Timur%2065111!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                            class="w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-white p-3.5 rounded-xl border border-gray-200/80 shadow-sm flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold mb-0.5">Lokasi Showroom</strong>
                                <p class="text-[11px] text-slate-500 leading-tight">Jl. Trunojoyo No. 09, Malang</p>
                            </div>
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-gray-200/80 shadow-sm flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold mb-0.5">Telepon / WA</strong>
                                <p class="text-[11px] text-slate-500 leading-tight">+62 812-3456-7890</p>
                            </div>
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-gray-200/80 shadow-sm flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold mb-0.5">Email Resmi</strong>
                                <p class="text-[11px] text-slate-500 leading-tight">nabilazmi11@gmail.com</p>
                            </div>
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-gray-200/80 shadow-sm flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <strong class="text-slate-800 block font-semibold mb-0.5">Jam Operasional</strong>
                                <p class="text-[11px] text-slate-500 leading-tight">Senin - Minggu: 09:00 - 18:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: CHAT ADMIN -->
                <div class="lg:col-span-7 bg-white p-8 rounded-2xl border border-gray-200/90 shadow-sm text-center my-auto">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-comments"></i>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Layanan Konsultasi Direct</h3>
                    <p class="text-slate-500 text-xs leading-relaxed mb-6 max-w-md mx-auto">
                        Punya pertanyaan seputar ketersediaan unit, harga, atau negosiasi? Konsultasikan secara langsung dengan Admin kami secara *real-time*.
                    </p>

                    @auth
                        <button onclick="toggleGarasiChat()" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-bold py-3.5 px-6 rounded-xl text-xs transition duration-150 shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Mulai Chat Dengan Admin
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="w-full inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl text-xs transition duration-150 shadow-sm text-center">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login Untuk Chat Admin
                        </a>
                    @endauth
                </div>

            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#0F172A] text-white pt-16 pb-8 border-t border-slate-800 text-xs">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="space-y-4">
                <span class="font-extrabold text-xl tracking-wider text-white">GARASI<span class="text-blue-500">IBRAHIM</span></span>
                <p class="text-slate-400 leading-relaxed text-[11px]">
                    GARASI IBRAHIM adalah penyedia unit kendaraan bekas/baru terpercaya yang mengutamakan kualitas tinggi dengan transparansi penuh serta kenyamanan bertransaksi.
                </p>
                <div class="flex gap-3 text-slate-400">
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-white"><i class="fab fa-globe"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-sm mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="#home" class="hover:text-white">Beranda</a></li>
                    <li><a href="#katalog" class="hover:text-white">Katalog Unit</a></li>
                    <li><a href="#kontak" class="hover:text-white">Hubungi Kami</a></li>
                    <li><a href="/admin" class="hover:text-white">Admin</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-sm mb-4">Layanan</h4>
                <ul class="space-y-2 text-slate-400">
                    <li>Jual Beli Mobil Bekas</li>
                    <li>Tukar Tambah (Trade-In)</li>
                    <li>Garansi Mesin & Transmisi</li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-sm mb-4">Newsletter</h4>
                <p class="text-slate-400 mb-3 text-[11px]">Dapatkan update unit terbaru langsung ke email Anda.</p>
                <div class="flex">
                    <input type="email" placeholder="Email Anda" class="bg-slate-800 border-none rounded-l-lg p-2.5 text-xs w-full focus:outline-none">
                    <button class="bg-blue-600 px-4 rounded-r-lg"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-6 text-center text-slate-500 text-[11px]">
            © 2026 GARASI IBRAHIM. All Rights Reserved.
        </div>
    </footer>

    <!-- Universal Live Chat Widget -->
    @include('components.chat-widget')

</body>
</html>