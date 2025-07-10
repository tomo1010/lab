<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Tirecalc extends Model
{
    protected $fillable = [
        'user_id',
        'item1_cost',
        'item1_quantity',
        'item2_cost',
        'item2_quantity',
        'item3_cost',
        'item3_quantity',
        'grossA',
        'grossB',
        'taxMode',
        'laborTaxMode',
        'laborItems',
        'maker1',
        'maker2',
        'maker3',
        'selectTire',
        'sizeGeneral',
        'sizeFree',
        'customer_name',
        'honorific',
        'comment',
    ];

    protected $casts = [
        'laborItems' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
