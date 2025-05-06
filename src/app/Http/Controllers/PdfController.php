<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

//use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $data = $request->except('view');
        $data['date'] = now()->format('Y-m-d');
        //dd($request);
        $view = $request->input('view');
        //dd($view);
        if (!view()->exists($view)) {
            abort(404, '指定されたビューが存在しません。');
        }

        $pdf = Pdf::loadView($view, $data);

        // 出力ファイル名はビュー名から自動生成
        $filename = class_basename(str_replace('.', '_', $view)) . '_' . $data['date'] . '.pdf';

        return $pdf->stream($filename);
    }
}
