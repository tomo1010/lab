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
        // Rakuten APIクライアントのセットアップ
        $client = new RakutenRws_Client();
        $client->setApplicationId(config('app.rakuten_id'));
        $client->setAffiliateId(config('app.rakuten_aff'));
    
        // 選択されたアイテムコードを取得
        $itemCodes = $request->input('itemCodes', []);
    
        // アイテムの詳細を格納する配列
        $items = [];
    
        // 各アイテムコードごとに詳細を取得
        foreach ($itemCodes as $code) {
            $response = $client->execute('IchibaItemSearch', [
                'itemCode' => $code,
            ]);
    
            if ($response->isOk()) {
                foreach ($response as $item) {
                    $items[] = [
                        'itemCode' => $item['itemCode'],
                        'itemName' => $item['itemName'],
                        'itemPrice' => $item['itemPrice'],
                    ];
                }
            }
        }
    
        // アイテム情報をビューに渡す
        return view('tire.setPdf', [
            'items' => $items,
        ]);
    }
    



    public function createPdf(Request $request)
    {
        $items = [];
        $sumPrice = 0;
    
        foreach ($request->input('items', []) as $item) {
            $itemName = $item['itemName'];
            $itemPrice = (int) $item['itemPrice'];
            $itemOption = (int) $item['itemOption'];
            $totalItemPrice = $itemPrice + $itemOption;
    
            $sumPrice += $totalItemPrice;
    
            $items[] = [
                'itemName' => $itemName,
                'itemPrice' => $itemPrice,
                'itemOption' => $itemOption,
                'totalItemPrice' => $totalItemPrice,
            ];
        }
    
        $data = [
            'items' => $items,
            'sumPrice' => $sumPrice,
        ];
    
        // PDF生成とビューにデータを渡す
        $pdf = PDF::loadView('tire.createPdf', $data);
    
        return $pdf->stream('laravel.pdf');
    }
    


}
