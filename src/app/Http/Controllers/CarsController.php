<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;    // 追加
use Carbon\Carbon;

use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;


class CarsController extends Controller
{

    const THISYEAR = 2025; //下半期には翌年度を指定するため必要な処理　※carbonで当年度を取得してはダメ


    /**
     * Display a listing of the resource.
     *　車種CRUD操作
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //車種すべて取得
        $cars = Car::paginate(25);

        // 車種一覧ビューでそれを表示
        return view('car.index', [
            'cars' => $cars,
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id, $genre)
    {
        $car = Car::findOrFail($id);
        $count = $car->count();

        // メッセージ詳細ビューでそれを表示
        return view('car.show', [
            'car' => $car,
            'genre' => $genre,
            'count' => $count,
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }





    /**
     * Remove the specified resource from storage.
     *　スペック
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function spec($genre, $spec, $year, $half = null)
    {

        //年度取得
        $thisyear = self::THISYEAR;

        //上下半期のデータがない場合の処理、常に最新のデータを取得する
        if (is_null($half)) {
            $half = Car::orderBy('id', 'desc')->value('half');
        }

        //getパラメータからチェックを受け取る        
        $import = request('import');
        $excludeKei = request('exclude_keicar');
        $excludeHv = request('exclude_hv');
        $excludeDiesel = request('exclude_diesel');


        /*
        デフォルトは国産車のみ表示、輸入車チェックを受け取ると輸入車表示
        */

        // ベースクエリ
        $query = Car::query();

        // ジャンルによる絞り込み
        switch ($genre) {
            case 'minivan':
                $query->where('minivan_flug', 1);
                break;
            case 'puchivan':
                $query->where('puchivan_flug', 1);
                break;
            case 'suv':
                $query->where('suv_flug', 1);
                break;
            case 'hatchback':
                $query->where('hatchback_flug', 1);
                break;
            case 'sedan':
                $query->where('sedan_flug', 1);
                break;
            case 'wagon':
                $query->where('wagon_flug', 1);
                break;
            case 'sports':
                $query->where('sports_flug', 1);
                break;
            case 'kei':
                $query->where('kei_flug', 1);
                break;
            case 'kei_wagon':
                $query->where('kei_style', 'ワゴン');
                break;
            case 'kei_heightwagon':
                $query->where('kei_style', 'ハイトワゴン');
                break;
            case 'kei_slide':
                $query->where('kei_flug', 1)->where('slidedoor_flug', 1);
                break;
            case 'kei_sedan':
                $query->where('kei_style', 'セダン');
                break;
            case 'kei_sports':
                $query->where('kei_style', 'スポーツ');
                break;
            case 'kei_suv':
                $query->where('kei_style', 'SUV');
                break;
            case 'kei_truck':
                $query->where('kei_style', 'トラック');
                break;
            case 'kei_hako':
                $query->where('kei_style', '軽箱');
                break;
            case 'kei_hakowagon':
                $query->where('kei_style', '軽箱ワゴン');
                break;
            case 'kei_heightvan':
                $query->where('kei_style', 'ハイトバン');
                break;
            case '3year':
                $query->whereYear('release', now()->subYears(3)->year);
                break;
            case '5year':
                $query->whereYear('release', now()->subYears(5)->year);
                break;
            case '7year': // ※元コードに5yearが重複してたので7yearとしました
                $query->whereYear('release', now()->subYears(7)->year);
                break;
            case 'longseler':
                $query->whereYear('release', '<=', now()->subYears(10)->year);
                break;
            case 'suv_3rd':
                $query->where('suv3rd_flug', 1);
                break;
            case 'compact':
                $query->where([
                    ['size_length', '<=', 4.70],
                    ['size_width', '<=', 1.70],
                    ['size_height', '<=', 2.00],
                ])
                    ->whereNull('kei_flug')
                    ->whereNull('van_flug');
                break;
            case '2door_courpe':
                $query->where('sports_flug', 1)
                    ->where('door', 2)
                    ->whereNull('van_flug');
                break;
            case 'headlight':
                $query->where('headlight_flug', 1);
                break;
            case 'oem':
                $query->where('oem_flug', 1);
                break;
            case 'familly':
                // famillyだけ特殊なので後で個別処理
                break;
        }

