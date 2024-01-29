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
            $table->id();
            $table->string('maker');    // メーカー
            $table->string('name');    // 車名
            $table->string('release');    // 発売日
            $table->string('grade');    // グレード
            $table->string('price');    // 価格
            $table->string('model');    // 型式
            $table->string('turningradius');    // 最小回転半径
            $table->string('drive');    // 駆動方式
            $table->string('size');    // 全長×全幅×全高
            $table->string('doors');    // ドア数
            $table->string('wheeelbase');    // ホイールベース
            $table->string('mission');    // ミッション
            $table->string('tred');    // 前トレッド/後トレッド
            $table->string('shift');    // AI-SHIFT
            $table->string('indoorsize');    // 室内(全長×全幅×全高)
            $table->string('4WS');    // ４WS
            $table->string('weight');    // 車両重量
            $table->string('seats');    // シート列数
            $table->string('capacity');    // 積載量
            $table->string('ridingcapacity');    // 乗車定員
            $table->string('grossweight');    // 総重量
            $table->string('missionposition');    // ミッション位置
            $table->string('groundclearance');    // 最低地上高
            $table->string('colors');    // 色数
            $table->string('comment');    // 掲載コメント
            $table->string('enginemodel');    // エンジン型式
            $table->string('environmentalengine');    // 環境対策エンジン
            $table->string('kinds');    // 種類
            $table->string('fuel');    // 使用燃料
            $table->string('supercharger');    // 過給機
            $table->string('fueltank');    // 燃料タンク
            $table->string('cylinderdevice');    // 可変気筒装置
            $table->string('JC08');    // 燃費
            $table->string('displacement');    // 総排気量
            $table->string('WLTC');    // 燃費
            $table->string('achievedfuel');    // 燃費基準達成
            $table->string('ps');    // 最高出力
            $table->string('torque');    // 最大トルク
            $table->string('position');    // 位置
            $table->string('steeringgear');    // ステアリングギア方式
            $table->string('powersteering');    // パワーステアリング
            $table->string('VGS');    // VGS/VGRS
            $table->string('Fsuspension');    // サスペンション形式　前
            $table->string('Rsuspension');    // サスペンション形式　後
            $table->string('Fttiresize');    // タイヤサイズ　前
            $table->string('Rtiresize');    // タイヤサイズ　後
            $table->string('Fbraketype');    // ブレーキ形式　前
            $table->string('Rbraketype');    // ブレーキ形式　後
            $table->string('year');    // 設定年（○年aは上半期、○年bは下半期）
            $table->string('genre');    // ジャンル

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
