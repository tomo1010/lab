<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\User;
use PDF;
use Carbon\Carbon;



class QuoteController extends Controller
{
    /**
     * トップページ
     */
    public function index()
    {
        $quotes = collect(); // デフォルトで空のコレクションを作成
    
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $quotes = $user->quotes()->orderBy('created_at', 'desc')->paginate(10);
        }
    
        return view('quote.index', compact('quotes'));
    }
        


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
;
    }


    /**
     * 投稿の作成
     */
    public function store(Request $request)
    {
        \Log::info('投稿処理開始');
    //dd($request);
        // バリデーション
        $request->validate([
            'name' => 'required|max:255',
            'car' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);
    
        \Log::info('バリデーション通過', [
            'name' => $request->name,
            'car' => $request->car,
            'price' => $request->price,
            'tax' => $request->tax,
            'total' => $request->total
        ]);
    
        // 認証済みユーザ（閲覧者）の投稿として作成
        $request->user()->quotes()->create([
            'name' => $request->name,
            'car' => $request->car,
            'price' => $request->price,
            'tax' => $request->tax,
            'total' => $request->total,
        ]);
    
        \Log::info('投稿データ作成成功');
    
        return back()->with('success', '投稿が完了しました');
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザの投稿一覧を作成日時の降順で取得
        $quotes = $user->quotes()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'quotes' => $quotes,
        ]);
    }


    /**
     * 投稿の編集フォームを表示
     */
    public function edit($id)
    {
        $quote = Quote::findOrFail($id);

        // 投稿の所有者のみ編集可能
        if (\Auth::id() !== $quote->user_id) {
            return redirect()->route('quote.index')->with('error', '不正な操作です');
        }

        return view('quote.edit', compact('quote'));
    }


    /**
     * 投稿の更新
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'car' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'tax' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
        ]);
    
        $quote = Quote::findOrFail($id);
    
        // 投稿の所有者のみ更新可能
        if (\Auth::id() !== $quote->user_id) {
            return redirect()->route('quote.index')->with('error', '不正な操作です');
        }
    
        // 内容を更新
        $quote->update([
            'name' => $request->name,
            'car' => $request->car,
            'price' => $request->price,
            'tax' => $request->tax,
            'total' => $request->total,
        ]);
    
        return redirect()->route('quote.index')->with('success', '投稿を更新しました');
    }
    


    /**
     * 投稿の削除
     */
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は削除
        if (\Auth::id() === $quote->user_id) {
            $quote->delete();
        }

        return back();
    }


    /**
     * 投稿のコピー
     */
    public function storeCopy($id)
    {
        // コピー元の投稿を取得
        $quote = Quote::findOrFail($id);
    
        // 認証済みユーザーの投稿として新しいレコードを作成
        $newQuote = new Quote();
        $newQuote->user_id = auth()->id();
        $newQuote->name = $quote->name;
        $newQuote->car = $quote->car;
        $newQuote->price = $quote->price;
        $newQuote->tax = $quote->tax;
        $newQuote->total = $quote->total;
        $newQuote->save();
    
        return redirect()->route('quote.index')->with('success', '投稿をコピーしました。');
    }


    public function createPdf(Request $request)
    {
        // フォームから送信されたデータを受け取る
        $comment = $request->input('comment');
        $productData = $request->input('productData'); 
        $maker1 = $request->input('maker1');
        $maker2 = $request->input('maker2');
        $maker3 = $request->input('maker3');
        $sizeFree = $request->input('sizeFree');
        $sizeGeneral = $request->input('sizeGeneral');
        $selectTire = $request->input('selectTire');
        $address = $request->input('address');
        $honorific = $request->input('honorific');


        // 現在日時を取得
        $now = Carbon::now();
        // 現在日時を××××-××-××に変換
        $date = $now->format('Y-m-d');


        // 印刷設定をデータに追加
        $data = [
            'products' => $formattedProducts,
            'makers' => [
                'maker1' => $maker1,
                'maker2' => $maker2,
                'maker3' => $maker3,
            ],
            'sizeFree' => $sizeFree,
            'sizeGeneral' => $sizeGeneral,
            'selectTire' => $selectTire,
            'imagePath' => 'file://' . $imagePath, // 画像パスを渡す
            'comment' => $comment,
            'address' => $address,
            'honorific' => $honorific,
            'date' => $date,

        ];
    
        // 動的なPDFファイル名を生成
        $fileName = "{$date}{$address}{$sizeFree}{$sizeGeneral}.pdf";

        // PDF生成とビューにデータを渡す
        $pdf = PDF::loadView('tirecalc.createPdf', $data);
        
        // PDFをダウンロード（ファイル名を指定）
        return $pdf->download($fileName);
    }
    
}
