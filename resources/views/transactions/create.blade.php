@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold text-slate-900">Checkout Transaksi</h1><p class="mt-1 text-sm text-slate-500">Pilih skema pembelian dan metode pembayaran yang Anda inginkan.</p></div>
        <x-back-link :href="route('cars.show', $car)" label="Kembali ke Detail" />
    </div>

    <form action="{{ route('transactions.store', $car) }}" method="POST" enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-3">
        @csrf
        <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm lg:col-span-2">
            <div class="mb-4"><h2 class="text-sm font-bold text-slate-900">1. Pilih skema pembelian</h2><p class="mt-1 text-[11px] text-gray-500">Tentukan tujuan pembayaran Anda. Pilihan ini dapat dikonfirmasi kembali bersama admin.</p></div>
            <div class="grid gap-3 sm:grid-cols-3">
                <label class="cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50"><input type="radio" class="sr-only" name="payment_method" value="booking_fee" checked><span class="block text-sm font-bold">Booking Fee</span><span class="mt-1 block text-[11px] leading-relaxed text-gray-500"><b>Untuk:</b> menahan unit sementara.<br><b>Berikutnya:</b> admin memverifikasi lalu menghubungi Anda untuk proses lanjutan.</span></label>
                <label class="cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50"><input type="radio" class="sr-only" name="payment_method" value="credit"><span class="block text-sm font-bold">DP Kredit</span><span class="mt-1 block text-[11px] leading-relaxed text-gray-500"><b>Untuk:</b> memulai pengajuan pembiayaan/kredit.<br><b>Berikutnya:</b> admin membantu simulasi dan persyaratan kredit.</span></label>
                <label class="cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50"><input type="radio" class="sr-only" name="payment_method" value="cash"><span class="block text-sm font-bold">Cash</span><span class="mt-1 block text-[11px] leading-relaxed text-gray-500"><b>Untuk:</b> pembelian tunai atau pelunasan.<br><b>Berikutnya:</b> admin mengonfirmasi nominal dan jadwal serah terima.</span></label>
            </div>
            <div id="scheme-help" class="mt-3 flex gap-2 rounded-xl border border-blue-100 bg-blue-50 p-3 text-[11px] leading-relaxed text-blue-800"><i class="fas fa-circle-info mt-0.5 text-blue-600"></i><span><b>Booking Fee dipilih:</b> masukkan nominal booking yang Anda sepakati. Setelah transaksi dibuat, statusnya menunggu verifikasi admin.</span></div>
            @error('payment_method')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror

            <h2 class="mb-4 mt-7 text-sm font-bold text-slate-900">2. Pilih metode pembayaran</h2>
            <div class="grid gap-3 sm:grid-cols-2">
                <label class="cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50"><input type="radio" class="sr-only" name="payment_channel" value="bank_transfer" checked><i class="fas fa-building mr-2 text-blue-600"></i><span class="text-sm font-bold">Transfer Bank</span><span class="mt-1 block text-[11px] text-gray-500">Instruksi rekening diberikan setelah transaksi dibuat.</span></label>
                <label class="cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50"><input type="radio" class="sr-only" name="payment_channel" value="ewallet"><i class="fas fa-wallet mr-2 text-blue-600"></i><span class="text-sm font-bold">E-Wallet</span><span class="mt-1 block text-[11px] text-gray-500">DANA, OVO, GoPay, atau ShopeePay.</span></label>
                <label class="cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50"><input type="radio" class="sr-only" name="payment_channel" value="qris"><i class="fas fa-qrcode mr-2 text-blue-600"></i><span class="text-sm font-bold">QRIS</span><span class="mt-1 block text-[11px] text-gray-500">Bayar dengan pemindai QRIS.</span></label>
                <label class="cursor-pointer rounded-xl border border-gray-200 p-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50"><input type="radio" class="sr-only" name="payment_channel" value="showroom"><i class="fas fa-store mr-2 text-blue-600"></i><span class="text-sm font-bold">Bayar di Showroom</span><span class="mt-1 block text-[11px] text-gray-500">Bayar langsung saat berkunjung.</span></label>
            </div>
            @error('payment_channel')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror

            <div class="mt-7"><label class="mb-1 block text-sm font-bold text-slate-900" for="down_payment">Nominal pembayaran / DP</label><input id="down_payment" type="number" name="down_payment" min="1" max="{{ $car->price }}" value="{{ old('down_payment') }}" required class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none" placeholder="Contoh: 5000000"><p id="amount-help" class="mt-1 text-[11px] text-gray-500">Masukkan nominal booking yang disepakati. Maksimal Rp {{ number_format($car->price, 0, ',', '.') }}.</p>@error('down_payment')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
            <div class="mt-5"><label class="mb-1 block text-sm font-bold text-slate-900" for="payment_receipt">Bukti pembayaran <span class="font-normal text-gray-400">(opsional)</span></label><input id="payment_receipt" type="file" name="payment_receipt" accept="image/*" class="block w-full text-xs text-gray-500">@error('payment_receipt')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror</div>
        </section>
        <aside class="h-fit rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-bold text-slate-900">Ringkasan Unit</h2>
            <img src="{{ $car->image ?: 'https://via.placeholder.com/600x400?text=Mobil' }}" alt="{{ $car->name }}" class="mt-4 h-36 w-full rounded-xl object-cover">
            <p class="mt-3 font-bold">{{ $car->name }}</p><p class="text-xs text-gray-500">{{ $car->brand }} · {{ $car->year }}</p>
            <div class="my-4 border-t border-gray-100"></div><p class="text-xs text-gray-500">Harga unit</p><p class="text-lg font-extrabold text-blue-600">Rp {{ number_format($car->price, 0, ',', '.') }}</p>
            <button type="submit" class="mt-5 w-full rounded-xl bg-blue-600 px-4 py-3 text-xs font-bold text-white hover:bg-blue-700">Buat Transaksi</button>
        </aside>
    </form>
</div>
<script>
    const schemeInfo = {
        booking_fee: ['<b>Booking Fee dipilih:</b> masukkan nominal booking yang Anda sepakati. Setelah transaksi dibuat, statusnya menunggu verifikasi admin.', 'Masukkan nominal booking yang disepakati.'],
        credit: ['<b>DP Kredit dipilih:</b> masukkan DP awal. Admin akan menghubungi Anda untuk simulasi angsuran dan kelengkapan pengajuan.', 'Masukkan nominal DP awal yang disepakati.'],
        cash: ['<b>Cash dipilih:</b> masukkan nominal pembayaran tunai/pelunasan. Admin akan mengonfirmasi pembayaran dan serah terima unit.', 'Masukkan nominal pembayaran tunai atau pelunasan yang disepakati.']
    };
    document.querySelectorAll('input[name="payment_method"]').forEach((input) => input.addEventListener('change', () => {
        const [detail, amount] = schemeInfo[input.value];
        document.getElementById('scheme-help').querySelector('span').innerHTML = detail;
        document.getElementById('amount-help').textContent = amount + ' Maksimal Rp {{ number_format($car->price, 0, ',', '.') }}.';
    }));
</script>
@endsection
