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

        // バリデーション
        $request->validate([
            'car' => 'nullable|max:255',
            'grade' => 'nullable|max:255',
            'displacement' => 'nullable|max:255',
            'transmission' => 'nullable|max:255',
            'color' => 'nullable|max:255',
            'drive' => 'nullable|max:255',
            'year' => 'nullable|max:255',
            'mileage' => 'nullable|max:255',
            'inspection' => 'nullable|max:255',
            'price' => 'required|integer',
            'tax_1' => 'nullable|integer',
            'tax_2' => 'nullable|integer',
            'tax_3' => 'nullable|integer',
            'tax_4' => 'nullable|integer',
            'tax_5' => 'nullable|integer',
            'tax_total' => 'nullable|integer',
            'overhead_1' => 'nullable|integer',
            'overhead_2' => 'nullable|integer',
            'overhead_total' => 'nullable|integer',
            'optionName_1' => 'nullable|max:255',
            'optionName_2' => 'nullable|max:255',
            'optionName_3' => 'nullable|max:255',
            'optionName_4' => 'nullable|max:255',
            'optionName_5' => 'nullable|max:255',
            'option_1' => 'nullable|integer',
            'option_2' => 'nullable|integer',
            'option_3' => 'nullable|integer',
            'option_4' => 'nullable|integer',
            'option_5' => 'nullable|integer',
            'option_total' => 'nullable|integer',
            'total' => 'nullable|integer',
            'trade_price' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'payment' => 'nullable|integer',
        ]);
    
//dd($request->optionName_1);
        // 投稿を保存
        $request->user()->quotes()->create([
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
            
            // オプション
            // オプションの名前
            'optionName_1' => $request->optionName_1,
            'optionName_2' => $request->optionName_2,
            'optionName_3' => $request->optionName_3,
            'optionName_4' => $request->optionName_4,
            'optionName_5' => $request->optionName_5,
            // オプションの価格
            'option_1' => $request->input('option_1') ?? '0',
            'option_2' => $request->input('option_2') ?? '0',
            'option_3' => $request->input('option_3') ?? '0',
            'option_4' => $request->input('option_4') ?? '0',
            'option_5' => $request->input('option_5') ?? '0',
            'option_total' => $request->input('option_total') ?? '0',

            // 税金・保険料
            'tax_1' => $request->input('tax_1') ?? '0',
            'tax_2' => $request->input('tax_2') ?? '0',
            'tax_3' => $request->input('tax_3') ?? '0',
            'tax_4' => $request->input('tax_4') ?? '0',
            'tax_5' => $request->input('tax_5') ?? '0',
            'tax_total' => $request->input('tax_total') ?? '0',

            // 諸費用
            'overhead_1' => $request->input('overhead_1') ?? '0',
            'overhead_2' => $request->input('overhead_2') ?? '0',
            'overhead_total' => $request->input('overhead_total') ?? '0',

            // 支払い総額
            'total' => $request->input('total') ?? '0',
            'trade_price' => $request->input('trade_price') ?? '0',
            'discount' => $request->input('discount') ?? '0',
            'payment' => $request->input('payment') ?? '0',
        ]);

