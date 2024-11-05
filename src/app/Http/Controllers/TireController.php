<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;
use PDF;


class TireController extends Controller
{
    public function index()
    {
         //楽天APIを扱うRakutenRws_Clientクラスのインスタンスを作成します
         $client = new RakutenRws_Client();
 
 
         //定数化
         define("RAKUTEN_APPLICATION_ID"     , config('app.rakuten_id'));
         define("RAKUTEN_APPLICATION_SEACRET", config('app.rakuten_key'));
         define("RAKUTEN_AFFILIATE_ID"     , config('app.rakuten_aff'));
 
         //アプリIDをセット！
         $client->setApplicationId(RAKUTEN_APPLICATION_ID);
         $client->setAffiliateId(RAKUTEN_AFFILIATE_ID);
  

        $response = $client->execute('IchibaItemSearch', array(
            //入力パラメーター
            'keyword' => '軽自動車　スタッドレスタイヤ　セット',
            //'page' => $page,
        ));


        return view('tire.index', [
            'items' => $response,
        ]);
        
    }
    

    public function setPdf(Request $request)
    {
         //楽天APIを扱うRakutenRws_Clientクラスのインスタンスを作成します
         $client = new RakutenRws_Client();
 
 
         //定数化
         define("RAKUTEN_APPLICATION_ID"     , config('app.rakuten_id'));
         define("RAKUTEN_APPLICATION_SEACRET", config('app.rakuten_key'));
         define("RAKUTEN_AFFILIATE_ID"     , config('app.rakuten_aff'));
 
         //アプリIDをセット！
         $client->setApplicationId(RAKUTEN_APPLICATION_ID);
         $client->setAffiliateId(RAKUTEN_AFFILIATE_ID);

        $response = $client->execute('IchibaItemSearch', array(
            //入力パラメーター
            'itemCode' => $request->itemCode,
            //'page' => $page,
        ));

        $items = $response;

        foreach ($items as $item){
            $itemCode = $item['itemCode'];
            $itemName = $item['itemName'];
            $itemPrice = $item['itemPrice'];
        }

        return view('tire.setPdf', [
            'itemCode' => $itemCode,
            'itemName' => $itemName,
            'itemPrice' => $itemPrice,
        ]);
            
    }



    public function createPdf(Request $request)
    {
         //楽天APIを扱うRakutenRws_Clientクラスのインスタンスを作成します
         $client = new RakutenRws_Client();
 
 
         //定数化
         define("RAKUTEN_APPLICATION_ID"     , config('app.rakuten_id'));
         define("RAKUTEN_APPLICATION_SEACRET", config('app.rakuten_key'));
         define("RAKUTEN_AFFILIATE_ID"     , config('app.rakuten_aff'));
 
         //アプリIDをセット！
         $client->setApplicationId(RAKUTEN_APPLICATION_ID);
         $client->setAffiliateId(RAKUTEN_AFFILIATE_ID);

        $response = $client->execute('IchibaItemSearch', array(
            //入力パラメーター
            'itemCode' => $request->itemCode,
            //'page' => $page,
        ));

        $items = $response;
//dd($request);
        //foreach ($items as $item){
        //    $itemName = $item['itemName'];
        //    $itemPrice = $item['itemPrice'];
        //}

        $sumPrice = $request->itemPrice + $request->itemOption;
//dd($sumPrice);
        $data = [
            'itemName' => $request->itemName,
            'sumPrice' => $sumPrice,
        ];

        // PDF生成とビューにデータを渡す
        $pdf = PDF::loadView('tire.createPdf', $data);

        // PDFとして表示
        return $pdf->stream('laravel.pdf');
            
    }


}
