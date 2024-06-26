<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();   //A　id
            $table->string('maker');    //B メーカー
            $table->string('name');    //C 車名
            $table->date('release');    //D 発売日
            $table->string('grade')->nullable();    //E グレード
            $table->integer('price')->nullable();    //F 価格
            $table->string('url');    //G URL
            $table->string('maker_kana');    //H メーカー英語
            $table->string('model')->nullable();    //I 型式
            $table->float('turningradius')->nullable();    //J 最小回転半径
            $table->string('drive')->nullable();    //K 駆動方式
            $table->float('size_length')->nullable();    //L 全長
            $table->float('size_width')->nullable();    //M 全幅
            $table->float('size_height')->nullable();    //N 全高
            $table->integer('door')->nullable();    //O ドア数
            $table->float('wheelbase')->nullable();    //P ホイールベース
            $table->string('mission')->nullable();    //Q ミッション
            $table->string('tred')->nullable();    //R 前トレッド/後トレッド
            $table->string('shift')->nullable();    //S AI-SHIFT
            $table->float('indoorsize_length')->nullable();    //T 室内(全長)
            $table->float('indoorsize_width')->nullable();    //U 室内(全幅)
            $table->float('indoorsize_height')->nullable();    //V 室内(全高)
            $table->string('fourws')->nullable();    //W ４WS
            $table->integer('weight')->nullable();    //X 車両重量
            $table->integer('seats')->nullable();    //Y シート列数
            $table->integer('capacity')->nullable();    //Z 最大積載量
            $table->integer('ridingcapacity')->nullable();    //AA 乗車定員
            $table->integer('grossweight')->nullable();    //AB 車輌総重量
            $table->string('missionposition')->nullable();    //AC ミッション位置
            $table->float('groundclearance')->nullable();    //AD 最低地上高
            $table->string('manualmode')->nullable();    //AE マニュアルモード
            $table->integer('color')->nullable();    //AF 色数
            $table->string('comment')->nullable();    //AG 掲載コメント
            $table->string('enginemodel')->nullable();    //AH エンジン型式
            $table->string('environmentalengine')->nullable();    //AI 環境対策エンジン
            $table->string('kinds')->nullable();    //AJ 種類
            $table->string('fuel')->nullable();    //AK 使用燃料
            $table->string('supercharger')->nullable();    //AL 過給機
            $table->integer('fueltank')->nullable();    //AM 燃料タンク
            $table->string('cylinderdevice')->nullable();    //AN 可変気筒装置
            $table->float('JC08')->nullable();    //AO 燃費
            $table->integer('displacement')->nullable();    //AP 総排気量
            $table->float('WLTC')->nullable();    //AQ 燃費
            $table->string('achievedfuel')->nullable();    //AR 燃費基準達成
            $table->integer('ps')->nullable();    //AS 最高出力
            $table->string('torque')->nullable();    //AT 最大トルク
            $table->string('position')->nullable();    //AU 位置
            $table->string('steeringgear')->nullable();    //AV ステアリングギア方式
            $table->string('powersteering')->nullable();    //AW パワーステアリング
            $table->string('VGS')->nullable();    //AX VGS/VGRS
            $table->string('suspension_front')->nullable();    //AY サスペンション形式　前
            $table->string('suspension_rear')->nullable();    //AZ サスペンション形式　後
            $table->string('tiresize_front')->nullable();    //BA タイヤサイズ　前
            $table->string('tiresize_rear')->nullable();    //BB タイヤサイズ　後
            $table->string('raketype_front')->nullable();    //BC ブレーキ形式　前
            $table->string('braketype_rear')->nullable();    //BD ブレーキ形式　後
            
            /*
            毎回追加
            */
            $table->string('year')->nullable();    //BE 設定年
            $table->string('half')->nullable();    //BF 上半期・下半期

            /*
            ジャンル別
            */
            //ミニバン
            $table->text('minivan_flug')->nullable();    //BE ジャンル・ミニバン
            $table->text('minivan_style')->nullable();    //BJ ジャンル・ミニバン形
            $table->text('minivan_3rd')->nullable();    //BK ジャンル・ミニバン３列目
            //プチバン
            $table->text('puchivan_flug')->nullable();    //BL ジャンル・プチバン
            $table->integer('puchivan_doorsize')->nullable();    //BM ジャンル・プチバンスライドドア開口部サイズ
            //SUV
            $table->text('suv_flug')->nullable();    //BO ジャンル・SUV
            $table->text('suv_style')->nullable();    //BQ ジャンル・SUV形
            //ハッチバック
            $table->text('hatchback_flug')->nullable();    //BR ジャンル・ハッチバック
            //セダン
            $table->text('sedan_flug')->nullable();    //BT ジャンル・セダン
            //ステーションワゴン
            $table->text('wagon_flug')->nullable();    //BV ジャンル・ステーションワゴン
            $table->integer('wagon_luggage')->nullable();    //BW ジャンル・ステーションワゴン荷室サイズ
            //スポーツ
            $table->text('sports_flug')->nullable();    //BX ジャンル・クーペ
            //軽
            $table->text('kei_flug')->nullable();    //BZ ジャンル・軽
            $table->text('kei_style')->nullable();    //CA ジャンル・軽形

            /*
            その他
            */
            $table->text('japan_flug')->nullable();    //国産
            $table->text('import_flug')->nullable();    //主要輸入車
            $table->text('slidedoor_flug')->nullable();    //スライドドア有無
            $table->text('open_flug')->nullable();    //オープン有無
            $table->text('mt_flug')->nullable();    //MT設定有無
            $table->text('van_flug')->nullable();    //バン
            $table->text('truck_flug')->nullable();    //トラック
            $table->text('diesel_flug')->nullable();    //ディーゼル
            $table->text('hev_flug')->nullable();    //HEV
            $table->text('ev_flug')->nullable();    //EV
            $table->text('oem_flug')->nullable();    //OEM
            $table->text('suv3rd_flug')->nullable();    //３列シートSUV
            $table->text('headlight_flug')->nullable();    //丸ヘッドライト

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
