<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use RakutenRws_Client;
use Zaico\Domain\RakutenItem\RakutenItem;
use PDF;
use App\Models\Tirecalc;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\PdfAccessService;




class TirecalcController extends Controller
{
    public function index(Request $request)
    {
        // test用コメント //

        $comment = $request->input('comment'); // $comment を受け取る

        // Rakuten APIクライアントのセットアップ
        $client = new RakutenRws_Client();
        $client->setApplicationId(config('app.rakuten_id'));
        $client->setAffiliateId(config('app.rakuten_aff'));

        // 選択されたアイテムコードを取得
        $itemCodes = $request->input('itemCodes', []);

        // アイテムの詳細を格納する配列
        $items = [];

        // 各アイテムコードごとに詳細を取得
        foreach ($itemCodes as $code) {
            $response = $client->execute('IchibaItemSearch', [
                'itemCode' => $code,
            ]);

            if ($response->isOk()) {
                foreach ($response as $item) {
                    $items[] = [
                        'itemCode' => $item['itemCode'],
                        'itemName' => $item['itemName'],
                        'itemPrice' => $item['itemPrice'],
                    ];
                }
            }
        }

        $tirecalcs = collect(); // デフォルトで空のコレクションを作成

        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tirecalcs = $user->tirecalcs()->orderBy('updated_at', 'desc')->paginate(10);
        }

