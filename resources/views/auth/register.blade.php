<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Garasi Ibrahim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Navigation -->
    <header class="bg-white/80 backdrop-blur-md border-b border-gray-200/80 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 h-16 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="text-xl font-black tracking-wider text-slate-900">
                GARASI<span class="text-blue-600">IBRAHIM</span>
            </a>
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-blue-600 bg-gray-100 hover:bg-blue-50 px-3.5 py-2 rounded-lg transition-all">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </header>

    <!-- Form Registrasi -->
    <main class="flex-1 flex items-center justify-center p-6 my-6">
        <div class="w-full max-w-md bg-white rounded-2xl border border-gray-200/90 shadow-sm p-8">
            
            <div class="text-center mb-6">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Buat Akun Baru</h1>
                <p class="text-xs text-slate-500 mt-1">Daftar untuk menyimpan unit ke wishlist dan bertransaksi.</p>
            </div>

            <!-- Display Error Validasi -->
            @if ($errors->any())
                <div class="mb-4 p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-1.5"><i class="fas fa-circle-exclamation"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-slate-600 font-semibold mb-1">Nama Lengkap *</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3.5 top-3.5 text-slate-400"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"  
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-slate-600 font-semibold mb-1">Alamat Email *</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3.5 top-3.5 text-slate-400"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required 
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label for="phone" class="block text-slate-600 font-semibold mb-1">Nomor WhatsApp *</label>
                    <div class="relative">
                        <i class="fab fa-whatsapp absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="081234567890" required 
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Kata Sandi -->
                <div>
                    <label for="password" class="block text-slate-600 font-semibold mb-1">Kata Sandi *</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400"></i>
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required 
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div>
                    <label for="password_confirmation" class="block text-slate-600 font-semibold mb-1">Konfirmasi Kata Sandi *</label>
                    <div class="relative">
                        <i class="fas fa-shield-alt absolute left-3.5 top-3.5 text-slate-400"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required 
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.99] text-white font-bold py-3.5 px-4 rounded-xl text-xs transition duration-150 shadow-sm mt-2">
                    Daftar Akun
                </button>
            </form>

            <!-- Tautan ke Halaman Login -->
            <div class="mt-6 pt-5 border-t border-gray-100 text-center text-xs text-slate-500">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Masuk di sini</a>
            </div>

        </div>
    </main>

    <footer class="py-4 text-center text-[11px] text-slate-400">
        &copy; {{ date('Y') }} Garasi Ibrahim. All rights reserved.
    </footer>

</body>
</html>