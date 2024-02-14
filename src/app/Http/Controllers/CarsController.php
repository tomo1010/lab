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
    public function spec($genre,$year,$spec)
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

        //メーカー取得
        if($spec == 'maker'){
            $makers = $cars->sortBy('maker');       
            
            return view('car.maker', compact('genre','year','spec','thisYear','makers'));
        }

        //車名取得
        elseif($spec == 'name'){
            $names = $cars->sortBy('name');

            return view('car.name', compact('genre','year','spec','thisYear','names'));
        }

        //発売日取得
        elseif($spec == 'release'){
            $releases = $cars->sortByDesc('release');

            return view('car.release', compact('genre','year','spec','thisYear','releases'));
        }

            //価格取得
            $prices = $cars->sortBy('price');

            //自動車税取得
            $taxs = $cars->sortBy('displacement');

                //排気量を自動車税へ変換し$taxへ格納
                foreach($taxs as $car){
                    if($car->displacement == '-'){
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


            //重量税取得
            $jtaxs = $cars->sortBy('wight');

                //排気量を自動車税へ変換し$taxへ格納
                foreach($jtaxs as $car){
                    if($car->weight == '-'){
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
    public function genre()
    {

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
    public function thirdyear()
    {

        //３年目を設定
        $dt = new Carbon();
        $year = $dt->subYears(3);
        $year = $year->year;
        
//dd($year);
            //3年目のみ取得
            $cars = Car::where([
                ['suv_flug','=', '1'],
                ['year','=', '2022']
                ])
                ->get();

            //メーカー取得
            $makers = $cars->sortBy('maker');

            //車名取得
            $names = $cars->sortBy('name');

            //価格取得
            $prices = $cars->sortBy('price');

            //自動車税取得
            $taxs = $cars->sortBy('displacement');

                //排気量を自動車税へ変換し$taxへ格納
                foreach($taxs as $car){
                    if($car->displacement == '-'){
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


        //車種一覧ビューでそれを表示
        return view('car.thirdyear', [
            'makers' => $makers,
            'names' => $names,
            'prices' => $prices,
            'taxs' => $taxs,
        ]);
    }



}
