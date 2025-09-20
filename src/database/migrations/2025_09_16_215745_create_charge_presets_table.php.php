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
        Schema::create('charge_presets', function (Blueprint $table) {
            $table->id();
            $table->unique('kind', ['tax', 'fee']); // 税金/諸費用
            $table->string('name');
            $table->integer('default_amount')->default(0);
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
        Schema::table('charge_presets', function (Blueprint $table) {
            $table->dropUnique(['charge_presets_kind_name_unique']);
        });
    }
};
