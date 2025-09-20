<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;     // ← 追加
use App\Models\ChargePreset;

class ChargePresetSeeder extends Seeder
{
    public function run(): void
    {
        // 税金・保険料（多くは不課税）
        $tax = [
            ['kind' => 'tax', 'name' => '自動車税',     'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null,  'position' => 1],
            ['kind' => 'tax', 'name' => '重量税',       'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null,  'position' => 2],
            ['kind' => 'tax', 'name' => '自賠責保険',   'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null,  'position' => 3],
            ['kind' => 'tax', 'name' => '環境性能割',   'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null,  'position' => 4],
            ['kind' => 'tax', 'name' => 'リサイクル費用', 'default_amount' => 0, 'tax_treatment' => 'non_taxable', 'tax_rate' => null,  'position' => 5],
        ];

        // 販売諸費用（ご希望の2件に変更）
        $fee = [
            ['kind' => 'fee', 'name' => '登録費用',   'default_amount' => 0, 'tax_treatment' => 'taxable', 'tax_rate' => 10.00, 'position' => 1],
            ['kind' => 'fee', 'name' => '希望番号',   'default_amount' => 0, 'tax_treatment' => 'taxable', 'tax_rate' => 10.00, 'position' => 2],
        ];

        // ▼ insert は使わず、まとめて upsert（存在すれば更新・無ければ作成）
        DB::table('charge_presets')->upsert(
            array_merge($tax, $fee),
            // 一意キー（テーブル側でユニーク制約があるとなお良い）
            ['kind', 'name'],
            // 更新対象カラム
            ['default_amount', 'tax_treatment', 'tax_rate', 'position']
        );
    }
}
