<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = File::json(public_path('data/cities.json'));

        foreach ($cities as $city) {
            if (in_array($city['id'], [
                '5100201',
            ])) {
                City::factory()->create([
                    'id' => $city['id'],
                    'state_id' => $city['state_id'],
                    'name' => $city['name'],
                    'active' => true,
                ]);
            }
        }

        // City::factory()->create([
        //     'id' > '5100201',
        //     'state_id' => 51,
        //     'name' => 'Água Boa',
        //     'active' => true,
        // ]);
    }
}
