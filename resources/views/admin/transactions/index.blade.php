@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Kelola Transaksi Booking</h1>
        <p class="text-xs text-gray-500">Verifikasi pembayaran DP pembeli dan konfirmasi unit terkunci.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4 text-xs text-green-700">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-xs text-red-700">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase">
                        <th class="p-4">Invoice & Pembeli</th>
                        <th class="p-4">Unit Mobil</th>
                        <th class="p-4">Nominal DP</th>
                        <th class="p-4">Metode Bayar</th>
                        <th class="p-4">Bukti Transfer</th>
                        <th class="p-4">Status Transaksi</th>
                        <th class="p-4 text-center">Update Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-xs">
                    @forelse($transactions as $tx)
                    <tr class="hover:bg-gray-50/50">
                        <!-- Invoice & Pembeli -->
                        <td class="p-4">
                            <p class="font-mono font-bold text-blue-600">{{ $tx->invoice_number }}</p>
                            <p class="font-bold text-gray-800 mt-0.5">{{ $tx->user->name }}</p>
                            <p class="text-[10px] text-gray-400">{{ $tx->user->email }}</p>
                        </td>

                        <!-- Detail Mobil -->
                        <td class="p-4 font-bold text-gray-800">
                            {{ $tx->car->name }}
                            <span class="block text-[10px] text-gray-400 font-normal">Harga Total: Rp {{ number_format($tx->total_price, 0, ',', '.') }}</span>
                        </td>

                        <!-- DP -->
                        <td class="p-4 font-bold text-emerald-600">
                            Rp {{ number_format($tx->down_payment, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-[11px] text-gray-600">{{ ['bank_transfer' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'qris' => 'QRIS', 'showroom' => 'Showroom'][$tx->payment_channel] ?? '-' }}</td>

                        <!-- Bukti Transfer -->
                        <td class="p-4">
                            @if($tx->payment_receipt)
                                <a href="{{ asset('storage/' . $tx->payment_receipt) }}" target="_blank" class="inline-flex items-center px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-[10px] font-bold">
                                    <i class="fas fa-image mr-1 text-blue-500"></i> Cek Bukti
                                </a>
                            @else
                                <span class="text-red-400 text-[10px]">Belum Upload</span>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td class="p-4">
                            @if($tx->status == 'pending')
                                <span class="px-2 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-md text-[10px] font-bold">Menunggu Verifikasi</span>
                            @elseif($tx->status == 'approved')
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md text-[10px] font-bold">Unit Terkunci</span>
                            @elseif($tx->status == 'completed')
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-md text-[10px] font-bold">Selesai / Terjual</span>
                            @else
                                <span class="px-2 py-1 bg-red-50 text-red-700 border border-red-200 rounded-md text-[10px] font-bold">Ditolak</span>
                            @endif
                        </td>

                        <!-- Form Perubahan Status oleh Admin -->
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.transactions.update', $tx->id) }}" method="POST" class="flex items-center justify-center space-x-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-[11px] p-1.5 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 bg-white">
                                    <option value="pending" {{ $tx->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $tx->status == 'approved' ? 'selected' : '' }}>Approved (Kunci Unit)</option>
                                    <option value="completed" {{ $tx->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                    <option value="rejected" {{ $tx->status == 'rejected' ? 'selected' : '' }}>Batalkan Transaksi</option>
                                </select>
                                <button type="submit" class="p-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="p-8 text-center text-gray-400">Belum ada transaksi booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
