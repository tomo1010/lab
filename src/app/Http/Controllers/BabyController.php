<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;


class BabyController extends Controller
{

    public function rakuten(Request $request)
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


        //ページ番号をセット
        if(empty($request->page)){
            $page = '1';
        }else{
            $page = $request->page;
        }


        /*ステッカー、マグネット、吸盤のタイプ振り分け*/
        //指定なし
        if(empty($request->type)){

            $response = $client->execute('IchibaItemSearch', array(
                //入力パラメーター
                'keyword' => 'ベイビーインカー ステッカー',
                //'page' => $page,
            ));

            return view('baby.index', [
                'items' => $response,
                //'page' =>  $page,
            ]);

        //ステッカー
        }elseif(($request->type == 'sticker')){

            $response = $client->execute('IchibaItemSearch', array(
                //入力パラメーター
                'keyword' => 'ベイビーインカー ステッカー',
                'NGKeyword' => 'マグネット 吸盤',
                'page' => $page,
            ));

            return view('baby.type', [
                'items' => $response,
                'page' => $page,
                'type' => $request->type,

            ]);

        //マグネット
        }elseif(($request->type == 'magnet')){

            $response = $client->execute('IchibaItemSearch', array(
                //入力パラメーター
                'keyword' => 'ベイビーインカー マグネット',
                'NGKeyword' => 'ステッカー 吸盤',
                'page' => $page,
            ));

            return view('baby.type', [
                'items' => $response,
                'page' => $page,
                'type' => $request->type,

            ]);

        //吸盤
            }elseif(($request->type == 'sucker')){

                $response = $client->execute('IchibaItemSearch', array(
                    //入力パラメーター
                    'keyword' => 'ベイビーインカー 吸盤',
                    'NGKeyword' => 'マグネット',
                    'page' => $page,
                ));

                return view('baby.type', [
                    'items' => $response,
                    'page' => $page,
                    'type' => $request->type,

                ]);

        }else{

            $response = $client->execute('IchibaItemSearch', array(
                //入力パラメーター
                'keyword' => 'ベイビーインカー ステッカー',
                'page' => $page,
            ));

            return view('baby.index', [
                'items' => $response,
                'page' =>  $page,

            ]);
        
        }




        //dd($response['page']);
        
        //// レスポンスが正しいかを isOk() で確認することができます
        //if ($response->isOk()) {
        //$items = array();
        ////配列で結果をぶち込んで行きます
        //foreach ($response as $item){
        //    //画像サイズを変えたかったのでURLを整形します
        //    $str = str_replace("_ex=128x128", "_ex=175x175", $item['mediumImageUrls'][0]['imageUrl']);
        //    $items[] = array(
        //        'itemName' => $item['itemName'],
        //        'itemPrice' => $item['itemPrice'],
        //        'itemUrl' => $item['itemUrl'],
        //        'mediumImageUrls' => $str,
        //        'siteIcon' => "../images/rakuten_logo.png",
        //    );


        //   return view('baby.index', [
        //       'items' => $response,
        //       'page' =>  $page,
        //    //   'items' => $items,
        //   ]);

        //}
        //} else {
        //    echo 'Error:'.$response->getMessage();
        //  }
        //} 


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
            //$str = str_replace("_ex=128x128", "_ex=175x175", $item['mediumImageUrls'][0]['imageUrl']);
            //$items[] = array(
            //    'itemName' => $item['itemName'],
            //    'itemPrice' => $item['itemPrice'],
            //    'itemUrl' => $item['itemUrl'],
            //    'mediumImageUrls' => $str,
            //    'siteIcon' => "../images/rakuten_logo.png",
        //);

            array_push($items, $item);

            dd($items);

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
