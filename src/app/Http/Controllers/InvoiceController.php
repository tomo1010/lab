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
        //dd($request->all());

        $request->validate([
            'client' => 'nullable|string|max:255',
            'to_suffix' => 'nullable|string|max:10',
            'postal' => 'nullable|string|max:10',
            'client_address' => 'nullable|string|max:255',

            'item_1' => 'nullable|string|max:255',
            'item_2' => 'nullable|string|max:255',
            'item_3' => 'nullable|string|max:255',
            'item_4' => 'nullable|string|max:255',
            'item_5' => 'nullable|string|max:255',

            'price_1' => 'nullable|integer|min:0',
            'price_2' => 'nullable|integer|min:0',
            'price_3' => 'nullable|integer|min:0',
            'price_4' => 'nullable|integer|min:0',
            'price_5' => 'nullable|integer|min:0',

            'total' => 'nullable|integer|min:0',
            'message' => 'nullable|string|max:500',
        ]);

        $invoice = Invoice::create([
            'user_id' => \Auth::id(),
            'date' => $request->input('date'),
            'page_count' => $request->input('page_count'),
            'client' => $request->input('client'),
            'to_suffix' => $request->input('to_suffix'),
            'client_address' => $request->input('client_address'),
            'item_1' => $request->input('item_1'),
            'item_2' => $request->input('item_2'),
            'item_3' => $request->input('item_3'),
            'item_4' => $request->input('item_4'),
            'item_5' => $request->input('item_5'),
            'price_1' => $request->input('price_1'),
            'price_2' => $request->input('price_2'),
            'price_3' => $request->input('price_3'),
            'price_4' => $request->input('price_4'),
            'price_5' => $request->input('price_5'),
            'total' => $request->input('total'),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('invoice.index')->with('success', '投稿が完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        return view('invoice.edit', compact('invoice', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $newInvoice->client = $invoice->client . "[コピー]";
        $newInvoice->to_suffix = $invoice->to_suffix;
        $newInvoice->client_address = $invoice->client_address;
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
