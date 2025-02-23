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

    }


    /**
     * 見積もりの保存
     */
    public function store(Request $request)
    {
        \Log::info('投稿処理開始');
//dd($request->user());

//dd($request->user()->quotes()->get()); // 全レコード取得
        // バリデーション
        $request->validate([
            'name' => 'required|max:255',
            'post' => 'nullable|max:10',
            'address' => 'nullable|max:255',
            'tell' => 'nullable|max:20',
            'car' => 'required|max:255',
            'grade' => 'nullable|max:255',
            'displacement' => 'nullable|max:255',
            'transmission' => 'nullable|max:255',
            'color' => 'nullable|max:255',
            'drive' => 'nullable|max:255',
            'year' => 'nullable|max:255',
            'mileage' => 'nullable|max:255',
            'inspection' => 'nullable|max:255',
            'price' => 'required|integer',
            'tax_1' => 'required|integer',
            'tax_2' => 'required|integer',
            'tax_3' => 'required|integer',
            'tax_4' => 'required|integer',
            'tax_5' => 'nullable|integer',
            'tax_total' => 'required|integer',
            'overhead_1' => 'nullable|integer',
            'overhead_2' => 'nullable|integer',
            'overhead_total' => 'nullable|integer',
            'option_1' => 'nullable|integer',
            'option_2' => 'nullable|integer',
            'option_3' => 'nullable|integer',
            'option_4' => 'nullable|integer',
            'option_5' => 'nullable|integer',
            'option_total' => 'nullable|integer',
            'total' => 'required|integer',
            'trade_price' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'payment' => 'required|integer',
        ]);
    
        \Log::info('バリデーション通過', $request->all());

dd($request->user()->quotes());

        // 投稿を保存
        $request->user()->quotes()->create([
            //'user_id' => $request->user()->id, // 追加

            // ユーザー情報
            'name' => $request->name,
            'post' => $request->post,
            'address' => $request->address,
            'tell' => $request->tell,

            // 車両情報
            'car' => $request->car,
            'grade' => $request->grade,
            'displacement' => $request->displacement,
            'transmission' => $request->transmission,
            'color' => $request->color,
            'drive' => $request->drive,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'inspection' => $request->inspection,

            // 車両価格
            'price' => $request->price,
            'discount' => $request->discount,

            // オプション
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
            'option_5' => $request->option_5,
            'option_total' => $request->option_total,

            // 税金・保険料
            'tax_1' => $request->tax_1,
            'tax_2' => $request->tax_2,
            'tax_3' => $request->tax_3,
            'tax_4' => $request->tax_4,
            'tax_5' => $request->tax_5,
            'tax_total' => $request->tax_total,

            // 諸費用
            'overhead_1' => $request->overhead_1,
            'overhead_2' => $request->overhead_2,
            'overhead_total' => $request->overhead_total,

            // 支払い総額
            'total' => $request->total,
            'trade_price' => $request->trade_price,
            'payment' => $request->payment,
        ]);


        \Log::info('投稿データ作成成功');
    
        //// PDF作成をリクエストされた場合
        //if ($request->input('action') === 'pdf') {
        //    return redirect()->route('quotes.createPdf', ['id' => $quote->id]);
        //}
    
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
            'tax_1' => 'required|integer|min:0',
            'tax_2' => 'required|integer|min:0',
            'tax_3' => 'required|integer|min:0',
            'tax_4' => 'required|integer|min:0',
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
            'tax_1' => $request->tax_1,
            'tax_2' => $request->tax_2,
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
        $newQuote->tax_1 = $quote->tax_1;
        $newQuote->tax_2 = $quote->tax_2;
        $newQuote->tax_3 = $quote->tax_3;
        $newQuote->tax_4 = $quote->tax_4;
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
        $data = $request->only([
            'name', 'post', 'address', 'tell',
            'car', 'grade', 'displacement', 'transmission', 'color', 'drive', 'year', 'mileage', 'inspection',
            'price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5',
            'tax_total', 'overhead_1', 'overhead_2', 'overhead_total',
            'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 'option_total',
            'total', 'trade_price', 'discount', 'payment'
        ]);
    
        // 現在日時を取得
        $data['date'] = now()->format('Y-m-d');
    
        // Mpdf インスタンス作成
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'ja+aCJK', // 日本語フォント組み込み
            'format' => 'A4',
            'orientation' => 'P', // 縦向き
            'default_font' => 'ipag' // 日本語フォントを指定
        ]);
    
        // 1ページ目
        $html1 = view('quote.template.one', $data)->render();
        $mpdf->WriteHTML($html1);
    
        //// 2ページ目を追加
        //$mpdf->AddPage();
        //$html2 = view('quote.template.two', $data)->render();
        //$mpdf->WriteHTML($html2);
    
        //// 3ページ目を追加
        //$mpdf->AddPage();
        //$html3 = view('quote.template.three', $data)->render();
        //$mpdf->WriteHTML($html3);
    
        // PDFをダウンロード
        return $mpdf->Output("{$data['date']}_{$data['name']}_見積書.pdf", 'D');
    }


    


    

    
    
}
