<?php

namespace Database\Seeders;

// database/seeders/ChargePresetSeeder.php
use Illuminate\Database\Seeder;
use App\Models\ChargePreset;

class ChargePresetSeeder extends Seeder
{
    public function run(): void
    {
        // 税金・保険料など（多くは不課税）
        ChargePreset::insert([
            ['kind' => 'tax', 'name' => '自動車税',   'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null, 'position' => 1],
            ['kind' => 'tax', 'name' => '重量税',     'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null, 'position' => 2],
            ['kind' => 'tax', 'name' => '自賠責保険', 'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null, 'position' => 3],
            ['kind' => 'tax', 'name' => '環境性能割', 'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null, 'position' => 4],
            ['kind' => 'tax', 'name' => 'リサイクル費用', 'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null, 'position' => 5],
        ]);

        // 販売諸費用（課税が多いが、証紙は非課税）
        ChargePreset::insert([
            ['kind' => 'fee', 'name' => '登録費用',         'default_amount' => 0, 'tax_treatment' => 'taxable',   'tax_rate' => 10.00, 'position' => 1],
            ['kind' => 'fee', 'name' => '車庫証明手続代行', 'default_amount' => 0, 'tax_treatment' => 'taxable',   'tax_rate' => 10.00, 'position' => 2],
            ['kind' => 'fee', 'name' => '車庫証明 証紙代',  'default_amount' => 0, 'tax_treatment' => 'exempt',    'tax_rate' => null,  'position' => 3],
            ['kind' => 'fee', 'name' => '納車費用',         'default_amount' => 0, 'tax_treatment' => 'taxable',   'tax_rate' => 10.00, 'position' => 4],
            ['kind' => 'fee', 'name' => '希望番号',         'default_amount' => 0, 'tax_treatment' => 'taxable',   'tax_rate' => 10.00, 'position' => 5],
        ]);

        DB::table('charge_presets')->upsert(
            array_merge($tax, $fee),
            ['kind', 'name'],                 // 一意キー
            ['default_amount', 'position']    // 更新対象
        );
    }
}
