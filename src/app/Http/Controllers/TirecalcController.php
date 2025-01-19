<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;
use PDF;


class TirecalcController extends Controller
{
    public function setPdf(Request $request)
    {

        $comment = $request->input('comment'); // $comment を受け取る

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
        return view('tirecalc.setPdf', [
            'items' => $items,
            'comment' => $comment,
        ]);
    }



    public function createPdf(Request $request)
    {
        // フォームから送信されたデータを受け取る
        $comment = $request->input('comment');
        $productData = $request->input('productData'); 
        $maker1 = $request->input('maker1');
        $maker2 = $request->input('maker2');
        $maker3 = $request->input('maker3');
        $sizeFree = $request->input('sizeFree');
        $sizeGeneral = $request->input('sizeGeneral');
        $selectTire = $request->input('selectTire');
        $address = $request->input('address');
        $honorific = $request->input('honorific');

        

    // selectTireに応じた画像パスを決定
    $tireImages = [
        '夏タイヤ' => 'img/tirecalc/summer.png',
        '夏タイヤAWセット' => 'img/tirecalc/summerSet.png',
        '冬タイヤ' => 'public/img/tirecalc/studless.png',
        '冬タイヤAWセット' => 'public/img/tirecalc/studlessSet.png',
        'オールシーズンタイヤ' => 'public/img/tirecalc/summer.png',
        'オールシーズンタイヤAWセット' => 'public/img/tirecalc/summerSet.png',
    ];

    // 画像パスを取得（未定義の場合はnull）
    $imagePath = $tireImages[$selectTire] ?? null;


        // 商品データを整形
        $formattedProducts = [];
        foreach ($productData as $key => $product) {
            $formattedProducts[] = [
                'productNumber' => $key,
                'profitTotal' => $product['profitTotal'] ?? 0,
                'wagesTotal' => $product['wagesTotal'] ?? 0,
                'taxExcludedTotal' => $product['taxExcludedTotal'] ?? 0,
                'taxIncludedTotal' => $product['taxIncludedTotal'] ?? 0,
            ];
        }

        // 現在日時を取得
        $now = Carbon::now();
        // 現在日時を××××-××-××に変換
        $date = $now->format('Y-m-d');


        // 印刷設定をデータに追加
        $data = [
            'products' => $formattedProducts,
            'makers' => [
                'maker1' => $maker1,
                'maker2' => $maker2,
                'maker3' => $maker3,
            ],
            'sizeFree' => $sizeFree,
            'sizeGeneral' => $sizeGeneral,
            'selectTire' => $selectTire,
            'imagePath' => 'file://' . $imagePath, // 画像パスを渡す
            'comment' => $comment,
            'address' => $address,
            'honorific' => $honorific,
            'date' => $date,

        ];
    
        // PDF生成とビューにデータを渡す
        $pdf = PDF::loadView('tirecalc.createPdf', $data);
        return $pdf->stream('laravel.pdf');
    }
    
    
}


