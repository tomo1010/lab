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
use App\Http\Controllers\FaxController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\InvoiceController;

use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Livewire\Livewire;


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
Stripe支払い関連
*/
// サブスクリプションの作成
Route::middleware(['auth'])->get('/subscribe', function (Request $request) {
    return $request->user()->newSubscription('default', 'price_1RQF1dDdEJpfTh4AsTnFR0k5')
        ->checkout([
            'success_url' => route('dashboard') . '?subscribed=1',
            'cancel_url' => route('dashboard'),
        ]);
});

// サブスクリプションのキャンセル
Route::post('/cancel', function () {
    auth()->user()->subscription('default')->cancel();
    return redirect()->back()->with('status', 'キャンセルしました');
});

// サブスクリプションの一時停止
Route::post('/resume', function (Request $request) {
    $request->user()->subscription('default')->resume();
    return redirect()->back()->with('status', 'サブスクリプションを再開しました');
})->middleware('auth');

// Stripeの請求書ポータルにリダイレクト
Route::middleware(['auth'])->get('/billing-portal', function (Request $request) {
    return $request->user()->redirectToBillingPortal(route('dashboard'));
});




/*
比較サイト
*/

// CSVデータ 
Route::get('car/csv/upload', [CsvController::class, 'uploadCar'])->name('csv.uploadCar');
Route::post('car/csv/import',  [CsvController::class, 'importCar'])->name('csv.importCar');
//Route::get('car_dl', 'exportCar')->name('csv.export');

//トップページ
Route::get('car/index', [CarsController::class, 'index'])->name('car.index');

//Route::get('/car', function () {
//    return view('car.index');
//});

//車種詳細ページ
Route::get('car/{genre}/detail/{id}', [CarsController::class, 'show'])->name('car.show');
//各ジャンルごとのページ　大カテゴリー小カテゴリーの一覧
Route::get('car/{genre}', [CarsController::class, 'genre'])->name('car.genre');
//各スペックごとのページ
Route::get('car/{genre}/{spec}/{year}/{half?}', [CarsController::class, 'spec'])->name('car.spec');



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
見積もり
*/
Route::get('quote', [QuoteController::class, 'index'])->name('quote.index');
Route::middleware('auth')->group(function () {
    Route::resource('quote', QuoteController::class)->only(['store', 'destroy', 'edit', 'update']);
});
Route::post('quote/{quote}/copy', [QuoteController::class, 'storeCopy'])->name('quote.copy');
Route::post('quote/createPdf', [QuoteController::class, 'createPdf'])->name('quote.createPdf');



/*
FAX送付状
*/
Route::get('send', function () {
    return view('fax.send');
})->name('fax.send');

Route::get('change', function () {
    return view('fax.change');
})->name('fax.change');

Route::post('fax/sendPdf', [FaxController::class, 'sendPdf'])->name('fax.sendPdf');
Route::post('fax/changePdf', [FaxController::class, 'changePdf'])->name('fax.changePdf');


/*
年齢計算機
*/
Route::get('agecalc', function () {
    return view('agecalc.index');
})->name('agecalc.index');



/*
ラベル印刷（css.paper）
*/
Route::match(['get', 'post'], '/label', [LabelController::class, 'index'])->name('label.index');
Route::post('/label/preview', [LabelController::class, 'preview'])->name('label.preview');


//ラベル保存処理（ログインユーザーのみ）
Route::post('/label/save', [LabelController::class, 'store'])
    ->middleware('auth')
    ->name('label.store');

Route::resource('label', LabelController::class)->only(['index', 'store', 'destroy']);



/*
下敷き印刷
*/

// 施工証明書
Route::get('pdf/construction', function () {
    return view('pdf.construction');
})->name('pdf.construction');

//売約済み（横書き）
Route::get('pdf/soldHorizental', function () {
    return view('pdf.soldHorizental');
})->name('pdf.soldHorizental');

//売約済み（縦書き）
Route::get('pdf/soldVertical', function () {
    return view('pdf.soldVertical');
})->name('pdf.soldVertical');



// PDF生成処理
Route::post('/pdf/generatePdf', [PdfController::class, 'generatePdf'])->name('pdf.generatePdf');



/*
請求書　liviwire3へ
*/
Route::get('invoice', [InvoiceController::class, 'index'])->name('invoice.index');
Route::middleware('auth')->group(function () {
    Route::resource('invoice', InvoiceController::class)->only(['store', 'destroy', 'edit', 'update']);
    Route::post('invoice/{invoice}/copy', [InvoiceController::class, 'storeCopy'])->name('invoice.copy');
});
Route::post('invoice/createPdf', [InvoiceController::class, 'createPdf'])->name('invoice.createPdf');
