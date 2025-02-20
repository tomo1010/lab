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
            $table->string('inspection')->nullable(); //車検日
            $table->string('mileage')->nullable(); //走行距離

            //車輌価格
            $table->integer('price');
            $table->integer('discount');

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

            //税金・保険料
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
            //諸費用
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
            //非課税　諸費用
            $table->integer('exempt_1')->default(0); //車庫証明証紙
            $table->integer('exempt_2')->default(0); //検査登録届出
            $table->integer('exempt_3')->default(0); //下取り車登録手続き費用
            $table->integer('exempt_4')->default(0);
            $table->integer('exempt_5')->default(0);
            $table->integer('exempt_total')->default(0);
            //合計
            $table->integer('subtotal');
            $table->integer('total');

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
            $table->integer('trade_price')->nullable();
            
            //支払い条件
            $table->integer('payments')->nullable(); //支払い回数
            $table->integer('first')->nullable(); //初回
            $table->integer('second')->nullable(); //2回目以降
            $table->integer('bonus')->nullable(); //ボーナス払い
            $table->integer('months')->nullable(); //月数
            $table->integer('residual')->nullable(); //残価設定
            $table->integer('cash')->nullable(); //頭金
            
            //メモ
            $table->string('memmo')->nullable(); //メモ

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
