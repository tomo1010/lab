<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\BabyController;


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

/*
比較サイト
*/

// 比較サイト
Route::get('car', [CarsController::class, 'index'])->name('car.index');

//各ジャンルごとのページ
Route::get('car/{genre}', [CarsController::class, 'genre'])->name('car.genre'); //ジャンルごとのカテゴリー表示
//Route::get('car/{genre}/index', [CarsController::class, 'category'])->name('car.index'); //ジャンルごとのカテゴリー表示
//Route::get('car/{genre}/{spec}', [CarsController::class, 'year'])->name('car.year'); //スペックごとの年度表示
//Route::get('car/{genre}/{spec}/{year}', [CarsController::class, 'specLatest'])->name('car.specLatest'); //自動的に最新情報
Route::get('car/{genre}/{spec}/{year}/{half?}', [CarsController::class, 'spec'])->name('car.spec'); //最新スペック情報

//車種詳細ページ
Route::get('car/detail/{id}', [CarsController::class, 'show'])->name('car.show');



/*
baby in car
*/
Route::get('baby', [BabyController::class, 'rakuten'])->name('baby.index');
Route::get('baby/{type}/{page?}', [BabyController::class, 'rakuten'])->name('baby.type');
Route::get('baby/result', [BabyController::class, 'get_rakuten_items'])->name('baby.result');

