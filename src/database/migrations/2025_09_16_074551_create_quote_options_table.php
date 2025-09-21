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
        Schema::create('quote_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();

            $table->enum('option_type', ['dealer', 'maker', 'aftermarket']); // ディーラー/メーカー/社外
            $table->string('name');                // 例: フロアマット、ナビ、ドラレコ 等
            $table->integer('amount')->default(0); 

            // 会計分類（ほとんど課税だと思いますが、将来の拡張を見据えて）
            $table->enum('tax_treatment', ['taxable', 'exempt', 'non_taxable'])->default('taxable');
            $table->decimal('tax_rate', 5, 2)->nullable();

            $table->unsignedInteger('position')->default(0);
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
