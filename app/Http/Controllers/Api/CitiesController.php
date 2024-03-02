<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return City::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return response()->json($city);
    }

    /**
     * Display a listing of the resource.
     */
    public function count()
    {
        return [
            'count' => City::count(),
        ];
    }
}
