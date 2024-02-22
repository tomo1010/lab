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
Route::get('car/{genre}', [CarsController::class, 'category'])->name('car.category'); //ジャンルごとのカテゴリー
Route::get('car/{genre}/{spec}', [CarsController::class, 'year'])->name('car.year'); //スペックごとの年度表示
//Route::get('car/{genre}/{spec}/{year}', [CarsController::class, 'specLatest'])->name('car.specLatest'); //自動的に最新情報
Route::get('car/{genre}/{spec}/{year}/{half?}', [CarsController::class, 'spec'])->name('car.spec'); //上半期下半期を指定した最新情報

////各ジャンルごとのページ
//Route::get('car/{genre}', [CarsController::class, 'genre'])->name('car.genre'); //ジャンルごとのカテゴリー
//Route::get('car/{genre}/{spec}', [CarsController::class, 'spec'])->name('car.spec'); //スペックごとの年度表示
//Route::get('car/{genre}/{spec}/{year}', [CarsController::class, 'spec'])->name('car.spec'); //自動的に最新情報
//Route::get('car/{genre}/{spec}/{year}/{half}', [CarsController::class, 'spec'])->name('car.spec'); //上半期下半期を指定した最新情報

//車種詳細ページ
Route::get('car/detail/{id}', [CarsController::class, 'show'])->name('car.show');


//新車から3年後
//Route::get('car/thirdyear', [CarsController::class, 'thirdyear'])->name('car.thirdyear');


