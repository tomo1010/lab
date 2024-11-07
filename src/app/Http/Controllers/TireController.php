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
    
            // 各オプションと倍率の初期値設定
            $itemOptionA = isset($item['itemOptionA']) ? (int) $item['itemOptionA'] : 0;
            $itemOptionB = isset($item['itemOptionB']) ? (float) $item['itemOptionB'] : 1;
            $wages = isset($item['wages']) ? (int) $item['wages'] : 0;
            $wagesMultiplier = isset($item['wagesMultiplier']) ? (int) $item['wagesMultiplier'] : 1;
            $wasteTire = isset($item['wasteTire']) ? (int) $item['wasteTire'] : 0;
            $wasteTireMultiplier = isset($item['wasteTireMultiplier']) ? (int) $item['wasteTireMultiplier'] : 1;
            $nut = isset($item['nut']) ? (int) $item['nut'] : 0;
            $nutMultiplier = isset($item['nutMultiplier']) ? (int) $item['nutMultiplier'] : 1;
            $valve = isset($item['valve']) ? (int) $item['valve'] : 0;
            $valveMultiplier = isset($item['valveMultiplier']) ? (int) $item['valveMultiplier'] : 1;
            $bag = isset($item['bag']) ? (int) $item['bag'] : 0;
            $bagMultiplier = isset($item['bagMultiplier']) ? (int) $item['bagMultiplier'] : 1;
            $others = isset($item['others']) ? (int) $item['others'] : 0;
            $othersMultiplier = isset($item['othersMultiplier']) ? (int) $item['othersMultiplier'] : 1;
    
            // 各項目に倍率を適用
            $wagesWithMultiplier = $wages * $wagesMultiplier;
            $wasteTireWithMultiplier = $wasteTire * $wasteTireMultiplier;
            $nutWithMultiplier = $nut * $nutMultiplier;
            $valveWithMultiplier = $valve * $valveMultiplier;
            $bagWithMultiplier = $bag * $bagMultiplier;
            $othersWithMultiplier = $others * $othersMultiplier;
    
            // 小計計算
            $subtotalPrice = $wagesWithMultiplier + $wasteTireWithMultiplier + $nutWithMultiplier + $valveWithMultiplier + $bagWithMultiplier + $othersWithMultiplier;
    
            // 合計計算
            if ($itemOptionA > 0) {
                $totalItemPrice = $itemPrice + $itemOptionA + $subtotalPrice;
            } elseif ($itemOptionB > 1) {
                $totalItemPrice = (int)($itemPrice * $itemOptionB) + $subtotalPrice;
            } else {
                $totalItemPrice = $itemPrice + $subtotalPrice;
            }
    
            // 合計金額の更新
            $sumPrice += $totalItemPrice;
    
            // 商品情報を配列に追加
            $items[] = [
                'itemName' => $itemName,
                'itemPrice' => $itemPrice,
                'itemOptionA' => $itemOptionA,
                'itemOptionB' => $itemOptionB,
                'wages' => $wages,
                'wagesMultiplier' => $wagesMultiplier,
                'wasteTire' => $wasteTire,
                'wasteTireMultiplier' => $wasteTireMultiplier,
                'nut' => $nut,
                'nutMultiplier' => $nutMultiplier,
                'valve' => $valve,
                'valveMultiplier' => $valveMultiplier,
                'bag' => $bag,
                'bagMultiplier' => $bagMultiplier,
                'others' => $others,
                'othersMultiplier' => $othersMultiplier,
                'subtotalPrice' => $subtotalPrice,
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
