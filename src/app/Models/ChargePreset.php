<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargePreset extends Model
{
    protected $fillable = [
        'kind', 'name', 'default_amount', 'tax_treatment', 'tax_rate', 'position',
    ];
    // テーブル名は charge_presets（規約通りなので指定不要）
    // timestamps あり（規約通り）
}
