<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goodby\CSV\Import\Standard\LexerConfig; //csvインポート
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Symfony\Component\HttpFoundation\StreamedResponse; //csv▼ダウンロード

use App\Models\Car;


class CsvController extends Controller
{
    
    //アップロード画面
    
    public function uploadCar()
    {
        return view("car.csv.uploadCar");
    }



    //インポート処理

    public function importCar(Request $request)
    {
        //dd($request);
        
        // CSV ファイル保存
        $tmpName = mt_rand().".".$request->file('csv')->guessExtension(); //TMPファイル名
        $request->file('csv')->move(public_path()."/csv/tmp",$tmpName);
        $tmpPath = public_path()."/csv/tmp/".$tmpName;
 
        //Goodby CSVのconfig設定
        $config = new LexerConfig();
        $interpreter = new Interpreter();
        $interpreter->unstrict(); //追加　厳密な列数のチェック回避
        $lexer = new Lexer($config);
 
        //CharsetをUTF-8に変換、CSVのヘッダー行を無視
        $config->setToCharset("UTF-8");
        //$config->setFromCharset("sjis-win");
        $config->setFromCharset("UTF-8");
        $config->setIgnoreHeaderLine(true);
 
        $dataList = [];
     
        // 新規Observerとして、$dataList配列に値を代入
        $interpreter->addObserver(function (array $row) use (&$dataList){
            // 各列のデータを取得
            $dataList[] = $row;
        });
 
        // CSVデータをパース
        $lexer->parse($tmpPath, $interpreter);
 
        // TMPファイル削除
        unlink($tmpPath);
 
        // 登録処理
        $count = 0;
        
        foreach($dataList as $row){

            Car::insert([
                'id' => $row[0],   //A　id
                'maker' => $row[1],    //B メーカー
                'name' =>$row[2],    //C 車名
                'release' => $row[3],    //D 発売日
                'grade' => $row[4],    //E グレード
                'price' => $row[5],    //F 価格
                'url' => $row[6],    //G URL
                'maker_kana' => $row[7],    //H メーカー英語
                'model' => $row[8],    //I 型式
                'turningradius' => $row[9] == '' ? NULL : $row[9],    //J 最小回転半径
                'drive' => $row[10] == '' ? NULL : $row[10],    //K 駆動方式
                'size_length' => $row[11] == '' ? NULL : $row[11],    //L 全長
                'size_width' => $row[12] == '' ? NULL : $row[12],    //M 全幅
                'size_height' => $row[13] == '' ? NULL : $row[13],    //N 全高
                'door' => $row[14] == '' ? NULL : $row[14],    //O ドア数
                'wheelbase' => $row[15] == '' ? NULL : $row[15],    //P ホイールベース
                'mission' => $row[16] == '' ? NULL : $row[16],    //Q ミッション
                'tred' => $row[17] == '' ? NULL : $row[17],    //R 前トレッド/後トレッド
                'shift' => $row[18] == '' ? NULL : $row[18],    //S AI-SHIFT
                'indoorsize_length' => $row[19] == '' ? NULL : $row[19],    //T 室内(全長)
                'indoorsize_width' => $row[20] == '' ? NULL : $row[20],    //U 室内(全幅)
                'indoorsize_height' => $row[21] == '' ? NULL : $row[21],    //V 室内(全高)
                'fourws' => $row[22] == '' ? NULL : $row[22],    //W ４WS
                'weight' => $row[23] == '' ? NULL : $row[23],    //X 車両重量
                'seats' => $row[24] == '' ? NULL : $row[24],    //Y シート列数
                'capacity' => $row[25] == '' ? NULL : $row[25],    //Z 最大積載量
                'ridingcapacity' => $row[26] == '' ? NULL : $row[26],    //AA 乗車定員
                'grossweight' => $row[27] == '' ? NULL : $row[27],    //AB 車輌総重量
                'missionposition' => $row[28] == '' ? NULL : $row[28],    //AC ミッション位置
                'groundclearance' => $row[29] == '' ? NULL : $row[29],    //AD 最低地上高
                'manualmode' => $row[30] == '' ? NULL : $row[30],    //AE マニュアルモード
                'color' => $row[31] == '' ? NULL : $row[31],    //AF 色数
                'comment' => $row[32] == '' ? NULL : $row[32],    //AG 掲載コメント
                'enginemodel' => $row[33] == '' ? NULL : $row[33],    //AH エンジン型式
                'environmentalengine' => $row[34] == '' ? NULL : $row[34],    //AI 環境対策エンジン
                'kinds' => $row[35] == '' ? NULL : $row[35],    //AJ 種類
                'fuel' => $row[36] == '' ? NULL : $row[36],    //AK 使用燃料
                'supercharger' => $row[37] == '' ? NULL : $row[37],    //AL 過給機
                'fueltank' => $row[38] == '' ? NULL : $row[38],    //AM 燃料タンク
                'cylinderdevice' => $row[39] == '' ? NULL : $row[39],    //AN 可変気筒装置
                'JC08' => $row[40] == '' ? NULL : $row[40],    //AO 燃費
                'displacement' => $row[41] == '' ? NULL : $row[41],    //AP 総排気量
                'WLTC' => $row[42] == '' ? NULL : $row[42],    //AQ 燃費
                'achievedfuel' => $row[43] == '' ? NULL : $row[43],    //AR 燃費基準達成
                'ps' => $row[44] == '' ? NULL : $row[44],    //AS 最高出力
                'torque' => $row[45] == '' ? NULL : $row[45],    //AT 最大トルク
                'position' => $row[46] == '' ? NULL : $row[46],    //AU 位置
                'steeringgear' => $row[47] == '' ? NULL : $row[47],    //AV ステアリングギア方式
                'powersteering' => $row[48] == '' ? NULL : $row[48],    //AW パワーステアリング
                'VGS' => $row[49] == '' ? NULL : $row[49],    //AX VGS/VGRS
                'suspension_front' => $row[50] == '' ? NULL : $row[50],    //AY サスペンション形式　前
                'suspension_rear' => $row[51] == '' ? NULL : $row[51],    //AZ サスペンション形式　後
                'tiresize_front' => $row[52] == '' ? NULL : $row[52],    //BA タイヤサイズ　前
                'tiresize_rear' => $row[53] == '' ? NULL : $row[53],    //BB タイヤサイズ　後
                'raketype_front' => $row[54] == '' ? NULL : $row[54],    //BC ブレーキ形式　前
                'braketype_rear' => $row[55] == '' ? NULL : $row[55],    //BD ブレーキ形式　後
                /*
                毎回追加
                */
                'year' => $row[56] == '' ? NULL : $row[56],    //BE 設定年
                'half' => $row[57] == '' ? NULL : $row[57],    //BF 上半期・下半期
                /*
                ジャンル別
                */
                //ミニバン
                'minivan_flug' => $row[58] == '' ? NULL : $row[58],    //BE ジャンル・ミニバン
                'minivan_style' => $row[59] == '' ? NULL : $row[59],    //BJ ジャンル・ミニバン形
                'minivan_3rd' => $row[60] == '' ? NULL : $row[60],    //BK ジャンル・ミニバン３列目
                //プチバン
                'puchivan_flug' => $row[61] == '' ? NULL : $row[61],    //BL ジャンル・プチバン
                'puchivan_doorsize' => $row[62] == '' ? NULL : $row[62],    //BM ジャンル・プチバンスライドドア開口部サイズ
                //SUV
                'suv_flug' => $row[63] == '' ? NULL : $row[63],    //BO ジャンル・SUV
                'suv_style' => $row[64] == '' ? NULL : $row[64],    //BQ ジャンル・SUV形
                //ハッチバック
                'hatchback_flug' => $row[65] == '' ? NULL : $row[65],    //BR ジャンル・ハッチバック
                //セダン
                'sedan_flug' => $row[66] == '' ? NULL : $row[66],    //BT ジャンル・セダン
                //ステーションワゴン
                'wagon_flug' => $row[67] == '' ? NULL : $row[67],    //BV ジャンル・ステーションワゴン
                'wagon_luggage' => $row[68] == '' ? NULL : $row[68],    //BW ジャンル・ステーションワゴン荷室サイズ
                //スポーツ
                'sports_flug' => $row[69] == '' ? NULL : $row[69],    //BX ジャンル・クーペ
                //軽
                'kei_flug' => $row[70] == '' ? NULL : $row[70],    //BZ ジャンル・軽
                'kei_style' => $row[71] == '' ? NULL : $row[71],    //CA ジャンル・軽形

                /*
                その他
                */
                'japan_flug' => $row[72] == '' ? NULL : $row[72],    //国産
                'import_flug' => $row[73] == '' ? NULL : $row[73],    //主要輸入車
                'slidedoor_flug' => $row[74] == '' ? NULL : $row[74],    //スライドドア有無
                'open_flug' => $row[75] == '' ? NULL : $row[75],    //オープン有無
                'mt_flug' => $row[76] == '' ? NULL : $row[76],    //MT設定有無
                'van_flug' => $row[77] == '' ? NULL : $row[77],    //バン
                'truck_flug' => $row[78] == '' ? NULL : $row[78],    //トラック
                'diesel_flug' => $row[79] == '' ? NULL : $row[79],    //ディーゼル
                'hev_flug' => $row[80] == '' ? NULL : $row[80],    //HEV
                'ev_flug' => $row[81] == '' ? NULL : $row[81],    //EV
                'oem_flug' => $row[82] == '' ? NULL : $row[82],    //OEM
                'suv3rd_flug' => $row[83] == '' ? NULL : $row[83],    //３列シートSUV
                'headlight_flug' => $row[84] == '' ? NULL : $row[84],    //丸ヘッドライト
    
            ]);
            $count++;
        }
 
        return redirect()->route('car.csv.uploadCar')->with('flash_message', $count . '件登録しました！');
    }
    





