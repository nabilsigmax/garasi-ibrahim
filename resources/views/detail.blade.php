<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $car->name }} - Garasi Ibrahim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 text-xl font-bold text-gray-900">
                <i class="fa-solid fa-car text-blue-600"></i>
                <span>Garasi Ibrahim</span>
            </a>
            <a href="{{ route('landing') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Katalog
            </a>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
            
            <!-- Gambar Mobil -->
            <div class="relative overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center">
                <img src="{{ $car->image }}" alt="{{ $car->name }}" class="w-full h-96 object-cover rounded-xl">
                @if($car->badge)
                    <span class="absolute top-4 right-4 text-xs font-bold text-white px-3 py-1.5 rounded-full {{ $car->badge_color ?? 'bg-gray-800' }}">
                        {{ $car->badge }}
                    </span>
                @endif
            </div>

            <!-- Detail Informasi -->
            <div class="flex flex-col justify-between">
                <div>
                    <div class="text-sm font-semibold text-blue-600 uppercase tracking-wider mb-1">{{ $car->brand }}</div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $car->name }}</h1>
                    <div class="text-2xl font-bold text-blue-600 mb-6">
                        Rp {{ number_format($car->price, 0, ',', '.') }}
                    </div>

                    <!-- Grid Spesifikasi Utama -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-xl mb-6 text-center">
                        <div class="p-2">
                            <span class="block text-xs text-gray-500 mb-1">Tahun</span>
                            <span class="font-bold text-gray-800"><i class="fa-solid fa-calendar mr-1 text-gray-400"></i>{{ $car->year }}</span>
                        </div>
                        <div class="p-2">
                            <span class="block text-xs text-gray-500 mb-1">Transmisi</span>
                            <span class="font-bold text-gray-800"><i class="fa-solid fa-gear mr-1 text-gray-400"></i>{{ $car->transmission }}</span>
                        </div>
                        <div class="p-2">
                            <span class="block text-xs text-gray-500 mb-1">Bahan Bakar</span>
                            <span class="font-bold text-gray-800"><i class="fa-solid fa-gas-pump mr-1 text-gray-400"></i>{{ $car->fuel }}</span>
                        </div>
                        <div class="p-2">
                            <span class="block text-xs text-gray-500 mb-1">Jarak Tempuh</span>
                            <span class="font-bold text-gray-800"><i class="fa-solid fa-gauge-high mr-1 text-gray-400"></i>{{ number_format($car->mileage) }} km</span>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Deskripsi Mobil</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            {{ $car->description ?? 'Tidak ada deskripsi tambahan untuk kendaraan ini.' }}
                        </p>
                    </div>
                </div>

                <!-- Tombol Kontak / Hubungi -->
                <div class="pt-4 border-t border-gray-100 flex gap-4">
                    <a href="https://wa.me/6281234567890?text=Halo%20Garasi%20Ibrahim,%20saya%20tertarik%20dengan%20mobil%20{{ urlencode($car->name) }}" target="_blank" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-xl text-center transition-colors flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-100 py-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Garasi Ibrahim. All rights reserved.
    </footer>

</body>
</html>