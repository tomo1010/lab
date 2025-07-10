<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tirecalcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // 商品情報
            $table->integer('item1_cost')->nullable();
            $table->integer('item1_quantity')->nullable();
            $table->integer('item2_cost')->nullable();
            $table->integer('item2_quantity')->nullable();
            $table->integer('item3_cost')->nullable();
            $table->integer('item3_quantity')->nullable();

            // 粗利・税
            $table->integer('grossA')->nullable();
            $table->float('grossB')->nullable();
            $table->string('taxMode')->nullable();
            $table->string('laborTaxMode')->nullable();

            // 工賃明細（JSON形式で保存）
            $table->json('laborItems')->nullable();

            // メーカー・サイズなど
            $table->string('maker1')->nullable();
            $table->string('maker2')->nullable();
            $table->string('maker3')->nullable();
            $table->string('selectTire')->nullable();
            $table->string('sizeGeneral')->nullable();
            $table->string('sizeFree')->nullable();

            // 宛名・コメント
            $table->string('customer_name')->nullable();
            $table->string('honorific')->nullable();
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tirecalcs');
    }
};
