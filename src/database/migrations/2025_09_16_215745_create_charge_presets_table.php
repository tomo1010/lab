<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charge_presets', function (Blueprint $table) {
            $table->id();

            // 'tax' or 'fee'
            $table->string('kind'); // enumでもOKだがstringで十分
            $table->string('name');

            // 初期金額
            $table->unsignedInteger('default_amount')->default(0);

            // 'taxable' | 'non_taxable' | 'exempt'（今回は使わない想定でも残してOK）
            $table->string('tax_treatment')->nullable();

            // 税率（nullable）
            $table->decimal('tax_rate', 5, 2)->nullable();

            // 表示順
            $table->unsignedSmallInteger('position')->default(0);

            $table->timestamps();

            // 複合ユニーク（kind + name）
            $table->unique(['kind', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charge_presets');
    }
};
