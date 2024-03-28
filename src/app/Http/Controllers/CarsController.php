<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;    // 追加
use Carbon\Carbon;


class CarsController extends Controller
{

    const THISYEAR = 2024;

    /**
     * Display a listing of the resource.
     *
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        return view('car.show', [
            'car' => $car,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function spec($genre,$spec,$year,$half=null)
    {

        //年度取得
        $thisYear = self::THISYEAR;

        //$half未入力の場合、常に最新のデータを表示させる処理
        if(empty($half)){
            $car = Car::whereYear('year', '<=', $year)->where('half', '=', '2')->first();

            if(empty($car)){
                $half = 1;
            }else{
                $half = 2;
            }
        }

        /*
        ジャンルと年を取得
        */

        if($genre == 'minivan' ){
            $cars = Car::where([
                ['minivan_flug','=', '1'],
                ['ridingcapacity','>', '5'],
                ['half','=', $half]
                ])
                ->whereYear('created_at', '<=', $year)
                ->get();

        }elseif($genre == 'puchivan'){
            $cars = Car::where([
                ['puchivan_flug','=', '1'],
                ['half','=', $half],
                ])
                ->whereYear('created_at', '<=', $year)
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where([
                ['suv_flug','=', '1'],
                ['half','=', $half],
                ])
                ->whereYear('created_at', '<=', $year)
                ->get();

        }elseif($genre == 'compact'){
            $cars = Car::where([
                ['compact_flug','=', '1'],
                ['half','=', $half],
                ])
                ->whereYear('created_at', '<=', $year)
                ->get();

        }elseif($genre == 'sedan'){
            $cars = Car::where([
                ['sedan_flug','=', '1'],
                ['half','=', $half],
                ])
                ->whereYear('created_at', '<=', $year)
                ->get();  
                
        }elseif($genre == 'wagon'){
            $cars = Car::where([
                ['wagon_flug','=', '1'],
                ['half','=', $half],
                ])
                ->whereYear('created_at', '<=', $year)
                ->get();                

        }elseif($genre == 'courpe'){
            $cars = Car::where([
                ['courpe_flug','=', '1'],
                ['half','=', $half],
                ])
                ->whereYear('created_at', '<=', $year)
                ->get();

        }


        /*
        各スペックを取得
        */

        //メーカー
        if($spec == 'maker'){
            $makers = $cars->sortBy('maker');       
            
            return view('car.spec.maker', compact('genre','year','spec','half','thisYear','makers'));
        }

        //車名
        elseif($spec == 'name'){
            $names = $cars->sortBy('name');

            return view('car.spec.name', compact('genre','year','spec','half','thisYear','names'));
        }

        //発売日
        elseif($spec == 'release'){
            $releases = $cars->sortByDesc('release');

            return view('car.spec.release', compact('genre','year','spec','half','thisYear','releases'));
        }

        //価格
        elseif($spec == 'price'){
            $prices = $cars->sortByDesc('price');

            return view('car.spec.price', compact('genre','year','spec','half','thisYear','prices'));
        }

        //小回り
        elseif($spec == 'turningradius'){
            $turningradiuses = $cars->sortBy('turningradius');

            return view('car.spec.turningradius', compact('genre','year','spec','half','thisYear','turningradiuses')); //複数形OK？カラム名変更検討
        }

        //車体 長さ
        elseif($spec == 'size_length'){
            $size_lengths = $cars->sortBy('size_length');

            return view('car.spec.size_length', compact('genre','year','spec','half','thisYear','size_lengths'));
        }        

        //車体　幅
        elseif($spec == 'size_width'){
            $size_widths = $cars->sortBy('size_width');

            return view('car.spec.size_width', compact('genre','year','spec','half','thisYear','size_widths'));
        }        

        //車体　高さ
        elseif($spec == 'size_height'){
            $size_heights = $cars->sortBy('size_height');

            return view('car.spec.size_height', compact('genre','year','spec','half','thisYear','size_heights'));
        }

        ////車体　合計
        //elseif($spec == 'size'){
        //    $plices = $cars->sortBy('size');

        //    return view('car.spec.size', compact('genre','year','spec','half','thisYear','sizes'));
        //}        
        
        //ホイールベース
        elseif($spec == 'wheelbase'){
            $wheelbases = $cars->sortBy('wheelbase');

            return view('car.spec.wheelbase', compact('genre','year','spec','half','thisYear','wheelbases'));
        }                

