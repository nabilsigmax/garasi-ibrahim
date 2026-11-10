<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $car->name }} - Garasi Ibrahim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <x-navbar />

    <!-- Main Container -->
    <main class="max-w-6xl mx-auto w-full px-6 pb-8 pt-28 flex-1">
        
        <!-- Breadcrumb / Badge Status -->
        <div class="flex items-center gap-2 mb-4">
            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700">
                {{ $car->brand }}
            </span>
            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $car->condition == 'Baru' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                {{ $car->condition ?? 'Bekas' }}
            </span>
        </div>

        <!-- Headline Title & Price -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-2 mb-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $car->name }}</h1>
                <p class="text-xs text-slate-500 mt-1"><i class="fas fa-calendar-alt mr-1"></i> Tahun {{ $car->year ?? '-' }}</p>
            </div>
            <div class="text-left md:text-right">
                <span class="text-[11px] text-slate-400 uppercase font-semibold block">Harga Penawaran</span>
                <span class="text-3xl font-extrabold text-blue-600 tracking-tight">
                    Rp {{ number_format($car->price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT SECTION: Photo Gallery (7 Cols) -->
            <div class="lg:col-span-7 space-y-4">
                <!-- Main Featured Image -->
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm aspect-[16/10] relative group">
                    <img id="mainImage" 
     src="{{ $car->image ?: 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=800' }}" 
     alt="{{ $car->name }}" 
     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=800';"
     class="w-full h-full object-cover transition-all duration-300">
                </div>

                <!-- Gallery Thumbnails -->
                <!-- Gallery Thumbnails -->
@if(!empty($car->gallery) && is_array($car->gallery))
    <div class="flex gap-3 overflow-x-auto pb-2">
        <!-- Thumbnail Foto Utama -->
        <img src="{{ $car->image ?: 'https://via.placeholder.com/800x500' }}" 
             onclick="changeMainImage(this)" 
             class="w-20 h-16 object-cover rounded-xl border-2 border-blue-600 hover:opacity-90 transition cursor-pointer thumb-img">

        <!-- Thumbnail Galeri -->
        @foreach($car->gallery as $imgUrl)
            @if(!empty(trim($imgUrl)))
                <img src="{{ trim($imgUrl) }}" 
                     onclick="changeMainImage(this)" 
                     class="w-20 h-16 object-cover rounded-xl border border-gray-200 hover:border-blue-500 hover:opacity-90 transition cursor-pointer thumb-img">
            @endif
        @endforeach
    </div>
@endif
            </div>

            <!-- RIGHT SECTION: Specifications Card (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm p-6">
                    <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fas fa-list-check text-blue-600"></i> Spesifikasi Ringkas
                    </h2>

                    <!-- Spec Grid -->
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5 text-[10px]">Transmisi</span>
                            <strong class="text-slate-800 font-bold text-sm">{{ $car->transmission }}</strong>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5 text-[10px]">Bahan Bakar</span>
                            <strong class="text-slate-800 font-bold text-sm">{{ $car->fuel ?? '-' }}</strong>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5 text-[10px]">Kapasitas Mesin</span>
                            <strong class="text-slate-800 font-bold text-sm">{{ $car->engine_capacity ?? '-' }}</strong>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5 text-[10px]">Kapasitas Penumpang</span>
                            <strong class="text-slate-800 font-bold text-sm">{{ $car->passenger_capacity ?? '-' }}</strong>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5 text-[10px]">Warna</span>
                            <strong class="text-slate-800 font-bold text-sm">{{ $car->color ?? '-' }}</strong>
                        </div>
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block mb-0.5 text-[10px]">Jarak Tempuh</span>
                            <strong class="text-slate-800 font-bold text-sm">
                                {{ $car->mileage ? number_format($car->mileage, 0, ',', '.') . ' km' : '-' }}
                            </strong>
                        </div>
                    </div>

                    <!-- Call to Action Button -->
                    <div class="mt-6 pt-5 border-t border-gray-100">
                        @auth
                            <a href="{{ route('transactions.create', $car) }}" class="mb-3 flex w-full items-center justify-center rounded-lg bg-blue-600 py-2.5 text-xs font-bold text-white hover:bg-blue-700">Lanjut ke Transaksi</a>
                        @else
                            <a href="{{ route('login') }}" class="mb-3 flex w-full items-center justify-center rounded-lg bg-blue-600 py-2.5 text-xs font-bold text-white hover:bg-blue-700">Masuk untuk Booking</a>
                        @endauth
                        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20mobil%20{{ urlencode($car->name) }}" 
                           target="_blank" 
                           class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.99] text-white font-bold py-3.5 px-4 rounded-xl text-xs flex items-center justify-center gap-2.5 transition duration-150 shadow-sm hover:shadow-emerald-200">
                            <i class="fab fa-whatsapp text-base"></i> Hubungi Sales via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM SECTION: Description Card -->
        <div class="mt-8 bg-white rounded-2xl border border-gray-200/90 shadow-sm p-6 md:p-8">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                <i class="fas fa-align-left text-blue-600"></i> Deskripsi Lengkap
            </h2>
            <div class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-5 rounded-xl border border-slate-100 whitespace-pre-line min-h-[100px]">
                {{ $car->description ?: 'Belum ada deskripsi khusus yang ditambahkan untuk unit mobil ini.' }}
            </div>
        </div>

    </main>

    <!-- Interactive Script for Image Switcher -->
    <script>
    function changeMainImage(element) {
        const mainImg = document.getElementById('mainImage');
        if (mainImg && element) {
            // Ubah gambar utama ke URL gambar yang diklik
            mainImg.src = element.src;

            // Reset border semua thumbnail
            document.querySelectorAll('.thumb-img').forEach(img => {
                img.classList.remove('border-blue-600', 'border-2');
                img.classList.add('border-gray-200', 'border');
            });

            // Beri border biru pada thumbnail yang sedang aktif
            element.classList.remove('border-gray-200', 'border');
            element.classList.add('border-blue-600', 'border-2');
        }
    }
    </script>

    <!-- Universal Live Chat Widget -->
    @include('components.chat-widget')

</body>
</html>
