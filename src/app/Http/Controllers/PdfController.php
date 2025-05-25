<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Services\PdfAccessService;
use Illuminate\Support\Facades\Auth;



//use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf(Request $request, PdfAccessService $accessService)
    {

        // PDFアクセス制限のチェック
        $page = 'pdf'; // ページ識別用。ページごとに変える。

        if (! $accessService->canAccess($page)) {
            return redirect()->back()->with([
                'error' => '上限に達しました。',
                'access_type' => Auth::check()
                    ? (Auth::user()->subscribed() ? null : 'subscribe')
                    : 'register',
            ]);
        }

        $accessService->logAccess($page);


        // PDF生成のためのデータを取得
        $data = $request->except('view');
        $data['date'] = now()->format('Y-m-d');

        $view = $request->input('view');

        if (!view()->exists($view)) {
            abort(404, '指定されたビューが存在しません。');
        }

        $pdf = Pdf::loadView($view, $data);

        // 出力ファイル名はビュー名から自動生成
        $filename = class_basename(str_replace('.', '_', $view)) . '_' . $data['date'] . '.pdf';

        return $pdf->stream($filename);
    }
}
