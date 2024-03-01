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
                ['half','=', $half]
                ])
                ->whereYear('year', '<=', $year)
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where('suv_flug','=', '1')
                ->whereYear('year', '<=', $year)
                ->get();

        }elseif($genre == 'compact'){
            $cars = Car::where('compact_flug','=', '1')
                ->whereYear('year', '<=', $year)
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
        elseif($spec == 'plice'){
            $plices = $cars->sortBy('plice');

            return view('car.spec.plice', compact('genre','year','spec','half','thisYear','plices'));
        }

        //小回り
        elseif($spec == 'turningradius'){
            $plices = $cars->sortBy('turningradius');

            return view('car.spec.turningradius', compact('genre','year','spec','half','thisYear','turningradiuses')); //複数形OK？カラム名変更検討
        }

        //車体 長さ
        elseif($spec == 'size_length'){
            $plices = $cars->sortBy('size_length');

            return view('car.spec.size_length', compact('genre','year','spec','half','thisYear','size_lengths'));
        }        

        //車体　幅
        elseif($spec == 'size_width'){
            $plices = $cars->sortBy('size_width');

            return view('car.spec.size_width', compact('genre','year','spec','half','thisYear','size_widths'));
        }        

        //車体　高さ
        elseif($spec == 'size_height'){
            $plices = $cars->sortBy('size_height');

            return view('car.spec.size_height', compact('genre','year','spec','half','thisYear','size_heights'));
        }

        //車体　合計
        elseif($spec == 'size'){
            $plices = $cars->sortBy('size');

            return view('car.spec.size', compact('genre','year','spec','half','thisYear','sizes'));
        }        
        
        //ホイールベース
        elseif($spec == 'wheelbase'){
            $plices = $cars->sortBy('wheelbase');

            return view('car.spec.wheelbase', compact('genre','year','spec','half','thisYear','wheelbases'));
        }                

        //トレッド
        elseif($spec == 'tred'){
            $plices = $cars->sortBy('tred');

            return view('car.spec.tred', compact('genre','year','spec','half','thisYear','treds'));
        }

        //室内　長さ
        elseif($spec == 'indoorsize_length'){
            $plices = $cars->sortBy('indoorsize_length');

            return view('car.spec.indoorsize_length', compact('genre','year','spec','half','thisYear','indoorsize_lengths'));
        }

        //室内　幅
        elseif($spec == 'indoorsize_width'){
            $plices = $cars->sortBy('indoorsize_width');

            return view('car.spec.indoorsize_width', compact('genre','year','spec','half','thisYear','indoorsize_widths'));
        }

        //室内　高さ
        elseif($spec == 'indoorsize_height'){
            $plices = $cars->sortBy('indoorsize_height');

            return view('car.spec.indoorsize_height', compact('genre','year','spec','half','thisYear','indoorsize_heights'));
        }

        //室内　合計
        elseif($spec == 'indoorsize'){
            $plices = $cars->sortBy('indoorsize');

            return view('car.spec.indoorsize', compact('genre','year','spec','half','thisYear','indoorsizes'));
        }        

        //車輌重量
        elseif($spec == 'weight'){
            $plices = $cars->sortBy('weight');

            return view('car.spec.weight', compact('genre','year','spec','half','thisYear','weights'));
        }

        //乗車人数
        elseif($spec == 'ridingcapacity'){
            $plices = $cars->sortBy('ridingcapacity');

            return view('car.spec.ridingcapacity', compact('genre','year','spec','half','thisYear','ridingcapacitys'));
        }

        //最低地上高
        elseif($spec == 'groundclearance'){
            $plices = $cars->sortBy('groundclearance');

            return view('car.spec.groundclearance', compact('genre','year','spec','half','thisYear','groundclearances'));
        }

        //色数
        elseif($spec == 'color'){
            $plices = $cars->sortBy('color');

            return view('car.spec.color', compact('genre','year','spec','half','thisYear','colors'));
        }

        //燃料の種類
        elseif($spec == 'fuel'){
            $plices = $cars->sortBy('fuel');

            return view('car.spec.fuel', compact('genre','year','spec','half','thisYear','fuels'));
        }        

        //燃料タンク容量
        elseif($spec == 'fueltank'){
            $plices = $cars->sortBy('fueltank');

            return view('car.spec.fueltank', compact('genre','year','spec','half','thisYear','fueltanks'));
        }

        //燃費JC08
        elseif($spec == 'JC08'){
            $plices = $cars->sortBy('JC08');

            return view('car.spec.JC08', compact('genre','year','spec','half','thisYear','JC08s'));
        }

        //排気量
        elseif($spec == 'displacement'){
            $plices = $cars->sortBy('displacement');

            return view('car.spec.displacement', compact('genre','year','spec','half','thisYear','displacements'));
        }

        //燃費WTLC
        elseif($spec == 'WTLC'){
            $plices = $cars->sortBy('WTLC');

            return view('car.spec.WTLC', compact('genre','year','spec','half','thisYear','WTLCs'));
        }

        //馬力
        elseif($spec == 'ps'){
            $plices = $cars->sortBy('ps');

            return view('car.spec.ps', compact('genre','year','spec','half','thisYear','pses')); //複数形OK？
        }

        //トルク
        elseif($spec == 'torque'){
            $plices = $cars->sortBy('torque');

            return view('car.spec.torque', compact('genre','year','spec','half','thisYear','torques'));
        }        

        //タイヤ
        elseif($spec == 'Ftiresize'){
            $plices = $cars->sortBy('Ftiresize');

            return view('car.spec.Ftiresize', compact('genre','year','spec','half','thisYear','Ftiresizes')); //大文字FはOK？　マイグレーションファイルのカラム名間違ってます
        }


        /*
        計算必要なスペック
        */

        //自動車税
        elseif($spec == 'tax'){

            $taxs = $cars->sortBy('displacement'); //排気量を取得

                //排気量を自動車税へ変換し$taxへ格納
                foreach($taxs as $car){
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

            return view('car.spec.tax', compact('genre','year','spec','half','thisYear','taxs'));
        }

        //重量税
        elseif($spec == 'jtax'){

            $jtaxs = $cars->sortBy('weight'); //車両重量を取得

                //車輌重量を重量税税へ変換し$jtaxへ格納
                foreach($jtaxs as $car){
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

            return view('car.spec.jtax', compact('genre','year','spec','half','thisYear','jtaxs'));
        }

        //kg単価
        elseif($spec == 'kg'){

            $kgs = $cars;

                foreach($kgs as $car){
                    $price = ($car->price)*10000;
                    $weight = $car->weight;
                    $car->kg = floor($price/$weight);//本当はこの結果でソートしたい
                    }

            $kgs = $cars->sortByDesc('kg'); //kg単価でソート    
                
            return view('car.spec.kg', compact('genre','year','spec','half','thisYear','kgs'));
        }


        //航続距離
        elseif($spec == 'cruising'){

            $cruisings = $cars;

                foreach($cruisings as $car){
                    $fueltank = $car->fueltank;
                    $wltc = $car->WLTC;
                    $car->cruising = $fueltank*$wltc;
                    }
            
            $cruisings = $cars->sortByDesc('cruising'); //航続距離でソート    
                
            return view('car.spec.cruising', compact('genre','year','spec','half','thisYear','cruisings'));
        }


        //車種一覧ビューでそれを表示
        return view('car.genre', [
            'genre' => $genre,
            'spec' => $spec,
            'year' => $year,
            'half' => $half,
            'makers' => $makers,
            'names' => $names,
            'releases' => $releases,
            'prices' => $prices,
            'taxs' => $taxs,
            'jtaxs' => $taxs,
        ]);
    }







    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category($genre)
    {

        //年度取得
        $thisYear = self::THISYEAR;

        //ジャンルを取得
        if($genre == 'minivan' ){
            $cars = Car::where([
                ['minivan_flug','=', '1'],
                ])
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where([
                ['suv_flug','=', '1'],
                ])
                ->get();
        }


        //車種一覧ビューでそれを表示
        return view('car.category', [
            'genre' => $genre,
            'cars' => $cars,
            'thisYear' => $thisYear,
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