        // アイテム情報をビューに渡す
        return view('tirecalc.index', [
            'items' => $items,
            'comment' => $comment,
            'tirecalcs' => $tirecalcs,
        ]);
    }



    public function createPdf(Request $request, PdfAccessService $accessService)
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


        $items = [];
        //dd($request);
        foreach ([1, 2, 3] as $i) {
            $cost = $request->input("item{$i}_cost");
            $quantity = $request->input("item{$i}_quantity");

            // cost が null または空ならスキップ
            if (is_null($cost) || $cost === '') {
                continue;
            }

            $items[] = [
                'label' => "商品{$i}",
                'cost' => $cost,
                'quantity' => $quantity,
            ];
        }

        // price が null/空文字/0 のものを除外
        $laborItemsRaw = $request->input('laborItems', []);
        $laborItems = collect($laborItemsRaw)->filter(function ($item) {
            $price = $item['price'] ?? null;
            return !is_null($price) && $price !== '' && $price != 0;
        })->values()->all();
        //dd($laborItems);

        $data = [
            'items' => $items,
            'grossA' => $request->grossA,
            'grossB' => $request->grossB,
            'taxMode' => $request->taxMode,
            'laborTaxMode' => $request->laborTaxMode,
            'laborItems' => $laborItems,
            'date' => now()->format('Y-m-d'),

            // PDF印刷・コピー設定
            'maker1' => $request->input('maker1'),
            'maker2' => $request->input('maker2'),
            'maker3' => $request->input('maker3'),
            'customer_name' => $request->input('customer_name'),
            'honorific' => $request->input('honorific'),
            'selectTire' => $request->input('selectTire'),
            'sizeGeneral' => $request->input('sizeGeneral'),
            'sizeFree' => $request->input('sizeFree'),
            'comment' => $request->input('comment'),

            //会社情報
            'company_postal' => $request->input('company_postal'),
            'company_address' => $request->input('company_address'),
            'company_name' => $request->input('company_name'),
            'company_tel' => $request->input('company_tel'),
            'company_fax' => $request->input('company_fax'),
            'company_email' => $request->input('company_mail'),
            'company_url' => $request->input('company_url'),
            'company_registration_number' => $request->input('company_registration_number'),
            'company_transfer_1' => $request->input('company_transfer_1'),
            'company_transfer_2' => $request->input('company_transfer_2'),
            'company_transfer_3' => $request->input('company_transfer_3'),
            'company_note' => $request->input('company_note'),

        ];
        //dd($data);
        $fileName = "{$data['date']}.pdf";

        $pdf = PDF::loadView('tirecalc.createPdf', $data);

        return $pdf->stream($fileName);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'item1_cost' => 'nullable|integer',
            'item1_quantity' => 'nullable|integer',
            'item2_cost' => 'nullable|integer',
            'item2_quantity' => 'nullable|integer',
            'item3_cost' => 'nullable|integer',
            'item3_quantity' => 'nullable|integer',
            'grossA' => 'nullable|integer',
            'grossB' => 'nullable|numeric',
            'taxMode' => 'nullable|string',
            'laborTaxMode' => 'nullable|string',
            'laborItems' => 'nullable|array',
            'maker1' => 'nullable|string',
            'maker2' => 'nullable|string',
            'maker3' => 'nullable|string',
            'selectTire' => 'nullable|string',
            'sizeGeneral' => 'nullable|string',
            'sizeFree' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'honorific' => 'nullable|string',
            'comment' => 'nullable|string',
            'memo' => 'nullable|string',
        ]);
        //dd($validated);
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        $tirecalc = Tirecalc::create($validated);

        return redirect()->route('tirecalc.edit', $tirecalc)->with('success', '保存しました');
    }


    public function destroy($id)
    {
        $tirecalc = Tirecalc::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は削除
        if (\Auth::id() === $tirecalc->user_id) {
            $tirecalc->delete();
        }

        return redirect()->route('tirecalc.index')->with('success', '投稿を削除しました');
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
        $tirecalc = Tirecalc::findOrFail($id);

        // 制限件数を超えたら一番古いデータをさ削除
        $limit = $user->limit();
        $count = $user->tirecalcs()->count();

        if ($count >= $limit) {
            $user->tirecalcs()->oldest()->first()?->delete();
        }

        // 認証済みユーザーの投稿として新しいレコードを作成
        $newTirecalc = new Tirecalc();
        $newTirecalc->user_id = auth()->id();

        // タイヤ計算のデータをコピー
        $newTirecalc->item1_cost = $tirecalc->item1_cost;
        $newTirecalc->item1_quantity = $tirecalc->item1_quantity;
        $newTirecalc->item2_cost = $tirecalc->item2_cost;
        $newTirecalc->item2_quantity = $tirecalc->item2_quantity;
        $newTirecalc->item3_cost = $tirecalc->item3_cost;
        $newTirecalc->item3_quantity = $tirecalc->item3_quantity;
        $newTirecalc->grossA = $tirecalc->grossA;
        $newTirecalc->grossB = $tirecalc->grossB;
        $newTirecalc->taxMode = $tirecalc->taxMode;
        $newTirecalc->laborTaxMode = $tirecalc->laborTaxMode;
        $newTirecalc->laborItems = $tirecalc->laborItems;
        // PDF印刷・コピー設定
        $newTirecalc->maker1 = $tirecalc->maker1;
        $newTirecalc->maker2 = $tirecalc->maker2;
        $newTirecalc->maker3 = $tirecalc->maker3;
        $newTirecalc->selectTire = $tirecalc->selectTire;
        $newTirecalc->sizeGeneral = $tirecalc->sizeGeneral;
        $newTirecalc->sizeFree = $tirecalc->sizeFree;
        $newTirecalc->customer_name = $tirecalc->customer_name . "[コピー]";
        $newTirecalc->honorific = $tirecalc->honorific;
        $newTirecalc->comment = $tirecalc->comment;
        $newTirecalc->memo = $tirecalc->memo;

        $newTirecalc->save();

        return redirect()->route('tirecalc.edit', ['tirecalc' => $newTirecalc->id])->with('success', '見積もりをコピーしました。');
    }


    public function edit($id)
    {
        $tirecalc = Tirecalc::findOrFail($id);
        //dd($tirecalc);  
        // 投稿の所有者のみ編集可能
        if (\Auth::id() !== $tirecalc->user_id) {
            return redirect()->route('tirecalc.index')->with('error', '不正な操作です');
        }

        // ログインユーザーの投稿一覧を取得
        $tirecalcs = Tirecalc::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->paginate(10);

        return view('tirecalc.edit', [
            'tirecalc' => $tirecalc,
            'tirecalcs' => $tirecalcs,
            'items' => $tirecalc->items ?? [],
        ]);
    }


    public function update(Request $request, Tirecalc $tirecalc)
    {
        $validated = $request->validate([
            'item1_cost' => 'nullable|integer',
            'item1_quantity' => 'nullable|integer',
            'item2_cost' => 'nullable|integer',
            'item2_quantity' => 'nullable|integer',
            'item3_cost' => 'nullable|integer',
            'item3_quantity' => 'nullable|integer',
            'grossA' => 'nullable|integer',
            'grossB' => 'nullable|numeric',
            'taxMode' => 'nullable|string',
            'laborTaxMode' => 'nullable|string',
            'laborItems' => 'nullable|array',
            //PDF印刷・コピー設定
            'maker1' => 'nullable|string',
            'maker2' => 'nullable|string',
            'maker3' => 'nullable|string',
            'selectTire' => 'nullable|string',
            'sizeGeneral' => 'nullable|string',
            'sizeFree' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'honorific' => 'nullable|string',
            'comment' => 'nullable|string',
            'memo' => 'nullable|string',
        ]);

        $filteredItems = collect($validated['laborItems'] ?? [])
            ->filter(fn($item) => !empty($item['name']) || !empty($item['price']))
            ->values()
            ->all();

        $tirecalc->update([
            'item1_cost' => $validated['item1_cost'],
            'item1_quantity' => $validated['item1_quantity'],
            'item2_cost' => $validated['item2_cost'],
            'item2_quantity' => $validated['item2_quantity'],
            'item3_cost' => $validated['item3_cost'],
            'item3_quantity' => $validated['item3_quantity'],
            'grossA' => $validated['grossA'],
            'grossB' => $validated['grossB'],
            'taxMode' => $validated['taxMode'],
            'laborTaxMode' => $validated['laborTaxMode'],
            'laborItems' => $filteredItems,
            // PDF印刷・コピー設定
            'maker1' => $validated['maker1'],
            'maker2' => $validated['maker2'],
            'maker3' => $validated['maker3'],
            'selectTire' => $validated['selectTire'],
            'sizeGeneral' => $validated['sizeGeneral'],
            'sizeFree' => $validated['sizeFree'],
            'customer_name' => $validated['customer_name'],
            'honorific' => $validated['honorific'],
            'comment' => $validated['comment'],
            'memo' => $validated['memo'],

        ]);

        return redirect()->route('tirecalc.edit', $tirecalc)->with('success', '保存しました');
    }
}
