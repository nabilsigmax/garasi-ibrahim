<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Garasi Ibrahim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <main class="flex flex-1 items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-2xl border border-gray-200/90 shadow-sm p-8">
            
            <div class="text-center mb-6">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali</h1>
                <p class="text-xs text-slate-500 mt-1">Masuk untuk mengakses akun dan wishlist Anda.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3.5 bg-green-50 border border-green-200 text-green-700 rounded-xl text-xs flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs flex items-center gap-2">
                    <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-1.5"><i class="fas fa-circle-exclamation"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label for="email" class="block text-slate-600 font-semibold mb-1">Alamat Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3.5 top-3.5 text-slate-400"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required 
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-slate-600 font-semibold mb-1">Kata Sandi</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required 
                               class="w-full pl-10 pr-3.5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-4 rounded-xl text-xs transition duration-150 shadow-sm mt-2">
                    Masuk Akun
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-gray-100 text-center text-xs text-slate-500">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Daftar sekarang</a>
            </div>

        </div>
    </main>

    <footer class="py-4 text-center text-[11px] text-slate-400">
        &copy; {{ date('Y') }} Garasi Ibrahim. All rights reserved.
    </footer>

</body>
</html>
