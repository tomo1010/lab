<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = collect(); // デフォルトで空のコレクションを作成

        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $invoices = $user->invoices()->orderBy('updated_at', 'desc')->paginate(10);
        }

        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'nullable|string|max:255',
            'to_suffix'        => 'nullable|string|max:10',
            'postal'           => 'nullable|string|max:10',
            'customer_address' => 'nullable|string|max:255',

            'items'            => 'array',
            'items.*.name'     => 'nullable|string|max:255',
            // ▼ マイナス許可：min:0 を外す
            'items.*.price'    => 'nullable|numeric',

            // ▼ total は hidden を信用しないので検証しない（再計算する）
            // 'total'          => 'nullable|integer|min:0',

            'message'          => 'nullable|string|max:500',
            'date'             => 'nullable|date',
            'page_count'       => 'nullable|integer|min:1|max:10',
        ]);

        // items 正規化（0 や 負数 を落とさない）
        $items = collect($validated['items'] ?? [])
            ->map(function ($item) {
                return [
                    'name'  => $item['name']  ?? '',
                    'price' => isset($item['price']) ? (float)$item['price'] : null,
                ];
            })
            // 名前 or 金額が存在する行だけ残す（0 は残す。null/'' は除外）
            ->filter(function ($item) {
                $hasName  = $item['name'] !== '';
                $hasPrice = $item['price'] !== null && $item['price'] !== '';
                return $hasName || $hasPrice;
            })
            ->values();

        // 合計はサーバで再計算（必要に応じて丸め方を変更）
        $serverTotal = $items->sum(fn($it) => (float)$it['price']);

        // 合計をマイナス不可にしたい場合はチェック（許可するならこの if を削除）
        if ($serverTotal < 0) {
            return back()
                ->withErrors(['items' => '合計がマイナスになっています。'])
                ->withInput();
        }

        // 円整数で保存する場合
        $serverTotal = (int) round($serverTotal);

        $invoice = Invoice::create([
            'user_id'          => auth()->id(),
            'date'             => $validated['date'] ?? null,
            'page_count'       => $validated['page_count'] ?? null,
            'customer_name'    => $validated['customer_name'] ?? null,
            'to_suffix'        => $validated['to_suffix'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'items'            => $items->all(),
            'total'            => $serverTotal, // クライアント送信の total は使わない
            'message'          => $validated['message'] ?? null,
        ]);

        return redirect()->route('invoice.index')->with('success', '投稿が完了しました');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\Invoice $invoice)
    {
        return view('invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        //dd($invoice);  
        // 投稿の所有者のみ編集可能
        if (\Auth::id() !== $invoice->user_id) {
            return redirect()->route('invoice.index')->with('error', '不正な操作です');
        }

        // ログインユーザーの投稿一覧を取得
        $invoices = Invoice::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->paginate(10);

        return view('invoice.edit', [
            'invoice' => $invoice,
            'invoices' => $invoices,
            'items' => $invoice->items ?? [],
        ]);

        //return view('invoice.edit', compact('invoice', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'date'             => 'nullable|date',
            'page_count'       => 'nullable|integer|min:1|max:10',
            'customer_name'    => 'nullable|string|max:255',
            'to_suffix'        => 'nullable|string|max:10',
            'customer_address' => 'nullable|string|max:255',
            'message'          => 'nullable|string|max:500',

            'items'            => 'array',
            'items.*.name'     => 'nullable|string|max:255',
            'items.*.price'    => 'nullable|numeric',

        ]);

        $items = collect($validated['items'] ?? [])
            ->map(function ($item) {
                return [
                    'name'  => $item['name']  ?? '',
                    'price' => isset($item['price']) ? (float)$item['price'] : null,
                ];
            })

            ->filter(function ($item) {
                $hasName  = $item['name'] !== '';
                $hasPrice = $item['price'] !== null && $item['price'] !== '';
                return $hasName || $hasPrice;
            })
            ->values();

        // 合計はサーバで再計算（小数対応 → 円に丸めたい場合は round()）
        $serverTotal = $items->sum(fn($it) => (float)$it['price']);

        // もし「合計はマイナス不可」にしたい場合はチェックを入れる（不要なら削除）
        if ($serverTotal < 0) {
            return back()
                ->withErrors(['items' => '合計がマイナスになっています。'])
                ->withInput();
        }

        // 円で保存したいなら整数に丸める（必要なければ小数のまま numeric カラムに）
        $serverTotal = (int) round($serverTotal);

        $invoice->update([
            'date'             => $validated['date'] ?? null,
            'page_count'       => $validated['page_count'] ?? null,
            'customer_name'    => $validated['customer_name'] ?? null,
            'to_suffix'        => $validated['to_suffix'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'message'          => $validated['message'] ?? null,
            'items'            => $items->all(),
            'total'            => $serverTotal, // クライアント値は使わない
        ]);

        return redirect()
            ->route('invoice.edit', $invoice)
            ->with('success', '保存しました');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は削除
        if (\Auth::id() === $invoice->user_id) {
            $invoice->delete();
        }

        return redirect()->route('invoice.index')->with('success', '投稿を削除しました');
    }


    /**
     * 投稿のコピー
     */
public function storeCopy($id)
{
    $user = Auth::user();
    if (! $user) {
        abort(403, 'ログインが必要です');
    }

    // コピー元
    $invoice = Invoice::findOrFail($id);

    // もし「自分の請求書しかコピー不可」にしたい場合は有効化
    // if ($invoice->user_id !== $user->id) {
    //     abort(403, 'この請求書をコピーする権限がありません');
    // }

    $newInvoice = null;

    DB::transaction(function () use ($user, $invoice, &$newInvoice) {
        // 制限：超えていたら最古を削除（自分の請求書のみ）
        $limit = $user->limit();
        $count = $user->invoices()->count();
        if ($count >= $limit) {
            $user->invoices()->oldest()->first()?->delete();
        }

        // items を正規化（名前か金額がある行のみ、0やマイナスは保持）
        $items = collect($invoice->items ?? [])
            ->map(function ($it) {
                return [
                    'name'  => (string)($it['name'] ?? ''),
                    'price' => isset($it['price']) ? (float)$it['price'] : null,
                ];
            })
            ->filter(function ($it) {
                $hasName  = $it['name'] !== '';
                $hasPrice = $it['price'] !== null && $it['price'] !== '';
                return $hasName || $hasPrice;
            })
            ->values();

        // 合計をサーバ側で再計算（円で保存する場合は丸める。小数で保存したいなら round() を外し、カラム型を decimal に）
        $serverTotal = (int) round($items->sum(fn ($it) => (float)$it['price']));

        // 新規作成（所有者はログインユーザ）
        $newInvoice = $user->invoices()->create([
            'date'             => $invoice->date,
            'page_count'       => $invoice->page_count,
            'customer_name'    => trim(($invoice->customer_name ?? '') . ' [コピー]'),
            'to_suffix'        => $invoice->to_suffix,
            'customer_address' => $invoice->customer_address,
            'items'            => $items->all(),
            'total'            => $serverTotal,
            'message'          => $invoice->message,
        ]);
    });

    return redirect()
        ->route('invoice.edit', ['invoice' => $newInvoice->id])
        ->with('success', 'コピーしました。');
}

}
