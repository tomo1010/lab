<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'page_count',
        'customer_name',
        'to_suffix',
        'customer_address',
        'items',
        'total',
        'message',
    ];

    //$casts は、**「データベースから取り出した値の型を自動的に変換してくれる機能」**
    protected $casts = [
        'items' => 'array',
    ];
}
