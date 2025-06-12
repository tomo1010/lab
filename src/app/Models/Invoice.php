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
        'client',
        'to_suffix',
        'client_address',
        'item_1',
        'item_2',
        'item_3',
        'item_4',
        'item_5',
        'price_1',
        'price_2',
        'price_3',
        'price_4',
        'price_5',
        'total',
        'message',
    ];
}
