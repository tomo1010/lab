<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;    // 追加
use Carbon\Carbon;

use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;


class CarsController extends Controller
{

    const THISYEAR = 2024; //下半期には翌年度を指定するため必要な処理　※carbonで当年度を取得してはダメ


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


    public function show($id)
    {
        $car = Car::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        return view('car.show', [
            'car' => $car,
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

        //$half未入力の場合、常に最新のデータを表示させる処理
        if (empty($half)) {
            $car = Car::whereYear('created_at', '<=', $year)->where('half', '=', '2')->first();

            if (empty($car)) {
                $half = 1;
            } else {
                $half = 2;
            }
        }



        //getパラメータから「国産車のみ」のチェックを受け取る        
        $import = request('import');


        /*
        デフォルトは国産車のみ表示、輸入車チェックを受け取ると輸入車表示
        */

        if ($import == NULL) {

            /*
            ジャンルと年を取得
            */

            if ($genre == 'minivan') {
                $cars = Car::where([
                    ['minivan_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'puchivan') {
                $cars = Car::where([
                    ['puchivan_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'suv') {
                $cars = Car::where([
                    ['suv_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'hatchback') {
                $cars = Car::where([
                    ['hatchback_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'sedan') {
                $cars = Car::where([
                    ['sedan_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'wagon') {
                $cars = Car::where([
                    ['wagon_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'sports') {
                $cars = Car::where([
                    ['sports_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();


                /*
            軽自動車
            */
            } elseif ($genre == 'kei') {
                $cars = Car::where([
                    ['kei_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_wagon') {
                $cars = Car::where([
                    ['kei_style', '=', 'ワゴン'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_heightwagon') {
                $cars = Car::where([
                    ['kei_style', '=', 'ハイトワゴン'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_slide') {
                $cars = Car::where([
                    ['kei_flug', '=', '1'],
                    ['slidedoor_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_sedan') {
                $cars = Car::where([
                    ['kei_style', '=', 'セダン'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_sports') {
                $cars = Car::where([
                    ['kei_style', '=', 'スポーツ'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_suv') {
                $cars = Car::where([
                    ['kei_style', '=', 'SUV'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_truck') {
                $cars = Car::where([
                    ['kei_style', '=', 'トラック'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_hako') {
                $cars = Car::where([
                    ['kei_style', '=', '軽箱'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_hakowagon') {
                $cars = Car::where([
                    ['kei_style', '=', '軽箱ワゴン'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_heightvan') {
                $cars = Car::where([
                    ['kei_style', '=', 'ハイトバン'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();


                /*
            その他
            */

                //新車から3年落ち              
            } elseif ($genre == '3year') {
                $dt = new Carbon();
                $dt = $dt->subYear(3)->format('Y');

                $cars = Car::whereYear('release', $dt)
                    ->where('half', '=', $half)
                    ->get();

                $count = $cars->count();

                //新車から5年落ち              
            } elseif ($genre == '5year') {
                $dt = new Carbon();
                $dt = $dt->subYear(5)->format('Y');

                $cars = Car::whereYear('release', $dt)
                    ->where('half', '=', $half)
                    ->get();

                $count = $cars->count();

                //新車から7年落ち              
            } elseif ($genre == '5year') {
                $dt = new Carbon();
                $dt = $dt->subYear(7)->format('Y');

                $cars = Car::whereYear('release', $dt)
                    ->where('half', '=', $half)
                    ->get();

                $count = $cars->count();

                //ロングセラー 
            } elseif ($genre == 'longseler') {
                $dt = new Carbon();
                $dt = $dt->subYear(10)->format('Y');

                $cars = Car::whereYear('release', '<=', $dt)
                    ->where('half', '<=', $half)
                    ->get();

                $count = $cars->count();


                //SUV３列シート                
            } elseif ($genre == 'suv_3rd') {
                $cars = Car::where([
                    ['suv3rd_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();

                //コンパクトカー                
            } elseif ($genre == 'compact') {
                $cars = Car::where([
                    ['size_length', '<=', '4.70'],
                    ['size_width', '<=', '1.70'],
                    ['size_height', '<=', '2.00'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->WhereNull('kei_flug') //軽以外
                    ->WhereNull('van') //バン以外
                    ->get();

                $count = $cars->count();

                //２ドアクーペ               
            } elseif ($genre == '2door_courpe') {
                $cars = Car::where([
                    ['sports_flug', '=', '1'],
                    ['door', '=', '2'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->WhereNull('van') //バン以外
                    ->get();

                $count = $cars->count();

                //丸目ヘッドライト             
            } elseif ($genre == 'headlight') {
                $cars = Car::where([
                    ['headlight_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->get();

                $count = $cars->count();

                //OEM     
            } elseif ($genre == 'oem') {
                $cars = Car::where([
                    ['oem_flug', '=', '1'],
                    ['half', '=', $half],
                    ['japan_flug', '=', '1'],
                ])
                    ->get();

                $count = $cars->count();


                //ファミリーカー
            } elseif ($genre == 'familly') {
                $cars_ridingcapacity = Car::where([
                    ['ridingcapacity', '>=', '6'],
                ])
                    ->get();

                $cars_kei = Car::where([
                    ['kei_style', '=', 'ハイトワゴン'],
                ])
                    ->get();

                $cars = $cars_ridingcapacity->concat($cars_kei); //結果を結合
                $count = $cars->count();
            }


            /*
            各スペックを取得
            */

            //メーカー
            if ($spec == 'maker') {
                $cars = $cars->sortBy('maker');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars', 'thisyear'));
            }

            //車名
            elseif ($spec == 'name') {
                $cars = $cars->sortBy('name');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //発売日
            elseif ($spec == 'release') {
                $cars = $cars->sortByDesc('release');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //価格
            elseif ($spec == 'price') {
                $cars = $cars->sortBy('price');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //小回り
            elseif ($spec == 'turningradius') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['turningradius'] === null ? PHP_FLOAT_MAX : $item['turningradius'];
                })->values();

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //駆動方法
            elseif ($spec == 'drive') {
                $cars = $cars->sortBy('drive');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車体 長さ
            elseif ($spec == 'size_length') {
                $cars = $cars->sortBy('size_length');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //車体　幅
            elseif ($spec == 'size_width') {
                $cars = $cars->sortBy('size_width');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //車体　高さ
            elseif ($spec == 'size_height') {
                $cars = $cars->sortBy('size_height');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //ホイールベース
            elseif ($spec == 'wheelbase') {
                $cars = $cars->sortBy('wheelbase');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //トレッド
            elseif ($spec == 'tred') {
                $cars = $cars->sortBy('tred');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //室内　長さ
            elseif ($spec == 'indoorsize_length') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['indoorsize_length'] === null ? PHP_FLOAT_MAX : $item['indoorsize_length'];
                })->values();

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //室内　幅
            elseif ($spec == 'indoorsize_width') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['indoorsize_width'] === null ? PHP_FLOAT_MAX : $item['indoorsize_width'];
                })->values();

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //室内　高さ
            elseif ($spec == 'indoorsize_height') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['indoorsize_height'] === null ? PHP_FLOAT_MAX : $item['indoorsize_height'];
                })->values();

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //車輌重量
            elseif ($spec == 'weight') {
                $cars = $cars->sortBy('weight');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //乗車人数
            elseif ($spec == 'ridingcapacity') {
                $cars = $cars->sortByDesc('ridingcapacity');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //最低地上高
            elseif ($spec == 'groundclearance') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['groundclearance'] === null ? PHP_FLOAT_MAX : $item['groundclearance'];
                })->values();

                //return view('car.spec.groundclearance', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //色数
            elseif ($spec == 'color') {
                $cars = $cars->sortByDesc('color');

                //return view('car.spec.color', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃料の種類
            elseif ($spec == 'fuel') {
                $cars = $cars->sortBy('fuel');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃料タンク容量
            elseif ($spec == 'fueltank') {
                $cars = $cars->sortByDesc('fueltank');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃費JC08
            elseif ($spec == 'JC08') {
                $cars = $cars->sortByDesc('JC08');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //排気量
            elseif ($spec == 'displacement') {
                $cars = $cars->sortByDesc('displacement');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃費WTLC
            elseif ($spec == 'WLTC') {
                $cars = $cars->sortByDesc('WLTC');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //馬力
            elseif ($spec == 'ps') {
                $cars = $cars->sortByDesc('ps');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars')); //複数形OK？
            }

            //トルク
            elseif ($spec == 'torque') {
                $cars = $cars->sortByDesc('torque');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //タイヤ
            elseif ($spec == 'tiresize_front') {
                $cars = $cars->sortBy('tiresize_front');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            各ジャンル別サイズ
            */

            //ミニバン
            elseif ($spec == 'minivan_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.5) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.9) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 8.04) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.49) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート  

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //SUV
            elseif ($spec == 'suv_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.0) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.72) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.95) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.47) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //ハッチバック
            elseif ($spec == 'hatchback_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 5.33) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 6.97) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.3) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 7.75) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //ステーションワゴン
            elseif ($spec == 'wagon_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.0) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.55) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 8.09) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.19) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //セダン
            elseif ($spec == 'sedan_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.0) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.69) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.91) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.2) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //スポーツ
            elseif ($spec == 'sports_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 6.16) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.28) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.55) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 7.99) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            計算必要なスペック
            */

            //自動車税
            elseif ($spec == 'tax') {

                //排気量を　自動車税へ変換し　taxへ格納
                foreach ($cars as $car) {
                    if ($car->displacement == '-') { //本番環境はnullへ変更？
                        $car->tax = '-';
                    } elseif ($car->displacement < 660) {
                        $car->tax = '10800';
                    } elseif ($car->displacement < 1000) {
                        $car->tax = '25000';
                    } elseif ($car->displacement < 1500) {
                        $car->tax = '30500';
                    } elseif ($car->displacement < 2000) {
                        $car->tax = '36000';
                    } elseif ($car->displacement < 2500) {
                        $car->tax = '43500';
                    } elseif ($car->displacement < 3000) {
                        $car->tax = '50000';
                    } elseif ($car->displacement < 3500) {
                        $car->tax = '57000';
                    } elseif ($car->displacement < 4000) {
                        $car->tax = '65500';
                    } elseif ($car->displacement < 4500) {
                        $car->tax = '75500';
                    } elseif ($car->displacement < 5000) {
                        $car->tax = '87000';
                    } elseif ($car->displacement < 5500) {
                        $car->tax = '110000';
                    } elseif ($car->displacement > 6000) {
                        $car->tax = '19800';
                    }
                }

                $cars = $cars->sortBy('displacement'); //排気量でソート

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //重量税
            elseif ($spec == 'jtax') {

                //車輌重量を重量税税へ変換し$jtaxへ格納
                foreach ($cars as $car) {
                    if ($car->weight == '-') { //本番環境はnullへ変更？
                        $car->jtax = '-';
                    } elseif ($car->weight < 500) {
                        $car->jtax = '12600';
                    } elseif ($car->weight < 1000) {
                        $car->jtax = '25200';
                    } elseif ($car->weight < 1500) {
                        $car->jtax = '37800';
                    } elseif ($car->weight < 2000) {
                        $car->jtax = '50400';
                    } elseif ($car->weight < 2500) {
                        $car->jtax = '63000';
                    } elseif ($car->weight < 3000) {
                        $car->jtax = '75600';
                    }
                }

                $cars = $cars->sortBy('weight'); //車両重量を取得    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //kg単価
            elseif ($spec == 'kg') {

                foreach ($cars as $car) {
                    if (!is_null($car->weight)) {

                        $price = ($car->price) * 10000;
                        $weight = $car->weight;

                        $car->kg = floor($price / $weight);
                    }
                }

                $cars = $cars->sortByDesc('kg'); //kg単価でソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //航続距離
            elseif ($spec == 'cruising') {

                foreach ($cars as $car) {
                    $fueltank = $car->fueltank;
                    $wltc = $car->WLTC;
                    $car->cruising = $fueltank * $wltc;
                }

                $cars = $cars->sortByDesc('cruising'); //航続距離でソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車体の大きさ　ボディサイズ
            elseif ($spec == 'bodysize') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;

                    $car->bodysize = $size_length + $size_width + $size_height;
                }

                $cars = $cars->sortByDesc('bodysize'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //室内の広さ　インドアサイズ
            elseif ($spec == 'indoorsize') {

                foreach ($cars as $car) {
                    $indoorsize_length = $car->indoorsize_length;
                    $indoorsize_width = $car->indoorsize_width;
                    $indoorsize_height = $car->indoorsize_height;
                    $car->indoorsize = $indoorsize_length + $indoorsize_width + $indoorsize_height;

                    $indoorsize = $car->indoorsize;
                }

                $cars = $cars->sortByDesc('indoorsize'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車は小さく、室内は広く
            elseif ($spec == 'gap') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height; //車輌の大きさ

                    $indoorsize_length = $car->indoorsize_length;
                    $indoorsize_width = $car->indoorsize_width;
                    $indoorsize_height = $car->indoorsize_height;
                    $car->indoorsize = $indoorsize_length + $indoorsize_width + $indoorsize_height; //室内の広さ

                    $car->gap = $car->size - $car->indoorsize;  //車輌の大きさ　から　室内の広さ　の差
                }

                //$cars = $cars->sortByDesc('gap'); //サイズでソート    

                $cars = $cars->sortByDesc(function ($item) {
                    return $item['gap'] === null ? PHP_FLOAT_MIN : $item['gap'];
                })->values();

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //自賠責保険
            elseif ($spec == 'jibai') {

                //排気量を自動車税へ変換し$taxへ格納
                foreach ($cars as $car) {
                    if ($car->displacement == '-') { //本番環境はnullへ変更？
                        $car->jibai = '-';
                    } elseif ($car->displacement < 660) {
                        $car->jibai = '17540';
                    } else {
                        $car->jibai = '17650';
                    }
                }

                $cars = $cars->sortBy('displacement'); //排気量でソート

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車検諸費用
            elseif ($spec == 'overhead') {

                foreach ($cars as $car) {
                    if ($car->weight == '-') {
                        $car->jtax = '-';
                    } elseif ($car->weight < 500) {
                        $car->jtax = '12600';
                    } elseif ($car->weight < 1000) {
                        $car->jtax = '25200';
                    } elseif ($car->weight < 1500) {
                        $car->jtax = '37800';
                    } elseif ($car->weight < 2000) {
                        $car->jtax = '50400';
                    } elseif ($car->weight < 2500) {
                        $car->jtax = '63000';
                    } elseif ($car->weight < 3000) {
                        $car->jtax = '75600';
                    }

                    if ($car->displacement == '-') {
                        $car->jibai = '-';
                    } elseif ($car->displacement < 660) {
                        $car->jibai = '17540';
                    } else {
                        $car->jibai = '17650';
                    }

                    $car->overhead = $car->jtax + $car->jibai;
                }

                $cars = $cars->sortBy('overhead'); //サイズでソート    

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }




            /*
            ミニバン独自スペック
            */

            //スライドドア有無
            elseif ($spec == 'minivan_slidedoor') {
                $cars = $cars->sortBy('slidedoor_flug');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //スタイル
            elseif ($spec == 'minivan_style') {
                $cars = $cars->sortBy('minivan_style');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //３列目の格納
            elseif ($spec == 'minivan_3rd') {
                $cars = $cars->sortBy('minivan_3rd');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            プチバン独自スペック
            */

            //スライドドア開口部
            elseif ($spec == 'puchivan_slideopen') {
                $cars = $cars->sortByDesc('puchivan_slideopen');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            SUV独自スペック
            */

            //スタイル
            elseif ($spec == 'suv_style') {
                $cars = $cars->sortBy('suv_style');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            ステーションワゴン独自スペック
            */

            //荷室のサイズ
            elseif ($spec == 'wagon_luggage') {
                $cars = $cars->sortByDesc('wagon_luggage');

                return view('car.spec', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }




            //車種一覧ビューでそれを表示
            return view('car.genre', [
                'genre' => $genre,
            ]);
        } else {

            /*
            ジャンルと年を取得
            */

            if ($genre == 'minivan') {
                $cars = Car::where([
                    ['minivan_flug', '=', '1'],
                    ['half', '=', $half]
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'puchivan') {
                $cars = Car::where([
                    ['puchivan_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'suv') {
                $cars = Car::where([
                    ['suv_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'hatchback') {
                $cars = Car::where([
                    ['hatchback_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'sedan') {
                $cars = Car::where([
                    ['sedan_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'wagon') {
                $cars = Car::where([
                    ['wagon_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'sports') {
                $cars = Car::where([
                    ['sports_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();


                /*
            軽自動車
            */
            } elseif ($genre == 'kei') {
                $cars = Car::where([
                    ['kei_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_wagon') {
                $cars = Car::where([
                    ['kei_style', '=', 'ワゴン'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_heightwagon') {
                $cars = Car::where([
                    ['kei_style', '=', 'ハイトワゴン'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_slide') {
                $cars = Car::where([
                    ['kei_flug', '=', '1'],
                    ['slidedoor_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_sedan') {
                $cars = Car::where([
                    ['kei_style', '=', 'セダン'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_sports') {
                $cars = Car::where([
                    ['kei_style', '=', 'スポーツ'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_suv') {
                $cars = Car::where([
                    ['kei_style', '=', 'SUV'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_truck') {
                $cars = Car::where([
                    ['kei_style', '=', 'トラック'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_hako') {
                $cars = Car::where([
                    ['kei_style', '=', '軽箱'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_hakowagon') {
                $cars = Car::where([
                    ['kei_style', '=', '軽箱ワゴン'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();
            } elseif ($genre == 'kei_heightvan') {
                $cars = Car::where([
                    ['kei_style', '=', 'ハイトバン'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();


                /*
            その他
            */

                //新車から3年落ち              
            } elseif ($genre == '3year') {
                $dt = new Carbon();
                $dt = $dt->subYear(3)->format('Y');

                $cars = Car::whereYear('release', $dt)
                    ->where('half', '=', $half)
                    ->get();

                $count = $cars->count();

                //新車から5年落ち              
            } elseif ($genre == '5year') {
                $dt = new Carbon();
                $dt = $dt->subYear(5)->format('Y');

                $cars = Car::whereYear('release', $dt)
                    ->where('half', '=', $half)
                    ->get();

                $count = $cars->count();

                //新車から7年落ち              
            } elseif ($genre == '5year') {
                $dt = new Carbon();
                $dt = $dt->subYear(7)->format('Y');

                $cars = Car::whereYear('release', $dt)
                    ->where('half', '=', $half)
                    ->get();

                $count = $cars->count();

                //ロングセラー 
            } elseif ($genre == 'longseler') {
                $dt = new Carbon();
                $dt = $dt->subYear(10)->format('Y');

                $cars = Car::whereYear('release', '<=', $dt)
                    ->where('half', '<=', $half)
                    ->get();

                $count = $cars->count();


                //SUV３列シート                
            } elseif ($genre == 'suv_3rd') {
                $cars = Car::where([
                    ['suv3rd_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->where('year', '=', $year)
                    ->get();

                $count = $cars->count();

                //コンパクトカー                
            } elseif ($genre == 'compact') {
                $cars = Car::where([
                    ['size_length', '<=', '4.70'],
                    ['size_width', '<=', '1.70'],
                    ['size_height', '<=', '2.00'],
                    ['half', '=', $half],
                ])
                    ->WhereNull('kei_flug') //軽以外
                    ->WhereNull('van') //バン以外
                    ->get();

                $count = $cars->count();

                //２ドアクーペ               
            } elseif ($genre == '2door_courpe') {
                $cars = Car::where([
                    ['sports_flug', '=', '1'],
                    ['door', '=', '2'],
                    ['half', '=', $half],
                ])
                    ->WhereNull('van') //バン以外
                    ->get();

                $count = $cars->count();

                //丸目ヘッドライト             
            } elseif ($genre == 'headlight') {
                $cars = Car::where([
                    ['headlight_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->get();

                $count = $cars->count();

                //OEM     
            } elseif ($genre == 'oem') {
                $cars = Car::where([
                    ['oem_flug', '=', '1'],
                    ['half', '=', $half],
                ])
                    ->get();

                $count = $cars->count();


                //ファミリーカー
            } elseif ($genre == 'familly') {
                $cars_ridingcapacity = Car::where([
                    ['ridingcapacity', '>=', '6'],
                ])
                    ->get();

                $cars_kei = Car::where([
                    ['kei_style', '=', 'ハイトワゴン'],
                ])
                    ->get();

                $cars = $cars_ridingcapacity->concat($cars_kei); //結果を結合
                $count = $cars->count();
            }


            /*
            各スペックを取得
            */

            //メーカー
            if ($spec == 'maker') {
                $cars = $cars->sortBy('maker');

                return view('car.spec.maker', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars', 'thisyear'));
            }

            //車名
            elseif ($spec == 'name') {
                $cars = $cars->sortBy('name');

                return view('car.spec.name', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //発売日
            elseif ($spec == 'release') {
                $cars = $cars->sortByDesc('release');

                return view('car.spec.release', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //価格
            elseif ($spec == 'price') {
                $cars = $cars->sortBy('price');

                return view('car.spec.price', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //小回り
            elseif ($spec == 'turningradius') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['turningradius'] === null ? PHP_FLOAT_MAX : $item['turningradius'];
                })->values();

                return view('car.spec.turningradius', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //駆動方法
            elseif ($spec == 'drive') {
                $cars = $cars->sortBy('drive');

                return view('car.spec.drive', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車体 長さ
            elseif ($spec == 'size_length') {
                $cars = $cars->sortBy('size_length');

                return view('car.spec.size_length', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //車体　幅
            elseif ($spec == 'size_width') {
                $cars = $cars->sortBy('size_width');

                return view('car.spec.size_width', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //車体　高さ
            elseif ($spec == 'size_height') {
                $cars = $cars->sortBy('size_height');

                return view('car.spec.size_height', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //ホイールベース
            elseif ($spec == 'wheelbase') {
                $cars = $cars->sortBy('wheelbase');

                return view('car.spec.wheelbase', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //トレッド
            elseif ($spec == 'tred') {
                $cars = $cars->sortBy('tred');

                return view('car.spec.tred', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //室内　長さ
            elseif ($spec == 'indoorsize_length') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['indoorsize_length'] === null ? PHP_FLOAT_MAX : $item['indoorsize_length'];
                })->values();

                return view('car.spec.indoorsize_length', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //室内　幅
            elseif ($spec == 'indoorsize_width') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['indoorsize_width'] === null ? PHP_FLOAT_MAX : $item['indoorsize_width'];
                })->values();

                return view('car.spec.indoorsize_width', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //室内　高さ
            elseif ($spec == 'indoorsize_height') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['indoorsize_height'] === null ? PHP_FLOAT_MAX : $item['indoorsize_height'];
                })->values();

                return view('car.spec.indoorsize_height', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //車輌重量
            elseif ($spec == 'weight') {
                $cars = $cars->sortBy('weight');

                return view('car.spec.weight', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //乗車人数
            elseif ($spec == 'ridingcapacity') {
                $cars = $cars->sortByDesc('ridingcapacity');

                return view('car.spec.ridingcapacity', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //最低地上高
            elseif ($spec == 'groundclearance') {
                $cars = $cars->sortBy(function ($item) {
                    return $item['groundclearance'] === null ? PHP_FLOAT_MAX : $item['groundclearance'];
                })->values();

                return view('car.spec.groundclearance', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //色数
            elseif ($spec == 'color') {
                $cars = $cars->sortByDesc('color');

                return view('car.spec.color', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃料の種類
            elseif ($spec == 'fuel') {
                $cars = $cars->sortBy('fuel');

                return view('car.spec.fuel', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃料タンク容量
            elseif ($spec == 'fueltank') {
                $cars = $cars->sortByDesc('fueltank');

                return view('car.spec.fueltank', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃費JC08
            elseif ($spec == 'JC08') {
                $cars = $cars->sortByDesc('JC08');

                return view('car.spec.JC08', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //排気量
            elseif ($spec == 'displacement') {
                $cars = $cars->sortByDesc('displacement');

                return view('car.spec.displacement', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //燃費WTLC
            elseif ($spec == 'WLTC') {
                $cars = $cars->sortByDesc('WLTC');

                return view('car.spec.WLTC', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //馬力
            elseif ($spec == 'ps') {
                $cars = $cars->sortByDesc('ps');

                return view('car.spec.ps', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars')); //複数形OK？
            }

            //トルク
            elseif ($spec == 'torque') {
                $cars = $cars->sortByDesc('torque');

                return view('car.spec.torque', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //タイヤ
            elseif ($spec == 'tiresize_front') {
                $cars = $cars->sortBy('tiresize_front');

                return view('car.spec.tiresize_front', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            各ジャンル別サイズ
            */

            //ミニバン
            elseif ($spec == 'minivan_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.5) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.9) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 8.04) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.49) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート  

                return view('car.spec.minivan_size', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //SUV
            elseif ($spec == 'suv_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.0) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.72) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.95) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.47) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec.suv_size', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //ハッチバック
            elseif ($spec == 'hatchback_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 5.33) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 6.97) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.3) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 7.75) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec.wagon_size', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //ステーションワゴン
            elseif ($spec == 'wagon_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.0) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.55) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 8.09) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.19) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec.wagon_size', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //セダン
            elseif ($spec == 'sedan_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 7.0) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.69) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.91) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 8.2) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec.wagon_size', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //スポーツ
            elseif ($spec == 'sports_size') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height;

                    if ($car->size <= 6.16) {
                        $car->sml = 'XS';
                    } elseif ($car->size <= 7.28) {
                        $car->sml = 'S';
                    } elseif ($car->size <= 7.55) {
                        $car->sml = 'M';
                    } elseif ($car->size <= 7.99) {
                        $car->sml = 'L';
                    } else {
                        $car->sml = 'XL';
                    }
                }

                $cars = $cars->sortByDesc('size'); //サイズでソート    

                return view('car.spec.wagon_size', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            計算必要なスペック
            */

            //自動車税
            elseif ($spec == 'tax') {

                //排気量を　自動車税へ変換し　taxへ格納
                foreach ($cars as $car) {
                    if ($car->displacement == '-') { //本番環境はnullへ変更？
                        $car->tax = '-';
                    } elseif ($car->displacement < 660) {
                        $car->tax = '10800';
                    } elseif ($car->displacement < 1000) {
                        $car->tax = '25000';
                    } elseif ($car->displacement < 1500) {
                        $car->tax = '30500';
                    } elseif ($car->displacement < 2000) {
                        $car->tax = '36000';
                    } elseif ($car->displacement < 2500) {
                        $car->tax = '43500';
                    } elseif ($car->displacement < 3000) {
                        $car->tax = '50000';
                    } elseif ($car->displacement < 3500) {
                        $car->tax = '57000';
                    } elseif ($car->displacement < 4000) {
                        $car->tax = '65500';
                    } elseif ($car->displacement < 4500) {
                        $car->tax = '75500';
                    } elseif ($car->displacement < 5000) {
                        $car->tax = '87000';
                    } elseif ($car->displacement < 5500) {
                        $car->tax = '110000';
                    } elseif ($car->displacement > 6000) {
                        $car->tax = '19800';
                    }
                }

                $cars = $cars->sortBy('displacement'); //排気量でソート

                return view('car.spec.tax', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //重量税
            elseif ($spec == 'jtax') {

                //車輌重量を重量税税へ変換し$jtaxへ格納
                foreach ($cars as $car) {
                    if ($car->weight == '-') { //本番環境はnullへ変更？
                        $car->jtax = '-';
                    } elseif ($car->weight < 500) {
                        $car->jtax = '12600';
                    } elseif ($car->weight < 1000) {
                        $car->jtax = '25200';
                    } elseif ($car->weight < 1500) {
                        $car->jtax = '37800';
                    } elseif ($car->weight < 2000) {
                        $car->jtax = '50400';
                    } elseif ($car->weight < 2500) {
                        $car->jtax = '63000';
                    } elseif ($car->weight < 3000) {
                        $car->jtax = '75600';
                    }
                }

                $cars = $cars->sortBy('weight'); //車両重量を取得    

                return view('car.spec.jtax', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //kg単価
            elseif ($spec == 'kg') {

                foreach ($cars as $car) {
                    if (!is_null($car->weight)) {

                        $price = ($car->price) * 10000;
                        $weight = $car->weight;

                        $car->kg = floor($price / $weight);
                    }
                }

                $cars = $cars->sortByDesc('kg'); //kg単価でソート    

                return view('car.spec.kg', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //航続距離
            elseif ($spec == 'cruising') {

                foreach ($cars as $car) {
                    $fueltank = $car->fueltank;
                    $wltc = $car->WLTC;
                    $car->cruising = $fueltank * $wltc;
                }

                $cars = $cars->sortByDesc('cruising'); //航続距離でソート    

                return view('car.spec.cruising', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車体の大きさ
            elseif ($spec == 'bodysize') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;

                    $car->bodysize = $size_length + $size_width + $size_height;
                }

                $cars = $cars->sortByDesc('bodysize'); //サイズでソート    

                return view('car.spec.bodysize', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //室内の広さ
            elseif ($spec == 'indoorsize') {

                foreach ($cars as $car) {
                    $indoorsize_length = $car->indoorsize_length;
                    $indoorsize_width = $car->indoorsize_width;
                    $indoorsize_height = $car->indoorsize_height;
                    $car->indoorsize = $indoorsize_length + $indoorsize_width + $indoorsize_height;

                    $indoorsize = $car->indoorsize;
                }

                $cars = $cars->sortByDesc('indoorsize'); //サイズでソート    

                return view('car.spec.indoorsize', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車は小さく、室内は広く
            elseif ($spec == 'gap') {

                foreach ($cars as $car) {
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;
                    $car->size = $size_length + $size_width + $size_height; //車輌の大きさ

                    $indoorsize_length = $car->indoorsize_length;
                    $indoorsize_width = $car->indoorsize_width;
                    $indoorsize_height = $car->indoorsize_height;
                    $car->indoorsize = $indoorsize_length + $indoorsize_width + $indoorsize_height; //室内の広さ

                    $car->gap = $car->size - $car->indoorsize;  //車輌の大きさ　から　室内の広さ　の差
                }

                //$cars = $cars->sortByDesc('gap'); //サイズでソート    

                $cars = $cars->sortByDesc(function ($item) {
                    return $item['gap'] === null ? PHP_FLOAT_MIN : $item['gap'];
                })->values();

                return view('car.spec.gap', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //自賠責保険
            elseif ($spec == 'jibai') {

                //排気量を自動車税へ変換し$taxへ格納
                foreach ($cars as $car) {
                    if ($car->displacement == '-') { //本番環境はnullへ変更？
                        $car->jibai = '-';
                    } elseif ($car->displacement < 660) {
                        $car->jibai = '17540';
                    } else {
                        $car->jibai = '17650';
                    }
                }

                $cars = $cars->sortBy('displacement'); //排気量でソート

                return view('car.spec.jibai', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            //車検諸費用
            elseif ($spec == 'overhead') {

                foreach ($cars as $car) {
                    if ($car->weight == '-') {
                        $car->jtax = '-';
                    } elseif ($car->weight < 500) {
                        $car->jtax = '12600';
                    } elseif ($car->weight < 1000) {
                        $car->jtax = '25200';
                    } elseif ($car->weight < 1500) {
                        $car->jtax = '37800';
                    } elseif ($car->weight < 2000) {
                        $car->jtax = '50400';
                    } elseif ($car->weight < 2500) {
                        $car->jtax = '63000';
                    } elseif ($car->weight < 3000) {
                        $car->jtax = '75600';
                    }

                    if ($car->displacement == '-') {
                        $car->jibai = '-';
                    } elseif ($car->displacement < 660) {
                        $car->jibai = '17540';
                    } else {
                        $car->jibai = '17650';
                    }

                    $car->overhead = $car->jtax + $car->jibai;
                }

                $cars = $cars->sortBy('overhead'); //サイズでソート    

                return view('car.spec.overhead', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }




            /*
            ミニバン独自スペック
            */

            //スライドドア有無
            elseif ($spec == 'minivan_slidedoor') {
                $cars = $cars->sortBy('slidedoor_flug');

                return view('car.spec.minivan_slidedoor', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //スタイル
            elseif ($spec == 'minivan_style') {
                $cars = $cars->sortBy('minivan_style');

                return view('car.spec.minivan_style', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }

            //３列目の格納
            elseif ($spec == 'minivan_3rd') {
                $cars = $cars->sortBy('minivan_3rd');

                return view('car.spec.minivan_3rd', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            プチバン独自スペック
            */

            //スライドドア開口部
            elseif ($spec == 'puchivan_slideopnen') {
                $cars = $cars->sortByDesc('puchivan_slideopnen');

                return view('car.spec.puchivan_slideopnen', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            SUV独自スペック
            */

            //スタイル
            elseif ($spec == 'suv_style') {
                $cars = $cars->sortBy('suv_style');

                return view('car.spec.suv_style', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }



            /*
            ステーションワゴン独自スペック
            */

            //荷室のサイズ
            elseif ($spec == 'wagon_luggage') {
                $cars = $cars->sortByDesc('wagon_luggage');

                return view('car.spec.wagon_luggage', compact('genre', 'year', 'thisyear', 'spec', 'half', 'count', 'cars'));
            }


            /*
            セダン独自スペック
            */


            //車種一覧ビューでそれを表示
            return view('car.genre', [
                'genre' => $genre,
            ]);
        }
    }









    /**
     * Remove the specified resource from storage.
     *　　あジャンル
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function genre($genre)
    {

        //年度取得
        $year = self::THISYEAR;


        //ジャンルを取得
        if ($genre == 'minivan') {
            $cars = Car::where([
                ['minivan_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'puchivan') {
            $cars = Car::where([
                ['puchivan_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'suv') {
            $cars = Car::where([
                ['suv_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'hatchback') {
            $cars = Car::where([
                ['hatchback_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'sedan') {
            $cars = Car::where([
                ['sedan_flug', '=', '1'],
            ])
                ->get();
            $count = $cars->count();
        } elseif ($genre == 'wagon') {
            $cars = Car::where([
                ['wagon_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'sports') {
            $cars = Car::where([
                ['sports_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();

            /*
軽自動車
*/
        } elseif ($genre == 'kei') {
            $cars = Car::where([
                ['kei_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_wagon') {
            $cars = Car::where([
                ['kei_style', '=', 'ワゴン'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_heightwagon') {
            $cars = Car::where([
                ['kei_style', '=', 'ハイトワゴン'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_slide') {
            $cars = Car::where([
                ['kei_flug', '=', '1'],
                ['slidedoor_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_sedan') {
            $cars = Car::where([
                ['kei_style', '=', 'セダン'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_sports') {
            $cars = Car::where([
                ['kei_style', '=', 'スポーツ'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_suv') {
            $cars = Car::where([
                ['kei_style', '=', 'SUV'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_hako') {
            $cars = Car::where([
                ['kei_style', '=', '軽箱'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_hakowagon') {
            $cars = Car::where([
                ['kei_style', '=', '軽箱ワゴン'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_heightvan') {
            $cars = Car::where([
                ['kei_style', '=', 'ハイトバン'],
            ])
                ->get();

            $count = $cars->count();
        } elseif ($genre == 'kei_sedan') {
            $cars = Car::where([
                ['kei_style', '=', 'セダン'],
            ])
                ->get();

            $count = $cars->count();


            /*
その他
*/

            //新車から3年落ち              
        } elseif ($genre == '3year') {
            $dt = new Carbon();
            $dt = $dt->subYear(3)->format('Y');

            $cars = Car::whereYear('release', $dt)
                ->get();

            $count = $cars->count();

            //新車から５年落ち              
        } elseif ($genre == '5year') {
            $dt = new Carbon();
            $dt = $dt->subYear(5)->format('Y');

            $cars = Car::whereYear('release', $dt)
                ->get();

            $count = $cars->count();

            //新車から7年落ち              
        } elseif ($genre == '7year') {
            $dt = new Carbon();
            $dt = $dt->subYear(7)->format('Y');

            $cars = Car::whereYear('release', $dt)
                ->get();

            $count = $cars->count();

            //ロングセラー
        } elseif ($genre == 'longseler') {
            $dt = new Carbon();
            $dt = $dt->subYear(10)->format('Y');

            $cars = Car::whereYear('release', $dt)
                ->get();

            $count = $cars->count();

            //SUV３列シート    
        } elseif ($genre == 'suv_3rd') {
            $cars = Car::where([
                ['suv3rd_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();

            //コンパクトカー                
        } elseif ($genre == 'compact') {
            $cars = Car::where([
                ['kei_flug', '<>', '1'],
                ['size_length', '<=', '4.70'],
                ['size_width', '<=', '1.70'],
                ['size_height', '<=', '2.00'],
            ])
                ->get();

            $count = $cars->count();

            //２ドアクーペ               
        } elseif ($genre == '2door_courpe') {
            $cars = Car::where([
                ['sports_flug', '=', '1'],
                ['door', '=', '2'],
            ])
                ->WhereNull('van') //バン以外
                ->get();

            $count = $cars->count();

            //丸目ヘッドライト             
        } elseif ($genre == 'headlight') {
            $cars = Car::where([
                ['headlight_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();

            //OEM
        } elseif ($genre == 'oem') {
            $cars = Car::where([
                ['oem_flug', '=', '1'],
            ])
                ->get();

            $count = $cars->count();

            //ファミリーカー
        } elseif ($genre == 'familly') {
            $cars_ridingcapacity = Car::where([
                ['ridingcapacity', '>=', '6'],
            ])
                ->get();

            $cars_kei = Car::where([
                ['kei_style', '=', 'ハイトワゴン'],
            ])
                ->get();

            $cars = $cars_ridingcapacity->concat($cars_kei); //6人乗り以上の結果と軽ハイトワゴンの結果を合体

            $count = $cars->count();
        }


        //車種一覧ビューでそれを表示
        return view('car.genre', [
            'genre' => $genre,
            'cars' => $cars,
            'year' => $year,
            'count' => $count,
        ]);
    }
}
