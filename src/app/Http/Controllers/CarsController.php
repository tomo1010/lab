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
    public function spec($genre,$spec,$year)
    {

        //年度取得
        $thisYear = self::THISYEAR;

        /*
        ジャンルと年を取得
        */

        if($genre == 'minivan' ){
            $cars = Car::where([
                ['minivan_flug','=', '1'],
                ['year','=', $year]
                ])
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where([
                ['suv_flug','=', '1'],
                ['year','=', $year]
                ])
                ->get();
        }


        /*
        各スペックを取得
        */

        //メーカー
        if($spec == 'maker'){
            $makers = $cars->sortBy('maker');       
            
            return view('car.maker', compact('genre','year','spec','thisYear','makers'));
        }

        //車名
        elseif($spec == 'name'){
            $names = $cars->sortBy('name');

            return view('car.name', compact('genre','year','spec','thisYear','names'));
        }

        //発売日
        elseif($spec == 'release'){
            $releases = $cars->sortByDesc('release');

            return view('car.release', compact('genre','year','spec','thisYear','releases'));
        }

        //価格
        elseif($spec == 'plice'){
            $plices = $cars->sortBy('plice');

            return view('car.plice', compact('genre','year','spec','thisYear','plices'));
        }

        //小回り
        elseif($spec == 'turningradius'){
            $plices = $cars->sortBy('turningradius');

            return view('car.turningradius', compact('genre','year','spec','thisYear','turningradiuses')); //複数形OK？カラム名変更検討
        }

        //大きさ　長さ
        elseif($spec == 'size_length'){
            $plices = $cars->sortBy('size_length');

            return view('car.size_length', compact('genre','year','spec','thisYear','size_lengths'));
        }        

        //大きさ　幅
        elseif($spec == 'size_width'){
            $plices = $cars->sortBy('size_width');

            return view('car.size_width', compact('genre','year','spec','thisYear','size_widths'));
        }        

        //大きさ　高さ
        elseif($spec == 'size_height'){
            $plices = $cars->sortBy('size_height');

            return view('car.size_height', compact('genre','year','spec','thisYear','size_heights'));
        }

        //大きさ　高さ
        elseif($spec == 'size'){
            $plices = $cars->sortBy('size');

            return view('car.size', compact('genre','year','spec','thisYear','sizes'));
        }        
        
        //ホイールベース
        elseif($spec == 'wheelbase'){
            $plices = $cars->sortBy('wheelbase');

            return view('car.wheelbase', compact('genre','year','spec','thisYear','wheelbases'));
        }                

        //トレッド
        elseif($spec == 'tred'){
            $plices = $cars->sortBy('tred');

            return view('car.tred', compact('genre','year','spec','thisYear','treds'));
        }

        //室内　長さ
        elseif($spec == 'indoorsize_length'){
            $plices = $cars->sortBy('indoorsize_length');

            return view('car.indoorsize_length', compact('genre','year','spec','thisYear','indoorsize_lengths'));
        }

        //室内　幅
        elseif($spec == 'indoorsize_width'){
            $plices = $cars->sortBy('indoorsize_width');

            return view('car.indoorsize_width', compact('genre','year','spec','thisYear','indoorsize_widths'));
        }

        //室内　高さ
        elseif($spec == 'indoorsize_height'){
            $plices = $cars->sortBy('indoorsize_height');

            return view('car.indoorsize_height', compact('genre','year','spec','thisYear','indoorsize_heights'));
        }

        //室内　
        elseif($spec == 'indoorsize'){
            $plices = $cars->sortBy('indoorsize');

            return view('car.indoorsize', compact('genre','year','spec','thisYear','indoorsizes'));
        }        

        //車輌重量
        elseif($spec == 'weight'){
            $plices = $cars->sortBy('weight');

            return view('car.weight', compact('genre','year','spec','thisYear','weights'));
        }

        //乗車人数
        elseif($spec == 'ridingcapacity'){
            $plices = $cars->sortBy('ridingcapacity');

            return view('car.ridingcapacity', compact('genre','year','spec','thisYear','ridingcapacitys'));
        }

        //最低地上高
        elseif($spec == 'groundclearance'){
            $plices = $cars->sortBy('groundclearance');

            return view('car.groundclearance', compact('genre','year','spec','thisYear','groundclearances'));
        }

        //色数
        elseif($spec == 'color'){
            $plices = $cars->sortBy('color');

            return view('car.color', compact('genre','year','spec','thisYear','colors'));
        }

        //燃料の種類
        elseif($spec == 'fuel'){
            $plices = $cars->sortBy('fuel');

            return view('car.fuel', compact('genre','year','spec','thisYear','fuels'));
        }        

        //燃料タンク容量
        elseif($spec == 'fueltank'){
            $plices = $cars->sortBy('fueltank');

            return view('car.fueltank', compact('genre','year','spec','thisYear','fueltanks'));
        }

        //燃費JC08
        elseif($spec == 'JC08'){
            $plices = $cars->sortBy('JC08');

            return view('car.JC08', compact('genre','year','spec','thisYear','JC08s'));
        }

        //排気量
        elseif($spec == 'displacement'){
            $plices = $cars->sortBy('displacement');

            return view('car.displacement', compact('genre','year','spec','thisYear','displacements'));
        }

        //燃費WTLC
        elseif($spec == 'WTLC'){
            $plices = $cars->sortBy('WTLC');

            return view('car.WTLC', compact('genre','year','spec','thisYear','WTLCs'));
        }

        //馬力
        elseif($spec == 'ps'){
            $plices = $cars->sortBy('ps');

            return view('car.ps', compact('genre','year','spec','thisYear','pses')); //複数形OK？
        }

        //トルク
        elseif($spec == 'torque'){
            $plices = $cars->sortBy('torque');

            return view('car.torque', compact('genre','year','spec','thisYear','torques'));
        }        

        //タイヤ
        elseif($spec == 'Ftiresize'){
            $plices = $cars->sortBy('Ftiresize');

            return view('car.Ftiresize', compact('genre','year','spec','thisYear','Ftiresizes')); //大文字FはOK？　マイグレーションファイルのカラム名間違ってます
        }

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

            return view('car.tax', compact('genre','year','spec','thisYear','taxs'));
        }

        //自動車税
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

            return view('car.jtax', compact('genre','year','spec','thisYear','jtaxs'));
        }

        ////SPECなし年のみ
        //elseif($spec == null){
        //    $cars = Car::where([
        //        ['minivan_flug','=', '1'],
        //        ['year','=', $year]
        //        ])
        //        ->get();

        //    return view('car.year', compact('genre','year','thisYear'));
        //}


