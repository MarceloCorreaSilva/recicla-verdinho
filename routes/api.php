<?php

use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\SchoolsController;
use App\Http\Controllers\Api\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SwapsController;
use App\Models\School;
use App\Models\Student;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cities', [CitiesController::class, 'index']);
Route::get('cities/count', [CitiesController::class, 'count']);
Route::get('cities/{city}', [CitiesController::class, 'show']);

Route::get('schools', [SchoolsController::class, 'index']);
Route::get('schools/count', [SchoolsController::class, 'count']);
Route::get('schools/{school}', [SchoolsController::class, 'show']);

Route::get('students', [StudentsController::class, 'index']);
Route::get('students/count', [StudentsController::class, 'count']);
Route::get('students/{student}', [StudentsController::class, 'show']);

Route::get('swaps', [SwapsController::class, 'index']);
Route::get('swaps/today', [SwapsController::class, 'today']);
Route::get('swaps/{swap}', [SwapsController::class, 'show']);



// API Cidades
// https://painel.reciclaverdinho.com.br/api/cites
// https://painel.reciclaverdinho.com.br/api/cites/couunt

// API Escolas
// https://painel.reciclaverdinho.com.br/api/schools
// https://painel.reciclaverdinho.com.br/api/schools/count

// API Aluns
// https://painel.reciclaverdinho.com.br/api/students
// https://painel.reciclaverdinho.com.br/api/students/count

// API Trocas
// https://painel.reciclaverdinho.com.br/api/swaps
// https://painel.reciclaverdinho.com.br/api/swaps/today


// https://medium.com/@miladev95/how-to-create-rest-api-crud-in-laravel-10-8a5d09cd7901

// How to document your Laravel API with Swagger and PHP attributes
// https://medium.com/@nelsonisioma1/how-to-document-your-laravel-api-with-swagger-and-php-attributes-1564fc11c305
