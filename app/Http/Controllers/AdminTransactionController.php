<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $transactions = Transaction::with(['user', 'car'])->latest()->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $data = $request->validate(['status' => 'required|in:pending,approved,completed,rejected']);

        if ($data['status'] === 'rejected' && $transaction->status === 'completed') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat dibatalkan.');
        }

        $transaction->update($data);

        return back()->with('success', $data['status'] === 'rejected'
            ? 'Transaksi berhasil dibatalkan. Unit kembali tersedia untuk dibooking.'
            : 'Status transaksi berhasil diperbarui.');
    }
}
