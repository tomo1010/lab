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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            //ユーザ情報
            $table->string('name')->nullable(); //お客様名
            $table->string('post')->nullable(); //郵便番号
            $table->string('address')->nullable(); //住所
            $table->string('tell')->nullable(); //電話番号
            //購入車種
            $table->string('maker')->nullable(); //メーカー
            $table->string('car')->nullable(); //車名
            $table->string('grade')->nullable(); //グレード
            $table->string('displacement')->nullable(); //排気量
            $table->string('transmission')->nullable(); //ミッション
            $table->string('color')->nullable(); //色
            $table->string('drive')->nullable(); //駆動
            $table->string('model')->nullable(); //型式
            $table->string('number')->nullable(); //車台番号
            $table->string('year')->nullable(); //年式
            $table->string('mileage')->nullable(); //走行距離
            $table->string('inspection')->nullable(); //車検日


            //車輌価格
            $table->integer('price');
            $table->integer('discount')->default(0);


            //税金・保険料など
            $table->integer('tax_1')->default(0); //自動車税
            $table->integer('tax_2')->default(0); //重量税
            $table->integer('tax_3')->default(0); //自賠責保険
            $table->integer('tax_4')->default(0); //環境性能割
            $table->integer('tax_5')->default(0); //リサイクル費用
            $table->integer('tax_6')->default(0); //延長保証
            $table->integer('tax_7')->default(0);
            $table->integer('tax_8')->default(0);
            $table->integer('tax_9')->default(0);
            $table->integer('tax_10')->default(0);
            $table->integer('tax_total')->default(0);
            //販売諸費用
            $table->integer('overhead_1')->default(0); //登録費用
            $table->integer('overhead_2')->default(0); //車庫証明
            $table->integer('overhead_3')->default(0); //リサイクル資金管理
            $table->integer('overhead_4')->default(0); //納車費用
            $table->integer('overhead_5')->default(0); //下取り車手続き代行費用
            $table->integer('overhead_6')->default(0); //下取り車査定料
            $table->integer('overhead_7')->default(0); //希望番号
            $table->integer('overhead_8')->default(0); //燃料代
            $table->integer('overhead_9')->default(0);
            $table->integer('overhead_10')->default(0);
            $table->integer('overhead_11')->default(0);
            $table->integer('overhead_12')->default(0);
            $table->integer('overhead_13')->default(0);
            $table->integer('overhead_14')->default(0);
            $table->integer('overhead_15')->default(0);
            $table->integer('overhead_total')->default(0);
            //諸費用名称
            $table->string('overheadName_11')->nullable();
            $table->string('overheadName_12')->nullable();
            $table->string('overheadName_13')->nullable();
            $table->string('overheadName_14')->nullable();
            $table->string('overheadName_15')->nullable();
            //非課税　諸費用
            $table->integer('exempt_1')->default(0); //車庫証明証紙
            $table->integer('exempt_2')->default(0); //検査登録届出
            $table->integer('exempt_3')->default(0); //下取り車登録手続き費用
            $table->integer('exempt_4')->default(0);
            $table->integer('exempt_5')->default(0);
            $table->integer('exempt_total')->default(0);


            //オプション
            $table->integer('option_1')->default(0);
            $table->integer('option_2')->default(0);
            $table->integer('option_3')->default(0);
            $table->integer('option_4')->default(0);
            $table->integer('option_5')->default(0);
            $table->integer('option_6')->default(0);
            $table->integer('option_7')->default(0);
            $table->integer('option_8')->default(0);
            $table->integer('option_9')->default(0);
            $table->integer('option_10')->default(0);
            $table->integer('option_11')->default(0);
            $table->integer('option_12')->default(0);
            $table->integer('option_13')->default(0);
            $table->integer('option_14')->default(0);
            $table->integer('option_15')->default(0);
            $table->integer('option_16')->default(0);
            $table->integer('option_17')->default(0);
            $table->integer('option_18')->default(0);
            $table->integer('option_19')->default(0);
            $table->integer('option_20')->default(0);
            $table->integer('option_total')->default(0);
            //オプション名称
            $table->string('optionName_1')->nullable();
            $table->string('optionName_2')->nullable();
            $table->string('optionName_3')->nullable();
            $table->string('optionName_4')->nullable();
            $table->string('optionName_5')->nullable();
            $table->string('optionName_6')->nullable();
            $table->string('optionName_7')->nullable();
            $table->string('optionName_8')->nullable();
            $table->string('optionName_9')->nullable();
            $table->string('optionName_10')->nullable();
            $table->string('optionName_11')->nullable();
            $table->string('optionName_12')->nullable();
            $table->string('optionName_13')->nullable();
            $table->string('optionName_14')->nullable();
            $table->string('optionName_15')->nullable();
            $table->string('optionName_16')->nullable();
            $table->string('optionName_17')->nullable();
            $table->string('optionName_18')->nullable();
            $table->string('optionName_19')->nullable();
            $table->string('optionName_20')->nullable();


            //合計
            $table->integer('subtotal')->default(0);
            $table->integer('total')->default(0);


            //下取り
            $table->string('trade_maker')->nullable(); //メーカー
            $table->string('trade_car')->nullable(); //車名
            $table->string('trade_grade')->nullable(); //下取りグレード
            $table->string('trade_displacement')->nullable(); //排気量
            $table->string('trade_transmission')->nullable(); //ミッション
            $table->string('trade_color')->nullable(); //色
            $table->string('trade_drive')->nullable(); //駆動
            $table->string('trade_model')->nullable(); //型式
            $table->string('trade_number')->nullable(); //車台番号
            $table->string('trade_year')->nullable(); //年式
            $table->string('trade_inspection')->nullable(); //車検
            $table->string('trade_mileage')->nullable(); //走行距離
            $table->integer('trade_price')->default(0);
            //支払い条件
            $table->integer('payments')->default(0); //支払い回数
            $table->integer('first')->default(0); //初回
            $table->integer('second')->default(0); //2回目以降
            $table->integer('bonus')->default(0); //ボーナス払い
            $table->integer('months')->default(0); //月数
            $table->integer('residual')->default(0); //残価設定
            $table->integer('cash')->default(0); //頭金


            $table->integer('payment')->default(0); //最終支払い総額


            //メモ
            $table->string('memo')->nullable(); //メモ

            $table->timestamps();
            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