        //トレッド
        elseif($spec == 'tred'){
            $treds = $cars->sortBy('tred');

            return view('car.spec.tred', compact('genre','year','spec','half','thisYear','treds'));
        }

        //室内　長さ
        elseif($spec == 'indoorsize_length'){
            $indoorsize_lengths = $cars->sortBy(function($item){
                return $item['indoorsize_length'] === null ? PHP_FLOAT_MAX : $item['indoorsize_length'];
            })->values();

            return view('car.spec.indoorsize_length', compact('genre','year','spec','half','thisYear','indoorsize_lengths'));
        }

        //室内　幅
        elseif($spec == 'indoorsize_width'){
            $indoorsize_widths = $cars->sortBy(function($item){
                return $item['indoorsize_width'] === null ? PHP_FLOAT_MAX : $item['indoorsize_width'];
            })->values();

            return view('car.spec.indoorsize_width', compact('genre','year','spec','half','thisYear','indoorsize_widths'));
        }

        //室内　高さ
        elseif($spec == 'indoorsize_height'){
            $indoorsize_heights = $cars->sortBy(function($item){
                return $item['indoorsize_height'] === null ? PHP_FLOAT_MAX : $item['indoorsize_height'];
            })->values();

            return view('car.spec.indoorsize_height', compact('genre','year','spec','half','thisYear','indoorsize_heights'));
        }

        ////室内　合計
        //elseif($spec == 'indoorsize'){
        //    $plices = $cars->sortBy('indoorsize');

        //    return view('car.spec.indoorsize', compact('genre','year','spec','half','thisYear','indoorsizes'));
        //}        

        //車輌重量
        elseif($spec == 'weight'){
            $weights = $cars->sortBy('weight');

            return view('car.spec.weight', compact('genre','year','spec','half','thisYear','weights'));
        }

        //乗車人数
        elseif($spec == 'ridingcapacity'){
            $ridingcapacitys = $cars->sortByDesc('ridingcapacity');

            return view('car.spec.ridingcapacity', compact('genre','year','spec','half','thisYear','ridingcapacitys'));
        }

        //最低地上高
        elseif($spec == 'groundclearance'){
            $groundclearances = $cars->sortBy(function($item){
                return $item['groundclearance'] === null ? PHP_FLOAT_MAX : $item['groundclearance'];
            })->values();

            return view('car.spec.groundclearance', compact('genre','year','spec','half','thisYear','groundclearances'));
        }

        //色数
        elseif($spec == 'color'){
            $colors = $cars->sortByDesc('color');

            return view('car.spec.color', compact('genre','year','spec','half','thisYear','colors'));
        }

        //燃料の種類
        elseif($spec == 'fuel'){
            $fuels = $cars->sortBy('fuel');

            return view('car.spec.fuel', compact('genre','year','spec','half','thisYear','fuels'));
        }        

        //燃料タンク容量
        elseif($spec == 'fueltank'){
            $fueltanks = $cars->sortByDesc('fueltank');

            return view('car.spec.fueltank', compact('genre','year','spec','half','thisYear','fueltanks'));
        }

        //燃費JC08
        elseif($spec == 'JC08'){
            $JC08s = $cars->sortByDesc('JC08');

            return view('car.spec.JC08', compact('genre','year','spec','half','thisYear','JC08s'));
        }

        //排気量
        elseif($spec == 'displacement'){
            $displacements = $cars->sortByDesc('displacement');

            return view('car.spec.displacement', compact('genre','year','spec','half','thisYear','displacements'));
        }

        //燃費WTLC
        elseif($spec == 'WLTC'){
            $WLTCs = $cars->sortByDesc('WLTC');

            return view('car.spec.WLTC', compact('genre','year','spec','half','thisYear','WLTCs'));
        }

        //馬力
        elseif($spec == 'ps'){
            $pses = $cars->sortByDesc('ps');

            return view('car.spec.ps', compact('genre','year','spec','half','thisYear','pses')); //複数形OK？
        }

        //トルク
        elseif($spec == 'torque'){
            $torques = $cars->sortByDesc('torque');

            return view('car.spec.torque', compact('genre','year','spec','half','thisYear','torques'));
        }        

