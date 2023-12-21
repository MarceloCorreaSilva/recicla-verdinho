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
                '5102678',
                '5104104',
                '5106307',
                '5007208',
                '5100201',
                '5105580',
                '5005400',
                '5003256',
                '5006200',
                '5003702',
                '5000609',
                '5007406',
                '5004403',
                '5107925',
                '5107248',
                '5103056',
                '5006275',
                '5107958',
                '5006002',
                '5104609',
                '5103502',
                '5106505',
                '5106109',
                '5101605',
                '5102504',
                '5102702',
                '5005707',
                '5002100',
                '5002407',
                '5006606',
                '5105234',
                '5007554',
                '5001904',
                '5101407',
                '5003306',
                '5002308',
                '5005806'
            ])) {
                City::factory()->create([
                    'id' => $city['id'],
                    'state_id' => $city['state_id'],
                    'name' => $city['name'],
                    'active' => true,
                ]);
            }
        }
    }
}
