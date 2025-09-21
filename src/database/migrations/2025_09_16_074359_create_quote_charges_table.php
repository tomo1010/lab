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
        Schema::create('quote_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();

            $table->enum('kind', ['tax', 'fee']); // 税金系 or 諸費用系
            $table->string('name');               // 例: 自動車税、重量税、登録費用、車庫証明...
            $table->integer('amount')->default(0);

            // 会計分類: 課税=taxable / 非課税=exempt / 不課税=non_taxable
            $table->enum('tax_treatment', ['taxable', 'exempt', 'non_taxable'])->default('taxable');
            $table->decimal('tax_rate', 5, 2)->nullable(); // 必要なら(10.00など)、不要ならnull運用

            $table->string('account_code')->nullable(); // 仕訳用に使いたい場合
            $table->unsignedInteger('position')->default(0); // 表示順

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