        //タイヤ
        elseif($spec == 'tiresize_front'){
            $tiresize_fronts = $cars->sortBy('tiresize_front');

            return view('car.spec.tiresize_front', compact('genre','year','spec','half','thisYear','tiresize_fronts')); //大文字FはOK？　マイグレーションファイルのカラム名間違ってます
        }


        /*
        計算必要なスペック
        */

        //自動車税
        elseif($spec == 'tax'){

                //排気量を自動車税へ変換し$taxへ格納
                foreach($cars as $car){
                    if($car->displacement == '-'){ //本番環境はnullへ変更？
                        $car->tax = '-';
                    }elseif($car->displacement < 660){
                        $car->tax = '10800';
                    }elseif($car->displacement < 1000){
                        $car->tax = '25000';
                    }elseif($car->displacement < 1500){
                        $car->tax = '30500';
                    }elseif($car->displacement < 2000){
                        $car->tax = '36000';
                    }elseif($car->displacement < 2500){
                        $car->tax = '43500';
                    }elseif($car->displacement < 3000){
                        $car->tax = '50000';
                    }elseif($car->displacement < 3500){
                        $car->tax = '57000';
                    }elseif($car->displacement < 4000){
                        $car->tax = '65500';
                    }elseif($car->displacement < 4500){
                        $car->tax = '75500';
                    }elseif($car->displacement < 5000){
                        $car->tax = '87000';
                    }elseif($car->displacement < 5500){
                        $car->tax = '110000';
                    }elseif($car->displacement > 6000){
                        $car->tax = '19800';
                    }
                }

            $cars = $cars->sortBy('displacement'); //排気量でソート

            return view('car.spec.tax', compact('genre','year','spec','half','thisYear','cars'));
        }

        //重量税
        elseif($spec == 'jtax'){

                //車輌重量を重量税税へ変換し$jtaxへ格納
                foreach($cars as $car){
                    if($car->weight == '-'){ //本番環境はnullへ変更？
                        $car->jtax = '-';
                    }elseif($car->weight < 500){
                        $car->jtax = '12600';
                    }elseif($car->weight < 1000){
                        $car->jtax = '25200';
                    }elseif($car->weight < 1500){
                        $car->jtax = '37800';
                    }elseif($car->weight < 2000){
                        $car->jtax = '50400';
                    }elseif($car->weight < 2500){
                        $car->jtax = '63000';
                    }elseif($car->weight < 3000){
                        $car->jtax = '75600';
                    }
                }

            $cars = $cars->sortBy('weight'); //車両重量を取得    

            return view('car.spec.jtax', compact('genre','year','spec','half','thisYear','cars'));
        }

        //kg単価
        elseif($spec == 'kg'){

                foreach($cars as $car){
                    $price = ($car->price)*10000;
                    $weight = $car->weight;
                    $car->kg = floor($price/$weight);//本当はこの結果でソートしたい
                    }

            $cars = $cars->sortByDesc('kg'); //kg単価でソート    
                
            return view('car.spec.kg', compact('genre','year','spec','half','thisYear','cars'));
        }


        //航続距離
        elseif($spec == 'cruising'){

                foreach($cars as $car){
                    $fueltank = $car->fueltank;
                    $wltc = $car->WLTC;
                    $car->cruising = $fueltank*$wltc;
                    }
            
            $cars = $cars->sortByDesc('cruising'); //航続距離でソート    
                
            return view('car.spec.cruising', compact('genre','year','spec','half','thisYear','cars'));
        }


        //車体の大きさ
        elseif($spec == 'size'){

                foreach($cars as $car){
                    $size_length = $car->size_length;
                    $size_width = $car->size_width;
                    $size_height = $car->size_height;

                    $car->size = $size_length + $size_width + $size_height;
                    }
            
            $cars = $cars->sortByDesc('size'); //サイズでソート    
                
            return view('car.spec.size', compact('genre','year','spec','half','thisYear','cars'));
        }


        //室内の大きさ
        elseif($spec == 'indoorsize'){

            foreach($cars as $car){
                $indoorsize_length = $car->indoorsize_length;
                $indoorsize_width = $car->indoorsize_width;
                $indoorsize_height = $car->indoorsize_height;

                $car->indoorsize = $indoorsize_length + $indoorsize_width + $indoorsize_height;
                }
        
            $cars = $cars->sortByDesc('indoorsize'); //サイズでソート    
            
            return view('car.spec.indoorsize', compact('genre','year','spec','half','thisYear','cars'));
        }


