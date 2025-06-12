<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Services\PdfAccessService;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice; // ← 請求書モデル追加（他も必要なら都度追加）

class PdfController extends Controller
{
    public function generatePdf(Request $request, PdfAccessService $accessService)
    {
        $view = $request->input('view');
        $page = $view;

        // アクセス制限のチェック
        if (! $accessService->canAccess($page)) {
            return redirect()->back()->with([
                'error' => '上限に達しました。',
                'access_type' => Auth::check()
                    ? (Auth::user()->subscribed() ? null : 'subscribe')
                    : 'register',
            ]);
        }

        $accessService->logAccess($page);

        // 表示ビューの存在チェック
        if (!view()->exists($view)) {
            abort(404, '指定されたビューが存在しません。');
        }

        // データ取得（今は請求書のみ、将来はif分岐など追加可）
        if ($request->has('invoice_id')) {
            $invoice = Invoice::findOrFail($request->invoice_id);
            $data = ['invoice' => $invoice];
        } else {
            // フォールバック（旧仕様互換 or エラーハンドリング）
            $data = $request->except('view');
        }

        $data['date'] = now()->format('Y-m-d'); // 出力日を共通で追加

        $pdf = PDF::loadView($view, $data);

        $filename = class_basename(str_replace('.', '_', $view)) . '_' . $data['date'] . '.pdf';

        return $pdf->stream($filename);
    }
}
