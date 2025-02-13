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
            $table->string('name');
            $table->string('car');
            $table->integer('price');
            $table->integer('tax_1')->default(0); // デフォルト値を 0 に設定
            $table->integer('tax_2')->default(0);
            $table->integer('tax_3')->default(0);
            $table->integer('tax_4')->default(0);
            $table->integer('total');
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
