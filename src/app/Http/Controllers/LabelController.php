<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Label; // モデルを使う場合
use Illuminate\Support\Facades\Auth;



class LabelController extends Controller
{

    public function index()
    {
        $labels = collect(); // デフォルトで空のコレクションを作成

        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $labels = $user->labels()->orderBy('updated_at', 'desc')->paginate(10);
            //dd($labels);
        }

        return view('label.index', compact('labels'));
    }


    public function preview(Request $request)
    {
        // バリデーション等必要なら追加
        session([
            'preview' => [
                'zipcode' => $request->zipcode,
                'address' => $request->address,
                'name'    => $request->name,
                'title'   => $request->title,
            ]
        ]);

        // プレビューのデータをビューに渡す
        return view('label.index', [
            'labels' => Auth::check() ? Label::where('user_id', Auth::id())->get() : null,  // ログインユーザーのラベルデータ
            'preview' => session('preview')  // セッションに保存されたプレビュー情報
        ]);
    }




    public function store(Request $request)
    {


        $user = Auth::user();
        if (! $user) {
            abort(403, 'ログインが必要です');
        }

        $limit = $user->limit();
        $count = $user->labels()->count();

        if ($count >= $limit) {
            $user->labels()->oldest()->first()?->delete();
        }

        //dd($request);
        $validated = $request->validate([
            'zipcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'name' => 'required|string|max:100',
            'title' => 'required|string|max:10',
        ]);

        // 保存処理（例：labels テーブルに保存）
        Label::create([
            'user_id' => auth()->id(),
            'zipcode' => $validated['zipcode'],
            'address' => $validated['address'],
            'name' => $validated['name'],
            'title' => $validated['title'],
        ]);

        return response()->noContent(); // JS側から送信されたのでページ遷移不要
    }


    public function print()
    {
        $labels = [
            ['name' => '商品A', 'description' => 'これはAの商品です。'],
            ['name' => '商品B', 'description' => 'これはBの商品です。'],
            // 必要なだけ追加
        ];

        return view('label.label', compact('labels'));
    }


    public function destroy($id)
    {
        $label = \Auth::user()->labels()->findOrFail($id);
        $label->delete();

        return redirect()->route('label.index')->with('success', 'データを削除しました。');
    }
}
