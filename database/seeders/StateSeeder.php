<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $states = File::json(public_path('data/states.json'));

        // foreach ($states as $state) {
        //     if (in_array($state['id'], ['50', '51'])) {
        //         State::factory()->create([
        //             'id' => $state['id'],
        //             'name' => $state['name'],
        //             'abbreviation' => $state['abbreviation'],
        //         ]);
        //     }
        // }

        State::factory()->create([
            'id' => 51,
            'name' => 'Mato Grosso',
            'abbreviation' => 'MT'
        ]);
    }
}
