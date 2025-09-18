<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{

    // app/Models/Quote.php

    protected $fillable = [
        'user_id',
        // お客様情報
        'name',
        'post',
        'address',
        'tell',
        // 車両情報
        'maker',
        'car',
        'grade',
        'displacement',
        'transmission',
        'color',
        'drive',
        'model',
        'number',
        'year',
        'mileage',
        'inspection',
        // 車両価格
        'price',
        'discount',
        // 下取り
        'trade_maker',
        'trade_car',
        'trade_grade',
        'trade_displacement',
        'trade_transmission',
        'trade_color',
        'trade_drive',
        'trade_model',
        'trade_number',
        'trade_year',
        'trade_inspection',
        'trade_mileage',
        'trade_price',
        // 支払い条件
        'payments',
        'first',
        'second',
        'bonus',
        'months',
        'residual',
        'cash',
        // 合計
        'subtotal',
        'total',
        'payment',
        // その他
        'memo',
        'message',
    ];


    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //諸費用
    public function charges()
    {
        return $this->hasMany(QuoteCharge::class);
    }

    //オプション
    public function options()
    {
        return $this->hasMany(QuoteOption::class);
    }

    // スコープ：ユーザごとの絞り込み
    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
