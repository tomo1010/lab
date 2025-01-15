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

        $keyword = $request->input('keyword'); // $keyword を受け取る

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
            'keyword' => $keyword,
        ]);
    }



    public function createPdf(Request $request)
    {
        // フォームから送信されたデータを受け取る
        $keyword = $request->input('keyword'); // $keyword を受け取る
    
        $productData = $request->input('productData'); // 商品データを受け取る
        // 商品データが正しい形式か確認
        if (!$productData || !is_array($productData)) {
            return redirect()->back()->with('error', '商品のデータが不正です。');
        }
//dd($request->input('sizeKeyword'));

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
//dd($formattedProducts);    
        // PDF生成に渡すデータを構築
        $data = [
            'keyword' => $keyword,
            'products' => $formattedProducts,
        ];
    
        // PDF生成とビューにデータを渡す
        $pdf = PDF::loadView('tirecalc.createPdf', $data);
        return $pdf->stream('laravel.pdf');
    }
    
}


