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
    return view('welcome')->name(home);
});

// 比較サイト
Route::get('car', [CarsController::class, 'index'])->name('car.index');



//各ジャンルごとのページ
Route::get('car/{genre}', [CarsController::class, 'genre'])->name('car.genre');
//Route::get('car/{genre}/{spec}', [CarsController::class, 'year'])->name('car.year');
Route::get('car/{genre}/{spec}/{year}', [CarsController::class, 'spec'])->name('car.spec');

//車種詳細ページ
Route::get('car/detail/{id}', [CarsController::class, 'show'])->name('car.show');


//Route::get('car/{genre}/{year}/maker', [CarsController::class, 'maker'])->name('car.maker');
//Route::get('car/{genre}/{year}/name', [CarsController::class, 'name'])->name('car.name');
//Route::get('car/{genre}/{year}/release', [CarsController::class, 'release'])->name('car.release');


//SUV
//Route::get('car/suv', [CarsController::class, 'suv'])->name('car.suv');

//新車から3年後
//Route::get('car/thirdyear', [CarsController::class, 'thirdyear'])->name('car.thirdyear');


