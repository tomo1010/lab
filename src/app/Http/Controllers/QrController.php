<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'vin'       => 'required|string|max:64',   // 車台番号
            'model'     => 'nullable|string|max:64',   // 型式
            'first_reg' => 'nullable|string|max:7',    // YYYY-MM
            'engine'    => 'nullable|string|max:64',   // 原動機型式
        ]);

        // TODO: 必要ならDB保存（例）
        // Vehicle::create($data);

        return response()->json(['status' => 'ok', 'data' => $data]);
    }
}
