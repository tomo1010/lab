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
        // database/migrations/xxxx_xx_xx_create_quotes_table.php
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // お客様情報（そのまま）
            $table->string('name')->nullable();
            $table->string('post')->nullable();
            $table->string('address')->nullable();
            $table->string('tell')->nullable();

            // 車情報（そのまま）
            $table->string('maker')->nullable();
            $table->string('car')->nullable();
            $table->string('grade')->nullable();
            $table->string('displacement')->nullable(); //排気量
            $table->string('transmission')->nullable();
            $table->string('color')->nullable();
            $table->string('drive')->nullable();
            $table->string('model')->nullable();
            $table->string('number')->nullable(); // 車台番号
            $table->string('year')->nullable();
            $table->string('mileage')->nullable();
            $table->string('inspection')->nullable(); // 車検

            // 車輌価格（本体）
            $table->integer('price');           // 車両本体
            $table->integer('discount')->default(0); // 値引き

            // 下取り・支払い条件・メモ（既存を流用）
            $table->string('trade_maker')->nullable();
            $table->string('trade_car')->nullable();
            $table->string('trade_grade')->nullable();
            $table->string('trade_displacement')->nullable(); //排気量
            $table->string('trade_transmission')->nullable();
            $table->string('trade_color')->nullable();
            $table->string('trade_drive')->nullable();
            $table->string('trade_model')->nullable();
            $table->string('trade_number')->nullable(); // 車台番号
            $table->string('trade_year')->nullable();
            $table->string('trade_inspection')->nullable();
            $table->string('trade_mileage')->nullable();
            $table->integer('trade_price')->default(0);  // 下取り価格

            $table->integer('payments')->default(0);    // ローン、リース選択
            $table->integer('first')->default(0);       // ローン初回支払い金額
            $table->integer('second')->default(0);     // ローン2回目以降支払い金額
            $table->integer('bonus')->default(0);   // ボーナス支払い金額
            $table->integer('months')->default(0);      // ローン支払い回数
            $table->integer('residual')->default(0);    // 残価設定額
            $table->integer('cash')->default(0);    // 頭金

            $table->integer('payment')->default(0); // お支払総額
            $table->integer('subtotal')->default(0);    // 諸費用の合計
            $table->integer('total')->default(0);       // 合計

            $table->string('message')->nullable();
            $table->string('memo')->nullable();

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
        Schema::dropIfExists('quotes');
    }
};
