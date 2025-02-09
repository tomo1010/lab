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
     * 見積もりの作成
     */
    public function store(Request $request)
    {
        \Log::info('投稿処理開始');
    
        // バリデーション
        $request->validate([
            'name' => 'required|max:255',
            'car' => 'required|max:255',
            'price' => 'required|integer',
            'tax' => 'required|integer',
            'total' => 'required|integer',
        ]);
    
        \Log::info('バリデーション通過', $request->all());
    
        // 投稿を保存
        $quote = $request->user()->quotes()->create([
            'name' => $request->name,
            'car' => $request->car,
            'price' => $request->price,
            'tax' => $request->tax,
            'total' => $request->total,
        ]);
    
        \Log::info('投稿データ作成成功');
    

        // PDF作成をリクエストされた場合
        if ($request->input('action') === 'pdf') {
            return redirect()->route('quotes.createPdf', ['id' => $quote->id]);
        }
    
        return redirect()->route('quote.index')->with('success', '投稿が完了しました');
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

        // ログインユーザーの投稿一覧を取得
        $quotes = Quote::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->paginate(10);

        return view('quote.edit', compact('quote', 'quotes'));
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


    /**
     * PDF作成
     */
    public function createPdf(Request $request)
    {
        // フォームから送信されたデータを取得
        $name = $request->input('name');
        $car = $request->input('car');
        $price = $request->input('price');
        $tax = $request->input('tax');
        $total = $request->input('total');
    
        // 現在日時を取得
        $date = now()->format('Y-m-d');
    
        // PDFデータを用意
        $data = [
            'name' => $name,
            'car' => $car,
            'price' => $price,
            'tax' => $tax,
            'total' => $total,
            'date' => $date,
        ];
    
        // Mpdf インスタンス作成
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P' // 縦向き
        ]);
    
        // 1ページ目
        $html1 = view('quote.template.one', $data)->render();
        $mpdf->WriteHTML($html1);
    
        // 2ページ目を追加
        $mpdf->AddPage();
        $html2 = view('quote.template.one', $data)->render();
        $mpdf->WriteHTML($html2);
    
        // 3ページ目を追加
        $mpdf->AddPage();
        $html3 = view('quote.template.one', $data)->render();
        $mpdf->WriteHTML($html3);
    
        // PDFをダウンロード
        return $mpdf->Output("{$date}_{$name}_見積書.pdf", 'D');
    }
    


    

    
    
}
