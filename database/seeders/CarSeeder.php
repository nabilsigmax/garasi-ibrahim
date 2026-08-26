<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        Car::create([
            'name' => 'Mercedes-Benz S 450',
            'brand' => 'Mercedes-Benz',
            'category' => 'Luxury Sedan',
            'badge' => 'PREMIUM',
            'badge_color' => 'bg-gray-800',
            'price' => 2450000000,
            'year' => 2022,
            'transmission' => 'Automatic',
            'fuel' => 'Petrol',
            'mileage' => 5000,
            'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=800',
            'description' => 'Mercedes-Benz S 450 dengan interior mewah, kondisi sangat terawat seperti baru.',
        ]);

        Car::create([
            'name' => 'BMW X5 xDrive40i',
            'brand' => 'BMW',
            'category' => 'Luxury SUV',
            'badge' => 'TERLAKU',
            'badge_color' => 'bg-amber-600',
            'price' => 1650000000,
            'year' => 2021,
            'transmission' => 'Automatic',
            'fuel' => 'Petrol',
            'mileage' => 12500,
            'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=800',
            'description' => 'SUV tangguh dengan kenyamanan maksimal dan fitur keamanan lengkap.',
        ]);

        Car::create([
            'name' => 'Range Rover Sport',
            'brand' => 'Land Rover',
            'category' => 'Luxury Off-road',
            'badge' => 'BARU MASUK',
            'badge_color' => 'bg-blue-600',
            'price' => 3200000000,
            'year' => 2023,
            'transmission' => 'Automatic',
            'fuel' => 'Diesel',
            'mileage' => 2000,
            'image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?q=80&w=800',
            'description' => 'Range Rover Sport kondisi gress, kilometer sangat rendah.',
        ]);
    }
}