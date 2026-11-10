@props(['landing' => false])

@php
    $landingUrl = route('landing');
    $isLanding = $landing && request()->routeIs('landing');
@endphp

<nav id="main-navbar" data-landing="{{ $isLanding ? 'true' : 'false' }}" class="fixed top-4 left-1/2 z-50 w-[95%] max-w-7xl -translate-x-1/2 rounded-2xl border backdrop-blur-xl transition-all duration-300 {{ $isLanding ? 'border-white/20 bg-white/10 shadow-lg' : 'border-slate-200/80 bg-white/90 shadow-md' }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="flex h-16 items-center justify-between gap-4">
            <a href="{{ $landingUrl }}" id="nav-logo" class="text-lg font-black tracking-tight transition-colors duration-300 sm:text-xl {{ $isLanding ? 'text-white' : 'text-slate-900' }}">
                GARASI<span id="nav-logo-accent" class="{{ $isLanding ? 'text-blue-300' : 'text-blue-600' }}">IBRAHIM</span>
            </a>

            <div class="hidden items-center gap-7 text-sm font-medium md:flex {{ $isLanding ? 'text-slate-200' : 'text-slate-600' }}">
                <a href="{{ $landingUrl }}#home" class="nav-link transition-colors hover:text-blue-500">Home</a>
                <a href="{{ $landingUrl }}#katalog" class="nav-link transition-colors hover:text-blue-500">Katalog</a>
                <a href="{{ $landingUrl }}#kontak" class="nav-link transition-colors hover:text-blue-500">Kontak</a>
            </div>

                <div class="hidden items-center gap-2 md:flex">
                @auth
                    @if($isLanding && Auth::user()->role === 'admin')
                        <a href="{{ route('admin.index') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3.5 py-2 text-xs font-semibold text-white transition-colors hover:bg-blue-700">
                            <i class="fas fa-chart-pie"></i> Panel Admin
                        </a>
                    @endif
                    <a href="{{ route('wishlist.index') }}" aria-label="Wishlist" title="Wishlist" class="nav-icon inline-flex items-center justify-center rounded-lg p-2 transition-colors {{ $isLanding ? 'text-slate-200 hover:bg-white/20 hover:text-rose-300' : 'text-slate-600 hover:bg-slate-100 hover:text-rose-500' }}"><i class="fas fa-heart"></i></a>
                    <a href="{{ route('transactions.index') }}" aria-label="Riwayat transaksi" title="Riwayat transaksi" class="nav-icon inline-flex items-center justify-center rounded-lg p-2 transition-colors {{ $isLanding ? 'text-slate-200 hover:bg-white/20 hover:text-blue-300' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600' }}"><i class="fas fa-receipt"></i></a>
                    <details class="relative">
                        <summary class="nav-user list-none cursor-pointer rounded-lg px-2.5 py-2 text-xs font-semibold transition-colors {{ $isLanding ? 'text-white hover:bg-white/20' : 'text-slate-700 hover:bg-slate-100' }}">{{ Str::before(Auth::user()->name, ' ') }} <i class="fas fa-chevron-down ml-1 text-[10px]"></i></summary>
                        <div class="absolute right-0 mt-2 w-44 rounded-xl border border-slate-100 bg-white p-1.5 shadow-lg">
                            <a href="{{ route('wishlist.index') }}" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">Wishlist</a>
                            <a href="{{ route('transactions.index') }}" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">Riwayat Transaksi</a>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.index') }}" class="block rounded-lg px-3 py-2 text-xs font-medium text-blue-600 hover:bg-blue-50">Kelola Mobil</a>
                                <a href="{{ route('admin.transactions.index') }}" class="block rounded-lg px-3 py-2 text-xs font-medium text-blue-600 hover:bg-blue-50">Kelola Transaksi</a>
                                <a href="{{ route('admin.consultation') }}" class="block rounded-lg px-3 py-2 text-xs font-medium text-blue-600 hover:bg-blue-50">Konsultasi</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-xs font-medium text-rose-600 hover:bg-rose-50">Keluar</button></form>
                        </div>
                    </details>
                @else
                    <a href="{{ route('login') }}" class="nav-link px-3 py-2 text-xs font-semibold transition-colors {{ $isLanding ? 'text-slate-200 hover:text-blue-300' : 'text-slate-600 hover:text-blue-600' }}">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-blue-600 px-3.5 py-2 text-xs font-semibold text-white transition-colors hover:bg-blue-700">Daftar</a>
                @endauth
            </div>

            <button type="button" id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false" class="nav-icon inline-flex items-center justify-center rounded-lg p-2 md:hidden {{ $isLanding ? 'text-white hover:bg-white/20' : 'text-slate-700 hover:bg-slate-100' }}" aria-label="Buka menu navigasi"><i class="fas fa-bars text-lg"></i></button>
        </div>
        <div id="mobile-menu" class="hidden border-t py-3 md:hidden {{ $isLanding ? 'border-white/20' : 'border-slate-200' }}">
            <div class="grid gap-1 text-sm font-medium {{ $isLanding ? 'text-slate-100' : 'text-slate-700' }}">
                <a href="{{ $landingUrl }}#home" class="rounded-lg px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Home</a><a href="{{ $landingUrl }}#katalog" class="rounded-lg px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Katalog</a><a href="{{ $landingUrl }}#kontak" class="rounded-lg px-3 py-2 hover:bg-slate-100 hover:text-blue-600">Kontak</a>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2 border-t pt-3 {{ $isLanding ? 'border-white/20' : 'border-slate-200' }}">
                @auth
                    <a href="{{ route('wishlist.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-100 px-3 py-2.5 text-xs font-semibold text-slate-700"><i class="fas fa-heart text-rose-500"></i> Wishlist</a>
                    <a href="{{ route('transactions.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-100 px-3 py-2.5 text-xs font-semibold text-slate-700"><i class="fas fa-receipt"></i> Transaksi</a>
                    @if(Auth::user()->role === 'admin')<a href="{{ route('admin.index') }}" class="col-span-2 inline-flex items-center justify-center gap-2 rounded-lg bg-slate-800 px-3 py-2.5 text-xs font-semibold text-white"><i class="fas fa-clipboard-list"></i> Kelola Admin</a>@endif
                    <form action="{{ route('logout') }}" method="POST" class="col-span-2">@csrf<button type="submit" class="w-full rounded-lg border border-rose-300 px-3 py-2.5 text-xs font-semibold text-rose-600">Keluar</button></form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-100 px-3 py-2.5 text-xs font-semibold text-slate-700">Masuk</a><a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-2.5 text-xs font-semibold text-white">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    (() => {
        const navbar = document.getElementById('main-navbar');
        const button = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        if (!navbar || !button || !menu) return;
        button.addEventListener('click', () => { const open = menu.classList.toggle('hidden'); button.setAttribute('aria-expanded', String(!open)); });
        if (navbar.dataset.landing !== 'true') return;
        const update = () => {
            const scrolled = window.scrollY > 30;
            navbar.classList.toggle('bg-white/10', !scrolled); navbar.classList.toggle('border-white/20', !scrolled); navbar.classList.toggle('shadow-lg', !scrolled);
            navbar.classList.toggle('bg-white/90', scrolled); navbar.classList.toggle('border-slate-200/80', scrolled); navbar.classList.toggle('shadow-md', scrolled);
            document.getElementById('nav-logo')?.classList.toggle('text-white', !scrolled); document.getElementById('nav-logo')?.classList.toggle('text-slate-900', scrolled);
            document.getElementById('nav-logo-accent')?.classList.toggle('text-blue-300', !scrolled); document.getElementById('nav-logo-accent')?.classList.toggle('text-blue-600', scrolled);
            navbar.querySelectorAll('.nav-link, .nav-icon, .nav-user').forEach(item => { item.classList.toggle('text-white', !scrolled); item.classList.toggle('text-slate-600', scrolled); });
        };
        window.addEventListener('scroll', update); update();
    })();
</script>
