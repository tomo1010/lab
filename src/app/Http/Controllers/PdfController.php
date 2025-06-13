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

        // アクセス制限
        if (! $accessService->canAccess($page)) {
            return redirect()->back()->with([
                'error' => '上限に達しました。',
                'access_type' => Auth::check()
                    ? (Auth::user()->subscribed() ? null : 'subscribe')
                    : 'register',
            ]);
        }

        $accessService->logAccess($page);

        // ビューが存在しない場合は404
        if (!view()->exists($view)) {
            abort(404, '指定されたビューが存在しません。');
        }

        // データ取得：保存済か未保存かを分岐（未保存の場合_idが取得できない）
        if ($request->filled('invoice_id')) {
            $invoice = Invoice::findOrFail($request->invoice_id);
            $data = ['invoice' => $invoice];
        } else {
            // 未保存の入力データを使って、仮のオブジェクトを構築
            $invoice = (object) $request->only([
                'postal',
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
                'message',
                'date',
                'page_count',
                'total',
                'invoice_number',
                'name',
                'address',
                'tel',
                'fax',
                'mail',
                'url',
                'transfar_1',
                'transfar_2',
                'transfar_3',
            ]);

            // price_x が未定義なら 0 に補完
            foreach (range(1, 5) as $i) {
                $invoice->{'price_' . $i} = (int) ($invoice->{'price_' . $i} ?? 0);
            }

            $data = ['invoice' => $invoice];
        }

        $data['date'] = now()->format('Y-m-d'); // 出力日を共通で追加

        $pdf = PDF::loadView($view, $data);

        $filename = class_basename(str_replace('.', '_', $view)) . '_' . $data['date'] . '.pdf';

        return $pdf->stream($filename);
    }
}
