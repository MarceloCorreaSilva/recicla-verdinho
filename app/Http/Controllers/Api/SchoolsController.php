<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return School::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        return response()->json($school);
    }

    /**
     * Display a listing of the resource.
     */
    public function count()
    {
        return [
            'count' => School::count(),
        ];
    }
}
