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
            $table->id(); //A　id
            $table->string('url');    //B 参照URL
            $table->string('maker');    //C メーカー
            $table->string('maker_kana');    //D メーカー英語
            $table->string('name');    //E 車名
            $table->string('release');    //F 発売日
            $table->string('grade');    //G グレード
            $table->string('price');    //H 価格
            $table->string('model');    //I 型式
            $table->string('turningradius');    //J 最小回転半径
            $table->string('drive');    //K 駆動方式
            $table->string('size_length');    //L 全長
            $table->string('size_width');    //M 全幅
            $table->string('size_height');    //N 全高
            $table->string('door');    //O ドア数
            $table->string('wheeelbase');    //P ホイールベース
            $table->string('mission');    //Q ミッション
            $table->string('tred');    //R 前トレッド/後トレッド
            $table->string('shift');    //S AI-SHIFT
            $table->string('indoorsize_length');    //T 室内(全長)
            $table->string('indoorsize_width');    //U 室内(全幅)
            $table->string('indoorsize_height');    //V 室内(全高)
            $table->string('fourws');    //W ４WS
            $table->string('weight');    //X 車両重量
            $table->string('seats');    //Y シート列数
            $table->string('capacity');    //Z 最大積載量
            $table->string('ridingcapacity');    //AA 乗車定員
            $table->string('grossweight');    //AB 車輌総重量
            $table->string('missionposition');    //AC ミッション位置
            $table->string('groundclearance');    //AD 最低地上高
            $table->string('manualmode');    //AE マニュアルモード
            $table->string('colors');    //AF 色数
            $table->string('comment');    //AG 掲載コメント
            $table->string('enginemodel');    //AH エンジン型式
            $table->string('environmentalengine');    //AI 環境対策エンジン
            $table->string('kinds');    //AJ 種類
            $table->string('fuel');    //AK 使用燃料
            $table->string('supercharger');    //AL 過給機
            $table->integer('fueltank');    //AM 燃料タンク
            $table->string('cylinderdevice');    //AN 可変気筒装置
            $table->string('JC08');    //AO 燃費
            $table->string('displacement');    //AP 総排気量
            $table->integer('WLTC');    //AQ 燃費
            $table->string('achievedfuel');    //AR 燃費基準達成
            $table->string('ps');    //AS 最高出力
            $table->string('torque');    //AT 最大トルク
            $table->string('position');    //AU 位置
            $table->string('steeringgear');    //AV ステアリングギア方式
            $table->string('powersteering');    //AW パワーステアリング
            $table->string('VGS');    //AX VGS/VGRS
            $table->string('Fsuspension');    //AY サスペンション形式　前
            $table->string('Rsuspension');    //AZ サスペンション形式　後
            $table->string('Ftiresize');    //BA タイヤサイズ　前
            $table->string('Rtiresize');    //BB タイヤサイズ　後
            $table->string('Fbraketype');    //BC ブレーキ形式　前
            $table->string('Rbraketype');    //BD ブレーキ形式　後
            $table->date('year');    //BE 設定年
            $table->string('half');    //BF 上半期・下半期
            $table->text('minivan_flug')->nullable();    //BG ジャンル・ミニバン
            $table->text('minivan_size')->nullable();    //BH ジャンル・ミニバンサイズ
            $table->text('minivan_slidedoor')->nullable();    //BI ジャンル・ミニバンスライドドア有無
            $table->text('minivan_style')->nullable();    //BJ ジャンル・ミニバン形
            $table->text('minivan_3rd')->nullable();    //BK ジャンル・ミニバン３列目
            $table->text('puchivan_flug')->nullable();    //BL ジャンル・プチバン
            $table->text('puchivan_doorsize')->nullable();    //BM ジャンル・プチバンスライドドア開口部サイズ
            $table->text('pushivan_style')->nullable();    //BN ジャンル・ミニバン形
            $table->text('suv_flug')->nullable();    //BO ジャンル・SUV
            $table->text('suv_size')->nullable();    //BP ジャンル・SUVサイズ
            $table->text('suv_style')->nullable();    //BQ ジャンル・SUV形
            $table->text('compact_flug')->nullable();    //BR ジャンル・コンパクトカー
            $table->text('compact_style')->nullable();    //BS ジャンル・コンパクトカー形
            $table->text('sedan_flug')->nullable();    //BT ジャンル・セダン
            $table->text('sedan_size')->nullable();    //BU ジャンル・セダンサイズ
            $table->text('wagon_flug')->nullable();    //BV ジャンル・ステーションワゴン
            $table->text('wagon_luggage')->nullable();    //BW ジャンル・ステーションワゴン荷室サイズ
            $table->text('courpe_flug')->nullable();    //BX ジャンル・クーペ
            $table->text('courpe_open')->nullable();    //BY ジャンル・オープン有無
            $table->text('kei_flug')->nullable();    //BZ ジャンル・軽
            $table->text('kei_style')->nullable();    //CA ジャンル・軽形
            $table->text('kei_slidedoor')->nullable();    //CB ジャンル・軽スライド有無
            $table->text('kei_truck')->nullable();    //CC ジャンル・軽トラック
            $table->text('ev_flug')->nullable();    //CD ジャンル・電気自動車
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
