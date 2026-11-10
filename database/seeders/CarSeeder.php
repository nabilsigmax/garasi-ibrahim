<?php

namespace Database\Seeders;

use App\Models\BodyType;
use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $bodyTypeIds = BodyType::pluck('id', 'name');

        

        foreach ($cars as $car) {
            $car['body_type_id'] = $bodyTypeIds[$car['body_type']] ?? null;
            unset($car['body_type']);
            $car['gallery'] = [];

            Car::updateOrCreate(['name' => $car['name']], $car);
        }
    }
}
