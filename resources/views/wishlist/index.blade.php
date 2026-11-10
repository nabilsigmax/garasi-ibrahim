<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya - Garasi Ibrahim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

    <x-navbar />

    <div class="container mx-auto px-4 pb-8 pt-28">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Wishlist Saya</h1>
            <x-back-link :href="route('landing')" label="Kembali ke Beranda" />
        </div>

        @if($wishlists->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                Belum ada mobil yang ditambahkan ke wishlist.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($wishlists as $item)
                    @php $car = $item->car; @endphp
                    @if($car)
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 relative group flex flex-col justify-between">
                            
                            <!-- Gambar & Tombol Wishlist -->
                            <div class="relative h-48 overflow-hidden bg-gray-200">
                                @php
                                    $img = $car->image;
                                    if ($img && !str_starts_with($img, 'http://') && !str_starts_with($img, 'https://')) {
                                        $img = asset('storage/' . $img);
                                    }
                                @endphp
                                <img src="{{ $img ?: 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                                     alt="{{ $car->name }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image'">

                                <!-- Tombol Hapus dari Wishlist (Hati Merah) -->
                                <form action="{{ route('wishlist.toggle', $car->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                    @csrf
                                    <button type="submit" title="Hapus dari Wishlist" class="w-9 h-9 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow hover:scale-105 transition">
                                        <i class="fa-solid fa-heart text-red-500 text-lg"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Informasi Mobil -->
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">
                                        {{ $car->brand ?? 'JMK' }}
                                    </span>
                                    <h3 class="text-lg font-bold text-gray-900 mt-0.5 line-clamp-1">
                                        {{ $car->name }}
                                    </h3>
                                    <p class="text-xl font-extrabold text-gray-900 mt-2">
                                        Rp {{ number_format($car->price, 0, ',', '.') }}
                                    </p>

                                    <!-- Spesifikasi Singkat -->
                                    <div class="grid grid-cols-3 gap-2 py-3 mt-4 border-t border-b border-gray-100 text-xs text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center gap-1">
                                            <i class="fa-regular fa-calendar text-gray-400"></i>
                                            <span>{{ $car->year ?? '-' }}</span>
                                        </div>
                                        <div class="flex flex-col items-center justify-center gap-1 border-x border-gray-100 px-1">
                                            <i class="fa-solid fa-gear text-gray-400"></i>
                                            <span class="capitalize">{{ $car->transmission ?? 'Automatic' }}</span>
                                        </div>
                                        <div class="flex flex-col items-center justify-center gap-1">
                                            <i class="fa-solid fa-gas-pump text-gray-400"></i>
                                            <span>{{ $car->fuel ?? 'Bensin' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('cars.show', $car->id) }}" 
                                   class="mt-5 w-full bg-[#0f172a] hover:bg-slate-800 text-white font-medium py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm transition-colors">
                                    Lihat Detail <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>

                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <!-- Universal Live Chat Widget -->
    @include('components.chat-widget')

</body>
</html>
