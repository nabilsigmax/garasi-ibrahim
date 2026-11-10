@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Transaksi Saya</h1>
            <p class="text-sm text-gray-500">Pantau status booking dan pembayaran unit mobil Anda di sini.</p>
        </div>
        <x-back-link :href="route('landing')" label="Kembali ke Katalog" class="mt-4 md:mt-0" />
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-xs">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Daftar Transaksi User -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="p-4">No. Invoice</th>
                        <th class="p-4">Unit Mobil</th>
                        <th class="p-4">Metode Bayar</th>
                        <th class="p-4">Skema Pembelian</th>
                        <th class="p-4">Total DP</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Bukti Transfer</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-xs text-gray-700">
                    @forelse($transactions as $tx)
                    <tr class="hover:bg-gray-50/50 transition">
                        <!-- Invoice -->
                        <td class="p-4 font-mono font-bold text-blue-600">
                            {{ $tx->invoice_number }}
                            <span class="block text-[10px] text-gray-400 font-sans font-normal">{{ $tx->created_at->format('d M Y, H:i') }}</span>
                        </td>

                        <!-- Mobil -->
                        <td class="p-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $tx->car->image ?: 'https://via.placeholder.com/120x100?text=Mobil' }}" class="w-12 h-10 object-cover rounded-lg border border-gray-100" alt="{{ $tx->car->name }}">
                                <div>
                                    <p class="font-bold text-gray-900">{{ $tx->car->name }}</p>
                                    <p class="text-[10px] text-gray-500">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-4 text-xs text-gray-600">
                            {{ ['bank_transfer' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'qris' => 'QRIS', 'showroom' => 'Bayar di Showroom'][$tx->payment_channel] ?? '-' }}
                        </td>

                        <!-- Skema Pembelian -->
                        <td class="p-4">
                            @if($tx->payment_method == 'booking_fee')
                                <span class="px-2.5 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-md font-semibold text-[10px]">Booking Fee</span>
                            @elseif($tx->payment_method == 'credit')
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-md font-semibold text-[10px]">DP Kredit</span>
                            @else
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md font-semibold text-[10px]">Cash / Pelunasan</span>
                            @endif
                        </td>

                        <!-- DP -->
                        <td class="p-4 font-bold text-gray-900">
                            Rp {{ number_format($tx->down_payment, 0, ',', '.') }}
                        </td>

                        <!-- Status Badge -->
                        <td class="p-4">
                            @if($tx->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 animate-pulse"></span> Verifikasi Admin
                                </span>
                            @elseif($tx->status == 'approved')
                                <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-check-circle mr-1 text-emerald-500"></i> Unit Terkunci
                                </span>
                            @elseif($tx->status == 'completed')
                                <span class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-car mr-1 text-blue-500"></i> Selesai (Serah Terima)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-[10px] font-bold">
                                    <i class="fas fa-times-circle mr-1 text-red-500"></i> Ditolak
                                </span>
                            @endif
                        </td>

                        <!-- Bukti Transfer -->
                        <td class="p-4">
                            @if($tx->payment_receipt)
                                <a href="{{ asset('storage/' . $tx->payment_receipt) }}" target="_blank" class="text-blue-600 hover:underline text-[11px] font-medium flex items-center">
                                    <i class="fas fa-file-image mr-1"></i> Lihat Foto
                                </a>
                            @else
                                <span class="text-red-500 text-[10px] font-semibold">Belum Upload</span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Tombol Chat Admin untuk koordinasi -->
                                <a href="{{ route('cars.show', $tx->car_id) }}" class="p-2 bg-gray-100 hover:bg-blue-50 hover:text-blue-600 rounded-lg text-gray-600 transition" title="Lihat unit">
                                    <i class="fas fa-car"></i>
                                </a>
                                @if($tx->status === 'pending')
                                    <form action="{{ route('transactions.cancel', $tx) }}" method="POST" onsubmit="return confirm('Batalkan transaksi ini? Unit akan kembali tersedia untuk pelanggan lain.');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Batalkan transaksi">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-400">
                            <i class="fas fa-receipt text-3xl mb-2 text-gray-300 block"></i>
                            Belum ada riwayat transaksi booking.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
