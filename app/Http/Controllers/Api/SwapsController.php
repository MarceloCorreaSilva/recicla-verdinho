<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Swap;

class SwapsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Swap::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Swap $swap)
    {
        return response()->json($swap);
    }

    /**
     * Display a listing of the resource.
     */
    public function today()
    {
        $lastSwap = Swap::orderBy('date', 'desc')->first();

        $pet_bottles = Swap::sum('pet_bottles');
        $packaging_of_cleaning_materials = Swap::sum('packaging_of_cleaning_materials');
        $tetra_pak = Swap::sum('tetra_pak');
        $aluminum_cans = Swap::sum('aluminum_cans');

        return [
            'lastSwap' => $lastSwap['date'],
            'pet_bottles' => $pet_bottles,
            'packaging_of_cleaning_materials' => $packaging_of_cleaning_materials,
            'tetra_pak' => $tetra_pak,
            'aluminum_cans' => $aluminum_cans
        ];
    }
}
