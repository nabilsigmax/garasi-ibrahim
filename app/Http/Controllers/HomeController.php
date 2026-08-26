<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        // Filter Pencarian Nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori/Tipe
        if ($request->filled('category') && $request->category != 'Semua Kategori') {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        // Filter Transmisi
        if ($request->filled('transmission') && $request->transmission != 'Semua Transmisi') {
            $query->where('transmission', $request->transmission);
        }

        $cars = $query->latest()->get();

        return view('landing', compact('cars'));
    }
}