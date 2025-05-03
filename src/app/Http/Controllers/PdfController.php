<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

//use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function constructionPdf(Request $request)
    {
        //dd($request);
        $data = $request->all();
        $data['date'] = now()->format('Y-m-d');

        $pdf = Pdf::loadView('pdf.constructionPdf', $data);

        return $pdf->stream('construction_' . $data['date'] . '.pdf');
    }
}
