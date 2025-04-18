<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function print()
    {
        $labels = [
            ['name' => '商品A', 'description' => 'これはAの商品です。'],
            ['name' => '商品B', 'description' => 'これはBの商品です。'],
            // 必要なだけ追加
        ];

        return view('label.label', compact('labels'));
    }
}
