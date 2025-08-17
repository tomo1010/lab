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
            // 保存済データ（Eloquentモデル）
            $invoice = Invoice::findOrFail($request->invoice_id);
            $data = ['invoice' => $invoice];
        } else {
            // 未保存データ（仮のオブジェクトにする）
            $invoice = (object) $request->only([
                'company_postal',
                'customer_name',
                'to_suffix',
                'customer_address',
                'message',
                'date',
                'page_count',
                'total',
                'company_registration_number',
                'company_name',
                'company_address',
                'company_tel',
                'company_fax',
                'company_mail',
                'company_url',
                'company_transfer_1',
                'company_transfer_2',
                'company_transfer_3',
                'company_note',
            ]);


            // ✅ 正しいitemsの取り出し方（フォーム構造と一致）
            $items = collect($request->input('items', []))
                ->filter(fn($item) => !empty($item['name']) || !empty($item['price']))
                ->values()
                ->all();

            $invoice->items = $items;
            //dd($invoice->items);
            // ✅ データをBladeに渡す
            $data = ['invoice' => $invoice];
        }


        $data['date'] = now()->format('Y-m-d'); // 出力日を共通で追加

        $pdf = PDF::loadView($view, $data);

        $filename = class_basename(str_replace('.', '_', $view)) . '_' . $data['date'] . '.pdf';

        return $pdf->stream($filename);
        //return $pdf->download($filename);
    }
}
