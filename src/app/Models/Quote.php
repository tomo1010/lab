<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    
    protected $fillable = [
        'user_id','name', 'post', 'address', 'tell',
        'car', 'grade', 'displacement', 'transmission', 'color', 'drive', 'year', 'mileage', 'inspection',
        'price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5', 'tax_total',
        'overhead_1', 'overhead_2', 'overhead_11', 'overhead_total',
        'overheadName_11',
        'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 'option_total',
        'optionName_1', 'optionName_2', 'optionName_3', 'optionName_4', 'optionName_5',
        'total', 'trade_price', 'discount', 'payment',
        'memo',
    ];
    
    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
