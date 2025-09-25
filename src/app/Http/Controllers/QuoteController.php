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
use Illuminate\Support\Facades\Validator;




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

        // 保存上限（既存ロジック）
        $limit = $user->limit();
        $count = $user->quotes()->count();
        if ($count >= $limit) {
            $user->quotes()->oldest()->first()?->delete();
        }

        // まず “生” 入力を受け取る（ここでは型チェックせず）
        $raw = $request->all();

        // ---------- charges をフラット化 + 空行除外 ----------
        $flatCharges = [];
        foreach (['tax', 'fee'] as $kind) {
            foreach ((array) data_get($raw, "charges.$kind", []) as $row) {
                $name   = trim((string)($row['name']   ?? ''));
                $amount = $row['amount'] ?? null; // 空なら null のまま
                $taxTr  = $row['tax_treatment'] ?? null;
                $taxRt  = $row['tax_rate']      ?? null;

                // 「名前も金額も空」はスキップ
                $isAmountEmpty = ($amount === '' || $amount === null);
                if ($name === '' && $isAmountEmpty) {
                    continue;
                }

                $flatCharges[] = [
                    'kind'          => $kind,
                    'name'          => $name,                       // 空名の登録は許可しない
                    'amount'        => $isAmountEmpty ? 0 : (int)$amount, // DB的には整数。空は 0 に丸める
                    'tax_treatment' => $taxTr ?: null,
                    'tax_rate'      => $taxRt ?: null,
                ];
            }
        }

        // ---------- options も空行を除外 ----------
        $flatOptions = [];
        foreach ((array) data_get($raw, 'options', []) as $row) {
            $name   = trim((string)($row['name'] ?? ''));
            $price  = $row['unit_price'] ?? null;
            $optType = $row['option_type'] ?? 'aftermarket'; // 画面は hidden で after­market

            $isPriceEmpty = ($price === '' || $price === null);
            if ($name === '' && $isPriceEmpty) {
                continue;
            }

            $flatOptions[] = [
                'option_type'   => in_array($optType, ['dealer', 'maker', 'aftermarket'], true) ? $optType : 'aftermarket',
                'name'          => $name,
                'unit_price'    => $isPriceEmpty ? 0 : (int)$price,
                'tax_treatment' => $row['tax_treatment'] ?? 'taxable',
                'tax_rate'      => $row['tax_rate']      ?? null,
            ];
        }

        // ---------- バリデーション ----------
        // ※ ここでは “整形後の配列” を対象にする
        $validated = Validator::make(
            [
                // そのままの単項目
                'maker'        => $raw['maker']        ?? null,
                'car'          => $raw['car']          ?? null,
                'grade'        => $raw['grade']        ?? null,
                'displacement' => $raw['displacement'] ?? null,
                'transmission' => $raw['transmission'] ?? null,
                'color'        => $raw['color']        ?? null,
                'drive'        => $raw['drive']        ?? null,
                'model'        => $raw['model']        ?? null,
                'number'       => $raw['number']       ?? null,
                'year'         => $raw['year']         ?? null,
                'mileage'      => $raw['mileage']      ?? null,
                'inspection_year'  => $raw['inspection_year']  ?? null,
                'inspection_month' => $raw['inspection_month'] ?? null,

                'price'       => $raw['price']       ?? null,
                'discount'    => $raw['discount']    ?? null,
                'trade_price' => $raw['trade_price'] ?? null,
                'message'     => $raw['message']     ?? null,
                'memo'        => $raw['memo']        ?? null,

                // 整形済み
                'charges'     => $flatCharges,
                'options'     => $flatOptions,
            ],
            [
                'maker'        => ['nullable', 'max:255'],
                'car'          => ['nullable', 'max:255'],
                'grade'        => ['nullable', 'max:255'],
                'displacement' => ['nullable', 'max:255'],
                'transmission' => ['nullable', 'max:255'],
                'color'        => ['nullable', 'max:255'],
                'drive'        => ['nullable', 'max:255'],
                'model'        => ['nullable', 'max:255'],
                'number'       => ['nullable', 'max:255'],
                'year'         => ['nullable', 'max:255'],
                'mileage'      => ['nullable', 'max:255'],
                'inspection_year'  => ['nullable', 'max:255'],
                'inspection_month' => ['nullable', 'max:255'],

                'price'       => ['required', 'integer'],
                'discount'    => ['nullable', 'integer'],
                'trade_price' => ['nullable', 'integer'],
                'message'     => ['nullable', 'max:255'],
                'memo'        => ['nullable', 'max:255'],

                'charges'                 => ['array'],
                'charges.*.kind'          => ['required', 'in:tax,fee'],
                'charges.*.name'          => ['required', 'string', 'max:255'],
                'charges.*.amount'        => ['nullable', 'integer'],
                'charges.*.tax_treatment' => ['nullable', 'in:taxable,exempt,non_taxable'],
                'charges.*.tax_rate'      => ['nullable', 'numeric'],

                // オプション
                'options'                      => 'nullable|array',
                'options.*.option_type'        => 'required_with:options|in:dealer,maker,aftermarket',
                'options.*.name'               => 'required_with:options|string|max:255',
                'options.*.amount'             => 'nullable|integer', // ← unit_price 削除して amount に統一
                'options.*.tax_treatment'      => 'nullable|in:taxable,exempt,non_taxable',
                'options.*.tax_rate'           => 'nullable|numeric',

            ],
            [], // カスタムメッセージ必要ならここに
        )->validate();

        // ここから DB 登録
        $discount   = (int)($validated['discount']    ?? 0);
        $tradePrice = (int)($validated['trade_price'] ?? 0);
        $quote = null;

        DB::transaction(function () use ($user, $validated, $discount, $tradePrice, &$quote) {
            // 1) 見積ヘッダ
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
                'trade_price'  => $tradePrice,

                'message'      => $validated['message'] ?? null,
                'memo'         => $validated['memo']    ?? null,

                'subtotal'     => 0,
                'total'        => 0,
                'payment'      => 0,
            ]);

            // 2) プリセット複製（amount は null を 0 に丸め）
            $presetRows = ChargePreset::orderBy('position')->get()->map(function ($p) use ($quote) {
                return [
                    'quote_id'      => $quote->id,
                    'kind'          => $p->kind,
                    'name'          => $p->name,
                    'amount'        => (int)($p->default_amount ?? 0),
                    'tax_treatment' => $p->tax_treatment,
                    'tax_rate'      => $p->tax_rate,
                    'position'      => $p->position,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            })->all();
            if ($presetRows) {
                QuoteCharge::insert($presetRows);
            }

            // 3) 画面入力（整形済み）で上書き or 追加
            foreach ($validated['charges'] as $i => $c) {
                $existing = QuoteCharge::where('quote_id', $quote->id)
                    ->where('kind', $c['kind'])
                    ->where('name', $c['name'])
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
                    QuoteCharge::create([
                        'quote_id' => $quote->id,
                        'kind'     => $c['kind'],
                        'name'     => $c['name'],
                    ] + $payload);
                }
            }

            // 4) オプション（整形済み）
            foreach ($validated['options'] as $j => $o) {
                QuoteOption::create([
                    'quote_id'      => $quote->id,
                    'option_type'   => $o['option_type'],
                    'name'          => $o['name'],
                    'amount'        => (int)($o['amount'] ?? 0),   // ← amount に統一
                    'tax_treatment' => $o['tax_treatment'] ?? 'taxable',
                    'tax_rate'      => $o['tax_rate']      ?? null,
                    'position'      => $j + 1,
                ]);
            }

            // 5) 合計再計算
            $taxesSum = $quote->charges()->where('kind', 'tax')->sum('amount');
            $feesSum  = $quote->charges()->where('kind', 'fee')->sum('amount');
            $optSum = $quote->options()->sum('amount'); // ← unit_price ではなく amount

            $subtotal = (int)$quote->price + $taxesSum + $feesSum + $optSum - (int)$quote->discount;
            $total    = $subtotal - (int)$quote->trade_price;

            $quote->update([
                'subtotal' => $subtotal,
                'total'    => $total,
                'payment'  => $total,
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
     * 見積の更新（quotes / quote_charges / quote_options）
     */
    public function update(Request $request, $id)
    {
        $quote = Quote::with(['charges', 'options'])->findOrFail($id);

        // 投稿の所有者のみ更新可能
        if (Auth::id() !== $quote->user_id) {
            return redirect()->route('quote.index')->with('error', '不正な操作です');
        }

        // --- 基本バリデーション（明細は配列の形だけチェック。中身は後で正規化） ---
        $validated = $request->validate([
            // 車両本体
            'maker'            => 'nullable|string|max:255',
            'car'              => 'nullable|string|max:255',
            'grade'            => 'nullable|string|max:255',
            'displacement'     => 'nullable|string|max:255',
            'transmission'     => 'nullable|string|max:255',
            'color'            => 'nullable|string|max:255',
            'drive'            => 'nullable|string|max:255',
            'model'            => 'nullable|string|max:255',
            'number'           => 'nullable|string|max:255',
            'year'             => 'nullable|string|max:255',
            'mileage'          => 'nullable|string|max:255',
            'inspection_year'  => 'nullable|string|max:255',
            'inspection_month' => 'nullable|string|max:255',

            'price'        => 'required|integer',
            'discount'     => 'nullable|integer',
            'trade_price'  => 'nullable|integer',

            // 備考・メモ
            'message' => 'nullable|string|max:255',
            'memo'    => 'nullable|string|max:255',

            // 明細（フォーム構造の許容）
            'charges'       => 'nullable|array',
            'charges.tax'   => 'nullable|array',
            'charges.fee'   => 'nullable|array',

            'options'       => 'nullable|array',
            'options.*.name'        => 'nullable|string|max:255',
            'options.*.amount'      => 'nullable|integer',
            'options.*.option_type' => 'nullable|in:dealer,maker,aftermarket',
            'options.*.tax_treatment' => 'nullable|in:taxable,exempt,non_taxable',
            'options.*.tax_rate'      => 'nullable|numeric',
        ]);

        // 検査日文字列の組み立て
        $inspection = null;
        $year  = $validated['inspection_year']  ?? null;
        $month = $validated['inspection_month'] ?? null;
        if (in_array($year, ['2年付', '3年付'], true)) {
            $inspection = $year;
        } elseif ($year && $month) {
            $inspection = $year . '-' . $month;
        }

        // 画面の charges は charges[tax][i][...] / charges[fee][i][...] の二段配列なので正規化
        $flatCharges = [];
        $inCharges   = $validated['charges'] ?? [];
        foreach (['tax', 'fee'] as $kind) {
            if (!empty($inCharges[$kind]) && is_array($inCharges[$kind])) {
                $pos = 1;
                foreach ($inCharges[$kind] as $row) {
                    $name   = trim((string)($row['name'] ?? ''));
                    $amount = $row['amount'] ?? null;

                    // 完全に空行（name も amount も空）はスキップ
                    if ($name === '' && ($amount === null || $amount === '')) {
                        continue;
                    }

                    $flatCharges[] = [
                        'kind'          => $kind,
                        'name'          => $name,
                        'amount'        => (int)($amount ?? 0),
                        'tax_treatment' => $row['tax_treatment'] ?? 'taxable',
                        'tax_rate'      => $row['tax_rate'] ?? null,
                        'position'      => $pos++,
                    ];
                }
            }
        }

        // options も正規化（name も amount も空ならスキップ）
        $normOptions = [];
        $inOptions   = $validated['options'] ?? [];
        $pos         = 1;
        foreach ($inOptions as $row) {
            $name   = trim((string)($row['name'] ?? ''));
            $amount = $row['amount'] ?? null;

            if ($name === '' && ($amount === null || $amount === '')) {
                continue;
            }

            $normOptions[] = [
                'name'          => $name,
                'amount'        => (int)($amount ?? 0),
                'option_type'   => $row['option_type']   ?? 'aftermarket',
                'tax_treatment' => $row['tax_treatment'] ?? 'taxable',
                'tax_rate'      => $row['tax_rate']      ?? null,
                'position'      => $pos++,
            ];
        }

        // 金額系
        $price      = (int)$validated['price'];
        $discount   = (int)($validated['discount']    ?? 0);
        $tradePrice = (int)($validated['trade_price'] ?? 0);

        DB::transaction(function () use (
            $quote,
            $validated,
            $inspection,
            $price,
            $discount,
            $tradePrice,
            $flatCharges,
            $normOptions
        ) {
            // 1) 見積本体を更新
            $quote->update([
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
                'inspection'   => $inspection,

                'price'        => $price,
                'discount'     => $discount,
                'trade_price'  => $tradePrice,

                'message'      => $validated['message'] ?? null,
                'memo'         => $validated['memo']    ?? null,
            ]);

            // 2) 明細を全入れ替え（シンプルで確実）
            $quote->charges()->delete();
            if (!empty($flatCharges)) {
                $rows = array_map(function ($c) use ($quote) {
                    return [
                        'quote_id'      => $quote->id,
                        'kind'          => $c['kind'],
                        'name'          => $c['name'],
                        'amount'        => $c['amount'],
                        'tax_treatment' => $c['tax_treatment'],
                        'tax_rate'      => $c['tax_rate'],
                        'position'      => $c['position'],
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }, $flatCharges);
                QuoteCharge::insert($rows);
            }

            $quote->options()->delete();
            if (!empty($normOptions)) {
                $rows = array_map(function ($o) use ($quote) {
                    return [
                        'quote_id'      => $quote->id,
                        'option_type'   => $o['option_type'],
                        'name'          => $o['name'],
                        'amount'        => $o['amount'],
                        'tax_treatment' => $o['tax_treatment'],
                        'tax_rate'      => $o['tax_rate'],
                        'position'      => $o['position'],
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }, $normOptions);
                QuoteOption::insert($rows);
            }

            // 3) 合計をサーバ側で再計算
            $taxesSum = $quote->charges()->where('kind', 'tax')->sum('amount');
            $feesSum  = $quote->charges()->where('kind', 'fee')->sum('amount');
            $optSum   = $quote->options()->sum('amount');

            // 画面の「合計」は 本体 + 諸費用合計 + オプション合計
            // 「支払総額」は 合計 - 下取り - 値引き（＝ store と同じ式に統一）
            $subtotal = $price + $taxesSum + $feesSum + $optSum;
            $total    = $subtotal;
            $payment  = $total - $tradePrice - $discount;

            $quote->update([
                'subtotal' => $subtotal,
                'total'    => $total,
                'payment'  => $payment,
            ]);
        });

        return redirect()
            ->route('quote.edit', ['quote' => $quote->id])
            ->with('success', '見積もりを更新しました');
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

        // 元見積＋関連明細を取得
        $quote = Quote::with(['charges', 'options'])->findOrFail($id);

        // 保存上限チェック（超過時は最古を削除）
        $limit = $user->limit();
        $count = $user->quotes()->count();
        if ($count >= $limit) {
            $user->quotes()->oldest()->first()?->delete();
        }

        $newQuote = null;

        DB::transaction(function () use ($user, $quote, &$newQuote) {
            // 見積本体を複製
            $newQuote = $user->quotes()->create([
                // お好みで [コピー] を付与（重複付与防止）
                'car'          => str_contains((string)$quote->car, '[コピー]') ? $quote->car : ($quote->car . ' [コピー]'),
                'grade'        => $quote->grade,
                'color'        => $quote->color,
                'transmission' => $quote->transmission,
                'drive'        => $quote->drive,
                'year'         => $quote->year,
                'mileage'      => $quote->mileage,
                'inspection'   => $quote->inspection,

                'price'        => (int)$quote->price,
                'discount'     => (int)$quote->discount,
                'trade_price'  => (int)$quote->trade_price,

                'message'      => $quote->message,
                'memo'         => $quote->memo,

                // いったん0で作成→後で再計算して更新
                'subtotal'     => 0,
                'total'        => 0,
                'payment'      => 0,
            ]);

            // 明細（税金・保険料 / 販売諸費用）を複製
            if ($quote->charges && $quote->charges->count()) {
                $rows = $quote->charges->map(function ($c) use ($newQuote) {
                    return [
                        'quote_id'      => $newQuote->id,
                        'kind'          => $c->kind,              // 'tax' | 'fee'
                        'name'          => $c->name,
                        'amount'        => (int)$c->amount,
                        'tax_treatment' => $c->tax_treatment,     // 'taxable'|'exempt'|'non_taxable'
                        'tax_rate'      => $c->tax_rate,
                        'position'      => (int)$c->position,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                })->all();

                if (!empty($rows)) {
                    QuoteCharge::insert($rows);
                }
            }

            // オプションを複製（amount で統一）
            if ($quote->options && $quote->options->count()) {
                $rows = $quote->options->map(function ($o) use ($newQuote) {
                    return [
                        'quote_id'      => $newQuote->id,
                        'option_type'   => $o->option_type,       // 'dealer'|'maker'|'aftermarket'
                        'name'          => $o->name,
                        'amount'        => (int)$o->amount,
                        'tax_treatment' => $o->tax_treatment,
                        'tax_rate'      => $o->tax_rate,
                        'position'      => (int)$o->position,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                })->all();

                if (!empty($rows)) {
                    QuoteOption::insert($rows);
                }
            }

            // 合計再計算（サーバ側）
            $taxesSum = $newQuote->charges()->where('kind', 'tax')->sum('amount');
            $feesSum  = $newQuote->charges()->where('kind', 'fee')->sum('amount');
            $optSum   = $newQuote->options()->sum('amount');

            $subtotal = (int)$newQuote->price - (int)$newQuote->discount + (int)$taxesSum + (int)$feesSum + (int)$optSum;
            $total    = $subtotal - (int)$newQuote->trade_price;

            $newQuote->update([
                'subtotal' => $subtotal,
                'total'    => $total,
                'payment'  => $total, // ここは運用に合わせて調整OK
            ]);
        });

        return redirect()
            ->route('quote.edit', ['quote' => $newQuote->id])
            ->with('success', '見積もりをコピーしました。');
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
                'price' => 'nullable|integer',

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
        $message         = $request->input('message');

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
            'message'           => $message,
        ];

        // ---------- PDF 生成 ----------
        $pdf = PDF::loadView('quote.createPdf', $data);

        return $pdf->stream('quote_' . $data['date'] . '.pdf');
    }
}
