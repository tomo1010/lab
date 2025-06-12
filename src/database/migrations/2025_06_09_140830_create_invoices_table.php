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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('client')->nullable();
            $table->string('to_suffix')->nullable();
            $table->string('client_address')->nullable();
            $table->string('item_1')->nullable();
            $table->string('item_2')->nullable();
            $table->string('item_3')->nullable();
            $table->string('item_4')->nullable();
            $table->string('item_5')->nullable();
            $table->integer('price_1')->nullable();
            $table->integer('price_2')->nullable();
            $table->integer('price_3')->nullable();
            $table->integer('price_4')->nullable();
            $table->integer('price_5')->nullable();
            $table->integer('total')->nullable();
            $table->string('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