//dd($request->user()->quotes());
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
//dd($quote);  
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
            'car' => 'nullable|max:255',
            'grade' => 'nullable|max:255',
            'displacement' => 'nullable|max:255',
            'transmission' => 'nullable|max:255',
            'color' => 'nullable|max:255',
            'drive' => 'nullable|max:255',
            'year' => 'nullable|max:255',
            'mileage' => 'nullable|max:255',
            'inspection' => 'nullable|max:255',
            'price' => 'required|integer',
            'tax_1' => 'nullable|integer',
            'tax_2' => 'nullable|integer',
            'tax_3' => 'nullable|integer',
            'tax_4' => 'nullable|integer',
            'tax_5' => 'nullable|integer',
            'tax_total' => 'nullable|integer',
            'overhead_1' => 'nullable|integer',
            'overhead_2' => 'nullable|integer',
            'overhead_total' => 'nullable|integer',
            'optionName_1' => 'nullable|max:255',
            'optionName_2' => 'nullable|max:255',
            'optionName_3' => 'nullable|max:255',
            'optionName_4' => 'nullable|max:255',
            'optionName_5' => 'nullable|max:255',
            'option_1' => 'nullable|integer',
            'option_2' => 'nullable|integer',
            'option_3' => 'nullable|integer',
            'option_4' => 'nullable|integer',
            'option_5' => 'nullable|integer',
            'option_total' => 'nullable|integer',
            'total' => 'nullable|integer',
            'trade_price' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'payment' => 'nullable|integer',
        ]);

        $quote = Quote::findOrFail($id);
    
        // 投稿の所有者のみ更新可能
        if (\Auth::id() !== $quote->user_id) {
            return redirect()->route('quote.index')->with('error', '不正な操作です');
        }
    
        // 内容を更新
        $quote->update([

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

            // オプション
            // オプションの名前
            'optionName_1' => $request->optionName_1,
            'optionName_2' => $request->optionName_2,
            'optionName_3' => $request->optionName_3,
            'optionName_4' => $request->optionName_4,
            'optionName_5' => $request->optionName_5,
            'option_1' => $request->input('option_1') ?? '0',
            'option_2' => $request->input('option_2') ?? '0',
            'option_3' => $request->input('option_3') ?? '0',
            'option_4' => $request->input('option_4') ?? '0',
            'option_5' => $request->input('option_5') ?? '0',
            'option_total' => $request->input('option_total') ?? '0',

            // 税金・保険料
            'tax_1' => $request->input('tax_1') ?? '0',
            'tax_2' => $request->input('tax_2') ?? '0',
            'tax_3' => $request->input('tax_3') ?? '0',
            'tax_4' => $request->input('tax_4') ?? '0',
            'tax_5' => $request->input('tax_5') ?? '0',
            'tax_total' => $request->input('tax_total') ?? '0',

            // 諸費用
            'overhead_1' => $request->input('overhead_1') ?? '0',
            'overhead_2' => $request->input('overhead_2') ?? '0',
            'overhead_total' => $request->input('overhead_total') ?? '0',

            // 支払い総額
            'total' => $request->input('total') ?? '0',
            'trade_price' => $request->input('trade_price') ?? '0',
            'discount' => $request->input('discount') ?? '0',
            'payment' => $request->input('payment') ?? '0',
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

        // 車両情報
        $newQuote->car = $quote->car;
        $newQuote->grade = $quote->grade;
        $newQuote->displacement = $quote->displacement;
        $newQuote->transmission = $quote->transmission;
        $newQuote->color = $quote->color;
        $newQuote->drive = $quote->drive;
        $newQuote->year = $quote->year;
        $newQuote->mileage = $quote->mileage;
        $newQuote->inspection = $quote->inspection;
        // 車輌価格        
        $newQuote->price = $quote->price;
        // オプション名称
        $newQuote->optionName_1 = $quote->optionName_1;
        $newQuote->optionName_2 = $quote->optionName_2;
        $newQuote->optionName_3 = $quote->optionName_3;
        $newQuote->optionName_4 = $quote->optionName_4;
        $newQuote->optionName_5 = $quote->optionName_5;
        // オプション
        $newQuote->option_1 = $quote->option_1;
        $newQuote->option_2 = $quote->option_2;
        $newQuote->option_3 = $quote->option_3;
        $newQuote->option_4 = $quote->option_4;
        $newQuote->option_5 = $quote->option_5;
        $newQuote->option_total = $quote->option_total;
        // 税金・保険料
        $newQuote->tax_1 = $quote->tax_1;
        $newQuote->tax_2 = $quote->tax_2;
        $newQuote->tax_3 = $quote->tax_3;
        $newQuote->tax_4 = $quote->tax_4;
        $newQuote->tax_5 = $quote->tax_5;
        $newQuote->tax_total = $quote->tax_total;
        // 諸費用
        $newQuote->overhead_1 = $quote->overhead_1;
        $newQuote->overhead_2 = $quote->overhead_2;        
        $newQuote->overhead_total = $quote->overhead_total;
        // 支払い総額
        $newQuote->total = $quote->total;
        $newQuote->trade_price = $quote->trade_price;
        $newQuote->discount = $quote->discount;
        $newQuote->payment = $quote->payment;
        $newQuote->save();
    
        return redirect()->route('quote.index')->with('success', '投稿をコピーしました。');
    }

    
    /**
     * PDF作成
     */
    public function createPdf(Request $request)
    {
//dd($request);
        // フォームから送信されたデータを取得
        $data = $request->only([
            'car', 'grade', 'displacement', 'transmission', 'color', 'drive', 'year', 'mileage', 'inspection', 
            'price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5',
            'tax_total', 'overhead_1', 'overhead_2', 'overhead_total',
            'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 'option_total',
            'optionName_1', 'optionName_2', 'optionName_3', 'optionName_4', 'optionName_5',
            'subtotal', 'total', 'trade_price', 'discount', 'payment'
        ]);        
    
        // 現在日時を取得
        $date['date'] = now()->format('Y-m-d');
       
        // PDF生成とビューにデータを渡す
        $pdf = PDF::loadView('quote.createPdf', $data);
       
        // PDFをブラウザで表示
        return $pdf->stream('quote_' . $date['date'] . '.pdf');
    }



    
    
}
