<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarsController;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\TireController;
use App\Http\Controllers\TirecalcController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\LavelController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
比較サイト
*/

// 比較サイト
//Route::get('car', [CarsController::class, 'index'])->name('car.index');



/*
csv処理
*/

// CSVデータ 
Route::get('car/csv/upload', [CsvController::class, 'uploadCar'])->name('csv.uploadCar');
//Route::post('car/csv/import',  [CsvController::class, 'importCar'])->name('csv.importCar');
//Route::get('car_dl', 'exportCar')->name('csv.export');


//Route::controller(CsvController::class)->prefix('admin/csv')->group(function () { 

//    // データ 
//    Route::get('car', 'uploadCar');
//    Route::post('car', 'importCar')->name('csv.importCar');

//});

//トップページ
Route::get('/car/index', function () {
    return view('car.index');
});

Route::get('/car', function () {
    return view('car.index');
});

//各ジャンルごとのページ
Route::get('car/{genre}', [CarsController::class, 'genre'])->name('car.genre'); //ジャンルごとのカテゴリー表示
//Route::get('car/{genre}/index', [CarsController::class, 'category'])->name('car.index'); //ジャンルごとのカテゴリー表示
//Route::get('car/{genre}/{spec}', [CarsController::class, 'year'])->name('car.year'); //スペックごとの年度表示
//Route::get('car/{genre}/{spec}/{year}', [CarsController::class, 'specLatest'])->name('car.specLatest'); //自動的に最新情報
Route::get('car/{genre}/{spec}/{year}/{half?}', [CarsController::class, 'spec'])->name('car.spec'); //最新スペック情報

//車種詳細ページ
Route::get('car/detail/{id}', [CarsController::class, 'show'])->name('car.show');

//新車から3年後
//Route::get('car/thirdyear', [CarsController::class, 'thirdyear'])->name('car.thirdyear');


/*
baby in car
*/
Route::get('baby', [BabyController::class, 'rakuten'])->name('baby.index');
Route::get('baby/pdf', [BabyController::class, 'viewPdf'])->name('baby.pdf');
Route::get('baby/{type}/{page?}', [BabyController::class, 'rakuten'])->name('baby.type');
Route::get('baby/result', [BabyController::class, 'get_rakuten_items'])->name('baby.result');


/*
タイヤ価格表
*/
//Route::get('tire', [TireController::class, 'index'])->name('tire.index');
//Route::post('tire/searchResult', [TireController::class, 'searchResult'])->name('tire.searchResult');
//Route::get('tire/searchResult', [TireController::class, 'searchResult'])->name('tire.searchResult');
////Route::post('tire', [TireController::class, 'index'])->name('tire.indexPdf');
//Route::post('tire/setPdf', [TireController::class, 'setPdf'])->name('tire.setPdf');
//Route::post('tire/createPdf', [TireController::class, 'createPdf'])->name('tire.createPdf');


/*
タイヤ計算機
*/
//Route::get('tirecalc', [TirecalcController::class, 'index'])->name('tirecalc.index');
////Route::get('tirecalc/setPdf', [TirecalcController::class, 'setPdf'])->name('tirecalc.setPdf');
//Route::post('tirecalc/createPdf', [TirecalcController::class, 'createPdf'])->name('tirecalc.createPdf');

Route::middleware(['web'])->group(function () {
    Route::get('tirecalc', [TirecalcController::class, 'index'])->name('tirecalc.index');
    Route::post('tirecalc/createPdf', [TirecalcController::class, 'createPdf'])->name('tirecalc.createPdf');
});



/*
PDF印刷
*/
//Route::get('pdf', [PdfController::class,'viewPdf']);


/*
見積もり
*/
Route::get('quote', [QuoteController::class, 'index'])->name('quote.index');
Route::middleware('auth')->group(function () {
    Route::resource('quotes', QuoteController::class)->only(['store', 'destroy', 'edit', 'update']);
});
Route::post('quotes/{quote}/copy', [QuoteController::class, 'storeCopy'])->name('quotes.copy');
Route::post('quotes/createPdf', [QuoteController::class, 'createPdf'])->name('quotes.createPdf');


/*
ラベル印刷
*/
Route::get('lavel', [LavelController::class, 'index'])->name('lavel.index');
Route::middleware('auth')->group(function () {
    Route::resource('lavels', LavelController::class)->only(['store', 'destroy', 'edit', 'update']);
});
Route::post('lavels/{lavel}/copy', [LavelController::class, 'storeCopy'])->name('lavels.copy');
Route::post('lavels/createPdf', [LavelController::class, 'createPdf'])->name('lavels.createPdf');


/*
年齢計算機
*/
Route::get('agecalc', function () {
    return view('agecalc.index');
})->name('agecalc.index');
