<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goodby\CSV\Import\Standard\LexerConfig; //csvインポート
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Symfony\Component\HttpFoundation\StreamedResponse; //csv▼ダウンロード

class CsvController extends Controller
{
    



    /*
    （２）entertainer▲アップロード画面
    */
    
    public function uploadEntertainer()
    {
        return view("csv.entertainer");
    }



    // entertainerインポート処理

    public function importEntertainer(Request $request)
    {
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
        $config->setFromCharset("sjis-win");
        $config->setIgnoreHeaderLine(true); //芸人と個人はヘッダーいれないとダメ　NULLでエラー
 
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

            Entertainer::insert([
                'id' => $row[0], //herokuのpostgreSQLでエラーがでるので、idは自動採番
                'office_id' => $row[1],                
                'name' => $row[2], 
                'numberofpeople' => $row[3],
                'gender' => $row[4],
                'alias' => $row[5],
                'active' => $row[6] == '' ? NULL : $row[6],
                'activeend' => $row[7] == '' ? NULL : $row[7],
                'master' => $row[8],
                'oldname' => $row[9],
                'brain' => $row[10],
                'encounter' => $row[11],                
                'named' => $row[12] == '' ? NULL : $row[12],                                
                'memo' => $row[13] == '' ? NULL : $row[13],                                                
                'official' => $row[14] == '' ? NULL : $row[14],
                'twitter' => $row[15] == '' ? NULL : $row[15],
                'youtube' => $row[16] == '' ? NULL : $row[16],
                'tiktok' => $row[17] == '' ? NULL : $row[17],
            ]);
            $count++;
        }
 
        return redirect()->route('csv.importEntertainer')->with('flash_message', $count . '件登録しました！');
    }
    





    //▼ダウンロード
    //芸人

    public function exportEntertainer(Request $request)
    {
        $post = $request->all(); // 本来ならここで、CSV出力のパラメータを受け取り、クエリで絞り込む
        $response = new StreamedResponse(function () use ($request, $post) {
            $stream = fopen('php://output','w');
            // 文字化け回避
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // Entertainerテーブルの全データを取得
            $results = Entertainer::all();
            if (empty($results[0])) {
                    fputcsv($stream, [
                        'データが存在しませんでした。',
                    ]);
            } else {
                foreach ($results as $row) {
                    fputcsv($stream, $this->_csvEntertainer($row));
                }
            }
            fclose($stream);
        });
        $response->headers->set('Content-Type', 'application/octet-stream'); 
        $response->headers->set('content-disposition', 'attachment; filename=芸人.csv');

        return $response;
    }

        /*
        * CSVの１行分のデータ　※本来はコントローラに書かない方が良い
        */
        private function _csvEntertainer($row){
                return [
                    $row->id,
                    $row->office_id,
                    
                    $row->name,
                    $row->numberofpeople,                    
                    $row->gender,
                    $row->ailias,
                    $row->active,
                    $row->activeend,
                    $row->master,
                    $row->oldname,
                    $row->brain,
                    $row->encounter,
                    $row->named,                    
                    $row->memo,                                        
                    $row->official,
                    $row->twitter,                                        
                    $row->youtube,          
                    $row->tiktok,                              
                ];
            }







}
