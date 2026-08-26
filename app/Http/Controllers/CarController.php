<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // Halaman Utama / Landing Page
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('body_type')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->body_type . '%')
                  ->orWhere('brand', 'like', '%' . $request->body_type . '%')
                  ->orWhere('description', 'like', '%' . $request->body_type . '%');
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $cars = $query->latest()->get();

        return view('landing', compact('cars'));
    }

    // Detail Mobil
    public function show($id)
    {
        $car = Car::findOrFail($id);

        return view('show', compact('car'));
    }

    // Halaman Dashboard Admin
    public function adminIndex()
{
    $cars = Car::all();
    
    // Ambil semua room chat beserta user dan pesan terakhirnya
    $chatRooms = ChatRoom::with(['user', 'messages' => function($query) {
        $query->latest();
    }])->latest()->get();

    return view('admin.index', compact('cars', 'chatRooms'));
}

    // Tambah Mobil Baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string',
            'brand'              => 'required|string',
            'year'               => 'nullable|numeric',
            'price'              => 'required|numeric',
            'color'              => 'nullable|string',
            'transmission'       => 'required|string',
            'fuel'               => 'nullable|string',
            'engine_capacity'    => 'nullable|string',
            'passenger_capacity' => 'nullable|string',
            'mileage'            => 'nullable|numeric',
            'condition'          => 'required|string',
            'description'        => 'nullable|string',
            'image'              => 'nullable|string',
            'gallery'            => 'nullable|string',
        ]);

        if (!empty($data['gallery'])) {
            $data['gallery'] = array_map('trim', explode(',', str_replace(["\r\n", "\n", "\r"], ',', $data['gallery'])));
        } else {
            $data['gallery'] = [];
        }

        Car::create($data);

        return redirect()->route('admin.index')->with('success', 'Mobil berhasil ditambahkan!');
    }

    // Edit Data Mobil
    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'name'               => 'required|string',
            'brand'              => 'required|string',
            'year'               => 'nullable|numeric',
            'price'              => 'required|numeric',
            'color'              => 'nullable|string',
            'transmission'       => 'required|string',
            'fuel'               => 'nullable|string',
            'engine_capacity'    => 'nullable|string',
            'passenger_capacity' => 'nullable|string',
            'mileage'            => 'nullable|numeric',
            'condition'          => 'required|string',
            'description'        => 'nullable|string',
            'image'              => 'nullable|string',
            'gallery'            => 'nullable|string',
        ]);

        if (!empty($data['gallery'])) {
            $data['gallery'] = array_map('trim', explode(',', str_replace(["\r\n", "\n", "\r"], ',', $data['gallery'])));
        } else {
            $data['gallery'] = [];
        }

        $car->update($data);

        return redirect()->route('admin.index')->with('success', 'Data mobil berhasil diperbarui!');
    }

    // Hapus Mobil
    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('admin.index')->with('success', 'Mobil berhasil dihapus!');
    }
}