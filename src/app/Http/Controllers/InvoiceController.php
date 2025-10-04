<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



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

        // コピー元の投稿を取得
        $invoice = Invoice::findOrFail($id);

        // 制限件数を超えたら一番古いデータをさ削除
        $limit = $user->limit();
        $count = $user->invoices()->count();

        if ($count >= $limit) {
            $user->invoices()->oldest()->first()?->delete();
        }

        // 認証済みユーザーの投稿として新しいレコードを作成
        $newInvoice = new Invoice();
        $newInvoice->user_id = auth()->id();

        // 
        $newInvoice->customer_name = $invoice->customer_name . "[コピー]";
        $newInvoice->to_suffix = $invoice->to_suffix;
        $newInvoice->customer_address = $invoice->customer_address;
        $newInvoice->date = $invoice->date;
        $newInvoice->page_count = $invoice->page_count;
        $newInvoice->item_1 = $invoice->item_1;
        $newInvoice->item_2 = $invoice->item_2;
        $newInvoice->item_3 = $invoice->item_3;
        $newInvoice->item_4 = $invoice->item_4;
        $newInvoice->item_5 = $invoice->item_5;
        $newInvoice->price_1 = $invoice->price_1;
        $newInvoice->price_2 = $invoice->price_2;
        $newInvoice->price_3 = $invoice->price_3;
        $newInvoice->price_4 = $invoice->price_4;
        $newInvoice->price_5 = $invoice->price_5;
        $newInvoice->total = $invoice->total;
        $newInvoice->message = $invoice->message;

        $newInvoice->save();

        return redirect()->route('invoice.edit', ['invoice' => $newInvoice->id])->with('success', 'コピーしました。');
    }
}
