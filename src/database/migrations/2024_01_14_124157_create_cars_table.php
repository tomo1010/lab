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
            $table->date('release');    //F 発売日
            $table->string('grade')->nullable();    //G グレード
            $table->integer('price');    //H 価格
            $table->string('model');    //I 型式
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
            $table->integer('colors')->nullable();    //AF 色数
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
            $table->string('Fsuspension')->nullable();    //AY サスペンション形式　前
            $table->string('Rsuspension')->nullable();    //AZ サスペンション形式　後
            $table->string('Ftiresize')->nullable();    //BA タイヤサイズ　前
            $table->string('Rtiresize')->nullable();    //BB タイヤサイズ　後
            $table->string('Fbraketype')->nullable();    //BC ブレーキ形式　前
            $table->string('Rbraketype')->nullable();    //BD ブレーキ形式　後
            $table->date('year')->nullable();    //BE 設定年
            $table->string('half')->nullable();    //BF 上半期・下半期
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