        // famillyだけ特別処理
        if ($genre === 'familly') {
            $cars_ridingcapacity = Car::where('ridingcapacity', '>=', 6)->get();
            $cars_kei = Car::where('kei_style', 'ハイトワゴン')->get();
            $cars = $cars_ridingcapacity->concat($cars_kei);
        } else {
            // 共通絞り込み
            $query->where('half', $half);

            // 日本車限定（$importがNULLのとき）
            if (is_null($import)) {
                $query->where('japan_flug', 1);
            }

            // 軽自動車除外（excludeKeiが1のとき）
            if ($excludeKei === '1') {
                $query->where(function ($q) {
                    $q->where('kei_flug', '!=', 1)->orWhereNull('kei_flug');
                });
            }

            // HV除外（excludeHvが1のとき）
            if ($excludeHv === '1') {
                $query->where(function ($q) {
                    $q->where('hev_flug', '!=', 1)->orWhereNull('hev_flug');
                });
            }

            // ディーゼル除外（excludeDieselが1のとき）
            if ($excludeDiesel === '1') {
                $query->where(function ($q) {
                    $q->where('diesel_flug', '!=', 1)->orWhereNull('diesel_flug');
                });
            }

            // 年式絞り込み（release年を使うジャンルは除く）
            if (!in_array($genre, ['3year', '5year', '7year', 'longseler'])) {
                $query->where('year', $year);
            }

            // クエリ実行
            $cars = $query->get();
        }

        // 件数取得
        $count = $cars->count();


        /*
        /
            各スペックを取得しspecページへ
        /
        */

        // ソートするだけの項目をまとめる
        $sortSpecs = [
            'maker',
            'name',
            'drive',
            'fuel',
            'price',
            'size_length',
            'size_width',
            'size_height',
            'wheelbase',
            'tred',
            'weight',
            'ridingcapacity',
            'tiresize_front',
            'minivan_style',
            'suv_style',
            'slidedoor_flug',
        ];

        // 降順でソートする項目
        $sortDescSpecs = [
            'release',
            'color',
            'fueltank',
            'JC08',
            'WLTC',
            'displacement',
            'ps',
            'torque',
            'puchivan_doorsize',
            'wagon_luggage',
        ];

        // null優先ソートが必要な項目
        $nullPrioritySpecs = [
            'turningradius',
            'indoorsize_length',
            'indoorsize_width',
            'indoorsize_height',
            'groundclearance',
        ];

        // ソート処理
        if (in_array($spec, $sortSpecs)) {
            $cars = $cars->sortBy($spec);
        } elseif (in_array($spec, $sortDescSpecs)) {
            $cars = $cars->sortByDesc($spec);
        } elseif (in_array($spec, $nullPrioritySpecs)) {
            $cars = $cars->sortBy(function ($item) use ($spec) {
                return $item[$spec] === null ? PHP_FLOAT_MAX : $item[$spec];
            })->values();
        }
        // 特殊な処理が必要な場合
        elseif (in_array($spec, ['minivan_size', 'suv_size', 'hatchback_size', 'wagon_size', 'sedan_size', 'sports_size'])) {
            $cars = $this->calculateSizeCategory($cars, $spec);
        } elseif ($spec == 'tax') {
            $cars = $this->calculateTax($cars);
        } elseif ($spec == 'jtax') {
            $cars = $this->calculateJtax($cars);
        } elseif ($spec == 'kg') {
            $cars = $this->calculateKgUnitPrice($cars);
        } elseif ($spec == 'cruising') {
            $cars = $this->calculateCruisingDistance($cars);
        } elseif ($spec == 'bodysize') {
            $cars = $this->calculateBodySize($cars);
        } elseif ($spec == 'indoorsize') {
            $cars = $this->calculateIndoorSize($cars);
        } elseif ($spec == 'gap') {
            $cars = $this->calculateGap($cars);
        } elseif ($spec == 'jibai') {
            $cars = $this->calculateJibai($cars);
        } elseif ($spec == 'overhead') {
            $cars = $this->calculateOverhead($cars);
        }

