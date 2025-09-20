<?php

// app/Models/QuoteCharge.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteCharge extends Model
{
    protected $fillable = [
        'quote_id','kind','name','amount','tax_treatment','tax_rate','position',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}

