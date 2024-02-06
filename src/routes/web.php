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

//ジャンル別一覧

Route::get('car/suv', [CarsController::class, 'suv'])->name('car.suv');
Route::get('car/thirdyear', [CarsController::class, 'thirdyear'])->name('car.thirdyear');
Route::get('car/minivan/{year}', [CarsController::class, 'minivan'])->name('car.minivan');
Route::get('car/minivan/{year}/name', [CarsController::class, 'minivanName'])->name('car.minivanName');
Route::get('car/minivan/{year}/maker', [CarsController::class, 'minivanMaker'])->name('car.minivanMaker');

Route::get('car/{id}', [CarsController::class, 'show'])->name('car.show');
