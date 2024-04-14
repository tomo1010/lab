<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;


class BabyController extends Controller
{

    public function rakuten()
    {
        //return view('baby.index', [
        //]);


        //楽天APIを扱うRakutenRws_Clientクラスのインスタンスを作成します
        $client = new RakutenRws_Client();

        //定数化
        define("RAKUTEN_APPLICATION_ID"     , config('app.rakuten_id'));
        define("RAKUTEN_APPLICATION_SEACRET", config('app.rakuten_key'));

        //アプリIDをセット！
        $client->setApplicationId(RAKUTEN_APPLICATION_ID);

        //リクエストから検索キーワードを取り出し
        $keyword = '生茶';

        // IchibaItemSearch API から、指定条件で検索
        if(!empty($keyword)){ 
        $response = $client->execute('IchibaItemSearch', array(
            //入力パラメーター
            'keyword' => $keyword,
        ));
        // レスポンスが正しいかを isOk() で確認することができます
        if ($response->isOk()) {
        $items = array();
        //配列で結果をぶち込んで行きます
        foreach ($response as $item){
            //画像サイズを変えたかったのでURLを整形します
            $str = str_replace("_ex=128x128", "_ex=175x175", $item['mediumImageUrls'][0]['imageUrl']);
            $items[] = array(
                'itemName' => $item['itemName'],
                'itemPrice' => $item['itemPrice'],
                'itemUrl' => $item['itemUrl'],
                'mediumImageUrls' => $str,
                'siteIcon' => "../images/rakuten_logo.png",
            );
           // dd($items[0]->itemName);
           return view('baby.index', [
               'items' => $items,
           ]);
        }
        } else {
            echo 'Error:'.$response->getMessage();
          }
        } 


    }


    public function get_rakuten_items(Request $request)
    {
        //楽天APIを扱うRakutenRws_Clientクラスのインスタンスを作成します
        $client = new RakutenRws_Client();

        //定数化
        define("RAKUTEN_APPLICATION_ID"     , config('app.rakuten_id'));
        define("RAKUTEN_APPLICATION_SEACRET", config('app.rakuten_key'));

        //アプリIDをセット！
        $client->setApplicationId(RAKUTEN_APPLICATION_ID);

        //リクエストから検索キーワードを取り出し
        $keyword = $request->input('keyword');

        // IchibaItemSearch API から、指定条件で検索
        if(!empty($keyword)){ 
        $response = $client->execute('IchibaItemSearch', array(
            //入力パラメーター
            'keyword' => $keyword,
        ));
        // レスポンスが正しいかを isOk() で確認することができます
        if ($response->isOk()) {
        $items = array();
        //配列で結果をぶち込んで行きます
        foreach ($response as $item){
            //画像サイズを変えたかったのでURLを整形します
            $str = str_replace("_ex=128x128", "_ex=175x175", $item['mediumImageUrls'][0]['imageUrl']);
            $items[] = array(
                'itemName' => $item['itemName'],
                'itemPrice' => $item['itemPrice'],
                'itemUrl' => $item['itemUrl'],
                'mediumImageUrls' => $str,
                'siteIcon' => "../images/rakuten_logo.png",
            );
           // dd($items[0]->itemName);
           return view('baby.show', [
               'items' => $items,
           ]);
        }
        } else {
            echo 'Error:'.$response->getMessage();
          }
        } 
   }




}