        // 最後に共通のreturn
        return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
    }



    //ジャンル別サイズ　SML
    protected function calculateSizeCategory($cars, $spec)
    {
        // サイズごとの基準値を設定
        $thresholds = [
            'minivan_size' => [7.5, 7.9, 8.04, 8.49],
            'suv_size' => [7.0, 7.72, 7.95, 8.47],
            'hatchback_size' => [5.33, 6.97, 7.3, 7.75],
            'wagon_size' => [7.0, 7.55, 8.09, 8.19],
            'sedan_size' => [7.0, 7.69, 7.91, 8.2],
            'sports_size' => [6.16, 7.28, 7.55, 7.99],
        ];

        foreach ($cars as $car) {
            $size = $car->size_length + $car->size_width + $car->size_height;
            $car->size = $size; // ソート用

            if ($size <= $thresholds[$spec][0]) {
                $car->$spec = 'XS';
            } elseif ($size <= $thresholds[$spec][1]) {
                $car->$spec = 'S';
            } elseif ($size <= $thresholds[$spec][2]) {
                $car->$spec = 'M';
            } elseif ($size <= $thresholds[$spec][3]) {
                $car->$spec = 'L';
            } else {
                $car->$spec = 'XL';
            }
        }

        return $cars->sortByDesc('size')->values();
    }

    //自動車税
    protected function calculateTax($cars)
    {
        foreach ($cars as $car) {
            $disp = $car->displacement;
            if ($disp === null || $disp == '-') {
                $car->tax = '-';
            } elseif ($disp < 660) {
                $car->tax = 10800;
            } elseif ($disp < 1000) {
                $car->tax = 25000;
            } elseif ($disp < 1500) {
                $car->tax = 30500;
            } elseif ($disp < 2000) {
                $car->tax = 36000;
            } elseif ($disp < 2500) {
                $car->tax = 43500;
            } elseif ($disp < 3000) {
                $car->tax = 50000;
            } elseif ($disp < 3500) {
                $car->tax = 57000;
            } elseif ($disp < 4000) {
                $car->tax = 65500;
            } elseif ($disp < 4500) {
                $car->tax = 75500;
            } elseif ($disp < 5000) {
                $car->tax = 87000;
            } elseif ($disp < 5500) {
                $car->tax = 110000;
            } else {
                $car->tax = 110000; // 上限
            }
        }

        return $cars;
    }

    //自動車重量税
    protected function calculateJtax($cars)
    {
        foreach ($cars as $car) {
            if ($car->weight === null || $car->weight == '-') { // 本番環境ならnull判定推奨
                $car->jtax = '-';
            } elseif ($car->weight < 500) {
                $car->jtax = 12600;
            } elseif ($car->weight < 1000) {
                $car->jtax = 25200;
            } elseif ($car->weight < 1500) {
                $car->jtax = 37800;
            } elseif ($car->weight < 2000) {
                $car->jtax = 50400;
            } elseif ($car->weight < 2500) {
                $car->jtax = 63000;
            } elseif ($car->weight < 3000) {
                $car->jtax = 75600;
            } else {
                $car->jtax = '-'; // 重量3000kg以上は今回は'-'にしておきます（必要なら上限設定してもOK）
            }
        }

        return $cars->sortBy('weight')->values();
    }

    //kg単価
    protected function calculateKgUnitPrice($cars)
    {
        foreach ($cars as $car) {
            if (!is_null($car->weight) && !is_null($car->price)) {
                $price = $car->price * 10000; // priceは万円単位なので
                $weight = $car->weight;

                if ($weight > 0) {
                    $car->kg = floor($price / $weight);
                } else {
                    $car->kg = '-'; // 万一重量0とか異常データなら'-'に
                }
            } else {
                $car->kg = '-'; // weightまたはpriceがnullなら'-'
            }
        }

        return $cars->sortByDesc('kg')->values();
    }

    //航続距離
    protected function calculateCruisingDistance($cars)
    {
        foreach ($cars as $car) {
            if (!is_null($car->fueltank) && !is_null($car->WLTC)) {
                $car->cruising = $car->fueltank * $car->WLTC;
            } else {
                $car->cruising = '-'; // どちらか欠けてたら'-'
            }
        }

        return $cars->sortByDesc('cruising')->values();
    }

    //ボディサイズ（大きさ）
    protected function calculateBodySize($cars)
    {
        foreach ($cars as $car) {
            if (!is_null($car->size_length) && !is_null($car->size_width) && !is_null($car->size_height)) {
                $car->bodysize = $car->size_length + $car->size_width + $car->size_height;
            } else {
                $car->bodysize = '-'; // どれか欠けてたら'-'
            }
        }

        return $cars->sortByDesc('bodysize')->values();
    }

    //車内サイズ（室内の広さ）
    protected function calculateIndoorSize($cars)
    {
        foreach ($cars as $car) {
            if (!is_null($car->indoorsize_length) && !is_null($car->indoorsize_width) && !is_null($car->indoorsize_height)) {
                $car->indoorsize = $car->indoorsize_length + $car->indoorsize_width + $car->indoorsize_height;
            } else {
                $car->indoorsize = '-'; // どれか欠けてたら '-'
            }
        }

        return $cars->sortByDesc('indoorsize')->values();
    }

    //ボディサイズは小さいけど室内は広い（ギャップ）
    protected function calculateGap($cars)
    {
        foreach ($cars as $car) {
            if (
                !is_null($car->size_length) && !is_null($car->size_width) && !is_null($car->size_height) &&
                !is_null($car->indoorsize_length) && !is_null($car->indoorsize_width) && !is_null($car->indoorsize_height)
            ) {
                $size = $car->size_length + $car->size_width + $car->size_height;
                $indoorsize = $car->indoorsize_length + $car->indoorsize_width + $car->indoorsize_height;

                $car->size = $size;
                $car->indoorsize = $indoorsize;
                $car->gap = $size - $indoorsize;
            } else {
                $car->gap = null; // どこか抜けてたらnull
            }
        }

        return $cars->sortByDesc(function ($item) {
            return $item->gap === null ? PHP_FLOAT_MIN : $item->gap;
        })->values();
    }

    //自動車自賠責
    protected function calculateJibai($cars)
    {
        foreach ($cars as $car) {
            if (is_null($car->displacement)) { // 本番用にnullチェック
                $car->jibai = '-';
            } elseif ($car->displacement < 660) {
                $car->jibai = '17540';
            } else {
                $car->jibai = '17650';
            }
        }

        return $cars->sortBy('displacement');
    }

    //自動車諸費用
    protected function calculateOverhead($cars)
    {
        foreach ($cars as $car) {
            // 重量税計算
            if (is_null($car->weight)) {
                $car->jtax = 0;
            } elseif ($car->weight < 500) {
                $car->jtax = 12600;
            } elseif ($car->weight < 1000) {
                $car->jtax = 25200;
            } elseif ($car->weight < 1500) {
                $car->jtax = 37800;
            } elseif ($car->weight < 2000) {
                $car->jtax = 50400;
            } elseif ($car->weight < 2500) {
                $car->jtax = 63000;
            } elseif ($car->weight < 3000) {
                $car->jtax = 75600;
            } else {
                $car->jtax = 0;
            }

            // 自賠責計算
            if (is_null($car->displacement)) {
                $car->jibai = 0;
            } elseif ($car->displacement < 660) {
                $car->jibai = 17540;
            } else {
                $car->jibai = 17650;
            }

            // 合算（車検諸費用）
            $car->overhead = $car->jtax + $car->jibai;
        }

        return $cars->sortBy('overhead');
    }






    /**
     * Remove the specified resource from storage.
     *　　ジャンル
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function genre($genre)
    {
        $year = self::THISYEAR;
        //dd($genre);
        // ジャンルとクエリ条件のマッピング
        $genreConditions = [
            'minivan' => ['minivan_flug' => 1],
            'puchivan' => ['puchivan_flug' => 1],
            'suv' => ['suv_flug' => 1],
            'hatchback' => ['hatchback_flug' => 1],
            'sedan' => ['sedan_flug' => 1],
            'wagon' => ['wagon_flug' => 1],
            'sports' => ['sports_flug' => 1],
            'kei' => ['kei_flug' => 1],
            'kei_slide' => ['kei_flug' => 1, 'slidedoor_flug' => 1],
            'suv_3rd' => ['suv3rd_flug' => 1],
            'headlight' => ['headlight_flug' => 1],
            'oem' => ['oem_flug' => 1],
        ];

        $genreStyles = [
            'kei_wagon' => 'ワゴン',
            'kei_heightwagon' => 'ハイトワゴン',
            'kei_sedan' => 'セダン',
            'kei_sports' => 'スポーツ',
            'kei_suv' => 'SUV',
            'kei_hako' => '軽箱',
            'kei_hakowagon' => '軽箱ワゴン',
            'kei_heightvan' => 'ハイトバン',
        ];

        // 年数によるジャンル
        $yearGenres = [
            '3year' => 3,
            '5year' => 5,
            '7year' => 7,
            'longseler' => 10,
        ];

        if (isset($genreConditions[$genre])) {
            // シンプルなフラグ条件
            $cars = Car::where($genreConditions[$genre])->get();
        } elseif (isset($genreStyles[$genre])) {
            // スタイルによる条件
            $cars = Car::where('kei_style', $genreStyles[$genre])->get();
        } elseif (isset($yearGenres[$genre])) {
            // 年数条件
            $dt = now()->subYears($yearGenres[$genre])->format('Y');
            $cars = Car::whereYear('release', $dt)->get();
        } elseif ($genre === 'compact') {
            $cars = Car::whereNotNull('kei_flug')
                ->where('kei_flug', '<>', 1)
                ->where('size_length', '<=', 4.70)
                ->where('size_width', '<=', 1.70)
                ->where('size_height', '<=', 1.75)
                ->get();
        } elseif ($genre === '2door_courpe') {
            $cars = Car::where('sports_flug', 1)
                ->where('door', 2)
                ->whereNull('van_flug')
                ->get();
        } elseif ($genre === 'familly') {
            $cars_ridingcapacity = Car::where('ridingcapacity', '>=', 6)->get();
            $cars_kei = Car::where('kei_style', 'ハイトワゴン')->get();
            $cars = $cars_ridingcapacity->concat($cars_kei);
        } else {
            // 該当なし（エラー処理してもいいかも）
            $cars = collect();
        }

        $count = $cars->count();
        $half = Car::orderByDesc('id')->value('half');

        return view('car.genre', [
            'genre' => $genre,
            'cars' => $cars,
            'year' => $year,
            'half' => $half,
            'count' => $count,
        ]);
    }
}
