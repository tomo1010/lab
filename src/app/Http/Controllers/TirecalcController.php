<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;
use PDF;


class TirecalcController extends Controller
{
    public function index(Request $request)
    {
        // test用コメント //

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
        return view('tirecalc.index', [
            'items' => $items,
            'comment' => $comment,
        ]);
    }



    public function createPdf(Request $request)
    {
        $items = [];

        foreach ([1, 2, 3] as $i) {
            $cost = $request->input("item{$i}_cost");
            $quantity = $request->input("item{$i}_quantity");
            $items[] = [
                'label' => "商品{$i}",
                'cost' => $cost,
                'quantity' => $quantity,
            ];
        }
        //dd($request->input('laborItems'));

        $data = [
            'items' => $items,
            'grossA' => $request->grossA,
            'grossB' => $request->grossB,
            'taxMode' => $request->taxMode,
            'laborTaxMode' => $request->laborTaxMode,
            'laborItems' => $request->input('laborItems', []),
            'date' => now()->format('Y-m-d'),
        ];
        //dd($data);
        $fileName = "{$data['date']}.pdf";

        $pdf = PDF::loadView('tirecalc.createPdf', $data);
        return $pdf->download($fileName);
    }
}