//dd($years);
        //車種一覧ビューでそれを表示
        return view('car.genre', [
            'genre' => $genre,
            'year' => $year,
            'spec' => $spec,
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
    public function genre($genre)
    {

        //ジャンルを取得
        if($genre == 'minivan' ){
            $cars = Car::where([
                ['minivan_flug','=', '1'],
                //['year','=', $year]
                ])
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where([
                ['suv_flug','=', '1'],
                //['year','=', $year]
                ])
                ->get();
        }


        //車種一覧ビューでそれを表示
        return view('car.genre', [
            'genre' => $genre,
            'cars' => $cars,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function year($genre,$year)
    {

        //年度取得
        $thisYear = self::THISYEAR;

        //ジャンルを取得
        if($genre == 'minivan' ){
            $cars = Car::where([
                ['minivan_flug','=', '1'],
                ['year','=', $year]
                ])
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where([
                ['suv_flug','=', '1'],
                ['year','=', $year]
                ])
                ->get();
        }

        //車種一覧ビューでそれを表示
        return view('car.year', compact('genre','year','thisYear','cars'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category($genre,$year)
    {

        //年度取得
        $thisYear = self::THISYEAR;

        //ジャンルを取得
        if($genre == 'minivan' ){
            $cars = Car::where([
                ['minivan_flug','=', '1'],
                ['year','=', $year]

                ])
                ->get();

        }elseif($genre == 'suv'){
            $cars = Car::where([
                ['suv_flug','=', '1'],
                ['year','=', $year]
                ])
                ->get();
        }

        //車種一覧ビューでそれを表示
        return view('car.category', compact('genre','year','thisYear','cars'));
    }    



//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function thirdyear()
//    {

//        //３年目を設定
//        $dt = new Carbon();
//        $year = $dt->subYears(3);
//        $year = $year->year;
        
////dd($year);
//            //3年目のみ取得
//            $cars = Car::where([
//                ['suv_flug','=', '1'],
//                ['year','=', '2022']
//                ])
//                ->get();

//            //メーカー取得
//            $makers = $cars->sortBy('maker');

//            //車名取得
//            $names = $cars->sortBy('name');

//            //価格取得
//            $prices = $cars->sortBy('price');

//            //自動車税取得
//            $taxs = $cars->sortBy('displacement');

//                //排気量を自動車税へ変換し$taxへ格納
//                foreach($taxs as $car){
//                    if($car->displacement == '-'){
//                        $car->tax = '-';
//                    }elseif($car->displacement < 660){
//                        $car->tax = '10800';
//                    }elseif($car->displacement < 1000){
//                        $car->tax = '25000';
//                    }elseif($car->displacement < 1500){
//                        $car->tax = '30500';
//                    }elseif($car->displacement < 2000){
//                        $car->tax = '36000';
//                    }elseif($car->displacement < 2500){
//                        $car->tax = '43500';
//                    }elseif($car->displacement < 3000){
//                        $car->tax = '50000';
//                    }elseif($car->displacement < 3500){
//                        $car->tax = '57000';
//                    }elseif($car->displacement < 4000){
//                        $car->tax = '65500';
//                    }elseif($car->displacement < 4500){
//                        $car->tax = '75500';
//                    }elseif($car->displacement < 5000){
//                        $car->tax = '87000';
//                    }elseif($car->displacement < 5500){
//                        $car->tax = '110000';
//                    }elseif($car->displacement > 6000){
//                        $car->tax = '19800';
//                    }
//                }


//        //車種一覧ビューでそれを表示
//        return view('car.thirdyear', [
//            'makers' => $makers,
//            'names' => $names,
//            'prices' => $prices,
//            'taxs' => $taxs,
//        ]);
//    }



}