    //ダウンロード処理

    public function exportCar(Request $request)
    {
        $post = $request->all(); // 本来ならここで、CSV出力のパラメータを受け取り、クエリで絞り込む
        $response = new StreamedResponse(function () use ($request, $post) {
            $stream = fopen('php://output','w');
            // 文字化け回避
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // Carテーブルの全データを取得
            $results = Car::all();
            if (empty($results[0])) {
                    fputcsv($stream, [
                        'データが存在しませんでした。',
                    ]);
            } else {
                foreach ($results as $row) {
                    fputcsv($stream, $this->_csvCar($row));
                }
            }
            fclose($stream);
        });
        $response->headers->set('Content-Type', 'application/octet-stream'); 
        $response->headers->set('content-disposition', 'attachment; filename=車データ.csv');

        return $response;
    }

        /*
        * CSVの１行分のデータ　※本来はコントローラに書かない方が良い
        */
        private function _csvCar($row){
                return [
                    'id' => $row[0],   //A　id
                    'maker' => $row[1],    //B メーカー
                    'name' =>$row[2],    //C 車名
                    'release' => $row[3],    //D 発売日
                    'grade' => $row[4],    //E グレード
                    'price' => $row[5],    //F 価格
                    'url' => $row[6],    //G URL
                    'maker_kana' => $row[7],    //H メーカー英語
                    'model' => $row[8],    //I 型式
                    'turningradius' => $row[9],    //J 最小回転半径
                    'drive' => $row[10],    //K 駆動方式
                    'size_length' => $row[11],    //L 全長
                    'size_width' => $row[12],    //M 全幅
                    'size_height' => $row[13],    //N 全高
                    'door' => $row[14],    //O ドア数
                    'wheelbase' => $row[15],    //P ホイールベース
                    'mission' => $row[16],    //Q ミッション
                    'tred' => $row[17],    //R 前トレッド/後トレッド
                    'shift' => $row[18],    //S AI-SHIFT
                    'indoorsize_length' => $row[19],    //T 室内(全長)
                    'indoorsize_width' => $row[20],    //U 室内(全幅)
                    'indoorsize_height' => $row[21],    //V 室内(全高)
                    'fourws' => $row[22],    //W ４WS
                    'weight' => $row[23],    //X 車両重量
                    'seats' => $row[24],    //Y シート列数
                    'capacity' => $row[25],    //Z 最大積載量
                    'ridingcapacity' => $row[26],    //AA 乗車定員
                    'grossweight' => $row[27],    //AB 車輌総重量
                    'missionposition' => $row[28],    //AC ミッション位置
                    'groundclearance' => $row[29],    //AD 最低地上高
                    'manualmode' => $row[30],    //AE マニュアルモード
                    'color' => $row[31],    //AF 色数
                    'comment' => $row[32],    //AG 掲載コメント
                    'enginemodel' => $row[33],    //AH エンジン型式
                    'environmentalengine' => $row[34],    //AI 環境対策エンジン
                    'kinds' => $row[35],    //AJ 種類
                    'fuel' => $row[36],    //AK 使用燃料
                    'supercharger' => $row[37],    //AL 過給機
                    'fueltank' => $row[38],    //AM 燃料タンク
                    'cylinderdevice' => $row[39],    //AN 可変気筒装置
                    'JC08' => $row[40],    //AO 燃費
                    'displacement' => $row[41],    //AP 総排気量
                    'WLTC' => $row[42],    //AQ 燃費
                    'achievedfuel' => $row[43],    //AR 燃費基準達成
                    'ps' => $row[44],    //AS 最高出力
                    'torque' => $row[45],    //AT 最大トルク
                    'position' => $row[46],    //AU 位置
                    'steeringgear' => $row[47],    //AV ステアリングギア方式
                    'powersteering' => $row[48],    //AW パワーステアリング
                    'VGS' => $row[49],    //AX VGS/VGRS
                    'suspension_front' => $row[50],    //AY サスペンション形式　前
                    'suspension_rear' => $row[51],    //AZ サスペンション形式　後
                    'tiresize_front' => $row[52],    //BA タイヤサイズ　前
                    'tiresize_rear' => $row[53],    //BB タイヤサイズ　後
                    'raketype_front' => $row[54],    //BC ブレーキ形式　前
                    'braketype_rear' => $row[55],    //BD ブレーキ形式　後
                    
                    /*
                    毎回追加
                    */
                    'year' => $row[56],    //BE 設定年
                    'half' => $row[57],    //BF 上半期・下半期
        
                    /*
                    ジャンル別
                    */
                    //ミニバン
                    'minivan_flug' => $row[58],    //BE ジャンル・ミニバン
                    'minivan_style' => $row[59],    //BJ ジャンル・ミニバン形
                    'minivan_3rd' => $row[60],    //BK ジャンル・ミニバン３列目
                    //プチバン
                    'puchivan_flug' => $row[61],    //BL ジャンル・プチバン
                    'puchivan_doorsize' => $row[62],    //BM ジャンル・プチバンスライドドア開口部サイズ
                    //SUV
                    'suv_flug' => $row[63],    //BO ジャンル・SUV
                    'suv_style' => $row[64],    //BQ ジャンル・SUV形
                    //ハッチバック
                    'hatchback_flug' => $row[65],    //BR ジャンル・ハッチバック
                    //セダン
                    'sedan_flug' => $row[66],    //BT ジャンル・セダン
                    //ステーションワゴン
                    'wagon_flug' => $row[67],    //BV ジャンル・ステーションワゴン
                    'wagon_luggage' => $row[68],    //BW ジャンル・ステーションワゴン荷室サイズ
                    //スポーツ
                    'sports_flug' => $row[69],    //BX ジャンル・クーペ
                    //軽
                    'kei_flug' => $row[70],    //BZ ジャンル・軽
                    'kei_style' => $row[71],    //CA ジャンル・軽形
        
                    /*
                    その他
                    */
                    'japan_flug' => $row[72],    //国産
                    'import_flug' => $row[73],    //主要輸入車
                    'slidedoor_flug' => $row[74],    //スライドドア有無
                    'open_flug' => $row[75],    //オープン有無
                    'mt_flug' => $row[76],    //MT設定有無
                    'van_flug' => $row[77],    //バン
                    'truck_flug' => $row[78],    //トラック
                    'diesel_flug' => $row[79],    //ディーゼル
                    'hev_flug' => $row[80],    //HEV
                    'ev_flug' => $row[81],    //EV
                    'oem_flug' => $row[82],    //OEM
                    'suv3rd_flug' => $row[83],    //３列シートSUV
                    'headlight_flug' => $row[84],    //丸ヘッドライト
                ];
            }







}