        /*
        ミニバン独自スペック
        */

        //サイズ
        elseif($spec == 'minivan_size'){
            $cars = $cars->sortBy('minivan_size');

            return view('car.spec.minivan_size', compact('genre','year','spec','half','thisYear','cars'));
        }

        //スライドドア有無
        elseif($spec == 'minivan_slidedoor'){
            $cars = $cars->sortBy('minivan_slidedoor');

            return view('car.spec.minivan_slidedoor', compact('genre','year','spec','half','thisYear','cars'));
        }

        //スタイル
        elseif($spec == 'minivan_style'){
            $cars = $cars->sortBy('minivan_style');

            return view('car.spec.minivan_style', compact('genre','year','spec','half','thisYear','cars'));
        }        

        //３列目の格納
        elseif($spec == 'minivan_3rd'){
            $cars = $cars->sortBy('minivan_3rd');

            return view('car.spec.minivan_3rd', compact('genre','year','spec','half','thisYear','cars'));
        }                


        /*
        SUV独自スペック
        */

        ////サイズ
        //elseif($spec == 'suv_size'){
        //    $cars = $cars->sortBy('minivan_size');

        //    return view('car.spec.minivan_size', compact('genre','year','spec','half','thisYear','cars'));
        //}

        //サイズ
        elseif($spec == 'suv_size'){

            foreach($cars as $car){
                $size_length = $car->size_length;
                $size_width = $car->size_width;
                $size_height = $car->size_height;
    
                $car->size = $size_length + $size_width + $size_height;
                    if($car->size <= 7.0){
                        $car->sml = 'XS';
                    }elseif($car->size <= 7.72){
                        $car->sml = 'S';
                    }elseif($car->size <= 7.95){
                        $car->sml = 'M';
                    }elseif($car->size <=8.47 ){
                        $car->sml = 'L';
                    }else{
                    $car->sml = 'XL';    
                    }
                }
        
        $cars = $cars->sortByDesc('size'); //サイズでソート    

            return view('car.spec.size', compact('genre','year','spec','half','thisYear','cars'));
        }        





        //スタイル
        elseif($spec == 'suv_style'){
            $cars = $cars->sortBy('minivan_style');

            return view('car.spec.minivan_style', compact('genre','year','spec','half','thisYear','cars'));
        }        





        //車種一覧ビューでそれを表示
        return view('car.genre', [
            'genre' => $genre,
        ]);
    }







    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function genre($genre)
    {

        //年度取得
        $thisYear = self::THISYEAR;

        //ジャンルを取得
        if($genre == 'minivan' ){
            $cars = Car::where([
                ['minivan_flug','=', '1'],
                ])
                ->get();

        }elseif($genre == 'puchivan'){
            $cars = Car::where([
                ['puchivan_flug','=', '1'],
                ])
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where([
                ['suv_flug','=', '1'],
                ])
                ->get();

        }elseif($genre == 'compact'){
            $cars = Car::where([
                ['compact_flug','=', '1'],
                ])
                ->get();        

        }elseif($genre == 'sedan'){
            $cars = Car::where([
                ['sedan_flug','=', '1'],
                ])
                ->get();

        }elseif($genre == 'wagon'){
            $cars = Car::where([
                ['wagon_flug','=', '1'],
                ])
                ->get();                

        }elseif($genre == 'courpe'){
            $cars = Car::where([
                ['courpe_flug','=', '1'],
                ])
                ->get();                                
        }


        //車種一覧ビューでそれを表示
        return view('car.genre', [
            'genre' => $genre,
            'cars' => $cars,
            'thisYear' => $thisYear,
            'year' => $thisYear,
        ]);
    }


//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function year($genre,$spec)
//    {

//        //年度取得
//        $thisYear = self::THISYEAR;
////dd($spec);
//        //ジャンルを取得
//        if($genre == 'minivan' ){
//            $cars = Car::where([
//                ['minivan_flug','=', '1'],
//                ['spec','=', $spec]
//                ])
//                ->get();

//        }elseif($genre == 'suv'){
//            $cars = Car::where([
//                ['suv_flug','=', '1'],
//                ['spec','=', $spec]
//                ])
//                ->get();
//        }

//        //車種一覧ビューでそれを表示
//        return view('car.year', compact('genre','spec','thisYear','cars'));
//    }






}
