<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = $request->user()->transactions()->with('car')->latest()->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request, Car $car)
    {
        $hasActiveTransaction = Transaction::where('car_id', $car->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        abort_if($hasActiveTransaction, 422, 'Unit ini sedang dalam proses booking.');

        return view('transactions.create', compact('car'));
    }

    public function store(Request $request, Car $car)
    {
        $data = $request->validate([
            'payment_method' => 'required|in:booking_fee,credit,cash',
            'payment_channel' => 'required|in:bank_transfer,ewallet,qris,showroom',
            'down_payment' => 'required|integer|min:1|max:' . $car->price,
            'payment_receipt' => 'nullable|image|max:2048',
        ]);

        $transaction = DB::transaction(function () use ($request, $car, $data) {
            $activeTransaction = Transaction::where('car_id', $car->id)
                ->whereIn('status', ['pending', 'approved'])
                ->lockForUpdate()
                ->exists();

            abort_if($activeTransaction, 422, 'Unit ini sedang dalam proses booking oleh pelanggan lain.');

            $receipt = $request->file('payment_receipt')?->store('payment-receipts', 'public');

            return Transaction::create([
                'invoice_number' => 'TRX-' . now()->format('Ymd') . '-' . strtoupper(str()->random(6)),
                'user_id' => $request->user()->id,
                'car_id' => $car->id,
                'payment_method' => $data['payment_method'],
                'payment_channel' => $data['payment_channel'],
                'total_price' => $car->price,
                'down_payment' => $data['down_payment'],
                'payment_receipt' => $receipt,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Booking berhasil dibuat dengan nomor invoice ' . $transaction->invoice_number . '.');
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        abort_unless($transaction->user_id === $request->user()->id, 403);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Hanya transaksi yang masih menunggu verifikasi yang dapat dibatalkan.');
        }

        $transaction->update(['status' => 'rejected']);

        return back()->with('success', 'Transaksi berhasil dibatalkan. Unit kembali tersedia untuk dibooking.');
    }
}
