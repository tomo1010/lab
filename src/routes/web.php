<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\CsvController;


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
Route::get('car/{genre}', [CarsController::class, 'genre'])->name('car.genre'); //ジャンルごとのカテゴリー表示
//Route::get('car/{genre}/index', [CarsController::class, 'category'])->name('car.index'); //ジャンルごとのカテゴリー表示
//Route::get('car/{genre}/{spec}', [CarsController::class, 'year'])->name('car.year'); //スペックごとの年度表示
//Route::get('car/{genre}/{spec}/{year}', [CarsController::class, 'specLatest'])->name('car.specLatest'); //自動的に最新情報
Route::get('car/{genre}/{spec}/{year}/{half?}', [CarsController::class, 'spec'])->name('car.spec'); //最新スペック情報

////各ジャンルごとのページ
//Route::get('car/{genre}', [CarsController::class, 'genre'])->name('car.genre'); //ジャンルごとのカテゴリー
//Route::get('car/{genre}/{spec}', [CarsController::class, 'spec'])->name('car.spec'); //スペックごとの年度表示
//Route::get('car/{genre}/{spec}/{year}', [CarsController::class, 'spec'])->name('car.spec'); //自動的に最新情報
//Route::get('car/{genre}/{spec}/{year}/{half}', [CarsController::class, 'spec'])->name('car.spec'); //上半期下半期を指定した最新情報

//車種詳細ページ
Route::get('car/detail/{id}', [CarsController::class, 'show'])->name('car.show');

//新車から3年後
//Route::get('car/thirdyear', [CarsController::class, 'thirdyear'])->name('car.thirdyear');


/*
csv処理
*/

    // CSVデータ 
    Route::get('car/csv/upload', [CsvController::class, 'uploadCar'])->name('csv.uploadCar');
    Route::post('car',  [CsvController::class, 'importCar'])->name('csv.importCar');
    //Route::get('car_dl', 'exportCar')->name('csv.export');


//Route::controller(CsvController::class)->prefix('admin/csv')->middleware(['auth', 'can:admin-only'])->group(function () { 

//    // 芸人データ 
//    Route::get('car', 'uploadCar');
//    Route::post('car', 'importCar')->name('csv.importCar');
//    Route::get('car_dl', 'exportCar')->name('csv.exportCar');

//});


