<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\QuoteCharge;
use App\Models\QuoteOption;
use App\Models\ChargePreset;




class QuoteController extends Controller
{
    /**
     * トップページ
     */
    public function index()
    {
        $quotes = collect(); // デフォルトで空のコレクション

        if (\Auth::check()) { // 認証済みの場合
            $user = \Auth::user();
            $quotes = $user->quotes()
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }

        // プリセットを kind ごとにまとめる
        $presets = ChargePreset::orderBy('position')->get()->groupBy('kind');

        return view('quote.index', [
            'quotes'     => $quotes,
            'taxPresets' => $presets->get('tax', collect()), // 税金・保険料など
            'feePresets' => $presets->get('fee', collect()), // 販売諸費用
        ]);
    }




    /**
     * 見積作成画面
     * - プリセット（税金/諸費用）を取得してビューへ
     */
    public function create()
    {
        // kindごとにまとめてViewへ
        $presets = ChargePreset::orderBy('position')->get()->groupBy('kind');

        return view('quote.index', [ // ← あなたのbladeに合わせて
            'taxPresets' => $presets->get('tax', collect()), // 税金・保険料など
            'feePresets' => $presets->get('fee', collect()), // 販売諸費用
            // 既存で使っている他の変数があればここに追加
        ]);
    }



