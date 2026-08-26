<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Tambahkan method index ini
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Mengambil daftar wishlist milik user yang sedang login beserta data mobilnya
        $wishlists = Wishlist::with('car')->where('user_id', Auth::id())->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle($carId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = Auth::id();
        $wishlist = Wishlist::where('user_id', $userId)->where('car_id', $carId)->first();

        if ($wishlist) {
            $wishlist->delete();
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'car_id' => $carId,
            ]);
        }

        return back();
    }
}