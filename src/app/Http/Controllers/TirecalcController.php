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
        $keyword = $request->input('keyword'); // $keyword を受け取る

        $items = [];
        $sumPrice = 0;
    
        // メーカー名のリスト
        $makers = ['Bridgestone', 'Dunlop', 'Yokohama', 'Toyo', 'Goodyear', 'Michelin', 'Continental', 'Pirelli', 'Hankook', 'Kumho', 'Falken', 'Nokian', 'Maxxis', 'Uniroyal', 'BFGoodrich','BRIDGESTONE', 'DUNLOP', 'YOKOHAMA', 'TOYO', 'GOODYEAR', 'MICHELIN', 'CONTINENTAL', 'PIRELLI', 'HANKOOK', 'KUMHO', 'FALKEN', 'NOKIAN', 'MAXXIS', 'UNIROYAL', 'BFGOODRICH','ブリヂストン', 'ダンロップ', 'ヨコハマ', 'トーヨー', 'グッドイヤー', 'ミシュラン', 'コンチネンタル', 'ピレリ', 'ハンコック', 'クムホ', 'ファルケン', 'ノキアン', 'マキシス', 'ユニロイヤル', 'BFグッドリッチ',
];
    
        foreach ($request->input('items', []) as $item) {
            $itemName = $item['itemName'];
            $itemPrice = (int) $item['itemPrice'];
    
            // メーカー名が含まれているか確認
            $maker = null; // 初期化
            foreach ($makers as $maker) {
                if (strpos($itemName, $maker) !== false) {
                    $maker = $maker; // メーカーを $maker に代入
                    break;
                }
            }
    
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
            $detachment = isset($item['detachment']) ? (int) $item['detachment'] : 0;
            $detachmentMultiplier = isset($item['detachmentMultiplier']) ? (int) $item['detachmentMultiplier'] : 1;
    
            // 各項目に倍率を適用
            $wagesWithMultiplier = $wages * $wagesMultiplier;
            $wasteTireWithMultiplier = $wasteTire * $wasteTireMultiplier;
            $nutWithMultiplier = $nut * $nutMultiplier;
            $valveWithMultiplier = $valve * $valveMultiplier;
            $bagWithMultiplier = $bag * $bagMultiplier;
            $detachmentWithMultiplier = $detachment * $detachmentMultiplier;
    
            // 小計計算
            $subtotalPrice = $wagesWithMultiplier + $wasteTireWithMultiplier + $nutWithMultiplier + $valveWithMultiplier + $bagWithMultiplier + $detachmentWithMultiplier;
    
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
                'detachment' => $detachment,
                'detachmentMultiplier' => $detachmentMultiplier,
                'subtotalPrice' => $subtotalPrice,
                'totalItemPrice' => $totalItemPrice,
                'maker' => $maker, // メーカー情報を追加
            ];
        }
    
        $data = [
            'items' => $items,
            'sumPrice' => $sumPrice,
            'keyword' => $keyword,
        ];
    
        // PDF生成とビューにデータを渡す
        $pdf = PDF::loadView('tirecalc.createPdf', $data);
        return $pdf->stream('laravel.pdf');
    }
}