    /**
     * 見積の保存
     * - quotes 作成 → プリセットを quote_charges に複製
     * - 画面入力値があれば複製時または後から上書き
     * - quote_options を保存（qty/amountは無し、unit_priceのみ）
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            abort(403, 'ログインが必要です');
        }

        // 保存上限チェック（あなたの既存ロジック）
        $limit = $user->limit();
        $count = $user->quotes()->count();
        if ($count >= $limit) {
            $user->quotes()->oldest()->first()?->delete();
        }

        // 画面入力想定（名前は必要に応じて合わせてください）
        // charges: [ [id|null, kind, name, amount, tax_treatment, tax_rate], ... ]
        // options: [ [option_type, name, unit_price, tax_treatment, tax_rate], ... ]
        $validated = $request->validate([
            // 車両本体
            'maker'        => 'nullable|max:255',
            'car'          => 'nullable|max:255',
            'grade'        => 'nullable|max:255',
            'displacement' => 'nullable|max:255',
            'transmission' => 'nullable|max:255',
            'color'        => 'nullable|max:255',
            'drive'        => 'nullable|max:255',
            'model'        => 'nullable|max:255',
            'number'       => 'nullable|max:255',
            'year'         => 'nullable|max:255',
            'mileage'      => 'nullable|max:255',
            'inspection_year'  => 'nullable|max:255',
            'inspection_month' => 'nullable|max:255',

            'price'    => 'required|integer',
            'discount' => 'nullable|integer',
            'trade_price' => 'nullable|integer',

            // メモ等
            'message' => 'nullable|max:255',
            'memo'    => 'nullable|max:255',

            // 明細（税金/諸費用）
            'charges'                      => 'nullable|array',
            'charges.*.kind'               => 'required_with:charges|in:tax,fee',
            'charges.*.name'               => 'required_with:charges|string|max:255',
            'charges.*.amount'             => 'nullable|integer',
            'charges.*.tax_treatment'      => 'nullable|in:taxable,exempt,non_taxable',
            'charges.*.tax_rate'           => 'nullable|numeric',

            // オプション
            'options'                      => 'nullable|array',
            'options.*.option_type'        => 'required_with:options|in:dealer,maker,aftermarket',
            'options.*.name'               => 'required_with:options|string|max:255',
            'options.*.unit_price'         => 'nullable|integer',
            'options.*.tax_treatment'      => 'nullable|in:taxable,exempt,non_taxable',
            'options.*.tax_rate'           => 'nullable|numeric',
        ]);

        // 合計はサーバ側で再計算するため、リクエスト total は受け取らない運用に寄せます
        $discount    = (int)($validated['discount']     ?? 0);
        $tradePrice  = (int)($validated['trade_price']  ?? 0);

        $quote = null;

        DB::transaction(function () use ($user, $validated, $discount, $tradePrice, &$quote) {
            // 1) 見積（quotes）をまず作成
            $quote = $user->quotes()->create([
                'name'         => $validated['name']         ?? null,
                'post'         => $validated['post']         ?? null,
                'address'      => $validated['address']      ?? null,
                'tell'         => $validated['tell']         ?? null,

                'maker'        => $validated['maker']        ?? null,
                'car'          => $validated['car']          ?? null,
                'grade'        => $validated['grade']        ?? null,
                'displacement' => $validated['displacement'] ?? null,
                'transmission' => $validated['transmission'] ?? null,
                'color'        => $validated['color']        ?? null,
                'drive'        => $validated['drive']        ?? null,
                'model'        => $validated['model']        ?? null,
                'number'       => $validated['number']       ?? null,
                'year'         => $validated['year']         ?? null,
                'mileage'      => $validated['mileage']      ?? null,
                'inspection'   => isset($validated['inspection_year'], $validated['inspection_month'])
                    ? ($validated['inspection_year'] . '-' . $validated['inspection_month'])
                    : null,

                'price'        => (int)$validated['price'],
                'discount'     => $discount,

                // 下取りなど（必要に応じて追加の入力を載せてください）
                'trade_price'  => $tradePrice,

                'message'      => $validated['message'] ?? null,
                'memo'         => $validated['memo']    ?? null,

                // 小計・合計は後で再計算して更新
                'subtotal'     => 0,
                'total'        => 0,
                'payment'      => 0,
            ]);

            // 2) プリセットを複製して quote_charges へ（初期行を作成）
            $presetRows = ChargePreset::orderBy('position')->get()->map(function ($p) use ($quote) {
                return [
                    'quote_id'      => $quote->id,
                    'kind'          => $p->kind,
                    'name'          => $p->name,
                    'amount'        => (int)$p->default_amount,
                    'tax_treatment' => $p->tax_treatment,
                    'tax_rate'      => $p->tax_rate,
                    'position'      => $p->position,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            })->all();
            if (!empty($presetRows)) {
                QuoteCharge::insert($presetRows);
            }

            // 3) もし画面から charges が来ていれば、同名行を上書き or 追加
            if (!empty($validated['charges'])) {
                foreach ($validated['charges'] as $i => $c) {
                    // 既存（プリセット）に name が一致するものがあれば更新、なければ追加
                    $existing = QuoteCharge::where('quote_id', $quote->id)
                        ->where('name', $c['name'])
                        ->where('kind', $c['kind'])
                        ->first();

                    $payload = [
                        'amount'        => isset($c['amount']) ? (int)$c['amount'] : 0,
                        'tax_treatment' => $c['tax_treatment'] ?? ($existing->tax_treatment ?? 'taxable'),
                        'tax_rate'      => $c['tax_rate']      ?? ($existing->tax_rate      ?? null),
                        'position'      => $existing->position ?? ($i + 1),
                    ];

                    if ($existing) {
                        $existing->update($payload);
                    } else {
                        QuoteCharge::create(array_merge([
                            'quote_id' => $quote->id,
                            'kind'     => $c['kind'],
                            'name'     => $c['name'],
                        ], $payload));
                    }
                }
            }

            // 4) オプション（qty/amount なし。unit_price のみ）
            if (!empty($validated['options'])) {
                foreach ($validated['options'] as $j => $o) {
                    QuoteOption::create([
                        'quote_id'      => $quote->id,
                        'option_type'   => $o['option_type'],      // dealer|maker|aftermarket
                        'name'          => $o['name'],
                        'unit_price'    => isset($o['unit_price']) ? (int)$o['unit_price'] : 0,
                        'tax_treatment' => $o['tax_treatment'] ?? 'taxable',
                        'tax_rate'      => $o['tax_rate']      ?? null,
                        'position'      => $j + 1,
                    ]);
                }
            }

            // 5) 合計をサーバ側で再計算して quotes を更新
            $taxesSum = $quote->charges()->where('kind', 'tax')->sum('amount');
            $feesSum  = $quote->charges()->where('kind', 'fee')->sum('amount');
            $optSum   = $quote->options()->sum('unit_price'); // ← qty/amount無し前提

            $subtotal = (int)$quote->price - (int)$quote->discount + $taxesSum + $feesSum + $optSum;
            $total    = $subtotal - (int)$quote->trade_price;

            $quote->update([
                'subtotal' => $subtotal,
                'total'    => $total,
                'payment'  => $total, // ここは運用に合わせて。ローン計算を別で上書きするならそのままでもOK
            ]);
        });

        \Log::info('見積の作成成功', ['quote_id' => $quote->id ?? null]);

        return redirect()
            ->route('quote.edit', ['quote' => $quote->id])
            ->with('success', '見積もりを保存しました');
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
        //dd($request);
        // バリデーション
        $request->validate([
            'car' => 'nullable|max:255',
            'grade' => 'nullable|max:255',
            'color' => 'nullable|max:255',
            'transmission' => 'nullable|max:255',
            'drive' => 'nullable|max:255',
            'year' => 'nullable|max:255',
            'mileage' => 'nullable|max:255',
            'inspection_year' => 'nullable|max:255',
            'inspection_month' => 'nullable|max:255',

            'price' => 'required|integer',

            'tax_1' => 'nullable|integer',
            'tax_2' => 'nullable|integer',
            'tax_3' => 'nullable|integer',
            'tax_4' => 'nullable|integer',
            'tax_5' => 'nullable|integer',
            'tax_total' => 'nullable|integer',
            'overhead_1' => 'nullable|integer',
            'overheadName_11' => 'nullable|max:255',
            'overhead_11' => 'nullable|integer',
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

            'memo' => 'nullable|max:255',
        ]);




        $quote = Quote::findOrFail($id);

        // 投稿の所有者のみ更新可能
        if (\Auth::id() !== $quote->user_id) {
            return redirect()->route('quote.index')->with('error', '不正な操作です');
        }


        // 年と月の取得とinspection文字列の生成は事前にやっておく
        $year = $request->input('inspection_year');
        $month = $request->input('inspection_month');

        if (in_array($year, ['2年付', '3年付'])) {
            $inspection = $year;
        } elseif ($year && $month) {
            $inspection = $year . '-' . $month;
        } else {
            $inspection = null;
        }
        //dd($inspection);
        // 内容を更新
        $quote->update([

            // 車両情報
            'car' => $request->car,
            'grade' => $request->grade,
            'transmission' => $request->transmission,
            'color' => $request->color,
            'drive' => $request->drive,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'inspection' => $inspection,

            // 車両価格
            'price' => $request->price,

            // 税金・保険料
            'tax_1' => $request->input('tax_1') ?? '0',
            'tax_2' => $request->input('tax_2') ?? '0',
            'tax_3' => $request->input('tax_3') ?? '0',
            'tax_4' => $request->input('tax_4') ?? '0',
            'tax_5' => $request->input('tax_5') ?? '0',

            // 諸費用
            'overhead_1' => $request->input('overhead_1') ?? '0',
            'overheadName_11' => $request->input('overheadName_11') ?? '0',
            'overhead_11' => $request->input('overhead_11') ?? '0',
            'overhead_total' => $request->input('overhead_total') ?? '0', //taxとoverheadの合計

            // オプション
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

            // 支払い総額
            'total' => $request->input('total') ?? '0',
            'trade_price' => $request->input('trade_price') ?? '0',
            'discount' => $request->input('discount') ?? '0',
            'payment' => $request->input('payment') ?? '0',

            'memo' => $request->memo,
        ]);

        //return redirect()->route('quote.index')->with('success', '投稿を更新しました');
        return redirect()->route('quote.edit', ['quote' => $id])->with('success', '見積もりを更新しました');
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

        return redirect()->route('quote.index')->with('success', '投稿を削除しました');
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
        $quote = Quote::findOrFail($id);

        // 制限件数を超えたら一番古いデータをさ削除
        $limit = $user->limit();
        $count = $user->quotes()->count();

        if ($count >= $limit) {
            $user->quotes()->oldest()->first()?->delete();
        }

        // 認証済みユーザーの投稿として新しいレコードを作成
        $newQuote = new Quote();
        $newQuote->user_id = auth()->id();

        // 車両情報
        $newQuote->car = $quote->car . "[コピー]";
        $newQuote->grade = $quote->grade;
        $newQuote->color = $quote->color;
        $newQuote->transmission = $quote->transmission;
        $newQuote->drive = $quote->drive;
        $newQuote->year = $quote->year;
        $newQuote->mileage = $quote->mileage;
        $newQuote->inspection = $quote->inspection;
        // 車輌価格        
        $newQuote->price = $quote->price;
        // 税金・保険料
        $newQuote->tax_1 = $quote->tax_1;
        $newQuote->tax_2 = $quote->tax_2;
        $newQuote->tax_3 = $quote->tax_3;
        $newQuote->tax_4 = $quote->tax_4;
        $newQuote->tax_5 = $quote->tax_5;
        // 諸費用
        $newQuote->overhead_1 = $quote->overhead_1;
        $newQuote->overheadName_11 = $quote->overheadName_11;
        $newQuote->overhead_11 = $quote->overhead_11;
        $newQuote->overhead_total = $quote->overhead_total; //taxとoverheadの合計
        // オプション
        $newQuote->optionName_1 = $quote->optionName_1;
        $newQuote->optionName_2 = $quote->optionName_2;
        $newQuote->optionName_3 = $quote->optionName_3;
        $newQuote->optionName_4 = $quote->optionName_4;
        $newQuote->optionName_5 = $quote->optionName_5;
        $newQuote->option_1 = $quote->option_1;
        $newQuote->option_2 = $quote->option_2;
        $newQuote->option_3 = $quote->option_3;
        $newQuote->option_4 = $quote->option_4;
        $newQuote->option_5 = $quote->option_5;
        $newQuote->option_total = $quote->option_total;
        // 支払い総額
        $newQuote->total = $quote->total;
        $newQuote->trade_price = $quote->trade_price;
        $newQuote->discount = $quote->discount;
        $newQuote->payment = $quote->payment;

        $newQuote->memo = $quote->memo;
        $newQuote->save();

        return redirect()->route('quote.edit', ['quote' => $newQuote->id])->with('success', '見積もりをコピーしました。');
    }


    /**
     * PDF作成
     */
    public function createPdf(Request $request)
    {
        // バリデーション（新フォーム構成）
        if (Auth::check()) {
            $request->validate([
                // 車両情報
                'car'              => 'nullable|string|max:255',
                'grade'            => 'nullable|string|max:255',
                'color'            => 'nullable|string|max:255',
                'transmission'     => 'nullable|string|max:255',
                'drive'            => 'nullable|string|max:255',
                'year'             => 'nullable|string|max:255',
                'mileage'          => 'nullable|string|max:255',
                'inspection_year'  => 'nullable|string|max:255',
                'inspection_month' => 'nullable|string|max:255',

                // 本体価格
                'price'            => 'required|integer|min:0',

                // 諸費用（配列）
                'charges'                  => 'nullable|array',
                'charges.tax'              => 'nullable|array',
                'charges.tax.*.name'       => 'nullable|string|max:255',
                'charges.tax.*.amount'     => 'nullable|integer|min:0',
                'charges.fee'              => 'nullable|array',
                'charges.fee.*.name'       => 'nullable|string|max:255',
                'charges.fee.*.amount'     => 'nullable|integer|min:0',

                // オプション（配列）
                'options'                  => 'nullable|array',
                'options.*.name'           => 'nullable|string|max:255',
                'options.*.unit_price'     => 'nullable|integer|min:0',

                // 決済関連
                'trade_price'      => 'nullable|integer|min:0',
                'discount'         => 'nullable|integer|min:0',

                // 表示用メモ
                'memo'             => 'nullable|string|max:255',
            ]);
        }

        // ---------- 入力の取り出し ----------
        $vehicle = [
            'car'              => $request->input('car'),
            'grade'            => $request->input('grade'),
            'color'            => $request->input('color'),
            'transmission'     => $request->input('transmission'),
            'drive'            => $request->input('drive'),
            'year'             => $request->input('year'),
            'mileage'          => $request->input('mileage'),
            'inspection_year'  => $request->input('inspection_year'),
            'inspection_month' => $request->input('inspection_month'),
        ];

        $price        = (int) $request->input('price', 0);
        $tradePrice   = (int) $request->input('trade_price', 0);
        $discount     = (int) $request->input('discount', 0);
        $memo         = $request->input('memo');

        // ---------- 諸費用（税金・保険料 / 販売諸費用）を正規化 ----------
        $charges = $request->input('charges', []);
        $taxRows = collect(data_get($charges, 'tax', []))
            ->map(function ($row) {
                return [
                    'name'   => (string)($row['name']   ?? ''),
                    'amount' => (int)   ($row['amount'] ?? 0),
                ];
            })
            // 空行（名称も金額も空）を除外
            ->filter(fn($r) => ($r['name'] !== '') || ($r['amount'] > 0))
            ->values()
            ->all();

        $feeRows = collect(data_get($charges, 'fee', []))
            ->map(function ($row) {
                return [
                    'name'   => (string)($row['name']   ?? ''),
                    'amount' => (int)   ($row['amount'] ?? 0),
                ];
            })
            ->filter(fn($r) => ($r['name'] !== '') || ($r['amount'] > 0))
            ->values()
            ->all();

        $taxTotal = collect($taxRows)->sum('amount');
        $feeTotal = collect($feeRows)->sum('amount');
        $chargesTotal = $taxTotal + $feeTotal;

        // ---------- オプションを正規化 ----------
        $optionsInput = $request->input('options', []);
        $optionRows = collect($optionsInput)
            ->map(function ($row) {
                return [
                    'name'       => (string)($row['name']        ?? ''),
                    'unit_price' => (int)   ($row['unit_price']  ?? 0),
                ];
            })
            ->filter(fn($r) => ($r['name'] !== '') || ($r['unit_price'] > 0))
            ->values()
            ->all();

        $optionTotal = collect($optionRows)->sum('unit_price');

        // ---------- 合計をサーバで再計算（改ざん対策） ----------
        $subtotal = $price + $chargesTotal + $optionTotal;     // 合計（税込）
        $payment  = max($subtotal - $tradePrice - $discount, 0); // お支払い総額（下取り・値引き後）

        // ---------- PDF に渡すデータ ----------
        $data = [
            // 日付
            'date'           => now()->format('Y-m-d'),

            // 車両情報
            'vehicle'        => $vehicle,

            // 金額
            'price'          => $price,

            // 諸費用
            'tax_rows'       => $taxRows,      // [ ['name'=>..., 'amount'=>...], ... ]
            'fee_rows'       => $feeRows,
            'tax_total'      => $taxTotal,
            'fee_total'      => $feeTotal,
            'charges_total'  => $chargesTotal,

            // オプション
            'option_rows'    => $optionRows,   // [ ['name'=>..., 'unit_price'=>...], ... ]
            'option_total'   => $optionTotal,

            // 決済
            'total'          => $subtotal,
            'trade_price'    => $tradePrice,
            'discount'       => $discount,
            'payment'        => $payment,

            // メモ
            'memo'           => $memo,
        ];

        // ---------- PDF 生成 ----------
        $pdf = PDF::loadView('quote.createPdf', $data);

        return $pdf->stream('quote_' . $data['date'] . '.pdf');
    }
}
