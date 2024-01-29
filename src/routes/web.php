<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 比較サイト
Route::get('car', [CarsController::class, 'index'])->name('car.index');
Route::get('car/minivan', [CarsController::class, 'minivan'])->name('car.minivan');
Route::get('car/suv', [CarsController::class, 'suv'])->name('car.suv');
Route::get('car/{id}', [CarsController::class, 'show'])->name('car.show');


