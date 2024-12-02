<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;


class PdfController extends Controller
{
    public function viewPdf()
    {
        $data = [
            'name' => 'ララベル',  // PDFに渡したいパラメータ
        ];
        $pdf = PDF::loadView('pdf.document', $data);  // blade名

        return $pdf->stream('laravel.pdf'); //生成されるファイル名
    }
}
