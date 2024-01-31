<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;    // 追加

class CarsController extends Controller
{
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
    public function minivan()
    {

        //毎年２回のデータ処理、上半期下半期
        //for($i = 0; $i < 3; $i++){

            //ミニバンのみ取得
            $cars = Car::where([
                ['genre','like', 'min'],
                ['year','=', '2020b']
                ])
                ->get();

            //メーカー取得
            $makers = $cars->sortBy('maker');

            //車名取得
            $names = $cars->sortBy('name');

            //発売日取得
            $releases = $cars->sortByDesc('release');

            //価格取得
            $plices = $cars->sortBy('plice');

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
        return view('car.minivan', [
            'makers' => $makers,
            'names' => $names,
            'releases' => $releases,
            'plices' => $plices,
            'taxs' => $taxs,
        ]);
    }



        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function suv()
    {

        //毎年２回のデータ処理、上半期下半期
        //for($i = 0; $i < 3; $i++){

            //SUVのみ取得
            $cars = Car::where([
                ['genre','like', 'suv'],
                ['year','=', '2020b']
                ])
                ->get();

            //メーカー取得
            $makers = $cars->sortBy('maker');

            //車名取得
            $names = $cars->sortBy('name');

            //価格取得
            $plices = $cars->sortBy('plice');

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
        return view('car.suv', [
            'makers' => $makers,
            'names' => $names,
            'plices' => $plices,
            'taxs' => $taxs,
        ]);
    }



}
